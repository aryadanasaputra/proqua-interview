<?= $this->extend('view_app') ?>

<?= $this->section('title') ?>
Asesmen
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-wrapper text-sm">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-12">
          <h1>Asesmen</h1>
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
              <a href="#!" class="btn btn-primary btn-xs" onclick="_Asesmen.getDataAdd()">Tambah Baru</a>
            </div>
            <div class="card-body">
              <div class="table-responsive p-0">
                <table class="table table-sm table-hover table-bordered datatable">
                  <thead>
                    <tr>
                      <th style="width:10px;">#</th>
                      <th>Pasien</th>
                      <th>No.RM</th>
                      <th>Tgl.Kunjungan</th>
                      <th>Jenis kunjungan</th>
                      <th>Keluhan Utama</th>
                      <th>Keluhan Tambahan</th>
                      <th>Aksi</th>
                    </tr>
                  </thead>
                  <tbody>
                  <?php if(!empty($asesmens)): ?>
                    <?php $i = 0; ?>
                    <?php foreach($asesmens as $asesmen): ?>
                      <?php $i++; ?>
                      <tr>
                        <td><?= $i ?>. </td>
                        <td><?= $asesmen->pasien_nama ?></td>
                        <td><?= $asesmen->pasien_norm ?></td>
                        <td><?= $template->formatDate($asesmen->kunjungan_tglkunjungan,'d-m-Y H:i') ?></td>
                        <td><?= $asesmen->kunjungan_jeniskunjungan ?></td>
                        <td><?= nl2br($asesmen->keluhan_utama) ?></td>
                        <td><?= nl2br($asesmen->keluhan_tambahan) ?></td>
                        <td>
                          <a href="#!" class="btn btn-success btn-xs" onclick="_Asesmen.getDataSave('<?= $asesmen->id ?>')"><i class="fa fa-edit" data-toggle="tooltip" data-original-title="Ubah"></i></a>
                          <a href="#!" class="btn btn-danger btn-xs" onclick="_Asesmen.del('<?= $asesmen->id ?>')"><i class="fa fa-trash" data-toggle="tooltip" title="Hapus"></i></a>
                          <a href="#!" class="btn btn-warning btn-xs" onclick="_Asesmen.detailModal('<?= $asesmen->id ?>')"><i class="fa fa-info-circle" data-toggle="tooltip" title="Detail"></i></a>
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
            <h4 class="modal-title">Simpan Data Asesmen</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body p-0">
            <form id="form_save">
              <div class="card-body">
                <div class="form-group">
                  <label for="kunjunganid">Kunjungan <span class="text-danger">*</span></label>
                  <select class="form-control" id="kunjunganid" name="kunjunganid">
                    <option value="">---</option>
                    <?php foreach($kunjungans as $kunjungan): ?>
                      <option value="<?= $kunjungan->id ?>"
                        data-tglkunjungan=<?= $kunjungan->tglkunjungan ?>
                        data-pasien_nama=<?= $kunjungan->pasien_nama ?>
                        data-pasien_norm=<?= $kunjungan->pasien_norm ?>
                      ><?= $kunjungan->tglkunjungan ?></option>
                    <?php endforeach; ?>
                  </select>
                </div>
                <div class="form-group">
                  <label for="keluhan_utama">Keluhan Utama <span class="text-danger">*</span></label>
                  <textarea class="form-control" id="keluhan_utama" name="keluhan_utama" placeholder="Keluhan Utama"></textarea>
                </div>
                <div class="form-group">
                  <label for="keluhan_tambahan">Keluhan Tambahan <span class="text-danger">*</span></label>
                  <textarea class="form-control" id="keluhan_tambahan" name="keluhan_tambahan" placeholder="Keluhan Tambahan"></textarea>
                </div>
                <i class="help-block">Field (*) harus diisi</i>
              </div>
            </form>
          </div>
          <div class="modal-footer">
            <a href="#!" class="btn btn-default" data-dismiss="modal">Tutup</a>
            <a href="#!" class="btn btn-primary" id="btn_save" onclick="_Asesmen.save()">Simpan</a>
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
<script src="<?= base_url() ?>assets/jController/CtrlAsesmen.js"></script>
<?= $this->endSection() ?>