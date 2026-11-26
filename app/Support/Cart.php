<?php

namespace App\Support;

final class Cart
{
    private const SESSION_KEY = 'cart';
    private const MAX_QUANTITY = 20;
    private const SHIPPING_THRESHOLD = 500;
    private const SHIPPING_FEE = 79;

    /** @return array<int, array{product: array<string, mixed>, quantity: int, line_total: int}> */
    public static function items(): array
    {
        $items = [];

        foreach (self::cart() as $slug => $quantity) {
            $product = Catalog::find((string) $slug);
            $quantity = (int) $quantity;

            if ($product === null || $quantity < 1) {
                continue;
            }

            $quantity = min($quantity, self::MAX_QUANTITY);
            $items[] = [
                'product' => $product,
                'quantity' => $quantity,
                'line_total' => (int) $product['price'] * $quantity,
            ];
        }

        return $items;
    }

    public static function count(): int
    {
        return array_sum(array_column(self::items(), 'quantity'));
    }

    public static function subtotal(): int
    {
        return array_sum(array_column(self::items(), 'line_total'));
    }

    public static function add(string $slug, int $qty = 1): void
    {
        $product = Catalog::find($slug);

        if ($product === null) {
            return;
        }

        $cart = self::cart();
        $cart[$slug] = min(self::MAX_QUANTITY, (int) ($cart[$slug] ?? 0) + max(1, min(self::MAX_QUANTITY, $qty)));
        self::store($cart);
    }

    public static function update(string $slug, int $qty): void
    {
        if (Catalog::find($slug) === null) {
            return;
        }

        if ($qty <= 0) {
            self::remove($slug);

            return;
        }

        $cart = self::cart();
        $cart[$slug] = min(self::MAX_QUANTITY, $qty);
        self::store($cart);
    }

    public static function remove(string $slug): void
    {
        $cart = self::cart();
        unset($cart[$slug]);
        self::store($cart);
    }

    public static function clear(): void
    {
        self::store([]);
    }

    public static function shipping(): int
    {
        $subtotal = self::subtotal();

        return $subtotal > 0 && $subtotal < self::SHIPPING_THRESHOLD ? self::SHIPPING_FEE : 0;
    }

    public static function total(): int
    {
        return self::subtotal() + self::shipping();
    }

    public static function freeShippingThreshold(): int
    {
        return self::SHIPPING_THRESHOLD;
    }

    /** @return array<string, int> */
    private static function cart(): array
    {
        $cart = session()->get(self::SESSION_KEY, []);

        return is_array($cart) ? $cart : [];
    }

    /** @param array<string, int> $cart */
    private static function store(array $cart): void
    {
        session()->put(self::SESSION_KEY, $cart);
    }
}
