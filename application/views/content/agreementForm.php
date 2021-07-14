<script type="text/javascript">
  tinymce.init({
    mode : "specific_textareas",
    editor_selector : "Description",
    height: 200,
    plugins: 'table',
    style_formats: [
      { title: 'Bold text', inline: 'strong' },
      { title: 'Red text', inline: 'span', styles: { color: '#ff0000' } },
      { title: 'Red header', block: 'h1', styles: { color: '#ff0000' } },
      { title: 'Badge', inline: 'span', styles: { display: 'inline-block', border: '1px solid #2276d2', 'border-radius': '5px', padding: '2px 5px', margin: '0 2px', color: '#2276d2' } },
      { title: 'Table row 1', selector: 'tr', classes: 'tablerow1' }
    ],
    formats: {
      alignleft: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'left' },
      aligncenter: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'center' },
      alignright: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'right' },
      alignfull: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'full' },
      bold: { inline: 'span', 'classes': 'bold' },
      italic: { inline: 'span', 'classes': 'italic' },
      underline: { inline: 'span', 'classes': 'underline', exact: true },
      strikethrough: { inline: 'del' },
      customformat: { inline: 'span', styles: { color: '#00ff00', fontSize: '20px' }, attributes: { title: 'My custom format' }, classes: 'example1' },
    },
    menubar:false,
    statusbar: false,
    toolbar: false
  });
