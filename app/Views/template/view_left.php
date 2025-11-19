<aside class="main-sidebar sidebar-dark-primary elevation-4">
  <!-- Brand Logo -->
  <a href="#!" class="brand-link">
    <img src="<?= base_url() ?>design/images/comp/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light"><?= env('application.name') ?></span>
  </a>

  <div class="sidebar">
    <nav class="mt-2">
      <ul class="nav nav-pills nav-sidebar flex-column nav-flat nav-compact nav-child-indent text-sm" data-widget="treeview" role="menu" data-accordion="false">
        <?= view('template/view_menu',['menus' => (session()->get('menus') ? : [])]) ?>
      </ul>
    </nav>
  </div>
</aside>