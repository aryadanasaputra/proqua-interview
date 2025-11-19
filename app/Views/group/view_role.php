<ul style="list-style: none;">
  <?php foreach ($roles as $role) : ?>
    <li>
      <div class="custom-control custom-checkbox">
        <input type="checkbox" class="custom-control-input role_id" id="role_id_<?= $role->id ?>" name="role_id[]" value="<?= $role->id ?>" onchange="_Group.doCheckRole(this)">
        <label class="custom-control-label" for="role_id_<?= $role->id ?>"><?= $role->name ?></label>
      </div>
      <?php
      if (!empty($role->childs)) :
        echo view("group/view_role", ['roles' => $role->childs]);
      endif;
      ?>
    </li>
  <?php endforeach; ?>
</ul>