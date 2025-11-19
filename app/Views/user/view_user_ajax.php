<div class="card-body">
  <div class="table-responsive p-0">
    <table class="table table-sm table-hover table-bordered">
      <thead>
        <tr>
          <th style="width:10px;">#</th>
          <th onclick="_Pagination.ordered('username')">
            User
            <i class="float-right fa fa-sort<?= (request()->getGet('ordered_field') == "username" ? "-" . (request()->getGet('ordered_sort') == "asc" ? "down" : "up") : "") ?>"></i>
          </th>
          <th onclick="_Pagination.ordered('email')">
            Email
            <i class="float-right fa fa-sort<?= (request()->getGet('ordered_field') == "email" ? "-" . (request()->getGet('ordered_sort') == "asc" ? "down" : "up") : "") ?>"></i>
          </th>
          <th onclick="_Pagination.ordered('name')">
            Nama
            <i class="float-right fa fa-sort<?= (request()->getGet('ordered_field') == "name" ? "-" . (request()->getGet('ordered_sort') == "asc" ? "down" : "up") : "") ?>"></i>
          </th>
          <th onclick="_Pagination.ordered('group_names')">
            Group
            <i class="float-right fa fa-sort<?= (request()->getGet('ordered_field') == "group_names" ? "-" . (request()->getGet('ordered_sort') == "asc" ? "down" : "up") : "") ?>"></i>
          </th>
          <th onclick="_Pagination.ordered('last_login')">
            Login Terakhir
            <i class="float-right fa fa-sort<?= (request()->getGet('ordered_field')=="last_login"?"-".(request()->getGet('ordered_sort')=="asc"?"down":"up"):"") ?>"></i>
          </th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($users)) : ?>
          <?php $i = $startNumber?? 0; ?>
          <?php foreach ($users as $user) : ?>
            <?php $i++; ?>
            <?php $userGroups = explode(";", ($user->group_names ?: "")); ?>
            <?php $groupNotes = explode(";", ($user->group_notes ?: "")); ?>
            <tr class="<?= ($user->isactive ? "" : "table-active") ?>">
              <td><?= $i ?>. </td>
              <td><?= $user->username ?></td>
              <td><?= $user->email ?></td>
              <td><?= $user->name ?></td>
              <td>
                <?php foreach ($userGroups as $k => $userGroup) : ?>
                  <a href="#!" class="badge bg-primary" data-toggle="tooltip" data-original-title="<?= $groupNotes[$k] ?>"><?= $userGroup ?></a>
                <?php endforeach; ?>
              </td>
              <td><?= $template->formatDate($user->last_login, 'd M Y H:i:s') ?></td>
              <td>
                <a href="#!" class="btn btn-success btn-xs" onclick="_User.getDataEdit('<?= $user->id ?>')"><i class="fa fa-edit" data-toggle="tooltip" data-original-title="Ubah"></i></a>
                <?php /** Check User Exist */ ?>
                <?php if ($user->id != session()->get('id')) : ?>
                  <a href="#!" class="btn btn-danger btn-xs" onclick="_User.del('<?= $user->id ?>')"><i class="fa fa-trash" data-toggle="tooltip" data-original-title="Hapus"></i></a>
                <?php endif; ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else : ?>
          <tr>
            <td colspan="100%">
              <p align="center">data tidak ditemukan</p>
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>

<div class="card-footer clearfix paging-1"><?= $pager->links('default', 'pager') ?></div>