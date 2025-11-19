$(document).ready(function () {
  $('#form_save').validate({
    rules: { name: { required: true }, },
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
  });
});

var Group = function () {
  let self = this;
  this.clearForm = function () {
    $('#form_save').validate().resetForm();
    $('#form_save').find('.is-invalid').removeClass('is-invalid');
    $('#form_save').find('.error').removeClass('error');

    $('#name').val('');
    $('#notes').val('');
    $('#isactive').prop('checked', false);
    $("#form_save input:checkbox[name='role_id[]']").prop('checked', false);
  }

  this.getDataAdd = function () {
    $('#btn_save').attr('onclick', '_Group.add()');
    $('#modal_save').modal('show');
    $('#modal_save .modal-title').html('Tambah Data Group');
    self.clearForm();
  }

  this.add = function () {
    if ($('#form_save').valid()) {
      $.ajax({
        type: 'POST',
        data: $('#form_save').serialize(),
        url: base_url + 'group/add',
        dataType: 'JSON',
        showLoader: true,
        beforeSend: function () {
        },
      }).done(function (response) {
        if (response.result == 1) {
          top.location.reload();
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
  }

  this.getDataEdit = function (id) {
    $.ajax({
      type: 'GET',
      url: base_url + 'group/' + id + '/get',
      dataType: 'JSON',
      beforeSend: function () {
        self.clearForm();
      },
    }).done(function (response) {
      if (response.result == 1) {
        $('#modal_save').modal('show');
        $('#btn_save').attr('onclick', "_Group.edit('" + id + "')");
        $('#modal_save .modal-title').html('Ubah Data Group');
        $('#name').val(response.group.name);
        $('#notes').val(response.group.notes);
        $('#isactive').prop('checked', (response.group.isactive == '1' ? true : false));
        $("#form_save input:checkbox[name='role_id[]']").prop('checked', false);
        for (role_id of response.group.role_ids) {
          $(`#form_save input:checkbox[name='role_id[]'][value='${role_id}']`).prop('checked', true);
        }
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

  this.edit = function (id) {
    if ($('#form_save').valid()) {
      $.ajax({
        type: 'POST',
        data: $('#form_save').serialize(),
        url: base_url + 'group/' + id + '/edit',
        dataType: 'JSON',
        showLoader: true,
        beforeSend: function () {
        },
      }).done(function (response) {
        if (response.result == 1) {
          top.location.reload();
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
          data: {
            id: id,
          },
          url: base_url + 'group/' + id + '/delete',
          dataType: 'JSON',
          showLoader: true,
        }).done(function (response) {
          if (response.result == 1) {
            top.location.reload();
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

  this.doCheckRole = function ($this) {
    if ($($this).is(':checked')) {
      $curr = $($this).closest('ul').closest('li').find("input[type='checkbox']")[0];
      $($curr).prop('checked', true);
      self.doCheckRole($curr);
    } else {
      $($this).closest('li').find("input[type='checkbox']").prop('checked', false);
    }
  }
}

var _Group = new Group;