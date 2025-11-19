$(document).on('click', '[data-toggle="lightbox"]', function (event) {
  event.preventDefault();
  $(this).ekkoLightbox({
    alwaysShowClose: true
  });
});

$.ajaxSetup({
  headers: {
    'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
  }
});

// Handle Ajax request error
$(document).ajaxError(function (event, xhr, options, exc) {
  if (xhr.status == '403' && xhr.responseText == 'session expired') {
    // toastr.error('Sesi habis, silahkan refresh halaman ini untuk Login kembali !');
    Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    }).fire({
      icon: 'error',
      title: 'Sesi habis, silahkan refresh halaman ini untuk Login kembali !'
    })
  }
});

/* Validate */
/* Validate filesize when upload file */
$.validator.addMethod('filesize', function (value, element, param) {
  return this.optional(element) || (element.files[0].size <= param)
}, 'Ukuran File harus kurang dari {0}');

/* Validate Date */
$.validator.addMethod('validDate', function (value, element) {
  return this.optional(element) || moment(value, 'DD-MM-YYYY', true).isValid() || moment(value, 'DD-MM-YYYY HH:mm', true).isValid();
}, 'Harap masukkan Tanggal yg valid.');

/* Validate Date */
$.validator.addMethod('validNik', function (value, element) {
  if (!this.optional(element)) {
    if (value.length !== 16) {
      return false;
    }
  }
  return true;
}, 'Harap masukkan NIK yg valid.');

// /* Disabled Right Click */
// $(function(){
//   $(this).bind('contextmenu', function(event){
//     event.preventDefault();
//   });
// });

