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
    ])->filter(fn($menu) => in_array($role, $menu->roles));
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <a href="#" class="brand-link">
        <img src="{{ asset('templates/dist/img/AdminLTELogo.png') }}" alt="Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Waspadalah</span>
    </a>

    <div class="sidebar">
        @if ($user)
        <div class="user-panel mt-3 pb-3 mb-3 d-flex align-items-center">
            <div class="image">
                <img src="{{ asset('templates/dist/img/avatar.png') }}" class="img-circle elevation-2" alt="User">
            </div>
            <div class="info">
                <a href="#" class="d-block">
                    {{ $user->name }}
                    <span class="badge bg-info text-white ms-1">{{ ucfirst($role) }}</span>
                </a>
            </div>
        </div>
        @endif

        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Cari menu..." aria-label="Search">
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
            </ul>
        </nav>
    </div>
</aside>