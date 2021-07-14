<!-- Main content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
  <div class='row'>
    <div class='col-xs-12'>
      <div class="pane pane-purple">
        <div class="panel-heading"><b>Vendor</b></div>
        <div class="panel-body">
          <div class='box box-primary'>
            <?=$this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>  
            <form action="<?php echo $ArrData['action']; ?>" method="post" class="form-horizontal">
                
              <div class="form-group">
                <div class="col-md-3">
                  <label> Kode Vendor </label>
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control" name="VendorCode" id="VendorCode" placeholder="Kode Vendor" value="<?php echo $ArrData['VendorCode']; ?>" />
                  <?php echo form_error('VendorCode') ?>
                </div>
              </div>        

              <div class="form-group">
                <div class="col-md-3">
                  <label> Nama Vendor </label>
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control" name="VendorName" id="VendorName" placeholder="Nama Vendor" value="<?php echo $ArrData['VendorName']; ?>" />
                  <?php echo form_error('VendorName') ?>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-3">
                  <label> Alamat </label>
                </div>
                <div class="col-md-6">
                  <textarea class="form-control" rows="3" cols="100" name="Address1" id="Address1" placeholder="Alamat"><?php echo $ArrData['Address1']; ?></textarea>
                  <?php echo form_error('Address1') ?>
                </div>
              </div>

              <div class="form-group">
                <div class="col-md-3">
                  <label> Telphone <?php echo form_error('Telp') ?></label>
                </div>
                <div class="col-md-4">
                  <input type="text" class="form-control" name="Telp" id="Telp" placeholder="Telphone" value="<?php echo $ArrData['Telp']; ?>" />
                </div>
              </div>

              <div class="form-action pull-right">
                <a href="<?php echo site_url('vendor') ?>" class="btn btn-one">Batal</a>
                <?php
                if($ArrData['button']){
                  echo '<button type="submit" class="btn btn-ok">'.$ArrData['button'].'</button>';
                }
                ?>
              </div>

              </form>
            </div>
        </div>
      </div>
    </div>
  </div><!-- /.row -->
    <br>
    <div class="row" <?php if ($this->uri->segment(2) == "create" || $this->uri->segment(2) == "create_action"): echo 'style="display:none;"'; endif;?>>
      <div class="col-md-12">
          <div class="pane pane-default" style="background-color: #efd7de">
            <div class="panel-heading"><b>Activity</b></div>
            <div class="panel-body">
              <table>
                <tr style="border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000;">
                  <td align="right" width="200" style="padding: 10px;">Created&nbsp;</td>
                  <td align="left" width="200" style="border-right: 1px solid #000; color: #af0c0c">: <?=$this->getdetailusers->GetById($ArrData['CreatedByUserId'], 'name')?></td>
                  <td align="right" width="200">Last Change&nbsp;</td>
                  <td align="left" width="200" style="border-right: 1px solid #000; color: #af0c0c">: <?=$this->getdetailusers->GetById($ArrData['LastChangedByUserId'], 'name')?></td>
                  <td align="right" width="200">Deleted&nbsp;</td>
                  <td align="left" width="200">: <?=$this->getdetailusers->GetById($ArrData['DeletedUserId'], 'name')?></td>
                </tr>
                <tr style="border-bottom: 1px solid #000; border-right: 1px solid #000; border-left: 1px solid #000;">
                  <td align="right" style="padding: 10px;">Created Date&nbsp;</td>
                  <td align="left" style="border-right: 1px solid #000; color: #af0c0c">: <?=$ArrData['CreatedDate']?></td>
                  <td align="right">Last Change Date&nbsp;</td>
                  <td align="left" style="border-right: 1px solid #000; color: #af0c0c">: <?=$ArrData['LastChangedDate']?></td>
                  <td align="right">Deleted Date&nbsp;</td>
                  <td align="left">: <?=$ArrData['DeletedDate']?></td>
                </tr>

              </table>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
