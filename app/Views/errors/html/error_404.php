<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <title><?= lang('Errors.pageNotFound') ?></title>

  <style>
    div.logo {
      height: 200px;
      width: 155px;
      display: inline-block;
      opacity: 0.08;
      position: absolute;
      top: 2rem;
      left: 50%;
      margin-left: -73px;
    }

    body {
      height: 100%;
      background: #fafafa;
      font-family: "Helvetica Neue", Helvetica, Arial, sans-serif;
      color: #777;
      font-weight: 300;
    }

    h1 {
      font-weight: lighter;
      letter-spacing: normal;
      font-size: 3rem;
      margin-top: 0;
      margin-bottom: 0;
      color: #222;
    }

    .wrap {
      max-width: 1024px;
      margin: 5rem auto;
      padding: 2rem;
      background: #fff;
      text-align: center;
      border: 1px solid #efefef;
      border-radius: 0.5rem;
      position: relative;
    }

    pre {
      white-space: normal;
      margin-top: 1.5rem;
    }

    code {
      background: #fafafa;
      border: 1px solid #efefef;
      padding: 0.5rem 1rem;
      border-radius: 5px;
      display: block;
    }

    p {
      margin-top: 1.5rem;
    }

    .footer {
      margin-top: 2rem;
      border-top: 1px solid #efefef;
      padding: 1em 2em 0 2em;
      font-size: 85%;
      color: #999;
    }

    a:active,
    a:link,
    a:visited {
      color: #dd4814;
    }
    
    .btn-home {
      display: inline-block;
      padding: 12px 24px;
      margin-top: 2rem;
      background-color: #dd4814;
      color: white;
      text-decoration: none;
      border-radius: 5px;
      font-weight: 400;
      transition: background-color 0.3s ease;
    }

    .btn-home:hover {
      background-color: #c43e0a;
      color: white;
    }

    .btn-home:active,
    .btn-home:link,
    .btn-home:visited {
      color: white;
    }
  </style>
</head>

<body>
  <div class="wrap">
    <h1>404</h1>

    <p>
      <?php if (ENVIRONMENT !== 'production') : ?>
        <?= nl2br(esc($message)) ?>
      <?php else : ?>
        <?= lang('Errors.sorryCannotFind') ?>
      <?php endif; ?>
    </p>

    <a href="<?= base_url() ?>" class="btn-home">
      Kembali ke Beranda
    </a>
  </div>
</body>

</html>