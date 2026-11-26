<?php

namespace App\Support;

use Illuminate\Pagination\LengthAwarePaginator;

final class CatalogFilter
{
    public const PER_PAGE = 12;

    /**
     * @param  array<int, array<string, mixed>>  $products
     * @param  array<string, mixed>  $query
     * @return array<int, array<string, mixed>>
     */
    public static function filter(array $products, array $query): array
    {
        $search = self::normalise((string) ($query['q'] ?? ''));
        $min = self::number($query['min'] ?? null);
        $max = self::number($query['max'] ?? null);
        $weights = self::values($query['agirlik'] ?? []);
        $badges = array_map(self::normalise(...), self::values($query['etiket'] ?? []));
        $categories = self::values($query['kategori'] ?? []);

        $products = array_values(array_filter($products, static function (array $product) use ($search, $min, $max, $weights, $badges, $categories): bool {
            if ($search !== '') {
                $haystack = self::normalise(implode(' ', [
                    (string) ($product['name'] ?? ''),
                    (string) ($product['description'] ?? ''),
                    (string) ($product['category_name'] ?? ''),
                ]));

                if (! str_contains($haystack, $search)) {
                    return false;
                }
            }

            $price = (float) ($product['price'] ?? 0);
            if ($min !== null && $price < $min) {
                return false;
            }
            if ($max !== null && $price > $max) {
                return false;
            }

            if ($weights !== [] && ! in_array(self::normaliseWeight((string) ($product['weight'] ?? '')), array_map(self::normaliseWeight(...), $weights), true)) {
                return false;
            }

            if ($badges !== [] && ! in_array(self::normalise((string) ($product['badge'] ?? '')), $badges, true)) {
                return false;
            }

            if ($categories !== [] && ! in_array((string) ($product['category'] ?? ''), $categories, true)) {
                return false;
            }

            return true;
        }));

        return self::sort($products, (string) ($query['sirala'] ?? 'onerilen'));
    }

    /**
     * @param  array<int, array<string, mixed>>  $products
     * @param  array<string, mixed>  $query
     */
    public static function paginate(array $products, array $query, string $path): LengthAwarePaginator
    {
        $filtered = self::filter($products, $query);
        $page = max(1, (int) ($query['sayfa'] ?? 1));
        $paginator = new LengthAwarePaginator(
            array_slice($filtered, ($page - 1) * self::PER_PAGE, self::PER_PAGE),
            count($filtered),
            self::PER_PAGE,
            $page,
            [
                'path' => $path,
                'pageName' => 'sayfa',
            ],
        );

        return $paginator->appends($query);
    }

    /** @return array<string, mixed> */
    public static function state(array $query): array
    {
        return [
            'q' => trim((string) ($query['q'] ?? '')),
            'min' => self::number($query['min'] ?? null),
            'max' => self::number($query['max'] ?? null),
            'weights' => self::values($query['agirlik'] ?? []),
            'badges' => self::values($query['etiket'] ?? []),
            'categories' => self::values($query['kategori'] ?? []),
            'sort' => (string) ($query['sirala'] ?? 'onerilen'),
        ];
    }

    /** @return array<int, array{label: string, url: string}> */
    public static function chips(array $query, string $path): array
    {
        $chips = [];
        $state = self::state($query);

        if ($state['q'] !== '') {
            $chips[] = ['label' => 'Arama: '.$state['q'], 'url' => self::remove($query, 'q', null, $path)];
        }
        if ($state['min'] !== null || $state['max'] !== null) {
            $range = ($state['min'] ?? 0).'–'.($state['max'] !== null ? $state['max'] : '∞').' ₺';
            $chips[] = ['label' => 'Fiyat: '.$range, 'url' => self::remove($query, 'min', null, $path, ['max'])];
        }

        foreach ($state['weights'] as $weight) {
            $chips[] = ['label' => $weight.' ×', 'url' => self::remove($query, 'agirlik', $weight, $path)];
        }
        foreach ($state['badges'] as $badge) {
            $chips[] = ['label' => $badge.' ×', 'url' => self::remove($query, 'etiket', $badge, $path)];
        }
        foreach ($state['categories'] as $category) {
            $chips[] = ['label' => $category.' ×', 'url' => self::remove($query, 'kategori', $category, $path)];
        }

        return $chips;
    }

