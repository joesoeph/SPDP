<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>TOLO</title>
  </head>
  <link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/style-login.css'); ?>">
  <body>
    <div class="wrapper">
    <form class="form-signin" action="<?= base_url('auth/doLogin'); ?>" method="POST">
      <p class="pocn-icon">TOLO</p>
      <p class="pocn-brand"></p>
      <input type="text" class="form-control" name="username" placeholder="Username" autofocus="" />
      <input type="password" class="form-control" name="password" placeholder="Password"/>

      <button class="btn btn-lg btn-pocn btn-block" type="submit">Login</button>
    </form>
  </div>
  <footer>
    Codegraphs Project from Love Inspiration <br> <b>&copy Last 2017</b>
  </footer>
  </body>
</html>
