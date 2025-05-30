<div class="navbar">
    <div>
        <strong>@yield('page-title', 'Home')</strong>
    </div>
    <div>
        @auth
            <span>{{ Auth::user()->name }}</span>
            <button class="ml-2 bg-gray-200 px-2 py-1 rounded">👤</button>
        @endauth
    </div>
</div>