</script>
<!-- Main content -->
<div id='page-content-wrapper'>
  <div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="#"><i class="glyphicon glyphicon-edit"></i> Perjanjian</a></li>
            <li class="active">SPB, SPJB & SPSA</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
  </div>
  <div class='container-fluid'>
  <div class='row panel'>

    <div class="pane pane-purple">
      <div class="panel-heading">
        <b>Form Perjanjian</b>
      </div>
      <div class='col-xs-12'>
        <div class="panel-body">
          <div class='box box-primary'>
            <?php echo $this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>
            <form action='<?php echo $ArrData['action']; ?>' method='post' class='form-horizontal'>

              <div class="row">
                <div class="col-md-6">
                </div>
                <div class="col-md-6">
                  <div class='form-group'>
                    <label class="col-md-4 control-label">Status Print&nbsp;:</label>
                    <div class='col-md-8'>
                      <select class="selectpicker" name="PrintStatus" id="PrintStatus" title="- Pilih -" data-width="150px">
                        <option value="1" <?=($ArrData['PrintStatus'] == 1) ? "selected" : ""?>>Sudah</option>
                        <option value="0" <?=($ArrData['PrintStatus'] == 0) ? "selected" : ""?>>Belum</option>
                      </select>
                    </div>
                  </div>
                </div>
              </div>
              <div class="row">

                <div class="col-md-6">

                  <div class='form-group'>
                    <label class="col-md-4 control-label">Tipe Perjanjian&nbsp;:</label>
                    <div class='col-md-8'>
                      <select class="selectpicker" name="AgreementTypeId" id="AgreementTypeId" title="- Pilih -" data-width="150px">
                        <?php
                          foreach ($DataAgreementType as $val) {
                            echo '<option value="'.$val->AgreementTypeId.'" data-tokens="'.$val->AgreementTypeName.'" '.$val->selected.'>'.$val->AgreementTypeName.'</option>';
                          }
                         ?>
                      </select>
                      <?php echo form_error('AgreementTypeId') ?>
                    </div>
                  </div>

                  <div class='form-group'>
                    <label class="col-md-4 control-label">Vendor&nbsp;:</label>
                    <div class='col-md-8'>
                      <select class="selectpicker" name="VendorId" id="VendorId" title="- Pilih -" data-show-subtext="true" data-live-search="true" data-width="100%">
                        <?php
                          foreach ($DataVendor as $val) {
                            echo '<option value="'.$val->VendorId.'" data-tokens="'.$val->VendorName.'" '.$val->selected.'>'.$val->VendorName.'</option>';
                          }
                         ?>
                      </select>
                      <?php echo form_error('VendorId') ?>
                    </div>
                  </div>

                  <div class='form-group'>
                    <label class="col-md-4 control-label">Nominal Kontrak&nbsp;:</label>
                    <div class='col-md-6'>
                      <div class="input-group">
                        <div class="input-group-addon">
                            Rp.
                        </div>
                        <input type="text" class="form-control" onKeyPress="tandaPemisahTitik(this);" name="ContractAmount" id="ContractAmount" placeholder="Nominal Kontrak" value="<?php echo $ArrData['ContractAmount']; ?>" readonly/>
                      </div>
                        <?php echo form_error('ContractAmount') ?>
                    </div>
                  </div>

                  <div class='form-group'>
                    <label class="col-md-4 control-label">Tipe Pembayaran&nbsp;:</label>
                    <div class='col-md-8'>
                      <select class="selectpicker" name="PaymentTypeId" id="PaymentTypeId" data-show-subtext="true" title="- Pilih -" data-live-search="true" data-width="150px">
                        <?php
                          foreach ($DataPaymentType as $val) {
                            echo '<option value="'.$val->PaymentTypeId.'" data-tokens="'.$val->PaymentTypeName.'" '.$val->selected.'>'.$val->PaymentTypeName.' ('.$val->PaymentTypeCode.')</option>';
                          }
                         ?>
                      </select>
                      <?php echo form_error('VendorId') ?>
                    </div>
                  </div>

                </div>

                <div class="col-md-6">

                  <div class='form-group'>
                    <label class="col-md-4 control-label">No. Kontrak&nbsp;:</label>
                    <div class='col-md-8'>
                      <input type="text" class="form-control" name="ContractNo" id="ContractNo" placeholder="" value="<?php echo $ArrData['ContractNo']; ?>" />
                      <?php echo form_error('ContractNo') ?>
                    </div>
                  </div>

                  <div class='form-group'>
                    <label class="col-md-4 control-label">Tanggal&nbsp;:</label>
                    <div class='col-md-5'>
                      <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                          <input type="text" class="form-control" name="Date" id="Date" placeholder="Tanggal" value="<?php echo $ArrData['Date']; ?>">
                          <div class="input-group-addon">
                              <span class="glyphicon glyphicon-th"></span>
                          </div>
                      </div>
                      <?php echo form_error('Date') ?>
                    </div>
                  </div>

                  <div class='form-group'>
                    <label class="col-md-4 control-label">Periode Kontrak</label>
                    <div class='col-md-6'>
                      <label class="col-md-4 control-label">Dari&nbsp;:</label>
                      <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                          <input type="text" class="form-control" name="ContractPeriodFrom" id="Dari" placeholder="" value="<?php echo $ArrData['ContractPeriodFrom']; ?>">
                          <div class="input-group-addon">
                              <span class="glyphicon glyphicon-th"></span>
                          </div>
                      </div>
                    </div>
                  </div>

                  <div class='form-group'>
                    <label class="col-md-4 control-label"></label>
                    <div class='col-md-6'>
                      <label class="col-md-4 control-label">Sampai&nbsp;:</label>
                      <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                          <input type="text" class="form-control" name="ContractPeriodTo" id="ContractPeriodTo" placeholder="" value="<?php echo $ArrData['ContractPeriodTo']; ?>">
                          <div class="input-group-addon">
                              <span class="glyphicon glyphicon-th"></span>
                          </div>
                      </div>
                      <?php echo form_error('ContractPeriodFrom') ?>
                      <?php echo form_error('ContractPeriodTo') ?>
                    </div>
                  </div>

                </div>

                <div class="col-md-12">

                  <div class='form-group'>
                    <label class="col-md-2 control-label">Deskripsi Tipe Pembayaran&nbsp;:</label>
                    <div class='col-md-9'>
                      <textarea class="form-control Description" rows="5" name="PaymentMethod" id="PaymentMethod"><?php echo $ArrData['PaymentMethod']; ?></textarea>
                      <?php echo form_error('ScopeOfWork') ?>
                    </div>
                  </div>

                  <div class='form-group'>
                    <label class="col-md-2 control-label">Lingkup Pekerjaan&nbsp;:</label>
                    <div class='col-md-9'>
                      <textarea class="form-control Description" rows="5" name="ScopeOfWork" id="ScopeOfWork"><?php echo $ArrData['ScopeOfWork']; ?></textarea>
                      <?php echo form_error('ScopeOfWork') ?>
                    </div>
                  </div>

                  <div class='form-group'>
                    <label class="col-md-2 control-label">Dasar Pelaksanaan Pekerjaan&nbsp;:</label>
                    <div class='col-md-9'>
                      <textarea class="form-control Description" rows="5" name="BasicOfWorkExecution" id="BasicOfWorkExecution" ><?php echo $ArrData['BasicOfWorkExecution']; ?></textarea>
                      <?php echo form_error('BasicOfWorkExecution') ?>
                    </div>
                  </div>

                  <div class='form-group'>
                    <label class="col-md-2 control-label">Pelaksanaan&nbsp;:</label>
                    <div class='col-md-9'>
                      <textarea class="form-control Description" rows="5" name="ImplementPeriode" id="ImplementPeriode" placeholder="Implement"><?php echo $ArrData['ImplementPeriode']; ?></textarea>
                      <?php echo form_error('ImplementPeriode') ?>
                    </div>
                  </div>

                  <div class='form-group'>
                    <label class="col-md-2 control-label">Contract Amount<br>Description&nbsp;:</label>
                    <div class='col-md-10'>
                      <!-- <div class="col-md-12"> -->
                        <!-- <button type="button" class="delete-row pull-right" name="button"><i class="glyphicon glyphicon-trash"></i></button> -->
                        <button type="button" class="add-row pull-right" name="button"><i class="glyphicon glyphicon-plus"></i></button>
                      <!-- </div> -->
                      <div class="table-responsive">
                        <table class="table" id="ContractAmountDescription">
                          <thead>
                            <tr>
                              <!-- <th>#</th> -->
                              <th>Qty</th>
                              <th>Unit</th>
                              <th>Description</th>
                              <th>Specification</th>
                              <th>Unit Price</th>
                              <th>Amount</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $n = 0;
                              if($DataValueDescription){
                                foreach ($DataValueDescription as $val) {
                                  $n++;
                                  echo "
                                    <tr>
                                      <td width='80'><input onkeyup='sum()' type='text' class='form-control' name='Quantity[".$n."]' id='Quantity".$n."' placeholder='Quantity' value='".$val->Qty."'></td>
                                      <td><input onkeyup='sum()' type='text' class='form-control' name='Unit[".$n."]' id='Unit".$n."' placeholder='Unit' value='".$val->Unit."'></td>
                                      <td><textarea class='form-control' rows='5' name='Description[".$n."]' id='Description".$n."' placeholder='Description'>".$val->Description."</textarea></td>
                                      <td><textarea class='form-control' rows='5' name='Spesification[".$n."]' id='Spesification".$n."' placeholder='Spesification'>".$val->Spesification."</textarea></td>
                                      <td><input onkeyup='sum()' type='text' class='money form-control' name='UnitPrice[".$n."]' id='UnitPrice".$n."' placeholder='Unit Price' value='".$val->UnitPrice."'></td>
                                      <td><input onkeyup='sum()' type='text' class='money form-control' name='Amount[".$n."]' id='Amount".$n."' placeholder='Amount' value='".$val->Amount."'></td>
                                    </tr>
                                  ";
                                }
                              }
                            ?>
                            <!-- Data description amount -->
                          </tbody>
                          <tfoot>
                            <tr>
                              <th colspan="4" class="text-right"> TOTAL </th>
                              <th colspan="3" class="text-right" id="total"></th>
                            </tr>
                            <tr>
                              <th colspan="4" class="text-right"> Dengan PPN </th>
                              <th colspan="3" class="text-right">
                                <input type="checkbox" name="WithPpn" id="WithPpn" onchange='sum()' <?=$ArrData['WithPpn'] ? "checked" : ""?>>
                              </th>
                            </tr>
                            <tr>
                              <th colspan="4" class="text-right"> PPN 10 % </th>
                              <th colspan="3" class="text-right" id="ppn"></th>
                            </tr>
                            <tr>
                              <th colspan="4" class="text-right"> Total Keseluruhan </th>
                              <th colspan="3" class="text-right" id="totalAll"></th>
                            </tr>
                          </tfoot>
                        </table>
                        <input type="hidden" id="row" name="row" value="<?=$n?>">
                      </div>
                      <?php echo form_error('ContractAmountDescription') ?>
                    </div>
                  </div>

                  <div class='form-group'>
                    <label class="col-md-2 control-label">Asuransi & Jaminan Pelaksanaan&nbsp;:</label>
                    <div class='col-md-9'>
                      <textarea class="form-control Description" rows="5" name="ImplementInsurrance" id="ImplementInsurrance"><?php echo $ArrData['ImplementInsurrance']; ?></textarea>
                      <?php echo form_error('ImplementInsurrance') ?>
                    </div>
                  </div>

                  <div class='form-group'>
                    <label class="col-md-2 control-label">Lain-Lain&nbsp;:</label>
                    <div class='col-md-9'>
                      <textarea class="form-control Description" rows="5" name="Miscellanous" id="Miscellanous"><?php echo $ArrData['Miscellanous']; ?></textarea>
                      <?php echo form_error('Miscellanous') ?>
                    </div>
                  </div>

                </div>

                <div class="col-md-6">
                  <div class='form-group'>
                    <label class="col-md-4 control-label">Yang Menerima Order&nbsp;:</label>
                    <div class='col-md-8'>
                      <input type="text" class="form-control" name="ReceivedAgreement" id="ReceivedAgreement" placeholder="" value="<?php echo $ArrData['ReceivedAgreement']; ?>" />
                      <?php echo form_error('ReceivedAgreement') ?>
                    </div>
                  </div>

                  <div class='form-group'>
                    <label class="col-md-4 control-label">Yang Memberi Order 1&nbsp;:</label>
                    <div class='col-md-8'>
                      <input type="text" class="form-control" name="Sender1Name" id="Sender1Name" placeholder="" value="<?php echo $ArrData['Sender1Name']; ?>" />
                      <?php echo form_error('Sender1Name') ?>
                    </div>
                  </div>

                  <div class='form-group'>
                    <label class="col-md-4 control-label">Yang Memberi Order 2&nbsp;:</label>
                    <div class='col-md-8'>
                      <input type="text" class="form-control" name="Sender2Name" id="Sender2Name" placeholder="" value="<?php echo $ArrData['Sender2Name']; ?>" />
                      <?php echo form_error('Sender2Name') ?>
                    </div>
                  </div>

                </div>

                <div class="col-md-6">

                  <div class='form-group'>
                    <label class="col-md-4 control-label">Jabatan Penerima&nbsp;:</label>
                    <div class='col-md-8'>
                      <input type="text" class="form-control" name="ReceivedAgreementTitle" id="ReceivedAgreementTitle" placeholder="" value="<?php echo $ArrData['ReceivedAgreementTitle']; ?>" />
                      <?php echo form_error('ReceivedAgreementTitle') ?>
                    </div>
                  </div>

                  <div class='form-group'>
                    <label class="col-md-4 control-label">Jabatan Pemberi Order 1&nbsp;:</label>
                    <div class='col-md-8'>
                      <input type="text" class="form-control" name="Sender1Title" id="Sender1Title" placeholder="" value="<?php echo $ArrData['Sender1Title']; ?>" />
                      <?php echo form_error('Sender1Title') ?>
                    </div>
                  </div>

                  <div class='form-group'>
                    <label class="col-md-4 control-label">Jabatan Pemberi Order 2&nbsp;:</label>
                    <div class='col-md-8'>
                      <input type="text" class="form-control" name="Sender2Title" id="Sender2Title" placeholder="" value="<?php echo $ArrData['Sender2Title']; ?>" />
                      <?php echo form_error('Sender2Title') ?>
                    </div>
                  </div>

                </div>
              </div>

              <div class='form-action'>
                  <?php
                  if($ArrData['button']){
                    echo '<button type="submit" class="btn btn-ok pull-right">'.$ArrData['button'].'</button>';
                  }

                  if($ArrData['AgreementId']){
                    echo '<a href="#" id="print" class="btn btn-cl pull-right" onclick="javascript:modalPrint(\''.$ArrData['AgreementId'].'\');">
                          <i class="glyphicon glyphicon-print"></i> Print
                        </a>';
                  }
                  ?>
                  <a href='<?php echo site_url('agreement') ?>' class='btn btn-one pull-right'>Kembali</a>
              </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div><!-- /.col -->
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

