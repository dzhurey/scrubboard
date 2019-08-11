<header class="c-header row no-gutters">
    <div class="c-bars">
        <img class="svg" src="{{ asset('assets/images/icons/menu.svg') }}" alt="menu">
    </div>
    <div class="c-search">
        <div class="c-search--inner">
            <input class="form-control border-0" placeholder="Pencarian">
        </div>
        <img class="svg" src="{{ asset('assets/images/icons/search.svg') }}" alt="search">
    </div>
    <div class="c-user dropdown">
        <div class="c-user--inner row no-gutters" id="dropdown-user" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <div class="c-user--avatar">
                <img class="svg" src="{{ asset('assets/images/icons/user.svg') }}" alt="user">
            </div>
            <div class="c-user--name">
                {{ Auth::user()->person->name }}
            </div>
            <div class="c-user--arrow">
                <img class="svg" src="{{ asset('assets/images/icons/chevron-down.svg') }}" alt="user">
            </div>
        </div>
        <div class="dropdown-menu" aria-labelledby="dropdown-user">
            <a class="dropdown-item" href="{{ route('logout') }}"
              onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
              {{ __('Logout') }}
            </a>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</header>
