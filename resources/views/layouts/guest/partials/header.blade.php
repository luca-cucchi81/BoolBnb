<header>
    <div class="container">
        <div class="header-left">
            <div id="logo">
                <a href="{{ url('/') }}">
                    <img src="{{asset('img/logo.png')}}" alt="logo">
                </a>
            </div>
        </div>
        <div class="header-right">
            <nav>
                <ul>
                    @guest
                        <li>
                            <button><a href="{{ route('login') }}">{{ __('Login') }}</a></button>
                        </li>
                        @if (Route::has('register'))
                            <li>
                                <button><a href="{{ route('register') }}">{{ __('Register') }}</a></button>
                            </li>
                        @endif
                    @else
                        <li>
                            <button id="btn-username">
                                <a href="#">
                                    {{ Auth::user()->info->name }} <span class="caret"></span>
                                </a>
                                <i class="fas fa-caret-down"></i>
                                <i class="fas fa-caret-left"></i>
                            </button>
                            <div class="dropdown">
                                <ul>
                                    <li>
                                        <a href="{{route('home')}}">Admin Area</a>
                                    </li>
                                    <li>
                                        <a href="{{ route('logout') }}"
                                        onclick="event.preventDefault();
                                        document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}</a>
                                        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </li>
                    @endguest
                </ul>
            </nav>
        </div>
    </div>
</header>

<script>
    $(document).ready(function(){
        $('#btn-username').click(function(){
            $('.dropdown').slideToggle();
            $('.fa-caret-left').toggle();
            $('.fa-caret-down').toggle();
        });
    });
</script>
