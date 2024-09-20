<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-light-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link navbar-primary">
      {{-- <img src="/lte/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8"> --}}
      <center><span class="brand-text font-weight-light text-white">PDAM</span></center>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item">
            <a href="/home" class="nav-link">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Dashboard
              </p>
            </a>
          </li>
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Data Master
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item">
                <a href="/image" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Daftar Gambar</p>
                </a>
              </li>
               <li class="nav-item">
                <a href="/devices" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Daftar Perangkat</p>
                </a>
              </li>
            </ul>
           
          </li>
          
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link">
              <i class="nav-icon fas fa-circle"></i>
              <p>
                Sub
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
               <li class="nav-item">
                <a href="/prediction" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Tabel Angka Meter Air</p>
                </a>
              </li>
        </ul>
         <ul class="nav nav-treeview">
               <li class="nav-item">
                <a href="/grafik" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Grafik</p>
                </a>
              </li>
        </ul>
         <ul class="nav nav-treeview">
               <li class="nav-item">
                <a href="/uploadgambar" class="nav-link">
                  <i class="far fa-circle nav-icon"></i>
                  <p>Upload Gambar</p>
                </a>
              </li>
         
        </ul>
        <li class="nav-item">
                <a href="/user" class="nav-link">
                  <i class="far fa-user nav-icon"></i>
                  <p>User</p>
                </a>
              </li>
         <li class="nav-item">
            <a href="/logout" class="nav-link">
              <i class="nav-icon fa fa-sign-out-alt"></i>
              <p>
                Logout
              </p>
            </a>
          </li>
      </nav>
      
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>