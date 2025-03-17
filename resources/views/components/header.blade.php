<div class="d-flex justify-content-between align-items-center py-3">
    <div>
        <a href="{{ auth()->check() ? route('cart.index') : route('login') }}" class="btn btn-link">
            Корзина
        </a>
    </div>
    <div class="d-flex">
        @guest
            <a href="{{ route('login') }}" class="btn btn-link">Вход</a>
            <a href="{{ route('register') }}" class="btn btn-link ml-2">Регистрация</a>
        @else
            <a href="{{ route('logout') }}" class="btn btn-link ml-2"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                Выход
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        @endguest

    </div>
</div>
