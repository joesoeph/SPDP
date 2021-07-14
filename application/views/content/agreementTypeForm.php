<!-- Main content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
  <div class='row'>
    <div class='col-xs-12'>
      <div class="pane pane-purple">
        <div class="panel-heading"><b>Tipe Perjanjian</b></div>
        <div class="panel-body">
          <div class='box box-primary'>
            <form action="<?php echo $ArrData['action']; ?>" method="post" class="form-horizontal">

              <div class="row">
                <div class="col-md-6">
                  <div class="col-md-4">
                    <label> Nama Tipe Perjanjian </label>
                  </div>
                  <div class="col-md-8">
                    <input type="text" class="form-control" name="AgreementTypeName" id="AgreementTypeName" placeholder="Nama Tipe Perjanjian" value="<?php echo $ArrData['AgreementTypeName']; ?>" />
                    <?php echo form_error('AgreementTypeName') ?>
                  </div>
                  </div>

                  <div class="col-md-6">
                    <div class="col-md-4">
                      <label> Pph <?php echo form_error('Pph') ?></label>
                    </div>
                    <div class="col-md-8">
                      <input type="text" class="form-control" name="Pph" id="Pph" placeholder="Pph" value="<?php echo $ArrData['Pph']; ?>" />
                      <input type="hidden" name="AgreementTypeId" value="<?php echo $ArrData['AgreementTypeId']; ?>" />
                    </div>
                  </div>
              </div>
                <div class="form-action pull-right">
                  <a href="<?php echo site_url('agreementtype') ?>" class="btn btn-cl pull-right">Batal</a>
                  <?php
                    if($ArrData['button']){
                      echo '<button type="submit" class="btn btn-ok pull-right">'.$ArrData['button'].'</button>';
                    }
                  ?>
                </div>
              </form>
            </div><!-- /.col -->
        </div>
      </div>
    </div>
  </div><!-- /.row -->
  </div><!-- /.content -->
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
