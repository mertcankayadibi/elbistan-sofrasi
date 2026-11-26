<?php

namespace App\Support;

final class Catalog
{
    /** @return array<int, array<string, mixed>> */
    public static function categories(): array
    {
        $categories = [
            ['name' => 'Tarhana & Erişte', 'slug' => 'tarhana-eriste', 'description' => 'Güneşte kuruyan, kaşıkta açılan.', 'image' => 'kategori-1.jpg'],
            ['name' => 'Salçalar', 'slug' => 'salcalar', 'description' => 'Bakır kazanda, sabırla.', 'image' => 'kategori-2.jpg'],
            ['name' => 'Baharat & İsot', 'slug' => 'baharat-isot', 'description' => 'Dumanı üstünde, ölçüsünde.', 'image' => 'kategori-1.jpg'],
            ['name' => 'Kurutmalık', 'slug' => 'kurutmalik', 'description' => 'Yazın kurur, kışın sofraya gelir.', 'image' => 'kategori-2.jpg'],
            ['name' => 'Bakliyat & Tahıl', 'slug' => 'bakliyat-tahil', 'description' => 'Tarladan, taş değirmenden.', 'image' => 'kategori-1.jpg'],
            ['name' => 'Tatlı & Kahvaltılık', 'slug' => 'tatli-kahvaltilik', 'description' => 'Pekmez, ceviz, sucuk.', 'image' => 'kategori-2.jpg'],
        ];

        return array_map(static function (array $category): array {
            $category['count'] = self::count($category['slug']);

            return $category;
        }, $categories);
    }

