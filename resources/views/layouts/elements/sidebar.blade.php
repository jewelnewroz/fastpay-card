<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('assets/img/logo-white.png') }}" title="{{ config('') }}" class="brand-image" style="opacity: .8">
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link active">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>Dashboard</p>
                    </a>
                </li>

                <div class="dropdown-divider"></div>

                <li class="nav-item @if(request()->segment('2') === 'operator') menu-open @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-box"></i>
                        <p>Operators <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('operator.create') }}" class="nav-link @if($current_route_name == 'operator.create') active @endif">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Add new operator</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('operator.index') }}" class="nav-link @if($current_route_name == 'operator.index') active @endif">
                                <i class="fa fa-list nav-icon"></i>
                                <p>Operators</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item @if(request()->segment('2') === 'bundle') menu-open @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-boxes"></i>
                        <p>Bundles <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('bundle.create') }}" class="nav-link @if($current_route_name == 'bundle.create') active @endif">
                                <i class="fa fa-plus nav-icon"></i>
                                <p>Add new bundle</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('bundle.index') }}" class="nav-link @if($current_route_name == 'bundle.index') active @endif">
                                <i class="fa fa-list nav-icon"></i>
                                <p>Bundles</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <div class="dropdown-divider"></div>

                <li class="nav-item @if(request()->segment('2') === 'manage') menu-open @endif">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-cogs"></i>
                        <p>Manage <i class="right fas fa-angle-left"></i></p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('role.index') }}" class="nav-link @if($current_route_name == 'role.index') active @endif">
                                <i class="fa fa-tags nav-icon"></i>
                                <p>Roles</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}" class="nav-link @if($current_route_name == 'user.index') active @endif">
                                <i class="fa fa-user-cog nav-icon"></i>
                                <p>Users</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('option.index') }}" class="nav-link @if($current_route_name == 'option.index') active @endif">
                                <i class="fa fa-cog nav-icon"></i>
                                <p>Options</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
