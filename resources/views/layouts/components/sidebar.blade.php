@php
    use Illuminate\Support\Facades\Auth;

    $user = Auth::user();
    $role = $user?->role ?? 'guest';

    $menus = collect([
        (object) [
            'title' => 'Dashboard',
            'path' => route('admin.dashboard'),
            'icon' => 'fas fa-home',
            'roles' => ['admin'],
        ],
        (object) [
            'title' => 'Barang',
            'path' => route('admin.products.index'),
            'icon' => 'fas fa-cube',
            'roles' => ['admin'],
        ],
        (object) [
            'title' => 'Kategori',
            'path' => route('admin.categories.index'),
            'icon' => 'fas fa-tags',
            'roles' => ['admin'],
        ],
        (object) [
            'title' => 'Manajemen Pengguna',
            'path' => route('admin.users.index'),
            'icon' => 'fas fa-users',
            'roles' => ['admin'],
        ],
        (object) [
            'title' => 'Home Pengguna',
            'path' => route('user.home'),
            'icon' => 'fas fa-user',
            'roles' => ['user'],
        ],
    ])->filter(fn($menu) => in_array($role, $menu->roles));
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
        @if ($user)
            <div class="user-panel mt-3 pb-3 mb-3">
                <div class="info ps-2">
                    <a href="#" class="d-block">
                        <div class="d-flex flex-column flex-md-row justify-content-md-between align-items-md-center gap-3">
                            <h2 class="h6 mb-0 mr-2 text-white">{{ $user->name }}</h2>
                            <span class="badge bg-primary fw-bold text-uppercase px-3 py-1">
                                {{ ucfirst($role) }}
                            </span>
                        </div>
                    </a>
                </div>
            </div>
        @endif

        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Cari menu..."
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar"><i class="fas fa-search fa-fw"></i></button>
                </div>
            </div>
        </div>

        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu">
                @foreach ($menus as $menu)
                    <li class="nav-item">
                        <a href="{{ $menu->path }}"
                            class="nav-link {{ request()->is(trim(parse_url($menu->path, PHP_URL_PATH), '/')) ? 'active' : '' }}">
                            <i class="nav-icon {{ $menu->icon }}"></i>
                            <p>{{ $menu->title }}</p>
                        </a>
                    </li>
                @endforeach

                <li class="nav-item mt-3 border-top pt-2">
                    <a href="{{ route('profile') }}" class="nav-link">
                        <i class="nav-icon fas fa-id-card"></i>
                        <p>Profil Saya</p>
                    </a>
                </li>
                <li class="nav-item">
                    <form action="{{ route('logout') }}" method="POST" class="nav-link p-0 m-0">
                        @csrf
                        <button type="submit" class="btn btn-link text-left w-100 nav-link">
                            <i class="nav-icon fas fa-sign-out-alt"></i>
                            <p>Keluar</p>
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>
</aside>
