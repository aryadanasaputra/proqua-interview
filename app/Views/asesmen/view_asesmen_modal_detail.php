<table class="table table-sm table-borderless">
  <tbody>
    <tr>
      <td style="width:30%;">Pasien<span class="float-right">:</span></td>
      <td><?= $asesmen->pasien_nama ?></td>
    </tr>
    <tr>
      <td style="width:30%;">No.RM<span class="float-right">:</span></td>
      <td><?= $asesmen->pasien_norm ?></td>
    </tr>
    <tr>
      <td style="width:30%;">No.Registrasi<span class="float-right">:</span></td>
      <td><?= $asesmen->pendaftaran_noregistrasi ?></td>
    </tr>
    <tr>
      <td style="width:30%;">Tgl.Registrasi<span class="float-right">:</span></td>
      <td><?= $template->formatDate($asesmen->pendaftaran_tglregistrasi,'d-m-Y H:i') ?></td>
    </tr>
    <tr>
      <td style="width:30%;">Jenis Kunjungan<span class="float-right">:</span></td>
      <td><?= $asesmen->kunjungan_jeniskunjungan ?></td>
    </tr>
    <tr>
      <td style="width:30%;">Tgl. Kunjungan<span class="float-right">:</span></td>
      <td><?= $template->formatDate($asesmen->kunjungan_tglkunjungan,'d-m-Y H:i') ?></td>
    </tr>
    <tr>
      <td style="width:30%;">Keluhan Utama<span class="float-right">:</span></td>
      <td><?= nl2br($asesmen->keluhan_utama) ?></td>
    </tr>
    <tr>
      <td style="width:30%;">Keluhan Tambahan<span class="float-right">:</span></td>
      <td><?= nl2br($asesmen->keluhan_tambahan) ?></td>
    </tr>
  </tbody>
</table>
