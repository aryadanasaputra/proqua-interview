<table class="table table-sm table-borderless">
  <tbody>
    <tr>
      <td style="width:30%;">Pasien<span class="float-right">:</span></td>
      <td><?= $kunjungan->pasien_nama ?></td>
    </tr>
    <tr>
      <td style="width:30%;">No.RM<span class="float-right">:</span></td>
      <td><?= $kunjungan->pasien_norm ?></td>
    </tr>
    <tr>
      <td style="width:30%;">No.Registrasi<span class="float-right">:</span></td>
      <td><?= $kunjungan->pendaftaran_noregistrasi ?></td>
    </tr>
    <tr>
      <td style="width:30%;">Tgl.Registrasi<span class="float-right">:</span></td>
      <td><?= $template->formatDate($kunjungan->pendaftaran_tglregistrasi,'d-m-Y H:i') ?></td>
    </tr>
    <tr>
      <td style="width:30%;">Jenis Kunjungan<span class="float-right">:</span></td>
      <td><?= $kunjungan->jeniskunjungan ?></td>
    </tr>
    <tr>
      <td style="width:30%;">Tgl. Kunjungan<span class="float-right">:</span></td>
      <td><?= $template->formatDate($kunjungan->tglkunjungan,'d-m-Y H:i') ?></td>
    </tr>
  </tbody>
</table>
