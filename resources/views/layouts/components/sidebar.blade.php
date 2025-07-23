@php
    $menus = [
        (object) [
            'title' => 'Dashboard',
            'path' => 'products',
            'icon' => 'fas fa-th',
        ],
        (object) [
            'title' => 'Produk',
            'path' => route('admin.products.index'),
            'icon' => 'fas fa-th',
        ],
        (object) [
            'title' => 'Kategori',
            'path' => route('admin.categories.index'),
            'icon' => 'fas fa-th',
        ],
    ];
@endphp


<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="templates/index3.html" class="brand-link">
        <img src="{{ asset('templates/dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo"
            class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Admin Waspadalah</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{ asset('templates/dist/img/avatar.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Admin Lagi Build Kah?</a>
            </div>
        </div>

        <!-- SidebarSearch Form -->
        <div class="form-inline">
            <div class="input-group" data-widget="sidebar-search">
                <input class="form-control form-control-sidebar" type="search" placeholder="Search"
                    aria-label="Search">
                <div class="input-group-append">
                    <button class="btn btn-sidebar">
                        <i class="fas fa-search fa-fw"></i>
                    </button>
                </div>
            </div>
        </div>


        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                @foreach ($menus as $menu)
                    <li class="nav-item">
                        <a href="{{ $menu->path }}" class="nav-link {{ request()->is(trim(parse_url($menu->path, PHP_URL_PATH), '/')) ? 'active' : '' }}">
                            <i class="nav-icon {{ $menu->icon }}"></i>
                            <p>
                                {{ $menu->title }}
                                {{-- <span class="right badge badge-danger">New</span> --}}
                            </p>
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