    /** @return array<int, array<string, mixed>> */
    public static function products(): array
    {
        return [
            ['name' => 'Dolmalık Kuru Biber (Dizi)', 'slug' => 'dolmalik-kuru-biber', 'category' => 'kurutmalik', 'category_name' => 'Kurutmalık', 'weight' => '50 adet', 'price' => 249, 'old_price' => 299, 'image' => 'p-kuru-biber.jpg', 'badge' => 'Çok satan', 'rating' => 4.9, 'reviews' => 86, 'description' => 'İğneyle dizilmiş, gölgede kurutulmuş tatlı biber.', 'groups' => ['all', 'bestsellers']],
            ['name' => 'Dolmalık Kuru Patlıcan', 'slug' => 'dolmalik-kuru-patlican', 'category' => 'kurutmalik', 'category_name' => 'Kurutmalık', 'weight' => '40-45 adet', 'price' => 289, 'old_price' => 349, 'image' => 'p-patlican.jpg', 'badge' => 'Çok satan', 'rating' => 4.9, 'reviews' => 124, 'description' => 'Acılığı alınmış, tek tek seçilmiş patlıcan.', 'groups' => ['all', 'bestsellers']],
            ['name' => 'Kuru Domates', 'slug' => 'kuru-domates-250-g', 'category' => 'kurutmalik', 'category_name' => 'Kurutmalık', 'weight' => '250 g', 'price' => 149, 'old_price' => null, 'image' => 'p-kuru-domates.jpg', 'badge' => 'Yeni', 'rating' => 4.7, 'reviews' => 41, 'description' => 'Tuzlanıp güneşte kurutulmuş, zeytinyağına hazır.', 'groups' => ['all', 'new']],
            ['name' => 'Kuru Biber (İpli)', 'slug' => 'kuru-biber-ipli-250-g', 'category' => 'kurutmalik', 'category_name' => 'Kurutmalık', 'weight' => '250 g', 'price' => 129, 'old_price' => null, 'image' => 'p-kuru-biber.jpg', 'badge' => null, 'rating' => 4.6, 'reviews' => 33, 'description' => 'Sofra biberi; kahvaltıda da, yemekte de.', 'groups' => ['all']],
            ['name' => 'Yöresel Pul Biber', 'slug' => 'yoresel-pul-biber-250-g', 'category' => 'baharat-isot', 'category_name' => 'Baharat & İsot', 'weight' => '250 g', 'price' => 149, 'old_price' => 179, 'image' => 'p-pulbiber.jpg', 'badge' => 'Çok satan', 'rating' => 4.8, 'reviews' => 152, 'description' => 'Kahramanmaraş biberi, çekirdeği alınmış.', 'groups' => ['all', 'bestsellers']],
            ['name' => 'Urfa İsot', 'slug' => 'urfa-isot-250-g', 'category' => 'baharat-isot', 'category_name' => 'Baharat & İsot', 'weight' => '250 g', 'price' => 169, 'old_price' => null, 'image' => 'p-isot.jpg', 'badge' => null, 'rating' => 4.9, 'reviews' => 63, 'description' => 'Duman kokusu baskın, acılığı ölçülü.', 'groups' => ['all', 'new']],
            ['name' => 'Sumak', 'slug' => 'sumak-200-g', 'category' => 'baharat-isot', 'category_name' => 'Baharat & İsot', 'weight' => '200 g', 'price' => 99, 'old_price' => null, 'image' => 'p-sumak.jpg', 'badge' => null, 'rating' => 4.7, 'reviews' => 58, 'description' => 'Ekşiliği yumuşak, sofranın olmazsa olmazı.', 'groups' => ['all']],
            ['name' => 'Karabiber', 'slug' => 'karabiber-100-g', 'category' => 'baharat-isot', 'category_name' => 'Baharat & İsot', 'weight' => '100 g', 'price' => 89, 'old_price' => null, 'image' => 'p-karabiber.jpg', 'badge' => null, 'rating' => 4.6, 'reviews' => 44, 'description' => 'Yeni çekilmiş, keskin kokulu.', 'groups' => ['all']],
            ['name' => 'Kimyon', 'slug' => 'kimyon-100-g', 'category' => 'baharat-isot', 'category_name' => 'Baharat & İsot', 'weight' => '100 g', 'price' => 79, 'old_price' => null, 'image' => 'p-kimyon.jpg', 'badge' => null, 'rating' => 4.5, 'reviews' => 29, 'description' => 'Elbistan mutfağının gizli ölçüsü.', 'groups' => ['all']],
            ['name' => 'Ev Yapımı Biber Salçası', 'slug' => 'ev-yapimi-biber-salcasi-1-kg', 'category' => 'salcalar', 'category_name' => 'Salçalar', 'weight' => '1 kg', 'price' => 249, 'old_price' => 299, 'image' => 'p-salca-biber.jpg', 'badge' => 'El emeği', 'rating' => 4.8, 'reviews' => 96, 'description' => 'Közlenmiş biber, bakır kazanda üç gün.', 'groups' => ['all', 'bestsellers']],
            ['name' => 'Domates Salçası', 'slug' => 'domates-salcasi-1-kg', 'category' => 'salcalar', 'category_name' => 'Salçalar', 'weight' => '1 kg', 'price' => 229, 'old_price' => null, 'image' => 'p-salca-domates.jpg', 'badge' => null, 'rating' => 4.7, 'reviews' => 74, 'description' => 'Tuz ve güneş; başka hiçbir şey yok.', 'groups' => ['all']],
            ['name' => 'Tatlı Biber Salçası', 'slug' => 'tatli-biber-salcasi-500-g', 'category' => 'salcalar', 'category_name' => 'Salçalar', 'weight' => '500 g', 'price' => 139, 'old_price' => null, 'image' => 'p-salca-biber.jpg', 'badge' => null, 'rating' => 4.6, 'reviews' => 37, 'description' => 'Yumuşak içimli, çocukların da sevdiği.', 'groups' => ['all', 'new']],
            ['name' => 'Elbistan Usulü Tarhana', 'slug' => 'elbistan-tarhana-1-kg', 'category' => 'tarhana-eriste', 'category_name' => 'Tarhana & Erişte', 'weight' => '1 kg', 'price' => 219, 'old_price' => 259, 'image' => 'p-tarhana.jpg', 'badge' => 'Çok satan', 'rating' => 4.9, 'reviews' => 128, 'description' => 'Yoğurt ve buğday, güneşte yedi gün.', 'groups' => ['all', 'bestsellers']],
            ['name' => 'Tarhana', 'slug' => 'tarhana-500-g', 'category' => 'tarhana-eriste', 'category_name' => 'Tarhana & Erişte', 'weight' => '500 g', 'price' => 119, 'old_price' => null, 'image' => 'p-tarhana.jpg', 'badge' => null, 'rating' => 4.8, 'reviews' => 61, 'description' => 'Küçük tencereler için pratik paket.', 'groups' => ['all']],
            ['name' => 'Ev Eriştesi', 'slug' => 'ev-eristesi-500-g', 'category' => 'tarhana-eriste', 'category_name' => 'Tarhana & Erişte', 'weight' => '500 g', 'price' => 129, 'old_price' => null, 'image' => 'p-eriste.jpg', 'badge' => 'Yeni', 'rating' => 4.7, 'reviews' => 22, 'description' => 'Yumurta ve un; elde kesilmiş.', 'groups' => ['all', 'new']],
            ['name' => 'Pilavlık Bulgur', 'slug' => 'pilavlik-bulgur-1-kg', 'category' => 'bakliyat-tahil', 'category_name' => 'Bakliyat & Tahıl', 'weight' => '1 kg', 'price' => 89, 'old_price' => null, 'image' => 'p-bulgur.jpg', 'badge' => null, 'rating' => 4.6, 'reviews' => 58, 'description' => 'Taş değirmende çekilmiş, iri taneli.', 'groups' => ['all']],
            ['name' => 'Kırmızı Mercimek', 'slug' => 'kirmizi-mercimek-1-kg', 'category' => 'bakliyat-tahil', 'category_name' => 'Bakliyat & Tahıl', 'weight' => '1 kg', 'price' => 99, 'old_price' => null, 'image' => 'p-mercimek.jpg', 'badge' => null, 'rating' => 4.7, 'reviews' => 41, 'description' => 'Yılın ilk hasadından, taşsız.', 'groups' => ['all', 'new']],
            ['name' => 'Yeşil Mercimek', 'slug' => 'yesil-mercimek-1-kg', 'category' => 'bakliyat-tahil', 'category_name' => 'Bakliyat & Tahıl', 'weight' => '1 kg', 'price' => 109, 'old_price' => null, 'image' => 'p-yesil-mercimek.jpg', 'badge' => null, 'rating' => 4.5, 'reviews' => 26, 'description' => 'El ile ayıklanmış, ince kabuklu.', 'groups' => ['all']],
            ['name' => 'Nohut', 'slug' => 'nohut-1-kg', 'category' => 'bakliyat-tahil', 'category_name' => 'Bakliyat & Tahıl', 'weight' => '1 kg', 'price' => 109, 'old_price' => null, 'image' => 'p-nohut.jpg', 'badge' => null, 'rating' => 4.5, 'reviews' => 33, 'description' => 'Eleme yerine el ile ayıklanır.', 'groups' => ['all']],
            ['name' => 'Ceviz İçi', 'slug' => 'ceviz-ici-500-g', 'category' => 'tatli-kahvaltilik', 'category_name' => 'Tatlı & Kahvaltılık', 'weight' => '500 g', 'price' => 289, 'old_price' => 329, 'image' => 'p-ceviz.jpg', 'badge' => 'Yeni hasat', 'rating' => 4.9, 'reviews' => 87, 'description' => 'Elbistan cevizi, elle kırılıp ayıklanır.', 'groups' => ['all', 'bestsellers', 'new']],
            ['name' => 'Üzüm Pekmezi', 'slug' => 'uzum-pekmezi-700-g', 'category' => 'tatli-kahvaltilik', 'category_name' => 'Tatlı & Kahvaltılık', 'weight' => '700 g', 'price' => 149, 'old_price' => null, 'image' => 'p-pekmez.jpg', 'badge' => null, 'rating' => 4.8, 'reviews' => 69, 'description' => 'Bakır kazanda, odun ateşinde.', 'groups' => ['all']],
            ['name' => 'Cevizli Sucuk', 'slug' => 'cevizli-sucuk-500-g', 'category' => 'tatli-kahvaltilik', 'category_name' => 'Tatlı & Kahvaltılık', 'weight' => '500 g', 'price' => 219, 'old_price' => null, 'image' => 'p-sucuk.jpg', 'badge' => 'El emeği', 'rating' => 4.7, 'reviews' => 52, 'description' => 'Üzüm şırası ve ceviz; katkısız.', 'groups' => ['all', 'bestsellers']],
            ['name' => 'Pestil', 'slug' => 'pestil-500-g', 'category' => 'tatli-kahvaltilik', 'category_name' => 'Tatlı & Kahvaltılık', 'weight' => '500 g', 'price' => 179, 'old_price' => null, 'image' => 'p-pestil.jpg', 'badge' => null, 'rating' => 4.6, 'reviews' => 31, 'description' => 'Gün kurusu üzümden, ince açılmış.', 'groups' => ['all']],
            ['name' => 'Köy Tereyağı', 'slug' => 'koy-tereyagi-500-g', 'category' => 'tatli-kahvaltilik', 'category_name' => 'Tatlı & Kahvaltılık', 'weight' => '500 g', 'price' => 349, 'old_price' => 399, 'image' => 'p-tereyagi.jpg', 'badge' => null, 'rating' => 4.8, 'reviews' => 48, 'description' => 'Yayıkta yayılmış, tuzu ölçülü.', 'groups' => ['all']],
            ['name' => 'Süzme Bal', 'slug' => 'suzme-bal-850-g', 'category' => 'tatli-kahvaltilik', 'category_name' => 'Tatlı & Kahvaltılık', 'weight' => '850 g', 'price' => 399, 'old_price' => 459, 'image' => 'p-bal.jpg', 'badge' => 'Yeni', 'rating' => 4.9, 'reviews' => 57, 'description' => 'Yayla çiçeğinden, süzme.', 'groups' => ['all', 'new']],
            ['name' => 'Kuru Patlıcan (İpli, 250 g)', 'slug' => 'kuru-patlican-ipli-250-g', 'category' => 'kurutmalik', 'category_name' => 'Kurutmalık', 'weight' => '250 g', 'price' => 139, 'old_price' => null, 'image' => 'p-patlican.jpg', 'badge' => null, 'rating' => 4.6, 'reviews' => 27, 'description' => 'İpe dizilmiş, ince kabuklu patlıcan.', 'groups' => ['a', 'l', 'l']],
            ['name' => 'Karışık Kurutmalık Paketi', 'slug' => 'karisik-kurutmalik-paketi', 'category' => 'kurutmalik', 'category_name' => 'Kurutmalık', 'weight' => '1 paket', 'price' => 279, 'old_price' => 329, 'image' => 'c-kurutmalik.jpg', 'badge' => 'El emeği', 'rating' => 4.8, 'reviews' => 45, 'description' => 'Patlıcan, biber ve domates bir arada.', 'groups' => ['b', 'e', 's', 't', 's', 'e', 'l', 'l', 'e', 'r', 's']],
            ['name' => 'Pul Biber (500 g)', 'slug' => 'pul-biber-500-g', 'category' => 'baharat-isot', 'category_name' => 'Baharat & İsot', 'weight' => '500 g', 'price' => 269, 'old_price' => null, 'image' => 'p-pulbiber.jpg', 'badge' => null, 'rating' => 4.8, 'reviews' => 71, 'description' => 'Büyük mutfaklar için ekonomik paket.', 'groups' => ['a', 'l', 'l']],
            ['name' => 'İsot (500 g)', 'slug' => 'isot-500-g', 'category' => 'baharat-isot', 'category_name' => 'Baharat & İsot', 'weight' => '500 g', 'price' => 319, 'old_price' => null, 'image' => 'p-isot.jpg', 'badge' => null, 'rating' => 4.9, 'reviews' => 38, 'description' => 'Duman kokusu, uzun süre dayanan paket.', 'groups' => ['a', 'l', 'l']],
            ['name' => 'Karabiber (250 g)', 'slug' => 'karabiber-250-g', 'category' => 'baharat-isot', 'category_name' => 'Baharat & İsot', 'weight' => '250 g', 'price' => 199, 'old_price' => null, 'image' => 'p-karabiber.jpg', 'badge' => null, 'rating' => 4.6, 'reviews' => 22, 'description' => 'Taze çekilmiş, keskin kokulu.', 'groups' => ['a', 'l', 'l']],
            ['name' => 'Biber Salçası (500 g)', 'slug' => 'biber-salcasi-500-g', 'category' => 'salcalar', 'category_name' => 'Salçalar', 'weight' => '500 g', 'price' => 139, 'old_price' => null, 'image' => 'p-salca-biber.jpg', 'badge' => null, 'rating' => 4.7, 'reviews' => 54, 'description' => 'Küçük kavanoz, aynı tarif.', 'groups' => ['a', 'l', 'l']],
            ['name' => 'Domates Salçası (500 g)', 'slug' => 'domates-salcasi-500-g', 'category' => 'salcalar', 'category_name' => 'Salçalar', 'weight' => '500 g', 'price' => 129, 'old_price' => null, 'image' => 'p-salca-domates.jpg', 'badge' => null, 'rating' => 4.6, 'reviews' => 49, 'description' => 'Tuz ve güneş, küçük boy.', 'groups' => ['a', 'l', 'l']],
            ['name' => 'Tarhana (250 g)', 'slug' => 'tarhana-250-g', 'category' => 'tarhana-eriste', 'category_name' => 'Tarhana & Erişte', 'weight' => '250 g', 'price' => 69, 'old_price' => null, 'image' => 'p-tarhana.jpg', 'badge' => null, 'rating' => 4.7, 'reviews' => 34, 'description' => 'Denemek için küçük paket.', 'groups' => ['a', 'l', 'l']],
            ['name' => 'Erişte (1 kg)', 'slug' => 'eriste-1-kg', 'category' => 'tarhana-eriste', 'category_name' => 'Tarhana & Erişte', 'weight' => '1 kg', 'price' => 229, 'old_price' => null, 'image' => 'p-eriste.jpg', 'badge' => null, 'rating' => 4.6, 'reviews' => 18, 'description' => 'Kalabalık sofralar için.', 'groups' => ['a', 'l', 'l']],
            ['name' => 'Köftelik Bulgur (1 kg)', 'slug' => 'koftelik-bulgur-1-kg', 'category' => 'bakliyat-tahil', 'category_name' => 'Bakliyat & Tahıl', 'weight' => '1 kg', 'price' => 79, 'old_price' => null, 'image' => 'p-bulgur.jpg', 'badge' => null, 'rating' => 4.5, 'reviews' => 36, 'description' => 'İnce çekilmiş, köfte ve kısır için.', 'groups' => ['a', 'l', 'l']],
            ['name' => 'Mercimek (500 g)', 'slug' => 'mercimek-500-g', 'category' => 'bakliyat-tahil', 'category_name' => 'Bakliyat & Tahıl', 'weight' => '500 g', 'price' => 59, 'old_price' => null, 'image' => 'p-mercimek.jpg', 'badge' => null, 'rating' => 4.6, 'reviews' => 24, 'description' => 'Çorbaya pratik ölçü.', 'groups' => ['a', 'l', 'l']],
            ['name' => 'Ceviz İçi (250 g)', 'slug' => 'ceviz-ici-250-g', 'category' => 'tatli-kahvaltilik', 'category_name' => 'Tatlı & Kahvaltılık', 'weight' => '250 g', 'price' => 159, 'old_price' => null, 'image' => 'p-ceviz.jpg', 'badge' => null, 'rating' => 4.8, 'reviews' => 39, 'description' => 'Küçük paket, taze kırım.', 'groups' => ['a', 'l', 'l']],
            ['name' => 'Üzüm Pekmezi (1 kg)', 'slug' => 'uzum-pekmezi-1-kg', 'category' => 'tatli-kahvaltilik', 'category_name' => 'Tatlı & Kahvaltılık', 'weight' => '1 kg', 'price' => 199, 'old_price' => null, 'image' => 'p-pekmez.jpg', 'badge' => null, 'rating' => 4.7, 'reviews' => 28, 'description' => 'Büyük boy, kahvaltı sofrası için.', 'groups' => ['a', 'l', 'l']],
            ['name' => 'Pestil (250 g)', 'slug' => 'pestil-250-g', 'category' => 'tatli-kahvaltilik', 'category_name' => 'Tatlı & Kahvaltılık', 'weight' => '250 g', 'price' => 99, 'old_price' => null, 'image' => 'p-pestil.jpg', 'badge' => null, 'rating' => 4.5, 'reviews' => 17, 'description' => 'Çayın yanına, ince açılmış.', 'groups' => ['a', 'l', 'l']],
            ['name' => 'Köy Tereyağı (250 g)', 'slug' => 'koy-tereyagi-250-g', 'category' => 'tatli-kahvaltilik', 'category_name' => 'Tatlı & Kahvaltılık', 'weight' => '250 g', 'price' => 189, 'old_price' => 219, 'image' => 'p-tereyagi.jpg', 'badge' => null, 'rating' => 4.7, 'reviews' => 31, 'description' => 'Yayık tereyağı, küçük kalıp.', 'groups' => ['a', 'l', 'l']],
        ];
    }

