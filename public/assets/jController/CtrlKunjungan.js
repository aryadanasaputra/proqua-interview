$(document).ready(function () {
  $('#form_save').validate({
    errorElement: 'span',
    errorPlacement: function (error, element) {
      error.addClass('invalid-feedback');
      element.closest('.form-group').append(error);
    },
    highlight: function (element, errorClass, validClass) {
      $(element).addClass('is-invalid');
    },
    unhighlight: function (element, errorClass, validClass) {
      $(element).removeClass('is-invalid');
    },
    invalidHandler: function (event, validator) {
      if (validator.errorList.length > 0) {
        let firstInvalidElement = $(validator.errorList[0].element);
        firstInvalidElement.focus();
      }
    },
    rules: {
      pendaftaranpasienid: { required: true, },
      jeniskunjungan: { required: true, },
      tglkunjungan: { required: true, },
    },
  });

  $("#pendaftaranpasienid").select2({
    placeholder: '---',
    allowClear: true,
    templateSelection: function (option) {
      let noregistrasi = $(option.element).data('noregistrasi');
      return noregistrasi;
    },
    templateResult: function (option) {
      let noregistrasi = $(option.element).data('noregistrasi');
      let tglregistrasi = $(option.element).data('tglregistrasi');
      let pasien_nama = $(option.element).data('pasien_nama');
      let pasien_norm = $(option.element).data('pasien_norm');
      if (typeof name !== 'undefined') {
        return $(`<span>${noregistrasi}</span><br><small>${pasien_nama} (${pasien_norm})</small><br><span>${tglregistrasi}</span>`);
      } else {
        return $('<span>---</span>');
      }
    },
  });
});

var Kunjungan = function () {
  let self = this;
  this.clearForm = function () {
    $('#form_save').validate().resetForm();
    $('#form_save').find('.is-invalid').removeClass('is-invalid');
    $('#form_save').find('.error').removeClass('error');

    $('#pendaftaranpasienid').val('').change();
    $('#jeniskunjungan').val('').change();
    $('#tglkunjungan').val('');
  }

  this.getDataAdd = function () {
    $('#btn_save').attr('onclick', '_Kunjungan.save()');
    $('#modal_save').modal('show');
    self.clearForm();
  }

  this.getDataSave = function (id) {
    $.ajax({
      type: 'GET',
      url: base_url + 'kunjungan/' + id + '/get',
      dataType: 'JSON',
      beforeSend: function () {
        self.clearForm();
      },
    }).done(function (response) {
      if (response.result == 1) {
        $('#btn_save').attr('onclick', "_Kunjungan.save('" + id + "')");
        $('#modal_save').modal('show');
        $('#pendaftaranpasienid').val(response.kunjungan.pendaftaranpasienid).change();
        $('#jeniskunjungan').val(response.kunjungan.jeniskunjungan).change();
        $('#tglkunjungan').val((response.kunjungan.tglkunjungan ? moment(response.kunjungan.tglkunjungan).format('DD-MM-YYYY HH:mm') : ""));
      } else {
        // toastr.error(response.message);
        Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        }).fire({
          icon: 'error',
          title: response.message
        })
      }
    }).fail(function (xhr) {
      // toastr.error('Proses gagal, Silahkan refresh halaman ini!');
      Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      }).fire({
        icon: 'error',
        title: 'Proses gagal, Silahkan refresh halaman ini!'
      })
    }).always();
  }

  this.save = function (id = null) {
    if (!$('#form_save').valid()) {
      Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      }).fire({
        icon: 'error',
        title: 'Lengkap data terlebih dahulu!'
      })
      return;
    }

    let formData = $('#form_save').serialize();
    if (id) formData += '&id=' + id;
    $.ajax({
      type: 'POST',
      data: formData,
      url: base_url + 'kunjungan/save',
      dataType: 'JSON',
      showLoader: true,
      beforeSend: function () {
      },
    }).done(function (response) {
      if (response.result == 1) {
        Swal.fire({
          icon: 'success',
          title: 'Simpan berhasil!',
          text: 'Halaman Akan di refresh.'
        }).then(() => {
          top.location.reload();
        });
      } else {
        // toastr.error(response.message);
        Swal.mixin({
          toast: true,
          position: 'top-end',
          showConfirmButton: false,
          timer: 3000
        }).fire({
          icon: 'error',
          title: response.message
        })
      }
    }).fail(function (xhr) {
      // toastr.error('Proses gagal, Silahkan refresh halaman ini!');
      Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      }).fire({
        icon: 'error',
        title: 'Proses gagal, Silahkan refresh halaman ini!'
      })
    }).always(function () {
    });
  }

  this.del = function (id) {
    confirmModal({
      title: 'Konfirmasi',
      text: 'Apakah Anda yakin akan menghapus data ini ?',
      confirmButtonText: 'Ya, Hapus',
      customClass: {
        headerClass: 'bg-gradient-danger',
        confirmButtonClass: 'btn-danger',
      },
    },
      function () {
        $.ajax({
          type: 'POST',
          url: base_url + 'kunjungan/' + id + '/delete',
          dataType: 'JSON',
          showLoader: true,
        }).done(function (response) {
          if (response.result == 1) {
            Swal.fire({
              icon: 'success',
              title: 'Hapus berhasil!',
              text: 'Halaman Akan di refresh.'
            }).then(() => {
              top.location.reload();
            });
          } else {
            // toastr.error(response.message);
            Swal.mixin({
              toast: true,
              position: 'top-end',
              showConfirmButton: false,
              timer: 3000
            }).fire({
              icon: 'error',
              title: response.message
            })
          }
        }).fail(function (xhr) {
          // toastr.error('Proses gagal, Silahkan refresh halaman ini!');
          Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000
          }).fire({
            icon: 'error',
            title: 'Proses gagal, Silahkan refresh halaman ini!'
          })
        }).always();
      });
  }

  this.detailModal = function (id) {
    $.ajax({
      type: 'GET',
      url: base_url + 'kunjungan/' + id + '/detailModal',
      dataType: 'JSON',
      showLoader: true,
      beforeSend: function () {
        $('#modal_detail .modal-body').html('');
      },
    }).done(function (response) {
      if (response.result == 1) {
        $('#modal_detail').modal('show');
        $('#modal_detail .modal-body').html(response.html);
      } else {
        toastr.error(response.message);
      }
    }).fail(function (xhr) {
      toastr.error('Proses gagal, Silahkan refresh halaman ini!');
    }).always();
  }
}

var _Kunjungan = new Kunjungan;