<!-- Modal -->
<div id="modal-print" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content modal-dialog modal-lg">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Print SPB SPJB</h4>
      </div>
      <div class="modal-body">
        <div class="portlet-body form">
            <!-- BEGIN FORM-->
            <embed id="frame-pdf" src="" width="100%" height="600"></embed>
            <!-- END FORM-->
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
    </div>

  </div>
</div>

<script type="text/javascript">
    $('.datepicker').datepicker({
      autoclose: true,
      todayBtn: true,
      startDate: "2010-02-14"
    });

    sum();

    $(".add-row").click(function(){
      var row = $('#row').val();
      row++;
      $('#row').val(row);
        var markup = "<tr>";
        // markup+="<td><input type='checkbox' name='record'></td>";
        markup+="<td width='80' ><input onkeyup=\"sum()\" type='text' class='form-control' name='Quantity["+row+"]' id='Quantity"+row+"' placeholder='Quantity' value=''></td>";
        markup+="<td><input onkeyup=\"sum()\" type='text' class='form-control' name='Unit["+row+"]' id='Unit"+row+"' placeholder='Unit' value=''></td>";
        markup+="<td><textarea class='form-control' rows='5' name='Description["+row+"]' id='Description["+row+"]' placeholder='Description'></textarea></td>";
        markup+="<td><textarea class='form-control' rows='5' name='Spesification["+row+"]' id='Spesification["+row+"]' placeholder='Spesification'></textarea></td>";
        markup+="<td><input onkeyup=\"sum()\" type='text' class='money form-control' name='UnitPrice["+row+"]' id='UnitPrice"+row+"' placeholder='Unit Price' value=''></td>";
        markup+="<td><input onkeyup=\"sum()\" type='text' class='money form-control' name='Amount["+row+"]' id='Amount"+row+"' placeholder='Amount' value=''></td>";
        markup+="</tr>";
        $("#ContractAmountDescription").append(markup);
    });

    // Find and remove selected table rows
    $(".delete-row").click(function(){

        $("#ContractAmountDescription tbody").find('input[name="record"]').each(function(){
          if($(this).is(":checked")){
                $(this).parents("tr").remove();
                var row = $('#row').val();
                row--;
                $('#row').val(row);
          }
        });

    });

    // Amount = Quantity*UnitPrice
    // Total  = sum(Amount)
    // PPN    = Total*0.1
    // totalAll = Total+PPN

    function sum(){
        var WithPpn = $('#WithPpn');
        var row   = $('#row').val();
        var Total = 0;
        var Amount= 0;

        for(var i=1; i<=row; i++){
            if($('#Quantity'+i).val() || $('#UnitPrice'+i).val()){
                a = parseInt($('#Quantity'+i).val());
                b = parseInt(parseCurrency($('#UnitPrice'+i).val()));
                Amount = (a * b);
                $('#Amount'+i).val(Amount);
                Total+=parseInt(parseCurrency($('#Amount'+i).val()));
            }
        }

        var Ppn = (WithPpn.is(":checked")) ? (Total * 0.1) : 0;
        var TotalAll = (Total + Ppn);
        $('#total').html(formatMoney(Total, '', 'Rp.'));
        $('#ppn').html(formatMoney(Ppn, '', 'Rp.'));
        $('#totalAll').html(formatMoney(TotalAll, '', 'Rp.'));
        $('#ContractAmount').val(TotalAll);
    }

    $(document).ready(function(){
      $('#ContractAmount, .money').inputmask('decimal',
      { 'alias': 'numeric',
        'groupSeparator': ',',
        'autoGroup': true,
        'digits': 0,
        'radixPoint': ".",
        'digitsOptional': false,
        'allowMinus': false,
        'placeholder': '0'
      });
    });

    function modalPrint(id){
      if(!id) return false;
      $('#modal-print').modal('show');
      $('#modal-print #frame-pdf').attr("src", "<?=base_url('agreement/report/')?>"+id);
    }

    function formatMoney(number, places, symbol, thousand, decimal) {
      number = number || 0;
      places = !isNaN(places = Math.abs(places)) ? places : 2;
      symbol = symbol !== undefined ? symbol : "";
      thousand = thousand || ",";
      decimal = decimal || ".";
      var negative = number < 0 ? "-" : "",
          i = parseInt(number = Math.abs(+number || 0).toFixed(places), 10) + "",
          j = (j = i.length) > 3 ? j % 3 : 0;
      return symbol + negative + (j ? i.substr(0, j) + thousand : "") + i.substr(j).replace(/(\d{3})(?=\d)/g, "$1" + thousand) + (places ? decimal + Math.abs(number - i).toFixed(places).slice(2) : "");
    }

    function parseCurrency( num ) {
        return parseFloat( num.replace( /,/g, '') );
    }

</script>
