<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Login')</title>
    <style>
        * { box-sizing: border-box; }
        body { margin: 0; min-height: 100vh; display: grid; place-items: center; font-family: Arial, sans-serif; color: #172026; background: #eef3f2; }
        .panel { width: min(420px, calc(100% - 32px)); background: #fff; border: 1px solid #d9e0e2; border-radius: 8px; padding: 24px; }
        .brand { margin: 0 0 8px; font-size: 24px; }
        .muted { color: #65747a; margin-top: 0; }
        label { display: block; font-weight: 700; margin: 14px 0 6px; }
        input { width: 100%; padding: 10px; border: 1px solid #b8c4c7; border-radius: 6px; font: inherit; background: #fff; }
        .row { display: flex; gap: 10px; align-items: center; }
        .btn { width: 100%; min-height: 40px; margin-top: 16px; border: 1px solid #116466; border-radius: 6px; background: #116466; color: #fff; cursor: pointer; font-weight: 700; }
        .error { background: #fdecec; color: #8a2424; padding: 12px; border-radius: 6px; margin-bottom: 14px; }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
