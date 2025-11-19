<?= $this->extend('view_app') ?>

<?= $this->section('title') ?>
Kunjungan
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-wrapper text-sm">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Kunjungan</h1>
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
              <a href="#!" class="btn btn-primary btn-xs" onclick="_Kunjungan.getDataAdd()">Tambah Baru</a>
            </div>
            <div class="card-body">
              <div class="table-responsive p-0">
                <table class="table table-sm table-hover table-bordered datatable">
                  <thead>
                    <tr>
                      <th style="width:10px;">#</th>
                      <th>Nama Pasien</th>
                      <th>No.RM</th>
                      <th>No.Registrasi</th>
                      <th>Tgl.Registrasi</th>
                      <th>Jenis kunjungan</th>
                      <th>Tgl.kunjungan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php if(!empty($kunjungans)): ?>
                    <?php $i = 0; ?>
                    <?php foreach($kunjungans as $kunjungan): ?>
                      <?php $i++; ?>
                      <tr>
                        <td><?= $i ?>. </td>
                        <td><?= $kunjungan->pasien_nama ?></td>
                        <td><?= $kunjungan->pasien_norm ?></td>
                        <td><?= $kunjungan->pendaftaran_noregistrasi ?></td>
                        <td><?= $template->formatDate($kunjungan->pendaftaran_tglregistrasi,'d-m-Y H:i') ?></td>
                        <td><?= $template->getLabelByValue($jeniskunjunganOpts,$kunjungan->jeniskunjungan ?: '') ?></td>
                        <td><?= $template->formatDate($kunjungan->tglkunjungan,'d-m-Y H:i') ?></td>
                        <td>
                          <a href="#!" class="btn btn-success btn-xs" onclick="_Kunjungan.getDataSave('<?= $kunjungan->id ?>')"><i class="fa fa-edit" data-toggle="tooltip" data-original-title="Ubah"></i></a>
                          <a href="#!" class="btn btn-danger btn-xs" onclick="_Kunjungan.del('<?= $kunjungan->id ?>')"><i class="fa fa-trash" data-toggle="tooltip" title="Hapus"></i></a>
                          <a href="#!" class="btn btn-warning btn-xs" onclick="_Kunjungan.detailModal('<?= $kunjungan->id ?>')"><i class="fa fa-info-circle" data-toggle="tooltip" title="Detail"></i></a>
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
            <h4 class="modal-title">Simpan Data Kunjungan</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body p-0">
            <form id="form_save">
              <div class="card-body">
                <div class="form-group">
                  <label for="pendaftaranpasienid">Pendaftaran <span class="text-danger">*</span></label>
                  <select class="form-control" id="pendaftaranpasienid" name="pendaftaranpasienid">
                    <option value="">---</option>
                    <?php foreach($pendaftarans as $pendaftaran): ?>
                      <option value="<?= $pendaftaran->id ?>"
                      data-noregistrasi=<?=  $pendaftaran->noregistrasi ?>
                      data-tglregistrasi=<?=  $pendaftaran->tglregistrasi ?>
                      data-pasien_nama=<?=  $pendaftaran->pasien_nama ?>
                      data-pasien_norm=<?=  $pendaftaran->pasien_norm ?>
                      ><?= $pendaftaran->noregistrasi ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="jeniskunjungan">Jenis kunjungan <span class="text-danger">*</span></label>
                  <select class="form-control" id="jeniskunjungan" name="jeniskunjungan">
                    <option value="">---</option>
                    <?php foreach($jeniskunjunganOpts as $jeniskunjunganOpt): ?>
                      <option value="<?= $jeniskunjunganOpt['value'] ?>"><?= $jeniskunjunganOpt['label'] ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="tglkunjungan">Tgl.kunjungan <span class="text-danger">*</span></label>
                  <div class="input-group date datetimepicker" id="date_tglkunjungan" data-target-input="nearest">
                    <input type="text" class="form-control datetimepicker-input" data-target="#date_tglkunjungan" data-inputmask-alias="datetime" data-inputmask-inputformat="dd-mm-yyyy HH:MM" data-mask="" id="tglkunjungan" name="tglkunjungan">
                    <div class="input-group-append" data-target="#date_tglkunjungan" data-toggle="datetimepicker">
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
            <a href="#!" class="btn btn-primary" id="btn_save" onclick="_Kunjungan.save()">Simpan</a>
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
<script src="<?= base_url() ?>assets/jController/CtrlKunjungan.js"></script>
<?= $this->endSection() ?>