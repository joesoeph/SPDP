
<!-- Main content -->
<div id='page-content-wrapper'>
  <div class='container-fluid'>
  <div class='row'>
    <div class='col-xs-12'>
      <div class="pane pane-purple">
        <div class="panel-heading"><b>Verifikator</b></div>
          <div class="panel-body">
            <div class='box box-primary'>
              <?php echo $this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>
              <form action='<?=base_url('Setting/updateVerifycator')?>' method='post' class='form-horizontal' id='form-verifycator'>
                <?php 
                $i=0;
                foreach ($DataProyek as $val) {
                  $i++;
                ?>
                <label class="col-md-12">Verifikator <?=$val->ProyekName?></label>
                <input type="hidden" name="ProyekId<?=$i?>" value="<?=$val->ProyekId?>">
                <div class="form-group">
                  <label class="col-md-2 control-label">Verifikator :</label>
                  <div class="col-md-10">
                    <select multiple="multiple" size="10" name="Verifycator<?=$i?>[]" class="selectBox">
                      
                      <?php 
                        foreach ($DataVerifycator[$val->ProyekId] as $data) {
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
                <input type="hidden" id="TotalProyek" name="TotalProyek" value="<?=$i?>">
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
