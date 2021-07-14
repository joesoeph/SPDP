<!-- Main content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class='row'>
      <div class='col-xs-12'>
        <div class="pane pane-purple">
          <div class="panel-heading"><b>PPH</b></div>
          <div class="panel-body">
            <div class='box'>
              <div class='box-header'>
                <!-- <h3 class='box-title'>Type Payment</h3> -->
                  <div class='box box-primary'>
                    <form action="<?php echo $ArrData['action']; ?>" method="post" class="form-horizontal">
                      <div class="row">
                        <div class="col-md-6">
                          <div class="col-md-4">
                            <label> PPH </label>
                          </div>
                          <div class="col-md-8">
                            <input type="text" class="form-control" name="PphName" id="PphName" placeholder="PPH" value="<?php echo $ArrData['PphName']; ?>" />
                            <?php echo form_error('PphName') ?>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="col-md-4">
                            <label> Persen </label>
                          </div>
                          <div class="col-md-8">
                            <input type="text" class="form-control" name="PphValue" id="PphValue" placeholder="Persen" value="<?php echo $ArrData['PphValue']; ?>" />
                            <?php echo form_error('PphValue') ?>
                          </div>
                        </div>
                      </div>

                      <div class="form-action pull-right">
                        <a href="<?php echo site_url('PPH') ?>" class="btn btn-one">Batal</a>
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
