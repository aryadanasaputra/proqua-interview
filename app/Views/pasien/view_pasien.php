<?= $this->extend('view_app') ?>

<?= $this->section('title') ?>
Pasien
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-wrapper text-sm">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Pasien</h1>
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
              <a href="#!" class="btn btn-primary" onclick="_Pasien.getDataAdd()">Tambah Baru</a>
              <a class="btn btn-primary" href="#!"  data-toggle="modal" data-target="#modal_import_json">Import JSON</a>
            </div>
            <div class="card-body">
              <div class="table-responsive p-0">
                <table class="table table-sm table-hover table-bordered datatable">
                  <thead>
                    <tr>
                      <th style="width:10px;">#</th>
                      <th>Nama</th>
                      <th>No.RM</th>
                      <th>Alamat</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php if(!empty($pasiens)): ?>
                    <?php $i = 0; ?>
                    <?php foreach($pasiens as $pasien): ?>
                      <?php $i++; ?>
                      <tr>
                        <td><?= $i ?>. </td>
                        <td><?= $pasien->nama ?></td>
                        <td><?= $pasien->norm ?></td>
                        <td><?= nl2br($pasien->alamat) ?></td>
                        <td>
                          <a href="#!" class="btn btn-success btn-xs" onclick="_Pasien.getDataSave('<?= $pasien->id ?>')"><i class="fa fa-edit" data-toggle="tooltip" data-original-title="Ubah"></i></a>
                          <a href="#!" class="btn btn-danger btn-xs" onclick="_Pasien.del('<?= $pasien->id ?>')"><i class="fa fa-trash" data-toggle="tooltip" title="Hapus"></i></a>
                          <a href="#!" class="btn btn-warning btn-xs" onclick="_Pasien.detailModal('<?= $pasien->id ?>')"><i class="fa fa-info-circle" data-toggle="tooltip" title="Detail"></i></a>
                        </td>
                      </tr>
                    <?php endforeach; ?>
                  <?php endif; ?>
                  </tbody>
                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- modal_save -->
    <div class="modal fade" id="modal_save" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Simpan Data Pasien</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body p-0">
            <form id="form_save">
              <div class="card-body">
                <div class="form-group">
                  <label for="nama">Nama <span class="text-danger">*</span></label>
                  <input type="text" autocomplete="off" class="form-control" id="nama" name="nama" placeholder="Nama">
                </div>
                <div class="form-group">
                  <label for="norm">No.RM <span class="text-danger">*</span></label>
                  <input type="text" autocomplete="off" class="form-control" id="norm" name="norm" placeholder="No.RM">
                </div>
                <div class="form-group">
                  <label for="alamat">Alamat <span class="text-danger">*</span></label>
                  <textarea class="form-control" id="alamat" name="alamat" placeholder="Alamat"></textarea>
                </div>
                <i class="help-block">Field (*) harus diisi</i>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <a href="#!" class="btn btn-default" data-dismiss="modal">Tutup</a>
            <a href="#!" class="btn btn-primary" id="btn_save" onclick="_Pasien.save()">Simpan</a>
          </div>
        </div>
      </div>
    </div>

    <!-- modal_detail -->
    <div class="modal fade" id="modal_detail" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Detail</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
          </div>
        </div>
      </div>
    </div>

    <!-- modal_import_json -->
    <div class="modal fade" id="modal_import_json" data-backdrop="static" data-keyboard="false">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h4 class="modal-title">Impor json</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form id="form_import_json">
              <div class="form-group">
                <label for="import_json_file">Upload Format json (*.json)</label>
                <div class="input-group">
                  <div class="custom-file">
                    <input type="file" class="custom-file-input" id="import_json_file" name="file">
                    <label class="custom-file-label" data-browse="Pilih file" for="import_json_file">Pilih file</label>
                  </div>
                </div>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <a href="#!" class="btn btn-default" data-dismiss="modal">Tutup</a>
            <a href="#!" class="btn btn-primary" onclick="_Pasien.importJson()">Impor</a>
          </div>
        </div>
      </div>
    </div>
  </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url() ?>assets/jController/CtrlPasien.js"></script>
<?= $this->endSection() ?>