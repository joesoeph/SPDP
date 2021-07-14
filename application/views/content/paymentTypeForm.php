<!-- Main content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class='row'>
      <div class='col-xs-12'>
        <div class="pane pane-purple">
          <div class="panel-heading"><b>Tipe Pembayaran</b></div>
          <div class="panel-body">
            <div class='box'>
              <div class='box-header'>
                <!-- <h3 class='box-title'>Type Payment</h3> -->
                  <div class='box box-primary'>
                    <form action="<?php echo $ArrData['action']; ?>" method="post" class="form-horizontal">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="col-md-4">
                            <label> Kode Tipe Pembayaran </label>
                          </div>
                          <div class="col-md-8">
                            <input type="text" class="form-control" name="PaymentTypeCode" id="PaymentTypeCode" placeholder="Kode Tipe Pembayaran" value="<?php echo $ArrData['PaymentTypeCode']; ?>" />
                            <?php echo form_error('PaymentTypeCode') ?>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="col-md-4">
                            <label> Nama Pembayaran </label>
                          </div>
                          <div class="col-md-8">
                            <input type="text" class="form-control" name="PaymentTypeName" id="PaymentTypeName" placeholder="Nama Pembayaran" value="<?php echo $ArrData['PaymentTypeName']; ?>" />
                            <?php echo form_error('PaymentTypeName') ?>
                          </div>
                        </div>
                      </div>
                      <br>
                      <div class="form-action pull-right">
                        <a href="<?php echo site_url('PaymentType') ?>" class="btn btn-one">Batal</a>
                        <?php
                        if($ArrData['button']){
                          echo '<button type="submit" class="btn btn-ok">'.$ArrData['button'].'</button>';
                        }
                        ?>
                      </div>

                  </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
          </div>
          </div>
        </div>
      </div><!-- /.col -->
    </div><!-- /.row -->
  </div>
</div><!-- /.content -->
