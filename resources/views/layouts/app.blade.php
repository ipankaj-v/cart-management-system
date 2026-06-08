<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Ecommerce')</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; font-family: Arial, sans-serif; color: #172026; background: #f6f7f8; }
        a { color: #116466; text-decoration: none; }
        .container { width: min(1120px, calc(100% - 32px)); margin: 0 auto; }
        .topbar { background: #ffffff; border-bottom: 1px solid #d9e0e2; }
        .nav { min-height: 64px; display: flex; align-items: center; justify-content: space-between; gap: 16px; flex-wrap: wrap; }
        .brand { font-weight: 700; color: #172026; font-size: 20px; }
        .nav-links { display: flex; gap: 14px; align-items: center; flex-wrap: wrap; }
        .main { padding: 28px 0 48px; }
        .grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(230px, 1fr)); gap: 18px; }
        .card, .panel { background: #fff; border: 1px solid #d9e0e2; border-radius: 8px; padding: 18px; }
        .btn { display: inline-flex; align-items: center; justify-content: center; min-height: 38px; padding: 8px 14px; border-radius: 6px; border: 1px solid #116466; background: #116466; color: #fff; cursor: pointer; font-weight: 600; }
        .btn.secondary { background: #fff; color: #116466; }
        .btn.danger { background: #a33131; border-color: #a33131; }
        input, select, textarea { width: 100%; padding: 10px; border: 1px solid #b8c4c7; border-radius: 6px; font: inherit; background: #fff; }
        label { display: block; font-weight: 700; margin: 14px 0 6px; }
        table { width: 100%; border-collapse: collapse; background: #fff; }
        th, td { padding: 12px; border-bottom: 1px solid #d9e0e2; text-align: left; vertical-align: top; }
        .messages { margin-bottom: 18px; }
        .success { background: #e8f6ef; color: #1f6f43; padding: 12px; border-radius: 6px; }
        .error { background: #fdecec; color: #8a2424; padding: 12px; border-radius: 6px; }
        .muted { color: #65747a; }
        .row { display: flex; gap: 12px; align-items: center; flex-wrap: wrap; }
        .price { font-weight: 700; font-size: 18px; }
        .footer { padding: 24px 0; border-top: 1px solid #d9e0e2; background: #fff; color: #65747a; }
        .ajax-message { position: fixed; right: 18px; bottom: 18px; max-width: 320px; padding: 12px 14px; border-radius: 6px; background: #172026; color: #fff; box-shadow: 0 8px 24px rgba(0,0,0,.18); z-index: 20; }
    </style>
</head>
<body>
    @include('partials.navbar')
    <main class="main">
        <div class="container">
            @include('partials.messages')
            @yield('content')
        </div>
    </main>
    @include('partials.footer')
    <script>
        document.addEventListener('submit', async function (event) {
            const form = event.target.closest('[data-ajax-cart]');

            if (!form) {
                return;
            }

            event.preventDefault();

            const button = form.querySelector('button[type="submit"]');
            const originalText = button ? button.textContent : '';

            if (button) {
                button.disabled = true;
                button.textContent = 'Saving...';
            }

            try {
                const response = await fetch(form.action, {
                    method: form.method.toUpperCase(),
                    body: new FormData(form),
                    headers: {
                        'Accept': 'application/json',
                        'X-Requested-With': 'XMLHttpRequest',
                    },
                });
                const data = await response.json();

                if (!response.ok) {
                    const errors = data.errors ? Object.values(data.errors).flat().join(' ') : (data.message || 'Cart update failed.');
                    throw new Error(errors);
                }

                updateCartUi(data);
                showAjaxMessage(data.message || 'Cart updated.');
            } catch (error) {
                showAjaxMessage(error.message, true);
            } finally {
                if (button) {
                    button.disabled = false;
                    button.textContent = originalText;
                }
            }
        });

        function updateCartUi(data) {
            document.querySelectorAll('[data-cart-count]').forEach(function (element) {
                element.textContent = data.cart_count ? '(' + data.cart_count + ')' : '';
            });

            document.querySelectorAll('[data-cart-total]').forEach(function (element) {
                element.textContent = data.cart_total;
            });

            if (data.item) {
                const row = document.querySelector('[data-cart-row="' + data.item.id + '"]');

                if (row) {
                    const quantity = row.querySelector('input[name="quantity"]');
                    const lineTotal = row.querySelector('[data-line-total]');

                    if (quantity) {
                        quantity.value = data.item.quantity;
                    }

                    if (lineTotal) {
                        lineTotal.textContent = '₹' + data.item.line_total;
                    }
                }
            }

            if (data.deleted_item_id) {
                const row = document.querySelector('[data-cart-row="' + data.deleted_item_id + '"]');

                if (row) {
                    row.remove();
                }
            }

            if (data.is_empty) {
                const table = document.querySelector('[data-cart-table]');
                const totalRow = document.querySelector('[data-cart-total-row]');
                const checkoutLink = document.querySelector('[data-checkout-link]');

                if (totalRow) {
                    totalRow.remove();
                }

                if (checkoutLink) {
                    checkoutLink.remove();
                }

                if (table && !document.querySelector('[data-empty-cart]')) {
                    table.insertAdjacentHTML('beforeend', '<tr data-empty-cart><td colspan="5">Your cart is empty.</td></tr>');
                }
            }
        }

        function showAjaxMessage(message, isError) {
            const oldMessage = document.querySelector('.ajax-message');

            if (oldMessage) {
                oldMessage.remove();
            }

            const element = document.createElement('div');
            element.className = 'ajax-message';
            element.style.background = isError ? '#8a2424' : '#172026';
            element.textContent = message;
            document.body.appendChild(element);

            setTimeout(function () {
                element.remove();
            }, 2600);
        }
    </script>
</body>
</html>
