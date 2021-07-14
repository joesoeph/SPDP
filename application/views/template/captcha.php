<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bantaeng</title>
  </head>
  <link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/style-login.css'); ?>">
  <script src="<?=base_url('assets/js/jquery-2.1.4.min.js')?>"></script>
  <body>
    <div class="wrapper">
    <form class="form-monitor" action="<?=base_url('Monitor')?>" name="form-monitor" method="post">
      <p class="pocn-icon">Bantaeng</p>
      <div class="form-group">
        <div class="row col-md-12">
          <div class="col-md-12">
            <p><?=$image;?></p>
          </div>
        </div>
        <div class="row col-md-12">
          <div class="col-md-8">
            <input type="text" class="form-control" name="secutity_code" placeholder="Masukan text" title="" />
          </div>
          <div class="col-md-4">
            <button class="btn btn-default pull-left" type="submit">
              &nbsp;&nbsp;Submit&nbsp;&nbsp;
            </button>
          </div>
        </div>
      </div>
    </form>
  </div>
  </body>
</html>