<header class="topbar">
    <div class="container nav">
        <a class="brand" href="{{ route('products.index') }}">Cart Management</a>
        <nav class="nav-links">
            <a href="{{ route('products.index') }}">Products</a>
            @auth
                @if(auth()->user()->isAdmin())
                    <a href="{{ route('admin.dashboard') }}">Admin</a>
                @else
                    <a href="{{ route('cart.index') }}">Cart <span data-cart-count>{{ auth()->user()->cart ? '('.auth()->user()->cart->items()->sum('quantity').')' : '' }}</span></a>
                    <a href="{{ route('orders.index') }}">My Orders</a>
                @endif
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="btn secondary" type="submit">Logout</button>
                </form>
            @else
                <a href="{{ route('login') }}">Login</a>
                <a class="btn" href="{{ route('register') }}">Register</a>
            @endauth
        </nav>
    </div>
</header>
