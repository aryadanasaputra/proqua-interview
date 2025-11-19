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
      pasienid: { required: true, },
      noregistrasi: { required: true, },
      tglregistrasi: { required: true, },
    },
  });
});

var Pendaftaran = function () {
  let self = this;
  this.clearForm = function () {
    $('#form_save').validate().resetForm();
    $('#form_save').find('.is-invalid').removeClass('is-invalid');
    $('#form_save').find('.error').removeClass('error');

    $('#pasienid').val('').change();
    $('#noregistrasi').val('');
    $('#tglregistrasi').val('');
  }

  this.getDataAdd = function () {
    $('#btn_save').attr('onclick', '_Pendaftaran.save()');
    $('#modal_save').modal('show');
    self.clearForm();
  }

  this.getDataSave = function (id) {
    $.ajax({
      type: 'GET',
      url: base_url + 'pendaftaran/' + id + '/get',
      dataType: 'JSON',
      beforeSend: function () {
        self.clearForm();
      },
    }).done(function (response) {
      if (response.result == 1) {
        $('#btn_save').attr('onclick', "_Pendaftaran.save('" + id + "')");
        $('#modal_save').modal('show');
        $('#pasienid').val(response.pendaftaran.pasienid).change();
        $('#noregistrasi').val(response.pendaftaran.noregistrasi);
        $('#tglregistrasi').val((response.pendaftaran.tglregistrasi ? moment(response.pendaftaran.tglregistrasi).format('DD-MM-YYYY HH:mm') : ""));
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
      url: base_url + 'pendaftaran/save',
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
          url: base_url + 'pendaftaran/' + id + '/delete',
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
      url: base_url + 'pendaftaran/' + id + '/detailModal',
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

var _Pendaftaran = new Pendaftaran;
