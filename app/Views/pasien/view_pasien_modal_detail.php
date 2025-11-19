<table class="table table-sm table-borderless">
  <tbody>
    <tr>
      <td style="width:30%;">Nama<span class="float-right">:</span></td>
      <td><?= $pasien->nama ?></td>
    </tr>
    <tr>
      <td style="width:30%;">Norm<span class="float-right">:</span></td>
      <td><?= $pasien->norm ?></td>
    </tr>
    <tr>
      <td style="width:30%;">Alamat<span class="float-right">:</span></td>
      <td><?= nl2br($pasien->alamat) ?></td>
    </tr>
  </tbody>
</table>
