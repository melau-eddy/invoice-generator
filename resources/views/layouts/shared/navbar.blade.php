<nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
    @yield('nav')
    <div class="container">

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            <ul class="navbar-nav mr-auto">
            @if (Auth::user())
                @if(auth()->user()->hasRole('admin'))
                <ul>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('Users')}}">USERS</a>
                    </li>
                </ul>

            <ul>
                <li class="nav-item">
                    <a class="nav-link" href="{{route('role.index')}}">ROLES</a>
                </li>
            </ul>

                    <ul>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('audit')}}">AUDIT LOG</a>
                        </li>
                    </ul>

                    <ul>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('company.index')}}">COMPANY</a>
                        </li>
                    </ul>
                    @endif
                    <ul>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('invoice.index')}}">INVOICE</a>
                        </li>
                    </ul>

                    <ul>
                        <li class="nav-item">
                            <a class="nav-link" href="{{route('editProfile', \Illuminate\Support\Facades\Auth::user()->id)}}">PROFILE</a>
                        </li>
                    </ul>
            </ul>
            @endif

            <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest

                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }}
                        </a>

                        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
