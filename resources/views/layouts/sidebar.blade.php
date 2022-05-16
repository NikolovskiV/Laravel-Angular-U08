<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
        <img src="{{URL::to('adminlte3/images/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">Recipes Admin</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <!-- <div class="image">
                <img src="{{URL::to('adminlte3/images/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block">Alexander Pierce</a>
            </div> -->
        </div>

      <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-item">
                    <a href="{{URL::to('admin/dashboard')}}" class="nav-link <?php if(Request::segment(2) == 'dashboard') echo 'active' ?>">
                        <p>
                            Dashboard
                        </p>
                    </a>
                </li>
                <li class="nav-item <?php if(in_array(Request::segment(2), ['add-user', 'user-list'])) echo 'menu-open' ?>">
                    <a href="#" class="nav-link">
                        <p>
                            Users
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{URL::to('admin/add-user')}}" class="nav-link <?php if(Request::segment(2) == 'add-user') echo 'active' ?>">
                                <p>Add User</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{URL::to('admin/user-list')}}" class="nav-link <?php if(Request::segment(2) == 'user-list') echo 'active' ?>">
                                <p>UserList</p>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="nav-item">
                    <a href="{{URL::to('admin/logout')}}" class="nav-link">
                        <p>
                            Logout
                        </p>
                    </a>
                </li>
            </ul>
        </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
