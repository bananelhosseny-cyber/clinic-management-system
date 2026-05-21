<nav style="background:#f8fafc; padding:15px; border-bottom:1px solid #e5e7eb;">
    <div style="max-width:1200px; margin:auto; display:flex; justify-content:space-between; align-items:center;">

        {{-- Left side --}}
        <div>
          
        </div>

        {{-- Right side --}}
        <div>
            @auth
                <span style="margin-right:15px;">
                    Welcome, {{ Auth::user()->name ?? Auth::user()->email }}
                </span>

                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <button type="submit" style="background:#ef4444;color:white;border:none;padding:6px 12px;border-radius:4px;cursor:pointer;">
                        Logout
                    </button>
                </form>
            @endauth

            @guest
                <a href="{{ route('login') }}" style="margin-right:10px;">Login</a>
                <a href="{{ route('register') }}">Register</a>
            @endguest
        </div>

    </div>
</nav>

