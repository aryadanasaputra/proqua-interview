<?= $this->extend('view_app') ?>

<?= $this->section('title') ?>
Pengguna
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-wrapper text-sm">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Pengguna</h1>
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
              <a href="#!" class="btn btn-primary btn-xs" onclick="_User.getDataAdd()">Tambah Baru</a>
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
              <?= view('user/view_user_ajax') ?>
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
            <h4 class="modal-title">Tambah Data Pengguna</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
          </div>
          <div class="modal-body p-0">
            <form id="form_save">
              <div class="card-body">
                <div class="form-group">
                  <label for="name">Nama <span class="text-danger">*</span></label>
                  <input type="text" autocomplete="off" class="form-control" id="name" name="name" placeholder="Nama">
                </div>
                <div class="form-group">
                  <label for="username">Username <span class="text-danger">*</span></label>
                  <input type="text" autocomplete="off" class="form-control no-spacing" id="username" name="username" placeholder="Username">
                </div>
                <div class="form-group">
                  <label for="email">Email</label>
                  <input type="email" autocomplete="off" class="form-control no-spacing" id="email" name="email" placeholder="Email">
                </div>
                <div class="form-group">
                  <label for="group_id">Group <span class="text-danger">*</span></label>
                  <select class="form-control select2" multiple style="width: 100%;" id="group_id" name="group_id[]">
                    <?php foreach ($groups as $group) : ?>
                      <option value="<?= $group->id ?>"><?= $group->name ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div id="div_user_password">
                </div>
                <template id="template_user_password">
                  <div class="form-group">
                    <label for="password">Kata Sandi <span class="text-danger">*</span></label>
                    <div class="input-group input-password">
                      <input type="password" class="form-control" id="password" name="password" placeholder="Kata Sandi" autocomplete="new-password">
                      <div class="input-group-append">
                        <div class="input-group-text show-password">
                          <span class="fa fa-eye-slash"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="form-group">
                    <label for="re_password">Ulangi Kata Sandi <span class="text-danger">*</span></label>
                    <div class="input-group input-password">
                      <input type="password" class="form-control" id="re_password" name="re_password" placeholder="Ulangi Kata Sandi" autocomplete="new-password">
                      <div class="input-group-append">
                        <div class="input-group-text show-password">
                          <span class="fa fa-eye-slash"></span>
                        </div>
                      </div>
                    </div>
                  </div>
                </template>
                <div class="form-group mb-0">
                  <div class="custom-control custom-switch">
                    <input type="checkbox" class="custom-control-input" id="isactive" name="isactive">
                    <label class="custom-control-label" for="isactive">Aktif</label>
                  </div>
                </div>
                <i class="help-block">Field (*) harus diisi</i>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <a href="#!" class="btn btn-default" data-dismiss="modal">Tutup</a>
            <a href="#!" class="btn btn-primary" id="btn_save" onclick="_User.add()">Simpan</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script>
_Pagination.urlRefreshTable = 'user';
</script>
<script src="<?= base_url() ?>assets/jController/CtrlUser.js"></script>
<?= $this->endSection() ?>