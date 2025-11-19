$(document).ready(function () {
  $('#form_save').validate({
    rules: {
      name: { required: true },
      username: { required: true, nowhitespace: true },
      // email : { required: true, email: true },
      'group_id[]': { required: true },
      password: { required: true, nowhitespace: true },
      re_password: { required: true, nowhitespace: true, equalTo: '#password' },
    },
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

var User = function () {
  let self = this;
  this.isChangePassword = 0;
  this.clearForm = function () {
    $('#form_save').validate().resetForm();
    $('#form_save').find('.is-invalid').removeClass('is-invalid');
    $('#form_save').find('.error').removeClass('error');

    $('#name').val('');
    $('#username').val('');
    $('#email').val('');
    $('#group_id').val('').change();
    $('#isactive').prop('checked', false);
  }

  this.getDataAdd = function () {
    $('#btn_save').attr('onclick', '_User.add()');
    $('#modal_save').modal('show');
    $('#modal_save .modal-title').html('Tambah Data Pengguna');
    self.clearForm();

    let templatePassword = $('#template_user_password').html();
    $('#div_user_password').html(templatePassword);
    $("label[for='password']").text('Kata Sandi');
    $('#password').attr('placeholder', 'Kata Sandi');
    $("label[for='re_password']").text('Ulangi Kata Sandi');
    $('#re_password').attr('placeholder', 'Ulangi Kata Sandi');
    $('#form_save .btn_change_password').remove();
  }

  this.add = function () {
    if ($('#form_save').valid()) {
      $.ajax({
        type: 'POST',
        data: $('#form_save').serialize(),
        url: base_url + 'user/add',
        dataType: 'JSON',
        showLoader: true,
        beforeSend: function () {
        },
      }).done(function (response) {
        if (response.result == 1) {
          top.location.reload();
        } else {
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
  }

  this.getDataEdit = function (id) {
    $.ajax({
      type: 'GET',
      url: base_url + 'user/' + id + '/get',
      dataType: 'JSON',
      beforeSend: function () {
        self.clearForm();
      },
    }).done(function (response) {
      if (response.result == 1) {
        $('#modal_save').modal('show');
        $('#btn_save').attr('onclick', "_User.edit('" + id + "')");
        $('#modal_save .modal-title').html('Ubah Data Pengguna');
        $('#name').val(response.user.name);
        $('#username').val(response.user.username);
        $('#email').val(response.user.email);
        $('#group_id').val(response.user.group_ids).change();
        $('#isactive').prop('checked', (response.user.isactive == '1' ? true : false));
        $('#div_user_password').html('');
        $('#form_save .btn_change_password').remove();
        $('#div_user_password').after(`<a href="#!" class="btn_change_password"><span class="fa fa-lock"></span> Ubah Kata Sandi</a>`);
        self.isChangePassword = 0;
        $('#form_save .btn_change_password').click(function () {
          if (!self.isChangePassword) {
            $('#form_save .btn_change_password').html("<span class='fa fa-times-circle'></span> Batal ubah kata sandi");
            let templatePassword = $('#template_user_password').html();
            $('#div_user_password').html(templatePassword);
            $("label[for='password']").text('Kata Sandi Baru');
            $('#password').attr('placeholder', 'Kata Sandi Baru');
            $("label[for='re_password']").text('Ulangi Kata Sandi Baru');
            $('#re_password').attr('placeholder', 'Ulangi Kata Sandi Baru');

            $('#div_user_password').hide().fadeIn('slow');
            self.isChangePassword = 1;
          } else {
            $('#form_save .btn_change_password').html("<span class='fa fa-lock'></span> Ubah kata sandi");
            $('#div_user_password').html('');
            self.isChangePassword = 0;
          }
        });
      } else {
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

  this.edit = function (id) {
    if ($('#form_save').valid()) {
      $.ajax({
        type: 'POST',
        data: $('#form_save').serialize() + '&is_change_password=' + self.isChangePassword,
        url: base_url + 'user/' + id + '/edit',
        dataType: 'JSON',
        showLoader: true,
        beforeSend: function () {
        },
      }).done(function (response) {
        if (response.result == 1) {
          top.location.reload();
        } else {
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
          url: base_url + 'user/' + id + '/delete',
          dataType: 'JSON',
          showLoader: true,
        }).done(function (response) {
          if (response.result == 1) {
            top.location.reload();
          } else {
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
}

var _User = new User;

