<table class="table table-sm table-borderless">
  <tbody>
    <tr>
      <td style="width:30%;">Pasien<span class="float-right">:</span></td>
      <td><?= $pendaftaran->pasien_nama ?></td>
    </tr>
    <tr>
      <td style="width:30%;">No.RM<span class="float-right">:</span></td>
      <td><?= $pendaftaran->pasien_norm ?></td>
    </tr>
    <tr>
      <td style="width:30%;">No.Registrasi<span class="float-right">:</span></td>
      <td><?= $pendaftaran->noregistrasi ?></td>
    </tr>
    <tr>
      <td style="width:30%;">Tgl.Registrasi<span class="float-right">:</span></td>
      <td><?= $template->formatDate($pendaftaran->tglregistrasi,'d-m-Y H:i') ?></td>
    </tr>
  </tbody>
</table>
