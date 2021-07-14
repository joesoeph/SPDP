<!-- Main content -->
<div id='page-content-wrapper'>
  <div class='container-fluid'>
  <div class='row'>
    <div class='col-xs-12'>
      <div class="pane pane-purple">
        <div class="panel-heading"><b>Verifikator Perjanjian</b></div>
          <div class="panel-body">
            <div class='box box-primary'>
              <?php echo $this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>
              <form action='<?=base_url('Setting/updateVerifycatorAgreement')?>' method='post' class='form-horizontal' id='form-verifycator'>
                <?php 
                $i=0;
                foreach ($DataAgreement as $val) {
                  $i++;
                ?>
                <label class="col-md-12">Verifikator <?=$val?></label>
                <input type="hidden" name="Agreement<?=$i?>" value="<?=$val?>">
                <div class="form-group">
                  <label class="col-md-2 control-label">Verifikator :</label>
                  <div class="col-md-10">
                    <select size="10" name="Verifycator<?=$i?>[]" class="selectBox">
                      
                      <?php 
                        foreach ($DataVerifycator[$val] as $data) {
                          echo '<option value="'.$data->JabatanId.'" '.$data->selected.'>'.$data->JabatanName.' ('.$data->JabatanCode.')</option>';
                        }
                      ?>

                    </select>
                    <input type="hidden" id="Verify<?=$i?>" name="Verify<?=$i?>" value="">
                    <script>
                      var selectBox = $('.selectBox').bootstrapDualListbox({
                        nonSelectedListLabel: 'Jabatan',
                        selectedListLabel: 'Jabatan Verifikator',
                        preserveSelectionOnMove: 'moved',
                        moveOnSelect: false
                      });

                      $(document).ready(function(){
                        $('#create').click(function(){
                          $('#Verify<?=$i?>').val($('[name="Verifycator<?=$i?>[]"]').val());
                          // $('#form-verifycator').submit();
                        });
                      });
                    </script>
                    </div>
                  </div>
                <?php 
                }
                ?>
                <input type="hidden" id="TotalAgreement" name="TotalAgreement" value="<?=$i?>">
                <div class='form-action'>
                  <button type="submit" class="btn btn-ok pull-right" id="create">Simpan</button>
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
    <br>
  </div>
</div>