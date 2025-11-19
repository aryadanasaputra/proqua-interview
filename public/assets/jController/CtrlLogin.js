// /* Disabled Right Click */
// $(function() {
//   $(this).bind("contextmenu", function(e) {
//     e.preventDefault();
//   });
// });

$(document).ready(function () {
  $("#form_login").validate({
    rules: {
      username: { required: true },
      password: { required: true },
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

  $("#username").focus();
});

$(document).on('click', '.show-password', function (event) {
  spanPass = $(this).find("span");
  if (spanPass.hasClass("fa fa-lock")) {
    spanPass.attr("class", "fa fa-lock-open");
    inputPass = $(this).closest(".form-group").find("input[type='password']");
    inputPass.attr("type", "text");
  } else {
    spanPass.attr("class", "fa fa-lock");
    inputPass = $(this).closest(".form-group").find("input[type='text']");
    inputPass.attr("type", "password");
  }
});

$(document).on('keypress', '.no-spacing', function (event) {
  if (event.which == 32) {
    event.preventDefault();
  }
});

function login(redirectUrl = null) {
  if ($("#form_login").valid()) {
    $.ajax({
      type: 'POST',
      headers: {
        'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content'),
      },
      data: $("#form_login").serialize(),
      url: base_url + 'doLogin',
      dataType: 'JSON',
    }).done(function (response) {
      if (response.result == 1) {
        if (redirectUrl) {
          window.location.href = base_url + redirectUrl;
        } else {
          window.location.href = base_url;
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
        $('#username').val("").focus();
        $('#password').val("");
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
}

function pressEnter(event, selection) {
  if (event.which == 13) {
    $(selection).click();
    event.preventDefault();
  }
}