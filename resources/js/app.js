(() => {
    if (window.__elbistanAppInitialized) return;
    window.__elbistanAppInitialized = true;

    const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
    const qs = (selector, scope = document) => scope.querySelector(selector);
    const qsa = (selector, scope = document) => [...scope.querySelectorAll(selector)];
    const csrfToken = qs('meta[name="csrf-token"]')?.content || '';

    const drawer = qs('[data-mobile-drawer]');
    const drawerBackdrop = qs('[data-drawer-backdrop]');
    const setDrawer = (open) => {
        if (!drawer || !drawerBackdrop) return;
        drawer.classList.toggle('translate-x-full', !open);
        drawerBackdrop.classList.toggle('hidden', !open);
        drawer.setAttribute('aria-hidden', String(!open));
        document.body.classList.toggle('drawer-open', open);
    };
    qs('[data-drawer-open]')?.addEventListener('click', () => setDrawer(true));
    qsa('[data-drawer-close]').forEach((button) => button.addEventListener('click', () => setDrawer(false)));
    drawerBackdrop?.addEventListener('click', () => setDrawer(false));
    drawer?.querySelectorAll('a').forEach((link) => link.addEventListener('click', () => setDrawer(false)));

    qsa('[data-mobile-accordion]').forEach((item) => {
        const trigger = qs('[data-mobile-trigger]', item);
        trigger?.addEventListener('click', () => {
            const open = item.classList.toggle('is-open');
            trigger.setAttribute('aria-expanded', String(open));
            const mark = trigger.querySelector('span');
            if (mark) mark.textContent = open ? '−' : '+';
        });
    });

    qsa('[data-dropdown]').forEach((dropdown) => {
        const trigger = qs('[data-dropdown-trigger]', dropdown);
        trigger?.addEventListener('click', (event) => {
            event.stopPropagation();
            qsa('[data-dropdown]').forEach((item) => {
                if (item !== dropdown) {
                    item.classList.remove('is-open');
                    qs('[data-dropdown-trigger]', item)?.setAttribute('aria-expanded', 'false');
                }
            });
            const open = dropdown.classList.toggle('is-open');
            trigger.setAttribute('aria-expanded', String(open));
        });
    });

    const siteHeader = qs('[data-site-header]');
    const updateHeader = () => siteHeader?.classList.toggle('header-scrolled', window.scrollY > 4);
    window.addEventListener('scroll', updateHeader, { passive: true });
    updateHeader();

    const formatPrice = (value) => `${new Intl.NumberFormat('tr-TR', { minimumFractionDigits: 2, maximumFractionDigits: 2 }).format(Number(value) || 0)} ₺`;
    const showToast = (message, isError = false) => {
        let toast = qs('[data-cart-toast]');
        if (!toast) {
            toast = document.createElement('div');
            toast.dataset.cartToast = 'true';
            toast.className = 'fixed bottom-5 left-1/2 z-[100] -translate-x-1/2 border px-4 py-3 text-sm font-semibold shadow-lg transition-opacity';
            document.body.appendChild(toast);
        }
        toast.textContent = message;
        toast.classList.toggle('border-bordo', isError);
        toast.classList.toggle('bg-bordo', isError);
        toast.classList.toggle('border-zeytin', !isError);
        toast.classList.toggle('bg-zeytin', !isError);
        toast.classList.add('text-white');
        toast.classList.remove('opacity-0');
        window.clearTimeout(toast.hideTimer);
        toast.hideTimer = window.setTimeout(() => toast.classList.add('opacity-0'), reducedMotion ? 1800 : 2600);
    };

    const requestCart = async (url, options = {}) => {
        const response = await fetch(url, {
            ...options,
            headers: {
                Accept: 'application/json',
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                ...(options.headers || {}),
            },
        });
        const data = await response.json().catch(() => ({}));
        if (!response.ok) throw new Error(data.message || 'Sepet işlemi tamamlanamadı.');
        return data;
    };

    const updateCartCount = (count) => {
        qsa('[data-cart-count]').forEach((element) => {
            element.textContent = String(count);
            element.classList.toggle('hidden', count < 1);
        });
        qsa('[data-cart-item-count]').forEach((element) => { element.textContent = `${count} ürün`; });
    };

    const setCartPageState = (isEmpty) => {
        qs('[data-cart-lines]')?.classList.toggle('hidden', isEmpty);
        qs('[data-cart-summary]')?.classList.toggle('hidden', isEmpty);
        qs('[data-empty-cart]')?.classList.toggle('hidden', !isEmpty);
        qs('[data-cart-clear]')?.classList.toggle('hidden', isEmpty);
    };

    const updateCartSummary = (data) => {
        const subtotal = Number(data.subtotal) || 0;
        const shipping = Number(data.totals?.shipping) || 0;
        const total = Number(data.totals?.total) || subtotal + shipping;
        qsa('[data-cart-subtotal]').forEach((element) => { element.textContent = formatPrice(subtotal); });
        qsa('[data-cart-total]').forEach((element) => { element.textContent = formatPrice(total); });
        qsa('[data-cart-shipping]').forEach((element) => {
            element.textContent = shipping === 0 ? 'Ücretsiz' : formatPrice(shipping);
            element.classList.toggle('text-zeytin', shipping === 0);
        });

        const summary = qs('[data-cart-summary]');
        const threshold = Number(summary?.dataset.threshold) || 500;
        const remaining = Math.max(0, threshold - subtotal);
        qsa('[data-shipping-message]').forEach((element) => {
            element.textContent = remaining > 0 ? `${formatPrice(remaining)} kaldı` : 'Ücretsiz kargo hakkı kazandınız';
        });
        qsa('[data-shipping-progress]').forEach((element) => {
            element.style.width = `${Math.min(100, Math.round((subtotal / threshold) * 100))}%`;
        });
    };

    qsa('[data-add-to-cart]').forEach((button) => {
        button.addEventListener('click', async () => {
            if (button.dataset.inFlight === 'true') return;
            const slug = button.dataset.productSlug;
            if (!slug) return;

            button.dataset.inFlight = 'true';
            const label = qs('[data-cart-label]', button);
            const original = label?.textContent || button.textContent;
            const quantityInput = button.parentElement?.querySelector('[data-stepper] input');
            const qty = Math.max(1, Math.min(20, Number(quantityInput?.value) || 1));

            try {
                const data = await requestCart('/sepet/ekle', { method: 'POST', body: JSON.stringify({ slug, qty }) });
                updateCartCount(Number(data.count) || 0);
                if (label) label.textContent = 'Eklendi ✓';
                button.classList.add('is-added');
                showToast(data.message || 'Ürün sepete eklendi.');
            } catch (error) {
                showToast(error.message, true);
            } finally {
                window.setTimeout(() => {
                    if (label) label.textContent = original;
                    button.classList.remove('is-added');
                    delete button.dataset.inFlight;
                }, 1400);
            }
        });
    });

    qsa('[data-stepper]').forEach((stepper) => {
        const input = qs('input', stepper);
        qsa('[data-step]', stepper).forEach((button) => button.addEventListener('click', () => {
            if (!input) return;
            const maximum = Number(input.max) || 20;
            input.value = String(Math.min(maximum, Math.max(1, (Number(input.value) || 1) + Number(button.dataset.step))));
            input.dispatchEvent(new Event('change', { bubbles: true }));
        }));
    });

    qsa('[data-cart-line]').forEach((line) => {
        const slug = line.dataset.cartSlug;
        const input = qs('[data-cart-quantity]', line);
        const updateLine = async (quantity) => {
            if (!slug || line.dataset.inFlight === 'true') return;
            line.dataset.inFlight = 'true';
            try {
                const data = await requestCart('/sepet/guncelle', { method: 'PATCH', body: JSON.stringify({ slug, qty: quantity }) });
                updateCartCount(Number(data.count) || 0);
                updateCartSummary(data);
                if (data.removed) {
                    line.remove();
                } else {
                    input.value = String(Math.max(1, Number(quantity) || 1));
                    qs('[data-line-total]', line).textContent = formatPrice(data.line_total);
                }
                setCartPageState((Number(data.count) || 0) === 0);
            } catch (error) {
                showToast(error.message, true);
            } finally {
                delete line.dataset.inFlight;
            }
        };

        input?.addEventListener('change', () => {
            const quantity = Number.parseInt(input.value, 10);
            updateLine(Number.isFinite(quantity) ? Math.min(20, Math.max(0, quantity)) : 1);
        });
        qs('[data-cart-remove]', line)?.addEventListener('click', () => updateLine(0));
    });

    qs('[data-cart-clear]')?.addEventListener('click', async () => {
        const button = qs('[data-cart-clear]');
        if (button.dataset.inFlight === 'true') return;
        button.dataset.inFlight = 'true';
        try {
            const data = await requestCart('/sepet/temizle', { method: 'POST', body: JSON.stringify({}) });
            qsa('[data-cart-line]').forEach((line) => line.remove());
            updateCartCount(0);
            updateCartSummary(data);
            setCartPageState(true);
            showToast('Sepet temizlendi.');
        } catch (error) {
            showToast(error.message, true);
        } finally {
            delete button.dataset.inFlight;
        }
    });

    qs('[data-coupon-form]')?.addEventListener('submit', (event) => event.preventDefault());

    qsa('[data-favorite-toggle]').forEach((button) => {
        button.addEventListener('click', () => {
            const active = button.getAttribute('aria-pressed') === 'true';
            button.setAttribute('aria-pressed', String(!active));
            button.classList.toggle('bg-bordo', !active);
            button.classList.toggle('text-white', !active);
            button.classList.toggle('bg-white/90', active);
            button.querySelector('svg')?.classList.toggle('fill-current', !active);
        });
    });

    qsa('[data-product-tab]').forEach((tab) => {
        tab.addEventListener('click', () => {
            const group = tab.dataset.productTab;
            qsa('[data-product-tab]').forEach((item) => {
                const selected = item === tab;
                item.setAttribute('aria-selected', String(selected));
                item.classList.toggle('border-bordo', selected);
                item.classList.toggle('text-bordo', selected);
                item.classList.toggle('border-transparent', !selected);
            });
            qsa('[data-product-card]').forEach((card) => card.classList.toggle('hidden', group !== 'all' && !(card.dataset.groups || '').split(',').includes(group)));
        });
    });

    qsa('[data-accordion]').forEach((item) => {
        const trigger = qs('[data-accordion-trigger]', item);
        const panel = qs('[data-accordion-panel]', item);
        trigger?.addEventListener('click', () => {
            const open = item.hasAttribute('data-open');
            item.toggleAttribute('data-open', !open);
            trigger.setAttribute('aria-expanded', String(!open));
            if (panel) panel.style.maxHeight = open ? '0px' : `${panel.scrollHeight}px`;
        });
    });

    qsa('[data-gallery-thumb]').forEach((thumb) => thumb.addEventListener('click', () => {
        const main = qs('[data-gallery-main]');
        if (!main) return;
        main.src = thumb.dataset.galleryThumb;
        qsa('[data-gallery-thumb]').forEach((item) => item.classList.remove('border-bordo'));
        thumb.classList.add('border-bordo');
    }));

    qsa('[data-newsletter-form]').forEach((form) => form.addEventListener('submit', (event) => {
        event.preventDefault();
        qs('button[type="submit"]', form)?.classList.add('hidden');
        qs('[data-newsletter-success]', form)?.classList.remove('hidden');
        qs('input', form)?.setAttribute('disabled', 'disabled');
    }));

    document.addEventListener('keydown', (event) => {
        if (event.key === 'Escape') {
            setDrawer(false);
            qsa('[data-dropdown]').forEach((dropdown) => {
                dropdown.classList.remove('is-open');
                qs('[data-dropdown-trigger]', dropdown)?.setAttribute('aria-expanded', 'false');
            });
        }
    });
})();
