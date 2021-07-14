<!-- Main content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
  <div class='row'>
    <div class='col-xs-12'>
      <div class="pane pane-purple">
        <div class="panel-heading"><b>Domumen</b></div>
          <div class="panel-body">
            <div class='box box-primary'>
              <form action='<?php echo $ArrData['action']; ?>' method='post' class='form-horizontal'>

                <div class='form-group'>
                  <label class="col-md-2 control-label">Kode Dokumen </label>
                  <div class='col-md-2'>
                    <input type="text" class="form-control" name="DocumentCode" id="DocumentCode" placeholder="Kode Dokumen" value="<?php echo $ArrData['DocumentCode']; ?>" />
                    <?php echo form_error('DocumentCode') ?>
                  </div>
                </div>

                <div class='form-group'>
                  <label class="col-md-2 control-label">Nama Dokumen </label>
                  <div class='col-md-4'>
                    <input type="text" class="form-control" name="DocumentName" id="DocumentName" placeholder="Nama Dokumen" value="<?php echo $ArrData['DocumentName']; ?>" />
                    <?php echo form_error('DocumentName') ?>
                  </div>
                </div>

                <div class='form-group'>
                  <label class="col-md-2 control-label">Deskripsi </label>
                  <div class='col-md-5'>
                    <textarea class="form-control" rows="3" name="Description" id="Description" placeholder="Deskripsi"><?php echo $ArrData['Description']; ?></textarea>
                    <?php echo form_error('DocumentName') ?>
                  </div>
                </div>

                <div class='form-action'>
                    <?php
                    if($ArrData['button']){
                      echo '<button type="submit" class="btn btn-ok pull-right">'.$ArrData['button'].'</button>';
                    }
                    ?>
                  <a href='<?php echo site_url('document') ?>' class='btn btn-one pull-right'>Batal</a>
                </div>
              </form>
            </div>
          </div>
        </div><!-- /.col -->
      </div>
    </div>
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
