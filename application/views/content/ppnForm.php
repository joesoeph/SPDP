<!-- Main content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class='row'>
      <div class='col-xs-12'>
        <div class="pane pane-purple">
          <div class="panel-heading"><b>PPN</b></div>
          <div class="panel-body">
            <div class='box'>
              <div class='box-header'>
                <!-- <h3 class='box-title'>Type Payment</h3> -->
                  <div class='box box-primary'>
                    <form action="<?php echo $ArrData['action']; ?>" method="post" class="form-horizontal">
                      <div class="col-md-6">
                        <div class="col-md-4">
                          <label> PPN </label>
                        </div>
                        <div class="col-md-8">
                          <input type="text" class="form-control" name="PpnName" id="PpnName" placeholder="PPn" value="<?php echo $ArrData['PpnName']; ?>" />
                          <?php echo form_error('PpnName') ?>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="col-md-4">
                          <label> Persen </label>
                        </div>
                        <div class="col-md-8">
                          <input type="text" class="form-control" name="PpnValue" id="PpnValue" placeholder="Persen" value="<?php echo $ArrData['PpnValue']; ?>" />
                          <?php echo form_error('PpnValue') ?>
                        </div>
                      </div>
                      <br>
                      <div class="form-action pull-right">
                        <a href="<?php echo site_url('PPN') ?>" class="btn btn-one">Batal</a>
                        <?php
                        if($ArrData['button']){
                          echo '<button type="submit" class="btn btn-ok">'.$ArrData['button'].'</button>';
                        }
                        ?>
                      </div>

                  </form>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
          </div><!-- /.col -->
          </div>
        </div>
      </div>
    </div><!-- /.row -->
  </div>
</div><!-- /.content -->
