<?php

namespace App\Http\Controllers;

use App\Support\Cart;
use App\Support\Catalog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

final class CartController extends Controller
{
    public function index(): Response
    {
        return response()->view('cart.index', [
            'items' => Cart::items(),
            'subtotal' => Cart::subtotal(),
            'shipping' => Cart::shipping(),
            'total' => Cart::total(),
            'threshold' => Cart::freeShippingThreshold(),
            'cartCount' => Cart::count(),
        ]);
    }

    public function add(Request $request): JsonResponse
    {
        $slug = $this->validSlug($request);
        $qty = $this->validQuantity($request->input('qty'), 1, 20);

        if ($slug === null) {
            return $this->invalidProductResponse();
        }

        if ($qty === null) {
            return $this->invalidQuantityResponse();
        }

        Cart::add($slug, $qty);

        return response()->json([
            'count' => Cart::count(),
            'subtotal' => Cart::subtotal(),
            'message' => 'Ürün sepete eklendi.',
        ]);
    }

    public function update(Request $request): JsonResponse
    {
        $slug = $this->validSlug($request);
        $qty = $this->validQuantity($request->input('qty'), 0, 20);

        if ($slug === null) {
            return $this->invalidProductResponse();
        }

        if ($qty === null) {
            return $this->invalidQuantityResponse();
        }

        Cart::update($slug, $qty);
        $line = $this->line($slug);

        return response()->json([
            'count' => Cart::count(),
            'subtotal' => Cart::subtotal(),
            'totals' => $this->totals(),
            'line_total' => $line['line_total'] ?? 0,
            'removed' => $line === null,
        ]);
    }

    public function remove(Request $request): JsonResponse
    {
        $slug = $this->validSlug($request);

        if ($slug === null) {
            return $this->invalidProductResponse();
        }

        Cart::remove($slug);

        return response()->json([
            'count' => Cart::count(),
            'subtotal' => Cart::subtotal(),
            'totals' => $this->totals(),
            'line_total' => 0,
            'removed' => true,
        ]);
    }

    public function clear(): JsonResponse
    {
        Cart::clear();

        return response()->json([
            'count' => 0,
            'subtotal' => 0,
            'totals' => ['shipping' => 0, 'total' => 0],
        ]);
    }

    private function validSlug(Request $request): ?string
    {
        $slug = $request->input('slug');

        return is_string($slug) && Catalog::find($slug) !== null ? $slug : null;
    }

    private function validQuantity(mixed $value, int $minimum, int $maximum): ?int
    {
        if (is_bool($value) || (! is_int($value) && ! (is_string($value) && preg_match('/^\d+$/', $value)))) {
            return null;
        }

        $quantity = (int) $value;

        return $quantity >= $minimum && $quantity <= $maximum ? $quantity : null;
    }

    private function invalidProductResponse(): JsonResponse
    {
        return response()->json(['message' => 'Ürün bulunamadı.'], 422);
    }

    private function invalidQuantityResponse(): JsonResponse
    {
        return response()->json(['message' => 'Geçersiz adet.'], 422);
    }

    /** @return array{shipping: int, total: int} */
    private function totals(): array
    {
        return ['shipping' => Cart::shipping(), 'total' => Cart::total()];
    }

    /** @return array{line_total: int}|null */
    private function line(string $slug): ?array
    {
        foreach (Cart::items() as $item) {
            if ($item['product']['slug'] === $slug) {
                return ['line_total' => $item['line_total']];
            }
        }

        return null;
    }
}
