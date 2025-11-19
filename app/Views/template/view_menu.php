<?php foreach($menus as $menu) : ?>
  <?php if($menu->isparent) : ?>
    <li class="nav-item has-treeview">
      <a href="#" class="nav-link">
        <i class="nav-icon <?= ($menu->icon ? : "fas fa-circle") ?>"></i>
        <p class="p_menu_<?= str_replace(".","_",$menu->code) ?>"><?= $menu->name ?> <i class="right fas fa-angle-left"></i></p>
      </a>
      <ul class="nav nav-treeview">
        <?= view('template/view_menu',['menus' => $menu->childs]) ?>
      </ul>
    </li>
  <?php else : ?>
    <li class="nav-item">
      <a href="<?= base_url().$menu->action ?>" data-action_active="<?= $menu->action_active ?>" class="nav-link">
        <i class="nav-icon <?= ($menu->icon ? : "fas fa-circle") ?>"></i><p class="p_menu_<?= str_replace(".","_",$menu->code) ?>"><?= $menu->name ?></p>
      </a>
    </li>
  <?php endif; ?>
<?php endforeach; ?>