<div class="nav-side-menu" style="width:200px;">
  <div class="brand">Brand Logo</div>
  <i class="fa fa-bars fa-2x toggle-btn" data-toggle="collapse" data-target="#menu-content"></i>

  <div class="menu-list">


    <ul id="menu-content" class="menu-content collapse out">
      <li>
        <a href="#" style="font-size:12px;">
          Current User: {{Session::get('currentUser')->email}}
        </a>
      </li>
      <li data-toggle="collapse" data-target="#messages" class="collapsed">
        <a href="/novone/public/admin/">
          <i class="fa fa-gift fa-lg"></i> Home
          <span class="arrow"></span>
        </a>
      </li>
      @if(isset(Session::get('access')->module_message) || Session::get('currentUser')->account_type == 'SUPER_ADMIN')
      <li data-toggle="collapse" data-target="#announcement" class="collapsed">
        <a href="#">
          <i class="fa fa-gift fa-lg"></i> Announcement
          <span class="arrow"></span>
        </a>
      </li>

      <ul class="sub-menu collapse" id="announcement">
        <li class="">
          <a href="/novone/public/admin/announcement">Create Announcement</a>
        </li>
        <li class="">
          <a href="/novone/public/admin/announcement/list">Update an Announcement</a>
        </li>
      </ul>

      @endif @if(isset(Session::get('access')->module_message) || Session::get('currentUser')->account_type == 'SUPER_ADMIN')
      <li data-toggle="collapse" data-target="#messages" class="collapsed">
        <a href="/novone/public/admin/messages/client">
          <i class="fa fa-gift fa-lg"></i> Messages
          <span class="arrow"></span>
        </a>
      </li>
      @endif @if(isset(Session::get('access')->module_inventory) || Session::get('currentUser')->account_type == 'SUPER_ADMIN')
      <li data-toggle="collapse" data-target="#inventory" class="collapsed">
        <a href="#">
          <i class="fa fa-gift fa-lg"></i> Inventory
          <span class="arrow"></span>
        </a>
      </li>

      <ul class="sub-menu collapse" id="inventory">
        <li class="">
          <a href="/novone/public/admin/inventory/list">List</a>
        </li>
        <li class="">
          <a href="/novone/public/admin/inventory/pull_in">Pull-In</a>
        </li>
        <li class="">
          <a href="/novone/public/admin/inventory/pull_out">Pull-Out</a>
        </li>
      </ul>
      @endif @if(isset(Session::get('access')->module_store) || Session::get('currentUser')->account_type == 'SUPER_ADMIN')
      <li data-toggle="collapse" data-target="#store" class="collapsed">
        <a href="/novone/public/admin/stores/list">
          <i class="fa fa-gift fa-lg"></i> Store
          <span class="arrow"></span>
        </a>
      </li>
      @endif
      <!--
                <ul class="sub-menu collapse" id="store">
                    <li class=""><a href="/novone/public/admin/inventory/list">Daily</a></li>
                </ul>
                -->

      @if(isset(Session::get('access')->module_invoice) || Session::get('currentUser')->account_type == 'SUPER_ADMIN')
      <li data-toggle="collapse" data-target="#invoice" class="collapsed">
        <a href="#">
          <i class="fa fa-gift fa-lg"></i> Transaction
          <span class="arrow"></span>
        </a>
      </li>
      <ul class="sub-menu collapse" id="invoice">
        <li class="">
          <a href="/novone/public/admin/invoice/list">Transaction History</a>
        </li>
      </ul>
      @endif @if(isset(Session::get('access')->module_products) || Session::get('currentUser')->account_type == 'SUPER_ADMIN')
      <li data-toggle="collapse" data-target="#service" class="collapsed">
        <a href="/novone/public/admin/product/edit">
          <i class="fa fa-globe fa-lg"></i> Product List
          <span class="arrow"></span>
        </a>
      </li>
      @endif @if(isset(Session::get('access')->module_maintenance ) || Session::get('currentUser')->account_type == 'SUPER_ADMIN')
      <li data-toggle="collapse" data-target="#maintenance" class="collapsed">
        <a href="#">
          <i class="fa fa-globe fa-lg"></i> Maintenance
          <span class="arrow"></span>
        </a>
      </li>
      <ul class="sub-menu collapse" id="maintenance">
        @if(Session::get('currentUser')->account_type == 'SUPER_ADMIN')
        <li>
          <a href="/novone/public/admin/account/type/create">Account Type</a>
        </li>
        @endif @if(isset(Session::get('access')->module_products) || Session::get('currentUser')->account_type == 'SUPER_ADMIN')
        <li>
          <a href="/novone/public/admin/product/add">Add New Product</a>
        </li>
        @endif @if(isset(Session::get('access')->module_category) || Session::get('currentUser')->account_type == 'SUPER_ADMIN')
        <li>
          <a href="/novone/public/admin/category/edit">Category List</a>
        </li>
        @endif @if(isset(Session::get('access')->module_measurement) || Session::get('currentUser')->account_type == 'SUPER_ADMIN')
        <li>
          <a href="/novone/public/admin/measurement">Unit Measurement</a>
        </li>
        @endif
        <li data-toggle="collapse" data-target="#new" class="collapsed">
          <a href="#">
            <i class="fa fa-users fa-lg"></i> Users
            <span class="arrow"></span>
          </a>
        </li>
        <ul class="sub-menu collapse" id="new">
          <li>
            <a href="/novone/public/admin/dashboard/user/create">Create a User</a>
          </li>
          <li>
            <a href='/novone/public/admin/dashboard/user/list'>User List</a>
          </li>
        </ul>

      </ul>
      @endif @if(isset(Session::get('access')->module_logs) || Session::get('currentUser')->account_type == 'SUPER_ADMIN')
      <li data-toggle="collapse" data-target="#logs" class="collapsed">
        <a href="/novone/public/admin/logs/user">
          <i class="fa fa-users fa-lg"></i> Logs
          <span class="arrow"></span>
        </a>
      </li>
      @endif @if(isset(Session::get('access')->module_clients) || Session::get('currentUser')->account_type == 'SUPER_ADMIN')
      <li data-toggle="collapse" data-target="#clients" class="collapsed">
        <a href="#">
          <i class="fa fa-users fa-lg"></i> Clients
          <span class="arrow"></span>
        </a>
      </li>
      <ul class="sub-menu collapse" id="clients">
        <li>
          <a href="/novone/public/admin/client/list">Customer List</a>
        </li>
      </ul>
      @endif
      <!--
                <li data-toggle="collapse" data-target="#new" class="collapsed">
                  <a href="/novone/public/admin/logout">
                  <i class="fa fa-user fa-lg"></i> Logout
                  </a>
                  </li>
                  -->

      @if(isset(Session::get('access')->module_reports) || Session::get('currentUser')->account_type == 'SUPER_ADMIN')
      <li data-toggle="collapse" data-target="#reports" class="collapsed">
        <a href="/novone/public/admin/reports/sales">
          <i class="fa fa-gift fa-lg"></i> Reports
          <span class="arrow"></span>
        </a>
      </li>

      @endif

      <!--
                <li  data-toggle="collapse" data-target="#account" class="collapsed">
                  <a href="/novone/public/admin/dashboard/user/update/password"><i class="fa fa-gift fa-lg"></i> Account <span class="arrow"></span></a>
                </li>
                -->

      <li data-toggle="collapse" data-target="#" class="collapsed">
        <a href='/novone/public/admin/dashboard/user/update/information'>
          <i class="fa fa-users fa-lg"></i> Account Info
          <span class="arrow"></span>
        </a>
      </li>

      <li data-toggle="collapse" data-target="#" class="collapsed">
        <a href="/novone/public/admin/logout">
          <i class="fa fa-users fa-lg"></i> Logout
          <span class="arrow"></span>
        </a>
      </li>
      <!--
                <li>
                  <a href="#">
                  <i class="fa fa-users fa-lg"></i> Users
                  </a>
                </li>
                -->
    </ul>
  </div>
</div>

<!-- /admin/dashboard/user/update/password -->