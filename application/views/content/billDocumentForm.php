
<!-- Main content -->
<div id='page-content-wrapper'>
  <div class='container-fluid'>
  <div class='row'>
    <div class='col-xs-12'>
      <div class="pane pane-purple">
        <div class="panel-heading"><b>Dokumen Tagihan</b></div>
          <div class="panel-body">
            <div class='box box-primary'>
              <?php echo $this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>
              <form action='<?=base_url('Setting/updateBillDocument')?>' method='post' class='form-horizontal' id='form-document'>

              <?php
                $id = "";
                foreach ($DataBillType as $val) {
                  $id.= ($id) ? ",".$val->BillTypeId : $val->BillTypeId;
                  echo '
                  <div class="form-group">
                    <label class="col-md-2 control-label">'.$val->BillTypeName.' ('.$val->BillTypeCode.') :</label>
                    <div class="col-md-10">
                      <select multiple="multiple" size="10" name="BillDocument'.$val->BillTypeId.'[]" class="selectBox">';

                      foreach ($DataBillDocument[$val->BillTypeId] as $data) {
                        echo '<option value="'.$data->DocumentId.'" '.$data->selected.'>'.$data->DocumentName.'</option>';
                      }

                      echo
                      '</select>
                        <input type="hidden" id="BillType'.$val->BillTypeId.'" name="BillType'.$val->BillTypeId.'">';
              ?>
                        <script>
                          var selectBox = $('.selectBox').bootstrapDualListbox({
                            nonSelectedListLabel: 'Dokumen',
                            selectedListLabel: 'Dokumen <?=$val->BillTypeName?>',
                            preserveSelectionOnMove: 'moved',
                            moveOnSelect: false
                          });
                        </script>
              <?php
                echo'
                      </div>
                    </div>';

                  }
              ?>
                <input type="hidden" name="bilExist" value="<?=$id?>">
                <div class='form-action'>
                  <button type="button" class="btn btn-pocn pull-right" id="create">Simpan</button>
                </div>

              </form>
            </div>
          </div>
        </div><!-- /.col -->
      </div>
    </div>
    <br>
  </div>
</div>

<script type="text/javascript">
  $(document).ready(function(){
    $('#create').click(function(){
      for(i=1; i<20; i++){
        $('#BillType'+i).val($('[name="BillDocument'+i+'[]"]').val());
      }
      $('#form-document').submit();
    });
  });
</script>
