@php($categories = \App\Support\Catalog::categories())
<footer class="site-footer bg-bordo text-krem">
    <div class="container-page grid gap-10 py-14 md:grid-cols-2 lg:grid-cols-[1.35fr_1fr_1fr_1.2fr] lg:gap-12">
        <div>
            <a href="{{ route('home') }}" class="inline-flex items-center" aria-label="Elbistan Sofrası ana sayfa">
                <img src="{{ asset('images/logo-light.png') }}" alt="Elbistan Sofrası" width="304" height="240" class="h-20 w-auto">
            </a>
            <p class="mt-5 max-w-xs text-sm leading-7 text-krem/80">Dört kuşaktır Elbistan'da tarhana, salça ve baharat üreten bir ailenin dijital kileri.</p>
            <div class="mt-6 flex gap-3">
                <a href="{{ route('home') }}#instagram" aria-label="Instagram" class="footer-social"><x-icon-instagram :size="17" /></a>
                <a href="{{ route('home') }}#youtube" aria-label="YouTube" class="footer-social"><x-icon-youtube :size="17" /></a>
                <a href="{{ route('home') }}#whatsapp" aria-label="WhatsApp" class="footer-social"><x-icon-whatsapp :size="17" /></a>
            </div>
        </div>
        <div>
            <h3 class="footer-heading">Kategoriler</h3>
            <ul class="mt-5 space-y-3 text-sm text-krem/80">
                @foreach ($categories as $category)<li><a href="{{ route('category.show', $category['slug']) }}" class="footer-link">{{ $category['name'] }}</a></li>@endforeach
            </ul>
        </div>
        <div>
            <h3 class="footer-heading">Kurumsal</h3>
            <ul class="mt-5 space-y-3 text-sm text-krem/80">
                <li><a href="{{ route('page.story') }}" class="footer-link">Hikâyemiz</a></li>
                <li><a href="{{ route('home') }}#surec" class="footer-link">Üretim</a></li>
                <li><a href="{{ route('recipes.index') }}" class="footer-link">Tarifler</a></li>
                <li><a href="{{ route('home') }}#iletisim" class="footer-link">İletişim</a></li>
                <li><a href="{{ route('home') }}#kvkk" class="footer-link">KVKK</a></li>
            </ul>
        </div>
        <div>
            <h3 class="footer-heading">Müşteri Hizmetleri</h3>
            <ul class="mt-5 space-y-3 text-sm text-krem/80">
                <li><a href="{{ route('home') }}#sss" class="footer-link">Sıkça Sorulan Sorular</a></li>
                <li><a href="{{ route('home') }}#kargo" class="footer-link">Sipariş Takibi</a></li>
                <li><a href="{{ route('home') }}#iletisim" class="footer-link">İletişim</a></li>
            </ul>
            <a href="https://wa.me/903440000000" class="mt-6 inline-flex items-center gap-2 rounded-full bg-zeytin px-4 py-2.5 text-xs font-bold text-white transition hover:bg-bordo-dark"><x-icon-whatsapp :size="18" /> WhatsApp Destek</a>
            <div class="mt-7">
                <p class="footer-heading">Ödeme yöntemleri</p>
                <div class="mt-3 flex flex-wrap gap-2"><span class="payment-badge">VISA</span><span class="payment-badge">Mastercard</span><span class="payment-badge">TROY</span></div>
            </div>
        </div>
    </div>
    <div class="border-t border-white/20">
        <div class="container-page flex flex-col gap-3 py-4 text-xs text-krem/75 sm:flex-row sm:items-center sm:justify-between">
            <p>© 2026 Elbistan Sofrası. Tüm hakları saklıdır.</p>
            <p>Elbistan, Kahramanmaraş · 0344 000 00 00 · merhaba@elbistansofrasi.com</p>
        </div>
    </div>
</footer>