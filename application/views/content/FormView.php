<!-- Main content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class='row'>
      <div class='col-xs-12'>
        <div class="pane pane-purple">
          <div class="panel-heading"><b>Verifikasi Invoice</b></div>
          <div class="panel-body">
            <div class='box'>
              <div class='box-header'>
                <!-- <h3 class='box-title'>Type Payment</h3> -->
                  <div class='box box-primary'>
                    <form action="<?php echo $ArrData['action']; ?>" method="post" class="form-horizontal">
                        <div class="form-group">
                          <label for="inputEmail3" class="col-sm-2 control-label">Tipe Proyek</label>
                          <div class="col-sm-5">
                            <select class="form-control" id="tipe_proyek" name="tipe_proyek">
                              <option value="">- Pilih Tipe Proyek -</option>
                              <option value="SUPPLIER">SUPPLIER</option>
                              <option value="SUBKONTRAKTOR">SUBKONTRAKTOR</option>
                              <option value="UPAH">UPAH</option>
                              <option value="ALAT">ALAT</option>
                              <option value="BTL">BTL</option>
                            </select>
                          </div>
                        </div>
                        <div class="form-action pull-right">
                          <a href="<?php echo site_url('VerifikasiInvoice') ?>" class="btn btn-one">Batal</a>
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
