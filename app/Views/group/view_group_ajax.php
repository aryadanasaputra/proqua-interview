<div class="card-body">
  <div class="table-responsive p-0" style="height: 68vh;">
    <table class="table table-sm table-hover table-bordered table-head-fixed">
      <thead>
        <tr>
          <th style="width:10px;">#</th>
          <th onclick="_Pagination.ordered('name')">
            Name
            <i class="float-right fa fa-sort<?= (request()->getGet('ordered_field') == "name" ? "-" . (request()->getGet('ordered_sort') == "asc" ? "down" : "up") : "") ?>"></i>
          </th>
          <th onclick="_Pagination.ordered('notes')">
            Notes
            <i class="float-right fa fa-sort<?= (request()->getGet('ordered_field') == "notes" ? "-" . (request()->getGet('ordered_sort') == "asc" ? "down" : "up") : "") ?>"></i>
          </th>
          <th>Aksi</th>
        </tr>
      </thead>
      <tbody>
        <?php if (!empty($groups)) : ?>
          <?php $i = 0; ?>
          <?php foreach ($groups as $group) : ?>
            <?php $i++; ?>
            <tr class="<?= ($group->isactive ? "" : "table-active") ?>">
              <td><?= $i ?>. </td>

              <td><?= $group->name ?></td>
              <td><?= nl2br($group->notes) ?></td>
              <td>
                <a href="#!" class="btn btn-success btn-xs" onclick="_Group.getDataEdit('<?= $group->id ?>')"><i class="fa fa-edit" data-toggle="tooltip" data-original-title="Ubah"></i></a>
                <a href="#!" class="btn btn-danger btn-xs" onclick="_Group.del('<?= $group->id ?>')"><i class="fa fa-trash" data-toggle="tooltip" data-original-title="Hapus"></i></a>
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