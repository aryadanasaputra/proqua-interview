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
      nama: { required: true, },
      norm: { required: true, },
      alamat: { required: true, },
    },
  });
});

var Pasien = function () {
  let self = this;
  this.clearForm = function () {
    $('#form_save').validate().resetForm();
    $('#form_save').find('.is-invalid').removeClass('is-invalid');
    $('#form_save').find('.error').removeClass('error');

    $('#nama').val('');
    $('#norm').val('');
    $('#alamat').val('');
  }

  this.getDataAdd = function () {
    $('#btn_save').attr('onclick', '_Pasien.save()');
    $('#modal_save').modal('show');
    self.clearForm();
  }

  this.getDataSave = function (id) {
    $.ajax({
      type: 'GET',
      url: base_url + 'pasien/' + id + '/get',
      dataType: 'JSON',
      beforeSend: function () {
        self.clearForm();
      },
    }).done(function (response) {
      if (response.result == 1) {
        $('#btn_save').attr('onclick', "_Pasien.save('" + id + "')");
        $('#modal_save').modal('show');
        $('#nama').val(response.pasien.nama);
        $('#norm').val(response.pasien.norm);
        $('#alamat').val(response.pasien.alamat);
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
      // toastr.error('Lengkap data terlebih dahulu!');
      Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000
      }).fire({
        icon: 'error',
        title: 'Lengkap data terlebih dahulu!'
      });
      return;
    }
    let formData = $('#form_save').serialize();
    if (id) formData += '&id=' + id;
    $.ajax({
      type: 'POST',
      data: formData,
      url: base_url + 'pasien/save',
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
          url: base_url + 'pasien/' + id + '/delete',
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

  this.importJson = function () {
    if ($('#form_import_json').valid()) {
      let formData = new FormData($("#form_import_json")[0]);
      $.ajax({
        type: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        url: base_url + 'pasien/importJson',
        dataType: 'JSON',
        beforeSend: function () {
        },
      }).done(function (response) {
        if (response.result == 1) {
          top.location.reload();
        } else {
          toastr.error(response.message);
        }
      }).fail(function (xhr) {
        toastr.error('Proses gagal, Silahkan refresh halaman ini!');
      }).always(function () {
      });
    }
  }

  this.detailModal = function (id) {
    $.ajax({
      type: 'GET',
      url: base_url + 'pasien/' + id + '/detailModal',
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

var _Pasien = new Pasien;
