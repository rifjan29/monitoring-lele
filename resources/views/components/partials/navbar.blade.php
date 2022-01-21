<nav class="navbar navbar-expand navbar-light navbar-bg">
    <a class="sidebar-toggle js-sidebar-toggle">
        <i class="hamburger align-self-center"></i>
    </a>

    <div class="navbar-collapse collapse">
        <ul class="navbar-nav navbar-align">
            <li class="nav-item dropdown">
                <a class="nav-icon dropdown-toggle d-inline-block d-sm-none" href="#" data-bs-toggle="dropdown">
                    <i class="align-middle" data-feather="settings"></i>
                </a>
                @if (Route::has('login'))
                    @auth
                    <a class="nav-link dropdown-toggle d-none d-sm-inline-block" href="#" data-bs-toggle="dropdown">
                        <svg width="50" height="50" viewBox="0 0 145 145" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <circle cx="72.5" cy="72.5" r="72.5" fill="#B5B8BD"/>
                            <mask id="mask0_1460_4369" style="mask-type:alpha" maskUnits="userSpaceOnUse" x="0" y="0" width="145" height="145">
                            <circle cx="72.5" cy="72.5" r="72.5" fill="#FF9292"/>
                            </mask>
                            <g mask="url(#mask0_1460_4369)">
                            <path d="M138.227 148.116C138.425 112.426 109.656 83.3434 73.9826 83.1457C38.2928 82.9479 9.21042 111.717 9.0127 147.391L138.227 148.116Z" fill="#5E5E5D"/>
                            </g>
                            <path d="M73.3186 83.7473C57.7696 83.7473 44.4883 86.1988 44.4883 96.0048C44.4883 105.814 57.6867 108.352 73.3186 108.352C88.8675 108.352 102.149 105.904 102.149 96.0949C102.149 86.2853 88.954 83.7473 73.3186 83.7473Z" fill="#1E1313"/>
                            <path opacity="0.4" d="M73.3186 74.4068C83.9105 74.4068 92.397 65.9167 92.397 55.3284C92.397 44.7401 83.9105 36.25 73.3186 36.25C62.7303 36.25 54.2402 44.7401 54.2402 55.3284C54.2402 65.9167 62.7303 74.4068 73.3186 74.4068Z" fill="#1E1313"/>
                            </svg>
                            <span class="text-dark">{{ Auth::user()->name }}</span>
                    </a>
                    @else
                        <a href="{{ route('login') }}" class="text-sm text-gray-700 dark:text-gray-500 underline">Log in</a>
                    @endauth
                @endif
                <div class="dropdown-menu dropdown-menu-end">

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a class="dropdown-item" href="{{ route('logout') }}"  onclick="event.preventDefault();
                        this.closest('form').submit();">Log out</a>
                    </form>
                </div>
            </li>
        </ul>
    </div>
</nav>
