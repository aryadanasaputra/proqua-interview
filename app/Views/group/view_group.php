<?= $this->extend('view_app') ?>

<?= $this->section('title') ?>
Hak Akses Group
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-wrapper text-sm">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Hak Akses Group</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <a href="#!" class="btn btn-primary btn-xs" onclick="_Group.getDataAdd()">Tambah Baru</a>
              <div class="card-tools">
                <div class="input-group input-group-sm" style="width: 200px;">
                  <input type="text" autocomplete="off" class="form-control float-right" placeholder="Cari" id="search" onchange="_Pagination.search('#search')">
                  <div class="input-group-append">
                    <a href="#!" class="btn btn-default" onclick="_Pagination.search('#search')"><i class="fa fa-search"></i></a>
                  </div>
                </div>
              </div>
            </div>
            <div id="div-paging">
              <?= view('group/view_group_ajax') ?>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Modals -->
    <!-- modal_save -->
    <div class="modal fade" id="modal_save" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Tambah Data Group</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body">
            <form id="form_save">
              <div class="card-header p-0 pt-1 border-bottom-0">
                <div class="nav nav-tabs" role="tablist">
                  <a href="#tab_group" aria-controls="tab_group" class="nav-item nav-link active" data-toggle="pill" role="tab" aria-selected="true">Group</a>
                  <a href="#tab_privilege" aria-controls="tab_privilege" class="nav-item nav-link" data-toggle="pill" role="tab" aria-selected="false">Hak Akses</a>
                </div>
              </div>
              <div class="card-body p-1">
                <div class="tab-content">
                  <div class="tab-pane fade show active" role="tabpanel" id="tab_group">
                    <div class="form-group">
                      <label for="name">Name <span class="text-danger">*</span></label>
                      <input type="text" autocomplete="off" class="form-control" id="name" name="name" placeholder="Name">
                    </div>
                    <div class="form-group">
                      <label for="notes">Notes </label>
                      <textarea class="form-control" id="notes" name="notes" placeholder="Notes"></textarea>
                    </div>
                    <div class="form-group mb-0">
                      <div class="custom-control custom-switch">
                        <input type="checkbox" class="custom-control-input" id="isactive" name="isactive">
                        <label class="custom-control-label" for="isactive">Aktif</label>
                      </div>
                    </div>
                    <i class="help-block">Field (*) harus diisi</i>
                  </div>
                  <div class="tab-pane" role="tabpanel" id="tab_privilege">
                    <?php
                    if (!empty($roles)) :
                      echo view("group/view_role", $roles);
                    endif;
                    ?>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <a href="#!" class="btn btn-default" data-dismiss="modal">Tutup</a>
            <a href="#!" class="btn btn-primary" id="btn_save" onclick="_Group.add()">Simpan</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
_Pagination.urlRefreshTable = 'group';
</script>
<script src="<?= base_url() ?>assets/jController/CtrlGroup.js"></script>
<?= $this->endSection() ?>