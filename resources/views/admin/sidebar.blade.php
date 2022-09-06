<!-- Main Sidebar Container -->
<aside class="main-sidebar sidebar-dark-primary elevation-4">

    <!-- Brand Logo -->
    <a href="/dashboard" class="brand-link">
      <img src='{{ asset("bower_components/admin-lte/dist/img/AdminLTELogo.png") }}' alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
           style="opacity: .8">
      <span class="brand-text font-weight-light">ADMIN</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <!-- Sidebar user panel (optional) -->
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{ asset('imgs/avatar1.png') }}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{ Auth::user()->name }}</a>
        </div>
      </div>
      <nav class="mt-2">
      @if(Auth::user()->can('List Users') | Auth::user()->can('Access Roles'))
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header">User Settings</li>
          @can('List Users')
          <li class="nav-item">
            <a href='/usersetup' id="sideusersetup" class="nav-link">
              <i class="fas fa-users nav-icon"></i>
              <p>Users Profile</p>
            </a>
          </li>
          @endcan
          @can('Access Roles')
          <li class="nav-item">
            <a href='/roles' id="sideroles" class="nav-link">
              <i class="far fa-edit nav-icon"></i>
              <p>Roles and Permissions</p>
            </a>
          </li>
          @endcan
        </ul>
      @endif
      <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header">Configration</li>
          <li class="nav-item">
            <a href='smtp' id="sidesmtp" class="nav-link">
              <i class="fas fa-server nav-icon"></i>
              <p>SMTP</p>
            </a>
          </li>
          <!-- <li class="nav-item">
            <a href='promocode' id="sidepromocode" class="nav-link">
              <i class="fas fa-code nav-icon"></i>
              <p>Promo Codes</p>
            </a>
          </li> -->
      </ul>
      @if(Auth::user()->can('List Services') | Auth::user()->can('List Providers') | Auth::user()->can('List Payments') | Auth::user()->can('List Shops') | Auth::user()->can('List Materials') | Auth::user()->can('List Clients'))
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-header">Catalogs</li>
          @can('List Services')
          <li class="nav-item">
            <a href='/services' id="sideservices" class="nav-link">
            <i class="fas fa-thumbs-up nav-icon"></i>
              <p>Services</p>
            </a>
          </li>
          @endcan
          @can('List Payments')
          <li class="nav-item">
            <a href='/payments' id="sidepayments" class="nav-link">
              <i class="fab fa-amazon-pay nav-icon"></i>
              <p>Payments</p>
            </a>
          </li>
          @endcan
          @can('List Providers')
          <li class="nav-item">
            <a href='/providers' id="sideproviders" class="nav-link">
              <i class="far fa-user nav-icon"></i>
              <p>Providers</p>
            </a>
          </li>
          @endcan
          @can('List Shops')
          <li class="nav-item">
            <a style="padding-left:1.5em;" href='/shops' id="sideshops" class="nav-link">
              <i class="fas fa-shopping-cart nav-icon"></i>
              <p>Shops</p>
            </a>
          </li>
          @endcan
            @can('List Materials')
            <li class="nav-item">
              <a style="padding-left:2em;" href="/materials" id="sidematerials" class="nav-link">
                <i class="far fa-heart nav-icon"></i>
                <p>Materials</p>
              </a>
            </li>
          @endcan
          @can('List Clients')
          <li class="nav-item">
            <a href='/clients' id="sideclients" class="nav-link">
              <i class="far fa-user nav-icon"></i>
              <p>Contractors</p>
            </a>
          </li>
          @endcan
          <li class="nav-item">
            <a href='/terms' id="sideterms" class="nav-link">
              <i class="fas fa-coffee nav-icon"></i>
              <p>Terms and Conditions</p>
            </a>
          </li>
        </ul>
      @endif
      </nav>
      
    </div>
    <!-- /.sidebar -->
  </aside>