$(document).ready(function () {
  initPlugin();

  /** Auto Active on Menu */
  let currentUrl = window.location.href.split('#')[0];

  $('ul.nav-sidebar li a').each(function () {
    let dataActionActive = $(this).data('action_active');
    if (dataActionActive) {
      let actionActivePatterns = dataActionActive.split(',');
      for (let i = 0; i < actionActivePatterns.length; i++) {
        let pattern = base_url + actionActivePatterns[i].replace(/\*/g, '[^/]+');
        let regex = new RegExp('^' + pattern + '$');
        if (regex.test(currentUrl)) {
          $(this).closest('li a').addClass('active');
          $(this).parentsUntil('.nav-sidebar', 'li.has-treeview').addClass('menu-open');
          $(this).parentsUntil('.nav-sidebar', 'li.has-treeview').children('a').addClass('active');
          break;
        }
      }
    }
  });

  /** Form User Probfile Validation */
  $('#form_user_profile').validate({
    rules: {
      name: { required: true },
      username: { required: true, nowhitespace: true },
      // email : {required: true, email: true},
      old_password: { required: true, nowhitespace: true },
      password: { required: true, nowhitespace: true },
      re_password: { required: true, nowhitespace: true, equalTo: '#profile_password' },
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

  $('.datatable').DataTable();
});

$(document).ajaxSend(function (event, xhr, options) {
  if (options.showLoader) {
    $("#loader").show();
    xhr._showLoader = true;
  }
});

$(document).ajaxComplete(function (event, xhr, options) {
  if (xhr._showLoader) {
    $("#loader").hide();
  }
  $("[data-toggle='tooltip']").tooltip();
  $("[data-toggle='popover']").popover();
});

$(document).ajaxError(function (event, xhr, options, exc) {
  if (xhr._showLoader) {
    $("#loader").hide();
  }
});

/**
 * Attr Action
 */

// number only mask
$(document).on('keypress', 'input.numericInput', function (event) {
  return /[0-9]/.test(String.fromCharCode(event.which));
});

$(document).on('keypress', '.number-only', function (event) {
  const charCode = event.which;
  const val = $(this).val();
  if (
    (charCode != 46 || val.indexOf('.') != -1) && // hanya boleh satu titik
    (charCode != 45 || val.indexOf('-') != -1 || this.selectionStart !== 0) && // minus hanya boleh di awal dan satu kali
    (charCode < 48 || charCode > 57) && // bukan angka
    charCode !== 8 // bukan backspace
  ) {
    event.preventDefault();
  }
});

$(document).on('keypress', '.no-spacing', function (event) {
  if (event.which == 32) {
    event.preventDefault();
  }
});

$(document).on('keydown', '.no-enter', function (event) {
  if (event.key === 'Enter') {
    event.preventDefault();
  }
});

// show password
$(document).on('click', '.show-password', function (event) {
  spanPass = $(this).find('span');
  if (spanPass.hasClass('fa fa-eye-slash')) {
    spanPass.attr('class', 'fa fa-eye');
    inputPass = $(this).closest('.form-group').find("input[type='password']");
    inputPass.attr('type', 'text');
  } else {
    spanPass.attr('class', 'fa fa-eye-slash');
    inputPass = $(this).closest('.form-group').find("input[type='text']");
    inputPass.attr('type', 'password');
  }
});

//Modal Outside
$(document).on('click', 'body', function (event) {
  if ($(event.target).closest('.modal[data-backdrop=static]').length && $(event.target).is('.modal[data-backdrop=static]')) {
    $('.modal-dialog').addClass('animated shake');
    setTimeout(function () {
      $('.modal-dialog').removeClass('animated shake');
    }, 1000);
  }
});

$(document).on('hidden.bs.modal', function (event) {
  if ($('.modal:visible').length) {
    $('body').addClass('modal-open');
  }
});

// $('.modal-dialog').draggable();

function initPlugin(container = null) {
  if (container) {
    $(container).find("[data-toggle='tooltip']").tooltip({
      container: '.content-wrapper'
    });

    // Datepicker
    $(container).find('.datepicker').each(function () {
      $(this).datetimepicker({
        format: 'DD-MM-YYYY',
        locale: moment.locale('id', {
          week: {
            dow: 0
          }
        }),
        // autoclose: true,
      });
    });
    // datepicker Mask dd-mm-yyyy
    $(container).find('.datepicker-input').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' });

    // Datetimepicker
    $(container).find('.datetimepicker').each(function () {
      $(this).datetimepicker({
        format: 'DD-MM-YYYY HH:mm',
        locale: moment.locale('id', {
          week: {
            dow: 0
          }
        }),
        sideBySide: true,
        // autoclose: true,
        icons: {
          time: 'fa fa-clock',
          date: 'fa fa-calendar'
        }
      });
    });
    // datetimepicker Mask dd-mm-yy HH:MM
    $(container).find('.datetimepicker-input').inputmask('dd-mm-yyyy HH:MM', { 'placeholder': 'dd-mm-yyyy HH:MM' });

    // Timepicker
    $(container).find('.timepicker').each(function () {
      $(this).datetimepicker({
        format: 'HH:mm',
        // autoclose: true,
      });
    });
    // timepicker Mask HH:MM
    $(container).find('.timepicker-input').inputmask('HH:MM', { 'placeholder': 'HH:MM' });
    // Initialize Select2 Elements
    $(container).find('.select2').select2({
      theme: 'bootstrap4',
    });

    $(container).find('.select2Tags').select2({
      theme: 'bootstrap4',
      tags: true,
    });

    // priceFormat mask
    $(container).find('.rupiah').priceFormat({
      prefix: 'Rp ',
      suffix: '',
      centsSeparator: ',',
      thousandsSeparator: '.',
      clearSuffix: true,
      clearPrefix: true,
      limit: 18,
      centsLimit: 0,
    });

    $(container).find('.currency').priceFormat({
      prefix: '',
      suffix: '',
      centsSeparator: ',',
      thousandsSeparator: '.',
      clearSuffix: true,
      clearPrefix: true,
      limit: 18,
      centsLimit: 0,
    });

    // Initialize bsCustomFileInput Elements
    bsCustomFileInput.init();
  } else {
    $("[data-toggle='tooltip']").tooltip({
      container: '.content-wrapper'
    });

    // Datepicker
    $('.datepicker').each(function () {
      $(this).datetimepicker({
        format: 'DD-MM-YYYY',
        locale: moment.locale('id', {
          week: {
            dow: 0
          }
        }),
        // autoclose: true,
      });
    });
    // datepicker Mask dd-mm-yyyy
    $('.datepicker-input').inputmask('dd-mm-yyyy', { 'placeholder': 'dd-mm-yyyy' });

    // Datetimepicker
    $('.datetimepicker').each(function () {
      $(this).datetimepicker({
        format: 'DD-MM-YYYY HH:mm',
        locale: moment.locale('id', {
          week: {
            dow: 0
          }
        }),
        sideBySide: true,
        // autoclose: true,
        icons: {
          time: 'fa fa-clock',
          date: 'fa fa-calendar'
        }
      });
    });
    // datetimepicker Mask dd-mm-yy HH:MM
    $('.datetimepicker-input').inputmask('dd-mm-yyyy HH:MM', { 'placeholder': 'dd-mm-yyyy HH:MM' });
    // Timepicker
    $('.timepicker').each(function () {
      $(this).datetimepicker({
        format: 'HH:mm',
        // autoclose: true,
      });
    });
    // timepicker Mask HH:MM
    $('.timepicker-input').inputmask('HH:MM', { 'placeholder': 'HH:MM' });

    // Initialize Select2 Elements
    $('.select2').select2({
      theme: 'bootstrap4',
    });

    $('.select2Tags').select2({
      theme: 'bootstrap4',
      tags: true,
    });

    // priceFormat mask
    $('.rupiah').priceFormat({
      prefix: 'Rp ',
      suffix: '',
      centsSeparator: ',',
      thousandsSeparator: '.',
      clearSuffix: true,
      clearPrefix: true,
      limit: 18,
      centsLimit: 0,
    });

    $('.currency').priceFormat({
      prefix: '',
      suffix: '',
      centsSeparator: ',',
      thousandsSeparator: '.',
      clearSuffix: true,
      clearPrefix: true,
      limit: 18,
      centsLimit: 0,
    });

    // Initialize bsCustomFileInput Elements
    bsCustomFileInput.init();
  }
}

/**
 * Start Pagination
 */

var Pagination = function () {
  this.orderedSort = 'asc';
  this.dataGet = {};
  this.divPaging = '#div-paging';
  this.urlRefreshTable = '';

  let self = this;

  /** search */
  this.search = function (id) {
    self.dataGet.search = $(id).val();
    self.refreshTable();
  }

  /** ordered */
  this.ordered = function (orderedField) {
    self.dataGet.ordered_field = orderedField;
    self.dataGet.ordered_sort = self.orderedSort;
    self.orderedSort = self.orderedSort == 'asc' ? 'desc' : 'asc';
    self.refreshTable();
  }

  /** filter */
  this.filter = function ({ inputId = null, formId = null }) {
    if (formId) {
      if (!$(formId).valid()) {
        return;
      }
      for (let input of $(formId).serializeArray()) {
        self.dataGet[input.name] = input.value;
      }
    }
    if (Array.isArray(inputId)) {
      for (let input of inputId) {
        if ($(input).attr('type') == 'checkbox') {
          self.dataGet[input.replace('#filter_', '')] = $(input).is(':checked') ? 1 : 0;
        } else {
          self.dataGet[input.replace('#filter_', '')] = $(input).val();
        }
      }
    } else {
      if (inputId) {
        if ($(inputId).attr('type') == 'checkbox') {
          self.dataGet[inputId.replace('#filter_', '')] = $(inputId).is(':checked') ? 1 : 0;
        } else {
          self.dataGet[inputId.replace('#filter_', '')] = $(inputId).val();
        }
      }
    }
    self.refreshTable();
  }

  this.refreshTable = function () {
    $.ajax({
      type: 'GET',
      data: self.dataGet,
      url: base_url + self.urlRefreshTable,
      beforeSend: function () {
        $(self.divPaging).html('');
      },
    }).done(function (message) {
      $(self.divPaging).html(message);
      toastr.success('Data berhasil diload!');
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

  this.exportExcel = function (url) {
    let strUrlGet = window.location.search;
    if (self.dataGet) {
      for (let key in self.dataGet) {
        strUrlGet += (strUrlGet ? '&' : '?') + key + '=' + encodeURIComponent(self.dataGet[key]);
      }
    }
    top.location.href = url + strUrlGet;
  }

  this.exportPdf = function (url) {
    let strUrlGet = window.location.search;
    if (self.dataGet) {
      for (let key in self.dataGet) {
        strUrlGet += (strUrlGet ? '&' : '?') + key + '=' + encodeURIComponent(self.dataGet[key]);
      }
    }
    popupCenter({ pageURL: url + strUrlGet, title: 'Cetak PDF' });
  }

  this.validateFilterDate = function (startDateId, endDateId) {
    $(endDateId).datetimepicker('useCurrent', false);
    $(startDateId).on('change.datetimepicker', (e) => {
      $(endDateId).datetimepicker('minDate', e.date);
    });

    $(endDateId).on('change.datetimepicker', (e) => {
      // $(startDateId).datetimepicker('maxDate', e.date);
    });
  }
}

var _Pagination = new Pagination;

$(document).on('click', '.paging-1 li a', function () {
  let url = $(this).attr('href');
  $.ajax({
    type: 'GET',
    data: _Pagination.dataGet,
    url: url,
  }).done(function (message) {
    $(_Pagination.divPaging).html(message);
  }).fail().always();
  return false;
});

/**
 * End Pagination
 */

/**
 * Start User Profile
 */

var UserProfile = function () {
  this.isChangePassword = 0;

  this.getData = function () {
    self.isChangePassword = 0;
    $.ajax({
      type: 'GET',
      url: base_url + 'profile',
      dataType: 'JSON',
    }).done(function (response) {
      if (response.result == 1) {
        $('#modal_user_profile').modal('show');
        $('#profile_name').val(response.user.name);
        $('#profile_username').val(response.user.username);
        $('#profile_email').val(response.user.email);
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

  this.save = function () {
    if ($('#form_user_profile').valid()) {
      $.ajax({
        type: 'POST',
        data: $('#form_user_profile').serialize() + '&is_change_password=' + self.isChangePassword,
        url: base_url + 'profile',
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

  this.changePassword = function () {
    if (!self.isChangePassword) {
      $('#form_user_profile .btn_change_password').html(`<span class="fa fa-times-circle"></span> Batal ubah kata sandi`);
      let templatePassword = $('#template_user_profile_password').html();
      $('#div_user_profile_password').html(templatePassword);

      $('#div_user_profile_password').hide().fadeIn('slow');

      self.isChangePassword = 1;
    } else {
      $('#form_user_profile .btn_change_password').html("<span class='fa fa-lock'></span> Ubah kata sandi");
      $('#div_user_profile_password').html('');
      self.isChangePassword = 0;
    }
  }

  this.getGroup = function () {
    $.ajax({
      type: 'GET',
      url: base_url + 'profile/group',
      dataType: 'JSON',
      beforeSend: function () {
        $('#div_user_profile_group').html('');
      },
    }).done(function (response) {
      if (response.result == 1) {
        let html = `<div class="list-group">`;
        html += `<a href="#!" class="list-group-item list-group-item-action" onclick="_UserProfile.switchGroup('all')">
          <h6>Semua</h6>
          <small class="text-muted">Akses ke semua grup pengguna</small>
        </a>`;
        for (let group of response.group) {
          html += `<a href="#!" class="list-group-item list-group-item-action" onclick="_UserProfile.switchGroup('${group.id}')">
            <h6>${group.name}</h6>
            <small class="text-muted">${group.notes}</small>
          </a>`;
        }
        html += `</div>`;
        $('#div_user_profile_group').html(html);
        $('#modal_user_profile_group').modal('show');
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

  this.switchGroup = function (id) {
    $.ajax({
      type: 'POST',
      url: base_url + 'profile/group',
      data: { id },
      dataType: 'JSON',
    }).done(function (response) {
      if (response.result == 1) {
        top.location.href = base_url;
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
}

var _UserProfile = new UserProfile;

/**
 * End User Profile
 */

function keyEnter(event, selection, url) {
  if (event.which == 13) {
    submit_data(selection, url);
    event.preventDefault();
  }
}

function pressEnter(event, selection) {
  if (event.which == 13) {
    $(selection).click();
    event.preventDefault();
  }
}

function popupCenter({ pageURL = null, title = 'Cetak', w = 650, h = 300 }) {
  let left = (screen.width / 2) - (w / 2);
  let top = (screen.height / 2) - (h / 2);
  let specs = 'toolbar=no, location=no, status=no, menubar=no, resizable=no, scrollbars=yes, copyhistory=no, width=' + w + ', height=' + h + ', top=' + top + ', left=' + left;
  window.open(pageURL, title, specs);
}

var UploadImage = function ({
  imgSelector,
  fileInputSelector,
  videoSelector,
  divBtnSelector,
}) {
  let self = this;
  let stream = null;

  this.imageBlobHigh = null;
  this.imageBlobThumb = null;
  this.angle = 0;
  this.isexist = false;

  this.triggerFileInput = function () {
    $(fileInputSelector).click();
  };

  this.loadImage = function () {
    let file = $(fileInputSelector)[0].files[0];
    if (!file || !['image/jpeg', 'image/png'].includes(file.type)) {
      alert('Format gambar harus JPG atau PNG!');
      return;
    }

    let reader = new FileReader();
    reader.onload = function (e) {
      let img = new Image();
      img.onload = async function () {
        self.imageBlobHigh = await self.resize(img, 2000, 2000);
        self.imageBlobThumb = await self.resize(img, 100, 100);
        $(imgSelector).attr('src', e.target.result).css('transform', 'rotate(0deg)');
        self.angle = 0;
      };
      img.src = e.target.result;
    };
    reader.readAsDataURL(file);
    self.isexist = 1;
  };

  this.resize = function (img, maxWidth, maxHeight) {
    return new Promise((resolve) => {
      let canvas = document.createElement('canvas');
      let ctx = canvas.getContext('2d');
      let width = img.width;
      let height = img.height;

      let scale = Math.min(maxWidth / width, maxHeight / height);
      width = Math.floor(scale * width);
      height = Math.floor(scale * height);

      canvas.width = width;
      canvas.height = height;
      ctx.drawImage(img, 0, 0, width, height);

      canvas.toBlob(function (blob) {
        resolve(blob);
      }, 'image/jpeg', 0.8);
    });
  };

  this.rotate = function (angle) {
    if (self.isexist) {
      let currentAngle = parseInt(self.angle, 10) || 0;
      let newAngle = (currentAngle + angle) % 360;
      $(imgSelector).css('transform', 'rotate(' + newAngle + 'deg)');
      self.angle = newAngle;
    }
  };

  this.reset = function () {
    $(imgSelector).attr('src', image_default_url).css('transform', 'rotate(0deg)');
    self.imageBlobHigh = null;
    self.imageBlobThumb = null;
    self.angle = 0;
    self.isexist = 0;
  };

  this.startCamera = function () {
    if (!videoSelector) return;

    if (!navigator.mediaDevices || !navigator.mediaDevices.getUserMedia) {
      alert('Browser Anda tidak mendukung akses kamera!');
      return;
    }

    $(videoSelector).show();

    $(imgSelector).hide();
    $(divBtnSelector + ' .btn_operation').hide();
    $(divBtnSelector + ' .btn_camera_start').hide();
    $(divBtnSelector + ' .btn_camera_capture').show();
    $(divBtnSelector + ' .btn_camera_stop').show();

    navigator.mediaDevices.getUserMedia({ video: true, audio: false })
      .then(function (mediaStream) {
        stream = mediaStream;
        $(videoSelector)[0].srcObject = mediaStream;
        $(videoSelector)[0].play();
      })
      .catch(function (error) {
        console.error('Gagal mengakses kamera:', error);
        alert('Gagal mengakses kamera. Pastikan Anda memberikan izin.');
        $(videoSelector).hide();

        $(imgSelector).show();
        $(divBtnSelector + ' .btn_operation').show();
        $(divBtnSelector + ' .btn_camera_start').show();
        $(divBtnSelector + ' .btn_camera_capture').hide();
        $(divBtnSelector + ' .btn_camera_stop').hide();
      });
  };

  this.stopCamera = function () {
    if (!videoSelector || !stream) return;

    stream.getTracks().forEach(track => track.stop());
    stream = null;

    $(videoSelector).hide();
    $(imgSelector).show();
    $(divBtnSelector + ' .btn_operation').show();
    $(divBtnSelector + ' .btn_camera_start').show();
    $(divBtnSelector + ' .btn_camera_capture').hide();
    $(divBtnSelector + ' .btn_camera_stop').hide();
  };

  this.captureImage = function () {
    if (!videoSelector || !stream) {
      self.startCamera();
      return;
    }

    let video = $(videoSelector)[0];

    let canvas = document.createElement('canvas');
    canvas.width = video.videoWidth;
    canvas.height = video.videoHeight;
    let ctx = canvas.getContext('2d');
    ctx.drawImage(video, 0, 0, canvas.width, canvas.height);

    let dataURL = canvas.toDataURL('image/png');

    let img = new Image();
    img.onload = async function () {
      self.imageBlobHigh = await self.resize(img, 2000, 2000);
      self.imageBlobThumb = await self.resize(img, 100, 100);
      $(imgSelector).attr('src', dataURL).css('transform', 'rotate(0deg)');
      self.angle = 0;
    };
    img.src = dataURL;

    self.isexist = 1;
    self.stopCamera();
  };
}

function base64encode(string) {
  return btoa(string);
}

function base64decode(string) {
  return atob(string);
}

function doCheckAll($this, classCbInput) {
  if ($($this).is(':checked')) {
    $('.' + classCbInput).prop('checked', true).change();
  } else {
    $('.' + classCbInput).prop('checked', false).change();
  }
}

function formatNumber(num) {
  return num.toString().replace(/(\d)(?=(\d{3})+(?!\d))/g, '$1.');
}

function selectedId(selectId, doSelectId, doUrl) {
  $(doSelectId).html(`<option value="">---</option>`);
  let id = $(selectId).val();
  if (id) {
    $.ajax({
      type: 'POST',
      data: {
        id: id,
      },
      url: base_url + doUrl,
      dataType: 'JSON',
    }).done(function (response) {
      if (response.result == 1) {
        let html = `<option value="">---</option>`;
        for (let data of response.datas) {
          let attrData = ``;
          if (data.attr_datas) {
            for (let attr_data of data.attr_datas) {
              attrData += ` data-${attr_data.data}="${attr_data.value}"`;
            }
          }
          html += `<option value="${data.id}" ${attrData}>${data.text}</option>`;
        }
        $(doSelectId).html(html);
      }
    }).fail(function (xhr) {
      toastr.error('Proses gagal, Silahkan refresh halaman ini!');
    }).always();
  }
}

function setSelect(id, url) {
  let val = $(id).val();
  $.ajax({
    type: 'POST',
    url: url,
    dataType: 'JSON',
  }).done(function (response) {
    let html = `<option value="">---</option>`;
    for (let data of response.datas) {
      html += `<option value="${data.id}">${data.text}</option>`;
    }
    $(id).html(html);
    $(id).val(val).change();
    toastr.success('Data berhasil di load !');
  }).fail().always();
}

function doReadonly({ inputIds = null, formId = null, isreadonly = true }) {
  if (formId) {
    $(formId).find('input, select, textarea, button').attr('readonly', isreadonly);
  }
  if (inputIds) {
    for (let inputId of inputIds) {
      $(inputId).attr('readonly', isreadonly);
    }
  }
}

function doDisabled({ inputIds = null, formId = null, isdisabled = true }) {
  if (formId) {
    if (isdisabled) {
      $(formId).find('input, select, textarea, button').addClass('disabled').attr('disabled', isdisabled);
    } else {
      $(formId).find('input, select, textarea, button').removeClass('disabled').attr('disabled', isdisabled);
    }
  }
  if (inputIds) {
    for (let inputId of inputIds) {
      if (isdisabled) {
        $(inputId).addClass('disabled').attr('disabled', isdisabled);
      } else {
        $(inputId).removeClass('disabled').attr('disabled', isdisabled);
      }
    }
  }
}

function doResetForm({ inputIds = null, formId = null }) {
  if (formId) {
    $(formId).serializeArray().forEach(function (input) {
      $(formId).find("[name='" + input.name + "']:not([type=radio]):not([type=checkbox])").val('').change();
      // $(formId).find("input:radio[name="+input.name+"]").attr('checked', false).change();
      // $(formId).find("input:checkbox[name="+input.name+"]").attr('checked', false).change();
    });
    $(':input', formId)
      .prop('checked', false)
      .prop('selected', false);
  }
  if (inputIds) {
    for (let inputId of inputIds) {
      $(inputId).val('').change();
    }
  }
}

/**
 * Modal
 */

const confirmModal = ({
  title = '',
  text = '',
  confirmButtonText = 'Ya',
  cancelButtonText = 'Tutup',
  customClass = {},
}, callback) => {
  customClass.headerClass = customClass.headerClass ?? '';
  customClass.confirmButtonClass = customClass.confirmButtonClass ?? 'btn-success';
  customClass.cancelButtonClass = customClass.cancelButtonClass ?? 'btn-default';

  $('#modal_confirm').remove();

  let htmlConfirmModal = `
  <div class="modal fade" id="modal_confirm" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header ${customClass.headerClass}">
          <h4 class="modal-title">${title}</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <p>${text}</p>
        </div>
        <div class="modal-footer">
          <a href="#!" class="btn ${customClass.cancelButtonClass}" data-dismiss="modal">${cancelButtonText}</a>
          <a href="#!" class="btn btn_confirm ${customClass.confirmButtonClass}">${confirmButtonText}</a>
        </div>
      </div>
    </div>
  </div>`;
  $('body').append(htmlConfirmModal);

  $('#modal_confirm').modal('show');

  $('#modal_confirm .btn_confirm').on('click', function () {
    if (typeof callback === 'function') {
      const result = callback();
      if (result && typeof result.then === 'function') {
        result.then(function () {
          $('#modal_confirm').modal('hide');
        });
      } else {
        $('#modal_confirm').modal('hide');
      }
    } else {
      $('#modal_confirm').modal('hide');
    }
  });
}