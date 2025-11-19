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
      kunjunganid: { required: true, },
      keluhan_utama: { required: true, },
      keluhan_tambahan: { required: true, },
    },
  });

  $("#kunjunganid").select2({
    placeholder: '---',
    allowClear: true,
    templateSelection: function (option) {
      let tglkunjungan = $(option.element).data('tglkunjungan');
      return tglkunjungan;
    },
    templateResult: function (option) {
      let tglkunjungan = $(option.element).data('tglkunjungan');
      let pasien_nama = $(option.element).data('pasien_nama');
      let pasien_norm = $(option.element).data('pasien_norm');
      if (typeof name !== 'undefined') {
        return $(`<span>${tglkunjungan}</span><br><small>${pasien_nama} (${pasien_norm})</small>`);
      } else {
        return $('<span>---</span>');
      }
    },
  });
});

var Asesmen = function () {
  let self = this;
  this.clearForm = function () {
    $('#form_save').validate().resetForm();
    $('#form_save').find('.is-invalid').removeClass('is-invalid');
    $('#form_save').find('.error').removeClass('error');

    $('#kunjunganid').val('').change();
    $('#keluhan_utama').val('');
    $('#keluhan_tambahan').val('');
  }

  this.getDataAdd = function () {
    $('#btn_save').attr('onclick', '_Asesmen.save()');
    $('#modal_save').modal('show');
    self.clearForm();
  }

  this.getDataSave = function (id) {
    $.ajax({
      type: 'GET',
      url: base_url + 'asesmen/' + id + '/get',
      dataType: 'JSON',
      beforeSend: function () {
        self.clearForm();
      },
    }).done(function (response) {
      if (response.result == 1) {
        $('#btn_save').attr('onclick', "_Asesmen.save('" + id + "')");
        $('#modal_save').modal('show');
        $('#kunjunganid').val(response.asesmen.kunjunganid).change();
        $('#keluhan_utama').val(response.asesmen.keluhan_utama);
        $('#keluhan_tambahan').val(response.asesmen.keluhan_tambahan);
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
      url: base_url + 'asesmen/save',
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
          url: base_url + 'asesmen/' + id + '/delete',
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
      url: base_url + 'asesmen/' + id + '/detailModal',
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

var _Asesmen = new Asesmen;
