
<!-- Main content -->
<div id='page-content-wrapper'>
  <div class='container-fluid'>
  <div class='row'>
    <div class='col-xs-12'>
      <div class="pane pane-purple">
        <div class="panel-heading"><b>Informasi Proyek</b></div>
          <div class="panel-body">
            <div class='box box-primary'>
              <form action='<?php echo $ArrData['action']; ?>' method='post' class='form-horizontal'>

                <div class='form-group'>
                  <label class="col-md-2 control-label">Kode Proyek : </label>
                  <div class='col-md-4'>
                    <input type="text" class="form-control" name="ProyekCode" id="ProyekCode" placeholder="Kode Proyek" value="<?php echo $ArrData['ProyekCode']; ?>" />
                    <?php echo form_error('ProyekCode') ?>
                  </div>
                </div>

                <div class='form-group'>
                  <label class="col-md-2 control-label">Name Proyek : </label>

                  <div class='col-md-4'>
                    <input type="text" class="form-control" name="ProyekName" id="ProyekName" placeholder="Nama Proyek" value="<?php echo $ArrData['ProyekName']; ?>" />
                    <?php echo form_error('ProyekName') ?>
                  </div>
                </div>

                <div class='form-group'>
                  <label class="col-md-2 control-label">Deskripsi : </label>

                  <div class='col-md-7'>
                    <textarea class="form-control" rows="5" cols="100" name="ProyekDescription" id="ProyekDescription" placeholder="Deskripsi"><?php echo $ArrData['ProyekDescription']; ?></textarea>
                    <?php echo form_error('ProyekDescription') ?>
                  </div>
                </div>

                      <div class="form-group">
                        <label class="col-md-2 control-label">Pilih Vendor :</label>
                        <div class="col-md-10">
                          <select multiple="multiple" size="10" name="SeqProyek[]" class="selectBox">
                            <?php
                            foreach ($DataVendor as $val) {
                              $selected = $val->selected;
                              echo '<option value="'.$val->VendorId.'" '.$selected.'>'.$val->VendorName.'</option>';
                            }
                            ?>
                          </select>
                          <input type="hidden" id="ProyekSeqId" name="ProyekSeqId" value="">

                          <script>
                            var selectBox = $('.selectBox').bootstrapDualListbox({
                              nonSelectedListLabel: 'List Vendor',
                              selectedListLabel: 'Vendor Penerima Proyek',
                              preserveSelectionOnMove: 'moved',
                              moveOnSelect: false
                            });

                            $(document).ready(function(){
                              $('#create').click(function(){
                                $('#ProyekSeqId').val($('[name="SeqProyek[]"]').val());
                                $('#form-proyek').submit();
                              });
                            });
                          </script>
                        </div>
                      </div>


                      <div class='form-action'>
                        <a href='<?php echo site_url('proyek') ?>' class='btn btn-cl pull-right'>Batal</a>
                        <?php
                        if($ArrData['button']){
                          echo '<button type="submit" class="btn btn-ok pull-right" id="create">'.$ArrData['button'].'</button>';
                        }
                        ?>
                      </div>
                    </div>
                  </div>
                </form>
              </div><!-- /.col -->
          </div>
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
