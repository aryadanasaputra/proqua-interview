  <footer class="main-footer copyright">
    <div style="display:none;">copyright arya.dana.saputra01@gmail.com</div>
    <div class="float-right d-none d-sm-block">
      <b>Version</b> <?= env('application.version') ?>
    </div>
    <strong>Made With <i class="fa fa-heart text-danger"></i> By <a href="#!">arya.dana.saputra01@gmail.com</a>.</strong>
  </footer>
</div>

<?php if (session()->get('id')) : ?>
  <!-- modal_user_profile -->
  <div class="modal fade" id="modal_user_profile" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ubah Akun</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body p-0">
          <form id="form_user_profile">
            <div class="card-body">
              <div class="form-group">
                <label for="profile_name">Nama <span class="text-danger">*</span></label>
                <input type="text" autocomplete="off" class="form-control" id="profile_name" name="name" placeholder="Nama" value="">
              </div>
              <div class="form-group">
                <label for="profile_username">Username <span class="text-danger">*</span></label>
                <input type="text" autocomplete="off" class="form-control no-spacing" id="profile_username" name="username" placeholder="Username" value="">
              </div>
              <div class="form-group">
                <label for="profile_email">Email</label>
                <input type="email" autocomplete="off" class="form-control no-spacing" id="profile_email" name="email" placeholder="Email" value="">
              </div>
              <div id="div_user_profile_password">
              </div>
              <template id="template_user_profile_password">
                <div class="form-group">
                  <label for="profile_old_password">Kata Sandi Lama <span class="text-danger">*</span></label>
                  <div class="input-group input-password">
                    <input type="password" class="form-control" id="profile_old_password" name="old_password" placeholder="Kata Sandi Lama" autocomplete="new-password">
                    <div class="input-group-append">
                      <div class="input-group-text show-password">
                        <span class="fa fa-eye-slash"></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="profile_password">Kata Sandi Baru <span class="text-danger">*</span></label>
                  <div class="input-group input-password">
                    <input type="password" class="form-control" id="profile_password" name="password" placeholder="Kata Sandi Baru" autocomplete="new-password">
                    <div class="input-group-append">
                      <div class="input-group-text show-password">
                        <span class="fa fa-eye-slash"></span>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="profile_re_password">Ulangi Kata Sandi Baru <span class="text-danger">*</span></label>
                  <div class="input-group input-password">
                    <input type="password" class="form-control" id="profile_re_password" name="re_password" placeholder="Ulangi Kata Sandi Baru" autocomplete="new-password">
                    <div class="input-group-append">
                      <div class="input-group-text show-password">
                        <span class="fa fa-eye-slash"></span>
                      </div>
                    </div>
                  </div>
                </div>
              </template>
              <a href="#!" class="btn_change_password" onclick="_UserProfile.changePassword()"><span class="fa fa-lock"></span> Ubah Kata Sandi</a>
              <i class="help-block">Field (*) harus diisi</i>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <a href="#!" class="btn btn-default" data-dismiss="modal">Tutup</a>
          <a href="#!" class="btn btn-primary" onclick=_UserProfile.save()>Simpan</a>
        </div>
      </div>
    </div>
  </div>

  <!-- modal_user_profile_group -->
  <div class="modal fade" id="modal_user_profile_group" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h4 class="modal-title">Ganti Hak Akses</h4>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
        <div class="modal-body p-0">
          <div id="div_user_profile_group">
          </div>
        </div>
        <div class="modal-footer">
          <a href="#!" class="btn btn-default" data-dismiss="modal">Tutup</a>
        </div>
      </div>
    </div>
  </div>
<?php endif; ?>
</body>

</html>