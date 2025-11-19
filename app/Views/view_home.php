<?= $this->extend('view_app') ?>

<?= $this->section('title') ?>
<?= env('application.name') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<div class="content-wrapper text-sm">
  <section class="content-header">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Selamat Datang</h5>
              <p class="card-text"><?= env('application.desc') ?></p>
            </div>
          </div>
        </div>
        <?php $i = 0; ?>
        <?php foreach ($menus as $menu) : ?>
          <?php if (!empty($menu->action)) : ?>
            <?php $i++; ?>
            <div class="col-lg-3 col-xs-12">
              <div class="small-box <?= $bgMenu[$i % 10] ?>">
                <div class="inner">
                  <h3><br></h3>
                  <p><?= $menu->name ?></p>
                </div>
                <div class="icon">
                  <i class="<?= $menu->icon ?>"></i>
                </div>
                <a href="<?= base_url() . $menu->action ?>" class="small-box-footer">Buka <i class="fa fa-arrow-circle-right"></i></a>
              </div>
            </div>
          <?php endif; ?>
        <?php endforeach; ?>
      </div>
    </div>
  </section>
</div>
<?= $this->endSection() ?>