    /**
     * Kategoriler arasında harmanlanmış ürün listesi (vitrin ızgarası için).
     *
     * @return array<int, array<string, mixed>>
     */
    public static function interleaved(): array
    {
        $grouped = [];

        foreach (self::products() as $product) {
            $grouped[$product['category']][] = $product;
        }

        $ordered = [];

        while ($grouped !== []) {
            foreach (array_keys($grouped) as $category) {
                $ordered[] = array_shift($grouped[$category]);

                if ($grouped[$category] === []) {
                    unset($grouped[$category]);
                }
            }
        }

        return $ordered;
    }

    /** @return array<int, array<string, mixed>> */
    public static function all(): array
    {
        return self::products();
    }

    /** @return array<string, mixed>|null */
    public static function find(string $slug): ?array
    {
        foreach (self::products() as $product) {
            if ($product['slug'] === $slug) {
                return $product;
            }
        }

        return null;
    }

    /** @return array<int, array<string, mixed>> */
    public static function byCategory(string $slug): array
    {
        return array_values(array_filter(self::products(), static fn (array $product): bool => $product['category'] === $slug));
    }

    /** @return array<int, array<string, mixed>> */
    public static function featured(?string $group = null): array
    {
        if ($group === 'new') {
            return self::newest();
        }

        if ($group === 'bestsellers') {
            return array_values(array_filter(self::products(), static fn (array $product): bool => in_array('bestsellers', $product['groups'], true)));
        }

        return array_slice(array_values(array_filter(self::products(), static fn (array $product): bool => in_array('bestsellers', $product['groups'], true))), 0, 8);
    }