    /** @return array<string, array<int, array{value: string, label: string, count: int}>> */
    public static function options(array $products, array $categories = []): array
    {
        $weights = [];
        $badges = [];

        foreach ($products as $product) {
            $weight = (string) ($product['weight'] ?? '');
            if ($weight !== '') {
                $weights[$weight] = ($weights[$weight] ?? 0) + 1;
            }

            $badge = (string) ($product['badge'] ?? '');
            if ($badge !== '') {
                $badges[$badge] = ($badges[$badge] ?? 0) + 1;
            }
        }

        return [
            'weights' => array_map(static fn (string $label, int $count): array => ['value' => $label, 'label' => $label, 'count' => $count], array_keys($weights), array_values($weights)),
            'badges' => array_map(static fn (string $label, int $count): array => ['value' => $label, 'label' => $label, 'count' => $count], array_keys($badges), array_values($badges)),
            'categories' => array_values(array_map(static function (array $category) use ($products): array {
                return [
                    'value' => $category['slug'],
                    'label' => $category['name'],
                    'count' => count(array_filter($products, static fn (array $product): bool => $product['category'] === $category['slug'])),
                ];
            }, $categories)),
        ];
    }

    /** @return array<string, mixed> */
    public static function without(array $query, string $key, ?string $value = null): array
    {
        unset($query['sayfa']);

        if ($value === null) {
            unset($query[$key]);

            return $query;
        }

        $values = self::values($query[$key] ?? []);
        $values = array_values(array_filter($values, static fn (string $candidate): bool => $candidate !== $value));
        if ($values === []) {
            unset($query[$key]);
        } else {
            $query[$key] = $values;
        }

        return $query;
    }

    private static function remove(array $query, string $key, ?string $value, string $path, array $also = []): string
    {
        $query = self::without($query, $key, $value);
        foreach ($also as $extra) {
            unset($query[$extra]);
        }

        return $path.($query !== [] ? '?'.http_build_query($query) : '');
    }

    /** @return array<int, string> */
    private static function values(mixed $value): array
    {
        if (is_array($value)) {
            return array_values(array_filter(array_map(static fn (mixed $item): string => trim((string) $item), $value), static fn (string $item): bool => $item !== ''));
        }

        return $value === null || trim((string) $value) === ''
            ? []
            : array_values(array_filter(array_map('trim', explode(',', (string) $value))));
    }

    private static function number(mixed $value): ?float
    {
        if ($value === null || $value === '' || ! is_numeric($value)) {
            return null;
        }

        return max(0, (float) $value);
    }

    /** @param array<int, array<string, mixed>> $products */
    private static function sort(array $products, string $sort): array
    {
        if ($sort === 'fiyat-artan' || $sort === 'fiyat-azalan') {
            usort($products, static function (array $left, array $right) use ($sort): int {
                $comparison = ((float) $left['price']) <=> ((float) $right['price']);

                return $sort === 'fiyat-azalan' ? -$comparison : $comparison;
            });
        } elseif ($sort === 'yeni') {
            usort($products, static function (array $left, array $right): int {
                $leftNew = in_array('new', (array) ($left['groups'] ?? []), true);
                $rightNew = in_array('new', (array) ($right['groups'] ?? []), true);

                return (int) $rightNew <=> (int) $leftNew;
            });
        }

        return $products;
    }

    private static function normaliseWeight(string $value): string
    {
        return preg_replace('/\s+/u', '', self::normalise($value)) ?? self::normalise($value);
    }

    private static function normalise(string $value): string
    {
        $value = mb_strtolower(trim($value), 'UTF-8');

        return strtr($value, [
            'ı' => 'i', 'ş' => 's', 'ğ' => 'g', 'ü' => 'u', 'ö' => 'o', 'ç' => 'c',
        ]);
    }
}
