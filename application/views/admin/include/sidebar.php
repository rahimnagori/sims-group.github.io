<aside class="main-sidebar">
  <!-- sidebar: style can be found in sidebar.less -->
  <section class="sidebar">
    <!-- Sidebar user panel -->
    <div class="user-panel" style="display:none;">
      <div class="pull-left image">
        <img src="<?php echo base_url(); ?>assets/admin/dist/img/userdummy.png" class="img-circle" alt="User Image">
      </div>
      <div class="pull-left info">
        <p><?=$adminData['first_name'] ; ?></p>
        <a href="#"><i class="fa fa-circle text-success"></i> Online</a>
      </div>
    </div>
    <!-- search form -->
    <form action="#" method="get" class="sidebar-form" style="display:none;">
      <div class="input-group">
        <input type="text" name="q" class="form-control" placeholder="Search...">
        <span class="input-group-btn">
              <button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>
              </button>
            </span>
      </div>
    </form>
    <!-- /.search form -->
    <!-- sidebar menu: : style can be found in sidebar.less -->
    <ul class="sidebar-menu" data-widget="tree">
      <!-- <li class="header">MAIN NAVIGATION</li> -->
      <li>
        <a href="<?=base_url(); ?>Admin/Dashboard">
          <i class="fa fa-dashboard"></i> <span>Dashboard</span>
        </a>
      </li>
      <li><a href="<?=base_url();?>Admin/Business"><i class="fa fa-address-card"></i>Business Details</a></li>
      <li><a href="<?=base_url();?>Admin/Services"><i class="fa fa-wrench"></i>Services Management</a></li>
      <li><a href="<?=base_url(); ?>Admin/Contacts"><i class="fa fa-user-plus"></i>Contact Requests </a></li>
      <!--
      <li class="treeview">
        <a href="#">
          <i class="fa fa-circle-o"></i><span> Pages Management </span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">
          <li style="display:none;"><a href="<?=base_url();?>Admin-Collections"><i class="fa fa-circle-o"></i>Collections Management</a></li>
          <li style="display:none;"><a href="<?=base_url();?>Admin-Sound" ><i class="fa fa-circle-o"></i>Sound Management</a></li>
        </ul>
      </li>
      <li><a href="<?=base_url(); ?>Admin/Users"><i class="fa fa-users"></i>Users Management</a></li>
      <li><a href="<?=base_url(); ?>Admin/Blogs"><i class="fa fa-newspaper-o"></i>Blogs Management</a></li>
      <li><a href="<?=base_url(); ?>Admin/Plans"><i class="fa fa-tasks"></i>Plans Management</a></li>

      <li><a href="<?=base_url(); ?>Admin-Banners"><i class="fa fa-picture-o"></i>Banner Management</a></li>
      -->
    </ul>
  </section>
  <!-- /.sidebar -->
</aside>