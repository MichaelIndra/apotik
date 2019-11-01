<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="index3.html" class="brand-link">
      <img src='{{asset("lte/dist/img/AdminLTELogo.png")}}' alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">AdminLTE 3</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src='{{asset("lte/dist/img/user2-160x160.jpg")}}' class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">Alexander Pierce</a>
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li class="nav-item has-treeview menu-open">
            <a href="#" class="nav-link active">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>
                Starter Pages
                <i class="right fas fa-angle-left"></i>
              </p>
            </a>
            <ul class="nav nav-treeview">
              <li class="nav-item ">
                <a href="{{route('obats.index')}}" class="nav-link {{set_active('obats.index')}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>OBAT</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="{{route('hargaobats.index')}}" class=" nav-link {{set_active('hargaobats.index')}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>HARGA OBAT</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="{{route('stoks.index')}}" class=" nav-link {{set_active('stoks.index')}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>STOK OBAT</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="{{route('detracikans.index')}}" class=" nav-link {{set_active('detracikans.index')}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>DETAIL RACIKAN</p>
                </a>
              </li>
              <li class="nav-item ">
                <a href="{{route('transactions.index')}}" class=" nav-link {{set_active('transactions.index')}}">
                  <i class="far fa-circle nav-icon"></i>
                  <p>TRANSAKSI</p>
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