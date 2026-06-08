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
</body>
</html>
