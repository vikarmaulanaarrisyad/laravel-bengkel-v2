<div id="top-header">
    <div class="container">
        <ul class="header-links pull-left">
            <li><a href="#"><i class="fa fa-phone"></i>{{ $setting->phone }}</a></li>
            <li><a href="#"><i class="fa fa-envelope-o"></i>{{ $setting->email }}</a></li>
            <li><a href="#"><i class="fa fa-map-marker"></i> {{ $setting->address }}</a></li>
        </ul>
        <ul class="header-links pull-right">
            @auth
                <li>
                    <a href="#">
                        <i class="fa fa-user-o"></i> Welcome, {{ auth()->user()->name }}</span>
                    </a>
                </li>
                <li><a href="{{ route('front.checkout_history') }}"><i class="fa fa-history"></i> History Order</a></li>
                <li><a href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i
                            class="fa fa-sign-out-alt"></i> Logout</a></li>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                </form>
            @else
                <li><a href="{{ route('login') }}"><i class="fa fa-sign-in-alt"></i> Login</a></li>
                <li><a href="{{ route('register') }}"><i class="fa fa-sign-in-alt"></i> Register</a></li>
            @endauth
        </ul>
    </div>
</div>
