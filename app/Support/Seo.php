<?php

namespace App\Support;

final class Seo
{
    public const SITE_NAME = 'Elbistan Sofrası';
    public const DEFAULT_DESCRIPTION = 'Elbistan’dan Türkiye’ye tarhana, salça, baharat ve yöresel kiler ürünleri. Katkısız, el emeği lezzetleri keşfedin.';

    /** @return array<string, string> */
    public static function defaults(): array
    {
        return [
            'title' => 'Ana Sayfa',
            'description' => self::DEFAULT_DESCRIPTION,
            'canonical' => url()->current(),
            'image' => asset('images/hero-slider.jpg'),
            'type' => 'website',
            'robots' => 'index,follow',
        ];
    }

    /** @return array<string, string> */
    public static function home(): array
    {
        return self::defaults();
    }

    /** @param array<string, mixed> $category */
    public static function category(array $category): array
    {
        return [
            'title' => $category['name'].' | Yöresel Ürünler',
            'description' => self::limitDescription($category['description'].' Elbistan Sofrası’nda katkısız, el emeği '.$category['name'].' ürünlerini keşfedin.'),
            'canonical' => url('/kategori/'.$category['slug']),
            'image' => asset('images/'.($category['image'] ?? 'kategori-1.jpg')),
            'type' => 'website',
            'robots' => 'index,follow',
        ];
    }

    /** @param array<string, mixed> $product */
    public static function product(array $product): array
    {
        return [
            'title' => $product['name'].' | Elbistan Sofrası',
            'description' => self::limitDescription($product['description'].' '.$product['category_name'].' kategorisinde Elbistan Sofrası güvencesiyle.'),
            'canonical' => url('/urun/'.$product['slug']),
            'image' => asset('images/'.($product['image'] ?? 'product-pack.jpg')),
            'type' => 'product',
            'robots' => 'index,follow',
        ];
    }

    /** @return array<string, string> */
    public static function listing(): array
    {
        return [
            'title' => 'Tüm Ürünler | Yöresel Kiler',
            'description' => 'Tarhana, salça, baharat, kurutmalık ve Elbistan’ın yöresel kiler ürünlerini tek rafta keşfedin.',
            'canonical' => url('/urunler'),
            'image' => asset('images/hero-spices.jpg'),
            'type' => 'website',
            'robots' => 'index,follow',
        ];
    }

    /** @return array<string, string> */
    public static function notFound(): array
    {
        return [
            'title' => 'Sayfa bulunamadı',
            'description' => 'Aradığınız sayfa bulunamadı. Elbistan Sofrası ana sayfasına dönerek yöresel lezzetleri keşfedebilirsiniz.',
            'canonical' => '',
            'image' => '',
            'type' => 'website',
            'robots' => 'noindex,nofollow',
        ];
    }

    /** @return array<string, mixed> */
    public static function organizationSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => self::SITE_NAME,
            'url' => url('/'),
            'logo' => asset('images/logo.png'),
            'sameAs' => [],
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Elbistan',
                'addressRegion' => 'Kahramanmaraş',
                'addressCountry' => 'TR',
            ],
            'telephone' => '0344 000 00 00',
            'contactPoint' => [
                '@type' => 'ContactPoint',
                'telephone' => '0344 000 00 00',
                'contactType' => 'customer service',
                'areaServed' => 'TR',
                'availableLanguage' => 'Turkish',
            ],
        ];
    }

    /** @return array<string, mixed> */
    public static function websiteSchema(): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => self::SITE_NAME,
            'url' => url('/'),
            'potentialAction' => [
                '@type' => 'SearchAction',
                'target' => url('/urunler').'?q={search_term_string}',
                'query-input' => 'required name=search_term_string',
            ],
        ];
    }

    /** @param array<int, array<string, mixed>> $products */
    public static function collectionSchema(string $name, string $url, array $products): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'CollectionPage',
            'name' => $name,
            'url' => $url,
            'mainEntity' => [
                '@type' => 'ItemList',
                'numberOfItems' => count($products),
                'itemListElement' => array_values(array_map(static fn (array $product, int $index): array => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'url' => url('/urun/'.$product['slug']),
                    'name' => $product['name'],
                ], $products, array_keys($products))),
            ],
        ];
    }

    /** @param array<string, mixed> $product */
    public static function productSchema(array $product): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Product',
            'name' => $product['name'],
            'image' => [asset('images/'.($product['image'] ?? 'product-pack.jpg'))],
            'description' => $product['description'],
            'sku' => $product['slug'],
            'brand' => ['@type' => 'Organization', 'name' => self::SITE_NAME],
            'category' => $product['category_name'],
            'offers' => [
                '@type' => 'Offer',
                'price' => number_format((float) $product['price'], 2, '.', ''),
                'priceCurrency' => 'TRY',
                'availability' => 'https://schema.org/InStock',
                'url' => url('/urun/'.$product['slug']),
            ],
        ];
    }

    /** @param array<int, array{label: string, url: string}> $items */
    public static function breadcrumbs(array $items): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array_values(array_map(static fn (array $item, int $index): array => [
                '@type' => 'ListItem',
                'position' => $index + 1,
                'name' => $item['label'],
                'item' => $item['url'],
            ], $items, array_keys($items))),
        ];
    }

    private static function limitDescription(string $description): string
    {
        $description = trim($description);

        return mb_strlen($description, 'UTF-8') > 160
            ? rtrim(mb_substr($description, 0, 157, 'UTF-8')).'...'
            : $description;
    }
}
