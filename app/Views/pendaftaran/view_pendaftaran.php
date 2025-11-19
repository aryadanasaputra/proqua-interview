<?= $this->extend('view_app') ?>

<?= $this->section('title') ?>
Pendaftaran
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-wrapper text-sm">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Pendaftaran</h1>
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
              <?php if(in_array('crud_pendaftaran', session()->get('roles'))): ?>
                <a href="#!" class="btn btn-primary btn-xs" onclick="_Pendaftaran.getDataAdd()">Tambah Baru</a>
              <?php endif; ?>
            </div>
            <div class="card-body">
              <div class="table-responsive p-0">
                <table class="table table-sm table-hover table-bordered datatable">
                  <thead>
                    <tr>
                      <th style="width:10px;">#</th>
                      <th>Pasien</th>
                      <th>No.RM</th>
                      <th>No.Registrasi</th>
                      <th>Tgl.Registrasi</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php if(!empty($pendaftarans)): ?>
                    <?php $i = 0; ?>
                    <?php foreach($pendaftarans as $pendaftaran): ?>
                      <?php $i++; ?>
                      <tr>
                        <td><?= $i ?>. </td>
                        <td><?= $pendaftaran->pasien_nama ?></td>
                        <td><?= $pendaftaran->pasien_norm ?></td>
                        <td><?= $pendaftaran->noregistrasi ?></td>
                        <td><?= $template->formatDate($pendaftaran->tglregistrasi,'d-m-Y H:i') ?></td>
                        <td>
                          <?php if(in_array('crud_pendaftaran', session()->get('roles'))): ?>
                            <a href="#!" class="btn btn-success btn-xs" onclick="_Pendaftaran.getDataSave('<?= $pendaftaran->id ?>')"><i class="fa fa-edit" data-toggle="tooltip" data-original-title="Ubah"></i></a>
                            <a href="#!" class="btn btn-danger btn-xs" onclick="_Pendaftaran.del('<?= $pendaftaran->id ?>')"><i class="fa fa-trash" data-toggle="tooltip" title="Hapus"></i></a>
                          <?php endif; ?>
                          <a href="#!" class="btn btn-warning btn-xs" onclick="_Pendaftaran.detailModal('<?= $pendaftaran->id ?>')"><i class="fa fa-info-circle" data-toggle="tooltip" title="Detail"></i></a>
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
            <h4 class="modal-title">Simpan Data Pendaftaran</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body p-0">
            <form id="form_save">
              <div class="card-body">
                <div class="form-group">
                  <label for="pasienid">Pasien <span class="text-danger">*</span></label>
                  <select class="form-control select2" id="pasienid" name="pasienid">
                    <option value="">---</option>
                    <?php foreach($pasiens as $pasien): ?>
                      <option value="<?= $pasien->id ?>"><?= $pasien->norm ?> - <?= $pasien->nama ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="noregistrasi">No.Registrasi <span class="text-danger">*</span></label>
                  <input type="text" autocomplete="off" class="form-control" id="noregistrasi" name="noregistrasi" placeholder="No.Registrasi">
                </div>
                <div class="form-group">
                  <label for="tglregistrasi">Tgl.Registrasi <span class="text-danger">*</span></label>
                  <div class="input-group date datetimepicker" id="date_tglregistrasi" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#date_tglregistrasi" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy HH:MM" data-mask="" id="tglregistrasi" name="tglregistrasi">
                    <div class="input-group-append" data-target="#date_tglregistrasi" data-toggle="datetimepicker">
                      <div class="input-group-text"><i class="fa fa-calendar"></i></div>
                    </div>
                  </div>
                </div>
                <i class="help-block">Field (*) harus diisi</i>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <a href="#!" class="btn btn-default" data-dismiss="modal">Tutup</a>
            <a href="#!" class="btn btn-primary" id="btn_save" onclick="_Pendaftaran.save()">Simpan</a>
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
  </section>
</div>
<?= $this->endSection() ?>

<?= $this->section('style') ?>
<?= $this->endSection() ?>

<?= $this->section('script') ?>
<script src="<?= base_url() ?>assets/jController/CtrlPendaftaran.js"></script>
<?= $this->endSection() ?>