<ul class="navbar-nav iq-main-menu" id="sidebar">
    {{-- <li class="nav-item static-item">
        <a class="nav-link static-item disabled" href="#" tabindex="-1">
            <span class="default-icon">Home</span>
            <span class="mini-icon">-</span>
        </a>
    </li> --}}

    <li class="nav-item">
        <a class="nav-link {{ activeRoute(route('dashboard')) }}" aria-current="page" href="{{ route('dashboard') }}">
            <i class="icon">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                    stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m3 9 9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
                    <polyline points="9 22 9 12 15 12 15 22"></polyline>
                </svg>
            </i>

            <span class="item-name">{{ __('Dashboard') }}</span>
        </a>
    </li>
    @foreach ($menus as $menu)
    @if ($menu->permissions_roles!=null)
    @php
    $permissions_role = explode(',',$menu->permissions_roles);
    @endphp
    @hasanyrole($permissions_role)
    <li class="nav-item mb-2">
        @if (Route::has($menu->link))
        <a class="nav-link {{activeRoute(route($menu->link))}}" aria-current="page" href="{{route($menu->link)}}">
            @else
            <a class="nav-link aria-current" href="#">
                @endif
                <i class="icon">
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                    </svg> --}}
                    <x-lucide-info class="w-4 h-4 text-gray-500" />
                </i>
                <span class="item-name">{{$menu->title}}</span>
            </a>
            {{-- <br> --}}
    </li>
    @else
    @canany($permissions_role)
    <li class="nav-item mb-2">
        @if (Route::has($menu->link))
        <a class="nav-link {{activeRoute(route($menu->link))}}" aria-current="page" href="{{route($menu->link)}}">
            @else
            <a class="nav-link aria-current" href="#">
                @endif
                <i class="icon">
                    {{-- <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="22 12 18 12 15 21 9 3 6 12 2 12"></polyline>
                    </svg> --}}
                    <x-lucide-info class="w-4 h-4 text-gray-500" />
                </i>
                <span class="item-name">{{$menu->title}}</span>
            </a>
            {{-- <br> --}}
    </li>
    @endcanany
    @endhasanyrole
    @endif
    @endforeach
</ul>
