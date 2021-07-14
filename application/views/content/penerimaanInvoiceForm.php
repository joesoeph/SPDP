<!-- Main content -->
<div id='page-content-wrapper'>
  <div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="#"><i class="glyphicon glyphicon-thumbs-up"></i> Tagihan & Verifikasi</a></li>
            <li class="active">Invoice Masuk</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
  </div>
  <div class='container-fluid'>
  <div class='row'>
    <div class="pane pane-purple">
      <div class="panel-heading"><b>Form Penerimaan Invoice</b></div>
      <div class="panel-body">
        <div class='col-xs-12'>
          <div class='box box-primary'>
            <?=$this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>
              <form action='<?php echo $ArrData['action']; ?>' method='post' class='form-horizontal'>

                  <div class="col-md-6">
                    <div class='form-group'>
                      <label class="col-md-4 control-label">Proyek&nbsp;:</label>
                      <div class='col-md-8'>
                        <select class="selectpicker" name="ProyekId" id="ProyekId" data-show-subtext="true" data-width="100%">
                          <?php
                            foreach ($DataProyek as $val) {
                              echo '<option value="'.$val->ProyekId.'" data-tokens="'.$val->ProyekName.'" '.$val->selected.'>'.$val->ProyekCode.' - '.$val->ProyekName.'</option>';
                            }
                           ?>
                        </select>
                        <?php echo form_error('ProyekId') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Vendor&nbsp;:</label>
                      <div class='col-md-8'>
                        <select class="selectpicker" name="VendorId" id="VendorId" title="- Pilih -" data-live-search="true" data-width="100%">
                          <?php
                            foreach ($DataVendor as $val) {
                              echo '<option value="'.$val->VendorId.'" data-tokens="'.$val->VendorName.'" >'.$val->VendorCode.' - '.$val->VendorName.'</option>';
                            }
                           ?>
                        </select>
                        <?php echo form_error('VendorId') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">No. Invoice&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="InvoiceNo" id="InvoiceNo" placeholder="" value="<?php echo $ArrData['InvoiceNo']; ?>" />
                        <?php echo form_error('InvoiceNo') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Tgl. Invoice&nbsp;:</label>
                      <div class='col-md-5'>
                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                            <input type="text" class="form-control" name="InvoiceDate" id="InvoiceDate" placeholder="" value="<?php echo $ArrData['InvoiceDate']; ?>">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                        <?php echo form_error('InvoiceDate') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">No. Faktur&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="FakturNo" id="FakturNo" placeholder="" value="<?php echo $ArrData['FakturNo']; ?>" />
                        <?php echo form_error('FakturNo') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">NPWP&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="NpwpNo" id="NpwpNo" placeholder="" value="<?php echo $ArrData['NpwpNo']; ?>" />
                        <?php echo form_error('NpwpNo') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Tipe Pembayaran&nbsp;:</label>
                      <div class='col-md-8'>
                        <select class="selectpicker" name="PaymentTypeId" id="PaymentTypeId" data-show-subtext="true" title="- Pilih -" data-live-search="true" data-width="200px">
                          <?php
                            foreach ($DataPaymentType as $val) {
                              echo '<option value="'.$val->PaymentTypeId.'" data-tokens="'.$val->PaymentTypeName.'" '.$val->selected.'>'.$val->PaymentTypeName.' ('.$val->PaymentTypeCode.')</option>';
                            }
                           ?>
                        </select>
                        <?php echo form_error('VendorId') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">No. Rekening&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="AccountNumber" id="AccountNumber" placeholder="" value="<?php echo $ArrData['AccountNumber']; ?>" />
                        <?php echo form_error('AccountNumber') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Atas Nama&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="AccountByName" id="AccountByName" placeholder="" value="<?php echo $ArrData['AccountByName']; ?>" />
                        <?php echo form_error('AccountByName') ?>
                      </div>
                    </div>

                  </div>

                  <div class="col-md-6">

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Tipe Berkas&nbsp;:</label>
                      <div class='col-md-6'>
                        <select class="selectpicker" name="BillTypeId" id="BillTypeId" title="- Pilih -" data-width="100%">
                          <?php
                            foreach ($DataBillType as $val) {
                              echo '<option value="'.$val->BillTypeId.'" data-tokens="'.$val->BillTypeName.'" '.$val->selected.'>'.$val->BillTypeCode.' - '.$val->BillTypeName.'</option>';
                            }
                           ?>
                        </select>
                        <?php echo form_error('BillTypeId') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">No Bukti&nbsp;:</label>
                      <div class='col-md-3'>
                          <input type="text" class="form-control text-center" name="BuktiNo" id="BuktiNo" placeholder="" value="<?php echo $ArrData['BuktiNo']; ?>" readonly/>
                        <?php echo form_error('BuktiNo') ?>
                      </div>
                    </div>
                    
                    <div class='form-group'>
                      <label class="col-md-4 control-label">No Kontrak&nbsp;:</label>
                      <div class='col-md-7'>
                          <input type="text" class="form-control text-left" name="KontrakNo" id="KontrakNo" placeholder="" value="<?php echo $ArrData['KontrakNo']; ?>"/>
                        <?php echo form_error('KontrakNo') ?>
                      </div>
                    </div>
                    
                    <div class='form-group'>
                      <label class="col-md-4 control-label">Tgl. Kontrak&nbsp;:</label>
                      <div class='col-md-4'>
                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                            <input type="text" class="form-control" name="KontrakDate" id="KontrakDate" placeholder="" value="<?php echo $ArrData['KontrakDate']; ?>">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                        <?php echo form_error('KontrakDate') ?>
                      </div>
                    </div>
                    
                    <div class='form-group'>
                    <label class="col-md-4 control-label">Deskripsi Kontrak&nbsp;:</label>
                    <div class='col-md-7'>
                      <textarea class="form-control Description" rows="5" name="KontrakDescription" id="KontrakDescription"><?php echo $ArrData['KontrakDescription']; ?></textarea>
                      <?php echo form_error('KontrakDescription') ?>
                    </div>
                  </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Penerima&nbsp;:</label>
                      <div class='col-md-6'>
                        <input type="hidden" class="form-control" name="ReceivedId" id="ReceivedId" placeholder="Penerima" value="<?php echo $ArrData['ReceivedId']; ?>" readonly/>
                        <input type="text" class="form-control" placeholder="Penerima" value="<?php echo $this->getdetailusers->GetById($ArrData['ReceivedId'], 'name'); ?>" readonly/>
                        <?php echo form_error('ReceivedId') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Tgl. Terima&nbsp;:</label>
                      <div class='col-md-5'>
                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                            <input type="text" class="form-control" name="ReceivedDate" id="ReceivedDate" placeholder="" value="<?php echo $ArrData['ReceivedDate']; ?>">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                        <?php echo form_error('ReceivedDate') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Pengirim&nbsp;:</label>
                      <div class='col-md-8'>
                        <select class="selectpicker" name="SenderId" id="SenderId" title="- Pilih -" data-show-subtext="true" data-live-search="true" data-width="150px">
                          <?php
                            foreach ($DataSender as $val) {
                              echo '<option value="'.$val->SenderId.'" data-tokens="'.$val->SenderName.'" '.$val->selected.'>'.$val->SenderName.'</option>';
                            }
                           ?>
                        </select>
                        <?php echo form_error('VendorId') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Nama Pengirim&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="OtherSenderName" id="OtherSenderName" placeholder="" value="<?php echo $ArrData['OtherSenderName']; ?>" />
                        <?php echo form_error('OtherSenderName') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Telp Pengirim&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="OtherSenderTelp" id="OtherSenderTelp" placeholder="" value="<?php echo $ArrData['OtherSenderTelp']; ?>" />
                        <?php echo form_error('OtherSenderTelp') ?>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="pane" style="background-color:#F6F6F6;">
                      <div class="panel-heading"><b>Detail Pembayaran</b></div>
                      <div class="panel-body">
                        <div class='box box-primary'>

                          <div class="col-md-6">

                            <div class='form-group'>
                              <label class="col-md-4 control-label">Real Cost&nbsp;:</label>
                              <div class='col-md-8'>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                      Rp.
                                  </div>
                                  <input type="text" class="form-control" name="RealCost" id="RealCost" placeholder="" value="<?php echo $ArrData['RealCost']; ?>"/>
                                </div>
                                <?php echo form_error('RealCost') ?>
                              </div>
                            </div>

                            <div class='form-group'>
                              <label class="col-md-4 control-label">PPN Tagihan&nbsp;:</label>
                              <div class='col-md-8'>
                                <div class="input-group">
                                  <select class="selectpicker" name="PpnId" id="PpnId" title="- Pilih -">
                                    <?php
                                      foreach ($DataPpn as $val) {
                                        echo '<option value="'.$val->PpnId.'" PpnValue="'.$val->PpnValue.'" PpnName="'.$val->PpnName.'" data-tokens="'.$val->PpnName.'" '.$val->selected.'>'.$val->PpnName.'</option>';
                                      }
                                     ?>
                                  </select>
                                  <span class="input-group-addon" id="PpnAmount"></span>
                                </div>
                                <?php echo form_error('PpnId') ?>
                              </div>
                            </div>

                            <div class='form-group'>
                              <label class="col-md-4 control-label">PPH Tagihan&nbsp;:</label>
                              <div class='col-md-8'>
                                <div class="input-group">
                                  <select class="selectpicker" name="PphId" id="PphId" title="- Pilih -">
                                    <?php
                                      foreach ($DataPph as $val) {
                                        echo '<option value="'.$val->PphId.'" PphValue="'.$val->PphValue.'" PphName="'.$val->PphName.'" data-tokens="'.$val->PphName.'" '.$val->selected.'>'.$val->PphName.'</option>';
                                      }
                                     ?>
                                  </select>
                                  <span class="input-group-addon" id="PphAmount"></span>
                                </div>
                                <?php echo form_error('PphId') ?>
                              </div>
                            </div>
                          </div>

                          <div class="col-md-6">
                            <div class='form-group'>
                              <label class="col-md-4 control-label">Total Value&nbsp;:</label>
                              <div class='col-md-8'>
                                <div class="input-group">
                                  <div class="input-group-addon">
                                      Rp.
                                  </div>
                                  <input type="text" class="form-control" name="TotalValue" id="TotalValue" placeholder="" value="<?php echo $ArrData['TotalValue']; ?>" readonly/>
                                </div>
                                <?php echo form_error('TotalValue') ?>
                              </div>
                            </div>
                          </div>

                        </div>
                      </div>
                    </div>
                  </div>

                  <div class='form-action'>
                      <?php
                      if($ArrData['button']){
                        echo '<button type="submit" class="btn btn-ok pull-right">'.$ArrData['button'].'</button>';
                      }
                      ?>
                      <a href="#" id="print" class='btn btn-cl pull-right' onclick="javascript:modalPrint('<?=$ArrData['PenerimaanInvoiceId']?>');">
                        <i class="glyphicon glyphicon-print"></i> Print
                      </a>
                      <a href='<?php echo site_url('penerimaanInvoice') ?>' class='btn btn-one pull-right'>
                        Kembali
                      </a>
                  </div>
                </form>

              </div>
            </div>
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

  <!-- Modal -->
  <div id="modal-print" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content modal-dialog modal-lg">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Print Penerimaan Invoice</h4>
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
  $(document).ready(function(){

    var PpnName = $('option:selected','#PpnId').attr('PpnName');
    sum(PpnName);

    $('#PpnId, #PphId').change(function(){
      var PpnName = $('option:selected',this).attr('PpnName');
      sum(PpnName);
    });

    $('#RealCost').keyup(function(){
      sum(PpnName);
    });

    function sum(PpnName){
      var RealCost = $('#RealCost').val();
      var Pph = parseFloat($('option:selected','#PphId').attr('PphValue'));
      var Ppn = parseFloat($('option:selected','#PpnId').attr('PpnValue'));
      RealCost = RealCost.split('.');
      var Real = RealCost[0].replace(',', '');
          Real = Real.replace(',', '');
          Real = Real.replace(',', '');
          Real = Real.replace(',', '');
          Real = parseFloat(Real);
      var PpnAmount = parseFloat((Real * Ppn )/100);
      var PphAmount = parseFloat((Real * Pph )/100);

      //belum selesai
      if(PpnName == 'PPN WAPU' || PpnName == 'NON PPN'){
        var TotalValue = Math.round(Real - PphAmount);
      }else{
        var TotalValue = Math.round(Real + PpnAmount - PphAmount);
      }

      $('#PpnAmount').html(formatMoney(PpnAmount));
      $('#PphAmount').html(formatMoney(PphAmount));
      $('#TotalValue').val(formatMoney(TotalValue));
    }

    $('#BillTypeId option').each(function() {
      if($(this).is(':selected')){
        proyekSelected();
      }
    });

    $('#BillTypeId').change(function(){
      proyekSelected();
    });

    function proyekSelected(){
      // var ProyekId = $('#ProyekId').val();
      var BillTypeId = $('#BillTypeId').val();
      var PenerimaanInvoiceId = '<?=$ArrData['PenerimaanInvoiceId']?>';
      $.ajax({
          type: 'POST',
          url: base_url+'PenerimaanInvoice/seqNoUrut/',
          data: {
              // 'ProyekId': ProyekId,
              'BillTypeId': BillTypeId
          },
          success: function (data) {
              // the next thing you want to do
              // var $VendorId = $('#VendorId');
              // $VendorId.empty();
              // data = jQuery.parseJSON(data);
              // $.each(data.SeqProyek, function (i, val) {
              //     $VendorId.append('<option value='+data.SeqProyek[i].VendorId+' data-tokens='+data.SeqProyek[i].VendorName+' '+data.SeqProyek[i].selected+'>' + data.SeqProyek[i].VendorName + '</option>').selectpicker('refresh');
              // });

              //manually trigger a change event for the contry so that the change handler will get triggered
              // $VendorId.change();
              data = jQuery.parseJSON(data);
              $('#BuktiNo').val(data.NoUrut);
          }
      });
    }

    $('#RealCost, #PpnAmount, #PphAmount').inputmask('decimal',
    { 'alias': 'numeric',
      'groupSeparator': ',',
      'autoGroup': true,
      'digits': 2,
      'radixPoint': ".",
      'digitsOptional': false,
      'allowMinus': false,
      'placeholder': '0'
    });

    $("#NpwpNo").inputmask("99.999.999.9.999.999",{placeholder:"00.000.000.0.000.000"});
    $("#FakturNo").inputmask("999.999.99.99999999",{placeholder:"000.000.00.00000000"});
  });

  function modalPrint(id){
    if(!id) return false;
    $('#modal-print').modal('show');
    $('#modal-print #frame-pdf').attr("src", "<?=base_url('penerimaanInvoice/report/')?>"+id);
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
</script>
