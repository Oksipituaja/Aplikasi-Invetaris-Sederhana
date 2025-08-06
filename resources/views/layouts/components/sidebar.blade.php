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
            'icon' => 'fas fa-home',
            'roles' => ['user'],
        ],
    ])->filter(fn($menu) => in_array($role, $menu->roles));
@endphp

<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
@if ($user)
    <div class="user-panel mt-3 pb-3 mb-3 px-3">
        <div class="info">
            <a href="#" class="d-block text-white">
                <div class="d-flex flex-column flex-sm-row align-items-start align-items-sm-center justify-content-between gap-2">
                    {{-- Icon + Username --}}
                    <div class="d-flex align-items-center gap-2">
                        <i class="fas {{ $role === 'admin' ? 'fa-user-gear' : 'fa-user' }} fa-xl text-white mr-2"></i>
                        <span class="text-lg text-break mr-2">{{ $user->name }}</span>
                    </div>

                    {{-- Badge Role --}}
                    <span class="badge bg-primary text-uppercase fw-bold px-3 py-1">
                        {{ ucfirst($role) }}
                    </span>
                </div>
            </a>
        </div>
    </div>
@endif
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
