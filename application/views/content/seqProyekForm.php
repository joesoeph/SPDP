<link rel="stylesheet" href="<?= base_url('assets/vendor/bootstrap-select/css/bootstrap-select.min.css'); ?>">
<!-- Main content -->
<div id='page-content-wrapper'>
  <div class='container-fluid'>
  <div class='row'>
    <div class='col-xs-12'>
      <div class='box box-primary'>
        <div class="pane pane-purple">
          <div class="panel-heading"><b>Add New Seq Project</b></div>
            <div class="panel-body">
              <form action='<?php echo $ArrData['action']; ?>' method='post' class='form-horizontal'>

                <div class='form-group'>
                  <div class='col-md-3'>
                    <label>Proyek <?php echo form_error('ProyekId') ?></label>
                  </div>
                  <div class='col-md-4'>
                    <select class="selectpicker" data-live-search="true">
                      <option data-tokens="ketchup mustard">Hot Dog, Fries and a Soda</option>
                      <option data-tokens="mustard">Burger, Shake and a Smile</option>
                      <option data-tokens="frosting">Sugar, Spice and all things nice</option>
                    </select>
                  </div>
                </div>

                <div class='form-group'>
                  <div class='col-md-3'>
                    <label>Vendor <?php echo form_error('VendorId') ?></label>
                  </div>
                  <div class='col-md-4'>
                    <input type="text" class="form-control" name="VendorId" id="VendorId" placeholder="Vendor" value="<?php echo $ArrData['VendorId']; ?>" />
                  </div>
                </div>
                <div class='form-action'>
            <?php
            if($ArrData['button']){
              echo '<button type="submit" class="btn btn-ok pull-right">'.$ArrData['button'].'</button>';
            }
            ?>
                      <a href='<?php echo site_url('seqproyek') ?>' class='btn btn-cl pull-right'>Cancel</a>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div><!-- /.col -->
  </div>
</div>