    /** @return array<int, array<string, mixed>> */
    public static function newest(): array
    {
        return array_values(array_filter(self::products(), static fn (array $product): bool => in_array('new', $product['groups'], true)));
    }

    /** @return array<int, array<string, mixed>> */
    public static function forRail(): array
    {
        return self::all();
    }

    /** @return array<int, array<string, mixed>> */
    public static function related(string $slug, int $limit = 4): array
    {
        $product = self::find($slug);

        if ($product === null) {
            return [];
        }

        $related = array_values(array_filter(self::byCategory($product['category']), static fn (array $candidate): bool => $candidate['slug'] !== $slug));

        if (count($related) < $limit) {
            $related = array_merge($related, array_values(array_filter(self::all(), static fn (array $candidate): bool => $candidate['slug'] !== $slug && ! in_array($candidate['slug'], array_column($related, 'slug'), true))));
        }

        return array_slice($related, 0, $limit);
    }

    public static function count(?string $categorySlug = null): int
    {
        return $categorySlug === null ? count(self::products()) : count(self::byCategory($categorySlug));
    }

    /** @return array<int, array<string, mixed>> */
    public static function spices(): array
    {
        $spices = [
            ['slug' => 'urfa-isot-250-g', 'fallback_name' => 'İsot', 'fallback_weight' => '250 g', 'fallback_price' => 169, 'icon' => 'pepper'],
            ['slug' => 'yoresel-pul-biber-250-g', 'fallback_name' => 'Pul Biber', 'fallback_weight' => '250 g', 'fallback_price' => 149, 'icon' => 'pepper'],
            ['slug' => 'sumak-200-g', 'fallback_name' => 'Sumak', 'fallback_weight' => '200 g', 'fallback_price' => 99, 'icon' => 'berry'],
            ['slug' => null, 'fallback_name' => 'Kuru Nane', 'fallback_weight' => '100 g', 'fallback_price' => 60, 'icon' => 'leaf'],
            ['slug' => 'karabiber-100-g', 'fallback_name' => 'Karabiber', 'fallback_weight' => '100 g', 'fallback_price' => 89, 'icon' => 'peppercorn'],
            ['slug' => 'kimyon-100-g', 'fallback_name' => 'Kimyon', 'fallback_weight' => '100 g', 'fallback_price' => 79, 'icon' => 'seed'],
        ];

        return array_map(static function (array $spice): array {
            $product = $spice['slug'] ? self::find($spice['slug']) : null;

            return [
                'name' => $product['name'] ?? $spice['fallback_name'],
                'weight' => $product['weight'] ?? $spice['fallback_weight'],
                'price' => $product['price'] ?? $spice['fallback_price'],
                'image' => $product['image'] ?? null,
                'slug' => $product['slug'] ?? null,
                'icon' => $spice['icon'],
            ];
        }, $spices);
    }

    public static function formatPrice(int|float|null $price): string
    {
        return number_format((float) $price, 2, ',', '.').' ₺';
    }
}
