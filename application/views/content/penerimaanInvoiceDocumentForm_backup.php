<?php $IdForm = $ArrData['PenerimaanInvoiceId']; ?>
<!-- Main content -->
<div id='page-content-wrapper'>
  <div class='container-fluid'>
  <div class='row'>
    <div class='col-xs-12'>
      <div class="pane pane-purple">
        <div class="panel-heading"><b>Form Penerimaan Invoice</b></div>
        <div class="panel-body">
          <div class='box box-primary'>
            <?=$this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>
            <form action='<?php echo $ArrData['action']; ?>' method='post' class='form-horizontal'>
              <div class="col-md-6">
                <div class='form-group'>
                  <label class="col-md-4 control-label">Proyek </label>
                  <div class='col-md-8'>
                    <select class="selectpicker" name="ProyekId" id="ProyekId" title="- Pilih -" data-show-subtext="true" data-width="100%">
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
                  <label class="col-md-4 control-label">Vendor</label>
                  <div class='col-md-8'>
                    <select class="selectpicker" name="VendorId" id="VendorId" title="- Pilih -" data-live-search="true" data-width="100%">
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
                  <label class="col-md-4 control-label">No. Invoice </label>
                  <div class='col-md-8'>
                    <input type="text" class="form-control" name="InvoiceNo" id="InvoiceNo" placeholder="No. Invoice" value="<?php echo $ArrData['InvoiceNo']; ?>" />
                    <?php echo form_error('InvoiceNo') ?>
                  </div>
                </div>

                <div class='form-group'>
                  <label class="col-md-4 control-label">Tgl. Invoice </label>
                  <div class='col-md-5'>
                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                        <input type="text" class="form-control" name="InvoiceDate" id="InvoiceDate" placeholder="Tgl. Invoice" value="<?php echo $ArrData['InvoiceDate']; ?>">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                    <?php echo form_error('InvoiceDate') ?>
                  </div>
                </div>

                <div class='form-group'>
                  <label class="col-md-4 control-label">No. Faktur </label>
                  <div class='col-md-8'>
                    <input type="text" class="form-control" name="FakturNo" id="FakturNo" placeholder="No. Faktur" value="<?php echo $ArrData['FakturNo']; ?>" />
                    <?php echo form_error('FakturNo') ?>
                  </div>
                </div>

                <div class='form-group'>
                  <label class="col-md-4 control-label">NPWP </label>
                  <div class='col-md-8'>
                    <input type="text" class="form-control" name="NpwpNo" id="NpwpNo" placeholder="NPWP" value="<?php echo $ArrData['NpwpNo']; ?>" />
                    <?php echo form_error('NpwpNo') ?>
                  </div>
                </div>

                <div class='form-group'>
                  <label class="col-md-4 control-label">Tipe Pembayaran </label>
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

                <div class='form-group'>
                  <label class="col-md-4 control-label">No. Rekening </label>
                  <div class='col-md-8'>
                    <input type="text" class="form-control" name="AccountNumber" id="AccountNumber" placeholder="No. Rekening" value="<?php echo $ArrData['AccountNumber']; ?>" />
                    <?php echo form_error('AccountNumber') ?>
                  </div>
                </div>

                <div class='form-group'>
                  <label class="col-md-4 control-label">Atas Nama</label>
                  <div class='col-md-8'>
                    <input type="text" class="form-control" name="AccountByName" id="AccountByName" placeholder="No. Rekening" value="<?php echo $ArrData['AccountByName']; ?>" />
                    <?php echo form_error('AccountByName') ?>
                  </div>
                </div>

              </div>

              <div class="col-md-6">

                <div class='form-group'>
                  <label class="col-md-4 control-label">No. Bukti </label>
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
                  <label class="col-md-4 control-label"> </label>
                  <div class='col-md-3'>
                      <input type="text" class="form-control text-center" name="BuktiNo" id="BuktiNo" placeholder="No. Bukti" value="<?php echo $ArrData['BuktiNo']; ?>" readonly/>
                    <?php echo form_error('BuktiNo') ?>
                  </div>
                </div>

                <div class='form-group'>
                  <label class="col-md-4 control-label">Penerima </label>
                  <div class='col-md-6'>
                    <input type="hidden" class="form-control" name="ReceivedId" id="ReceivedId" placeholder="Penerima" value="<?php echo $ArrData['ReceivedId']; ?>" readonly/>
                    <input type="text" class="form-control" placeholder="Penerima" value="<?php echo $this->getdetailusers->GetById($ArrData['ReceivedId'], 'name'); ?>" readonly/>
                    <?php echo form_error('ReceivedId') ?>
                  </div>
                </div>

                <div class='form-group'>
                  <label class="col-md-4 control-label">Tgl. Terima </label>
                  <div class='col-md-5'>
                    <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                        <input type="text" class="form-control" name="ReceivedDate" id="ReceivedDate" placeholder="Tgl. Terima" value="<?php echo $ArrData['ReceivedDate']; ?>">
                        <div class="input-group-addon">
                            <span class="glyphicon glyphicon-th"></span>
                        </div>
                    </div>
                    <?php echo form_error('ReceivedDate') ?>
                  </div>
                </div>

                <div class='form-group'>
                  <label class="col-md-4 control-label">Pengirim </label>
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
                  <label class="col-md-4 control-label">Nama Pengirim </label>
                  <div class='col-md-8'>
                    <input type="text" class="form-control" name="OtherSenderName" id="OtherSenderName" placeholder="Other Sender Name" value="<?php echo $ArrData['OtherSenderName']; ?>" />
                    <?php echo form_error('OtherSenderName') ?>
                  </div>
                </div>

                <div class='form-group'>
                  <label class="col-md-4 control-label">Telp Pengirim</label>
                  <div class='col-md-8'>
                    <input type="text" class="form-control" name="OtherSenderTelp" id="OtherSenderTelp" placeholder="Other Sender Telp" value="<?php echo $ArrData['OtherSenderTelp']; ?>" />
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
                          <label class="col-md-4 control-label">Real Cost </label>
                          <div class='col-md-8'>
                            <div class="input-group">
                              <div class="input-group-addon">
                                  Rp.
                              </div>
                              <input type="text" class="form-control" name="RealCost" id="RealCost" placeholder="Real Cost" value="<?php echo $ArrData['RealCost']; ?>"/>
                            </div>
                            <?php echo form_error('RealCost') ?>
                          </div>
                        </div>

                        <div class='form-group'>
                          <label class="col-md-4 control-label">PPN Tagihan </label>
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
                          <label class="col-md-4 control-label">PPH Tagihan </label>
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
                          <label class="col-md-4 control-label">Total Value </label>
                          <div class='col-md-8'>
                            <div class="input-group">
                              <div class="input-group-addon">
                                  Rp.
                              </div>
                              <input type="text" class="form-control" name="TotalValue" id="TotalValue" placeholder="Total Value" value="<?php echo $ArrData['TotalValue']; ?>" readonly/>
                            </div>
                            <?php echo form_error('TotalValue') ?>
                          </div>
                        </div>
                      </div>

                    </div>
                  </div>
                </div>
              </div>
              <br>
              <div class='form-action'>
                  <?php if($ArrData['button']) echo '<button type="submit" class="btn btn-ok pull-right">'.$ArrData['button'].'</button>';?>
                  <a href="#" id="print" class='btn btn-cl pull-right' onclick="javascript:modalPrint('<?=$ArrData['PenerimaanInvoiceId']?>');">
                    <i class="glyphicon glyphicon-print"></i> Print
                  </a>
                  <a href='<?=site_url('PenerimaanInvoice');?>' class='btn btn-one pull-right'>
                    Kembali
                  </a>
              </div>
              <div class="clearfix"></div>
              <?php
              if($DataCompleteVerification){
                if($DataCompleteVerification->TotVerificationDocumentCompleted == $DataCompleteVerification->TotVerificationDocumentCompleted){
              ?>
              <div class="col-md-6">
                <div class="pane" style="background-color:#F6F6F6;">
                  <div class="panel-heading"><b>Verifikasi Invoice</b></div>
                  <div class="panel-body">
                    <div class='box box-primary'>
                      <div class="row">
                        <div class="col-md-12">
                          <div class='form-group'>
                            <label class="col-md-3 control-label">Status :</label>
                            <div class='col-md-4'>
                              <select class="selectpicker" name="InvoiceVerificationStatus" id="InvoiceVerificationStatus" data-show-subtext="false" data-live-search="false" data-width="100%">
                                <option value="0" <?=($DataCompleteVerification->Status == 0 ? "selected" : "")?>>Menunggu</option>
                                <option value="1" <?=($DataCompleteVerification->Status == 1 ? "selected" : "")?>>Terima</option>
                                <option value="2" <?=($DataCompleteVerification->Status == 2 ? "selected" : "")?>>Tolak</option>
                              </select>
                            </div>
                          </div>
                        </div>
                      </div>
                      
                      <div class="row">
                        <div class="col-md-12">
                          <div class='form-group'>
                            <label class="col-md-3 control-label">Catatan :</label>
                            <div class='col-md-9'>
                              <textarea class="form-control" rows="3" cols="50" id="InvoiceVerificationNote" name="InvoiceVerificationNote"><?=$DataCompleteVerification->Note?></textarea>
                            </div>
                          </div>

                          <div class='form-action'>
                              <div id="loadingVerif"></div>
                              <div id="postVerif"></div>
                              <button type="submit" class="btn btn-ok pull-right" onclick="javascript:invoiceVerification('<?=$ArrData['PenerimaanInvoiceId']?>');">Verifikasi</button>
                          </div>
                        </div>
                      </div>
                      <!-- verifikasi status invoice -->
                    </div>
                  </div>
                </div>
              </div>
              <?php 
                }
              }
              ?>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

        <br>
        <div class="row">
          <div class="col-md-12">
              <div class="pane pane-purple">
                <div class="panel-heading">
                  <b>
                    Status Dokumen Pendukung
                  </b>
                </div>
                <!-- verifikasi status invoice -->
                <div class="panel-body">
                  <!--<button width="250px" type="button" class="btn btn-ok pull-top" id="btnUpload" >Upload Semua</button>-->
                  <table border="1">
                    <tr  bgcolor="#E6E1E1" align="center" style="border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000;">
                      <td width="200px" style="padding: 8px;"><b>Document</b></td>
                      <td width="100px" style="padding: 8px;"><b>Upload</b></td>
                      <?php
                        foreach ($DataVerificator as $Val) {
                          ?>
                            <td width="120px" style="padding: 8px;"><b><?=$Val->JabatanCode;?></b></td>
                          <?php
                        }
                      ;?>
                      <td width="120px" style="padding: 8px;">
                        <a href="#" id="print" class='btn btn-cl pull-right' onclick="javascript:modalPrintCheckList('<?=$ArrData['PenerimaanInvoiceId']?>');">
                          <i class="glyphicon glyphicon-print"></i> Print
                        </a>
                      </td>
                    </tr>
                    <?php

                      $tempArrDataVerificator = (array)$DataVerificator[0];
                      $tempI = 0;
                      $tempCount = count($tempArrDataVerificator);
                      foreach ($DataDocumentStatus as $Val) {
                        ?>
                          <tr align="center" style="border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000;">
                            <td style="padding: 8px;">
                              <a href="#" onclick="
                                  <?php if($Val->Path != "") { ?>javascript:viewDocument('<?=$IdForm;?>', <?=$Val->DocumentId;?>, '<?=$Val->Path;?>');
                                  <?php } else { ?> $('#modal-document-s<?=$Val->DocumentId;?>').modal('show'); <?php } ?>" id="a<?=$Val->DocumentId;?>">
                                <u><?=$Val->DocumentName;?></u>
                              </a>
                            </td>
                            <td style="padding: 8px;">
                              <div id="filup<?=$Val->DocumentId;?>">
                                <?php if($Val->Path != "") echo "Y"; else echo "-";?>
                              </div>
                            </td>
                            <?php
                              $statusDocVer = 1;
                              foreach ($DataVerificator as $Val2)
                              {
                                $arrDocumentStatus = (array)$DataDocumentStatus[$tempI];
                                ?>
                                <td style="padding: 8px;">
                                  <div class="filup<?=$Val->DocumentId;?>">
                                    <?php
                                      if($Val->Path != "")
                                      {
                                        $StatusDoc = "Menunggu";
                                        if($arrDocumentStatus[$Val2->JabatanCode] == 1) $StatusDoc = "Terima";
                                        elseif ($arrDocumentStatus[$Val2->JabatanCode] == 2) $StatusDoc = "Tolak";
                                        echo $StatusDoc;

                                        if($arrDocumentStatus[$Val2->JabatanCode] != 1) $statusDocVer = $arrDocumentStatus[$Val2->JabatanCode];
                                      }
                                      else
                                      {
                                        echo "-";
                                      }

                                    ?>
                                  </div>
                                </td>
                                <?php
                              }
                              ?>
                              <td>
                                <?php
                                  if($statusDocVer != 1 || $Val->Path == ""){
                                    ?>
                                    <a href="#" onclick="$('#modal-document-s<?=$Val->DocumentId;?>').modal('show')"><u>Upload</u></a>
                                    <?php
                                  }
                                ?>
                              </td>
                          </tr>
                        <?php
                        $tempI ++;
                      }
                    ;?>

                  </table>
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
              <embed id="frame-pdf" src="" width="100%" height="600">
              <!-- END FORM-->
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
        </div>
      </div>

    </div>
  </div>

  <!-- Modal -->
  <div id="modal-print-verification" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content modal-dialog modal-lg">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">
            <div id="dvDocumentName"></div>
          </h4>
        </div>
        <div class="modal-body">
          <div class="portlet-body form">
              <!-- BEGIN FORM-->
              <div class="col-md-12">
                <embed id="frame-pdf-verification" src="" width="100%" height="600">
                <br><br><br><br><br><br>
              </div>

              <!-- END FORM-->

              <div id="VerificationAction">

            <?php

              $isVerif = 0;
              $isJabatanId = $this->session->userdata('jabatanid');
              foreach ($DataVerificator as $Val) {
                if($Val->JabatanId == $isJabatanId) $isVerif = 1;
              }
              
              if ($isVerif == 1)
              {
              ?>
                <script>
                  $(function() {$( "#verification" ).on("submit", function(e)
                    {
                      $("#loadingVerif").html("<img src='<?=base_url("assets/img/loading.gif");?>'>");
                      e.preventDefault();
                      // console.log(new FormData(this));
                      $.ajax({
                        url     : "<?=base_url('/PenerimaanInvoice/UpdateDocumentStatus/'.$IdForm); ?>",
                        type:"post",dataType:"html",
                        data:new FormData(this),
                        contentType:false,
                        cache:false,
                        processData:false,
                        success:function(data){
                          if(data=='berhasil')
                          {
                            window.location.href = '<?=base_url("/penerimaanInvoice/update/".$IdForm);?>';
                          }
                          else
                          {
                            alert("Input tidak lengkap");
                          }
                        },
                      })
                    });
                  });
                </script>
                <form action='<?=base_url('/PenerimaanInvoice/UpdateDocumentStatus/'.$IdForm); ?>' method='post' class='form-horizontal' id="verification">
                  <br><br><br>
                  <h4><u>Verifikasi Dokument</u></h4>
                  <input type="hidden" id="JabatanId" name="JabatanId" value="<?=$this->session->userdata('jabatanid');?>">
                  <input type="hidden" id="DocumentId" name="DocumentId" value="">
                  <div class="col-md-6">
                    <div class='form-group'>
                      <br><br><br>
                      <h4> </h4>
                      <label class="col-md-4 control-label">Status :</label>
                      <div class='col-md-8'>
                        <select class="selectpicker" name="Status" id="Status" data-show-subtext="false" data-live-search="false" data-width="100%">
                          <option value="0">Menunggu</option>
                          <option value="1">Terima</option>
                          <option value="2">Tolak</option>
                        </select>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class='form-group'>
                      <label class="col-md-2 control-label">Catatan :</label>
                      <div class='col-md-6'>
                        <textarea class="form-control" rows="3" cols="50" id="Note" name="Note"></textarea>
                      </div>
                    </div>
                    <div class='form-action'>
                        <div id="loadingVerif"></div>
                        <div id="postVerif"></div>
                        <button type="submit" class="btn btn-ok pull-right">Verifikasi</button>
                    </div>
                  </div>
                </form>
              <?php
              }
            ?>
              </div>
              <div class="col-md-12">
                <div id="DocumentVerificationStatus"></div>
              </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
          </div>
        </div>

      </div>
    </div>
  </div>

<!-- Upload Modal -->
  <?php
    $texse = "";
    foreach ($DataGrpBillDocument as $Val) {
      $arr = $Val->DocumentGroup;
      foreach ($arr as $SubVal)
      { ?>
        <div id="modal-document-s<?=$SubVal->DocumentId;?>" class="modal fade" role="dialog">
          <div class="modal-dialog">
          <!-- Modal content-->
            <div class="modal-content modal-dialog modal-lg">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Upload Document <?=$SubVal->DocumentName;?></h4>
                <?php
                  if($SubVal->DocumentExample){
                    echo '<a href="'.base_url($SubVal->DocumentExample).'">
                            <i class="glyphicon glyphicon-download"></i>
                            Unduh format '.$SubVal->DocumentName.'
                          </a>';
                  }
                ?>
              </div>
              <div class="modal-body">
                <div class="portlet-body form">
                  <!-- BEGIN FORM-->
                  <?php
                  $a = '$("#a'.$SubVal->DocumentId.'").attr("onClick", "javascript:viewDocument('."'".$IdForm."', ".$SubVal->DocumentId.", 'Doc_".$IdForm."_".$SubVal->BillTypeId."_".$SubVal->DocumentId.".pdf'".');")';
                  $texse = "<b><font color='green'><i>".$SubVal->DocumentName." Berhasil diupload</i></font></b><input type='hidden' name='hdnStatss".$SubVal->BillTypeId.$SubVal->DocumentId."' id='hdnStatss".$SubVal->BillTypeId.$SubVal->DocumentId."' value='1'><br>";
                   echo ' <script>
                      $(function() {
                        $( "#Uploads'.$SubVal->BillTypeId.$SubVal->DocumentId.'" ).on("submit", function(e) {
                          $("#divimgs'.$SubVal->BillTypeId.$SubVal->DocumentId.'" ).html("<img src='."'".base_url("assets/img/loading.gif")."'>".'");
                          e.preventDefault();
                          console.log(new FormData(this));
                          $.ajax({
                            url     : "'.base_url("PenerimaanInvoice/UploadDocument/s".$SubVal->BillTypeId.$SubVal->DocumentId.'/'.$IdForm).'",
                            type:"post",
                            dataType:"html",
                            data:new FormData(this),
                            contentType:false,
                            cache:false,
                            processData:false,
                            success:function(data){
                              $("#divimgs'.$SubVal->BillTypeId.$SubVal->DocumentId.'").html(data); 
                              if(data=="'.$texse.'"){
                                $("#divLooks'.$SubVal->BillTypeId.$SubVal->DocumentId.'").html("");
                                $("#filup'.$SubVal->DocumentId.'").html("Y");
                                $(".filup'.$SubVal->DocumentId.'").html("Menunggu");
                                '.$a.'
                                window.location.href = "'.base_url('/penerimaanInvoice/update/'.$IdForm).'";
                              }  
                            },
                          })
                        });
                      });
                    </script>';
                  ?>
                  <br><br>
                  <?=$SubVal->DocumentName;?>
                  <div id="divimgs<?=$SubVal->BillTypeId.$SubVal->DocumentId;?>"></div>
                  <div id="divLooks<?=$SubVal->BillTypeId.$SubVal->DocumentId;?>" class="form-horizontal col-md-8">
                    <form method="post" action="<?=base_url("PenerimaanInvoice/UploadDocument/s".$SubVal->BillTypeId.$SubVal->DocumentId."/".$IdForm);?>" id="Uploads<?=$SubVal->BillTypeId.$SubVal->DocumentId;?>" name="Uploads<?=$SubVal->BillTypeId.$SubVal->DocumentId;?>">
                      <input id="file_s<?=$SubVal->BillTypeId.$SubVal->DocumentId;?>" name="file_s<?=$SubVal->BillTypeId.$SubVal->DocumentId;?>" class="file" type="file" multiple data-min-file-count="1">
                      <button type="submit" class="btn btn-primary" name="sbt" id="sbts<?=$SubVal->BillTypeId.$SubVal->DocumentId;?>">Submit</button>
                      <button type="reset" class="btn btn-default" name="res" id="ress<?=$SubVal->BillTypeId.$SubVal->DocumentId;?>">Reset</button>
                      <input type="hidden" id="hdnTemps<?=$SubVal->BillTypeId.$SubVal->DocumentId;?>_Id" name="hdnTemps<?=$SubVal->BillTypeId.$SubVal->DocumentId;?>_Id" value="<?=$IdForm;?>">
                      <input type="hidden" id="hdnTemps<?=$SubVal->BillTypeId.$SubVal->DocumentId;?>" name="hdnTemps<?=$SubVal->BillTypeId.$SubVal->DocumentId;?>" value="hdnTemps<?=$SubVal->BillTypeId.$SubVal->DocumentId;?>">
                      <input type="hidden" id="hdnTemps<?=$SubVal->BillTypeId.$SubVal->DocumentId;?>_DocumentName" name="hdnTemps<?=$SubVal->BillTypeId.$SubVal->DocumentId;?>_DocumentName" value="<?=$SubVal->DocumentName;?>">
                      <input type="hidden" id="hdnTemps<?=$SubVal->BillTypeId.$SubVal->DocumentId;?>_BillTypeId" name="hdnTemps<?=$SubVal->BillTypeId.$SubVal->DocumentId;?>_BillTypeId" value="<?=$SubVal->BillTypeId;?>">
                      <input type="hidden" id="hdnTemps<?=$SubVal->BillTypeId.$SubVal->DocumentId;?>_DocumentId" name="hdnTemps<?=$SubVal->BillTypeId.$SubVal->DocumentId;?>_DocumentId" value="<?=$SubVal->DocumentId;?>">
                    </form>
                  </div>
                  <dir class="clearfix"></dir>
                </div>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
              </div>
            </div>
          </div>
        </div>
        <?php
        }
      }
    ?>
    <!-- End Upload Moda -->
    <div id="modal-document" class="modal fade" role="dialog">
      <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content modal-dialog modal-lg">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Upload Document</h4>
          </div>
          <div class="modal-body">
            <div class="portlet-body form">
                <!-- BEGIN FORM-->
                <embed id="frame-pdf" src="" width="100%" height="600">
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

    $('#RealCost').keypress(function(){
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
      $('#TotalValue').val(TotalValue);
    }

    $('#BillTypeId option').each(function() {
      if($(this).is(':selected')){
        //proyekSelected();
      }
    });

    $('#BillTypeId').change(function(){
      //proyekSelected();
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

    $('#RealCost, #TotalValue, #PpnAmount, #PphAmount').inputmask('decimal',
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

    function formatMoney(n) {
        return n.toFixed(2).replace(/(\d)(?=(\d{3})+\.)/g, "$1,");
    }

  });

  function modalPrint(id){
    if(!id) return false;
    $('#modal-print').modal('show');
    $('#modal-print #frame-pdf').attr("src", "<?=base_url('penerimaanInvoice/report/')?>"+id);
  }

  function modalPrintCheckList(id){
    if(!id) return false;
    $('#modal-print').modal('show');
    $('#modal-print #frame-pdf').attr("src", "<?=base_url('penerimaanInvoice/reportCheckList/')?>"+id);
  }

  function viewDocument(PenerimaanInvoiceId, DocumentId, Path){
    var PenerimaanInvoiceId = PenerimaanInvoiceId;
    var DocumentId = DocumentId;
    $.ajax({
        type: 'POST',
        url: base_url + 'PenerimaanInvoice/DocumentPenerimaanInvoice',
        data: {
            'PenerimaanInvoiceId' : PenerimaanInvoiceId,
            'DocumentId' : DocumentId
        },
        success: function (data) {
            console.log(data);
            var Data = jQuery.parseJSON(data);
            $("#dvDocumentName").html(Data[0].DocumentName);
            $('#modal-print-verification').modal('show', {
              backdrop: 'static',
              keyboard: false
            });
            $('#modal-print-verification #frame-pdf-verification').attr("src", base_url + "/upload/" + Path);
            $('#DocumentId').attr("value", DocumentId);

            var x = '';
            x += '<h4><b>Keterangan Verifikasi</b></h4>';
            x += '<table border="1" bgcolor="#E6E1E1" align="center" style="border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000;">';
            x += '  <tr>';
            x += '    <td width="1000px" style="padding: 10px;">';
            // x += '      <table>';

            var xy = 0;
            $.each( Data, function( key, val ) {
              var StatusDoc = '-';
              var VerificationDateDoc = '-';
              var NoteDoc = '-';
              var JabatanId = '<?=$this->session->userdata("jabatanid")?>';

              if (Path != '')
              {
                if (val.Status == 0) StatusDoc = 'Menunggu';
                else if (val.Status == 1) StatusDoc = 'Terima';
                else StatusDoc = 'Tolak';

                VerificationDateDoc = (val.VerificationDate == null) ? '' : val.VerificationDate;
                NoteDoc = (val.Note == null) ? '' : val.Note;
                NameVerification = (val.Status == 0) ? '' : val.NameVerification;

                if (JabatanId == val.JabatanId) {
                  $("#Status").empty();
                  var option = '<option value="0" '+(val.Status == 0 ? "selected" : "")+'>Menunggu</option>';
                      option+= '<option value="1" '+(val.Status == 1 ? "selected" : "")+'>Terima</option>';
                      option+= '<option value="2" '+(val.Status == 2 ? "selected" : "")+'>Tolak</option>';
                  $("#Status").append(option).selectpicker('refresh');;

                  $("#Note").val(NoteDoc);
                }
              }
              x += '<div class="col-md-6" style="padding: 10px;">';
              x += '<div class="form-group">';
              x += '<span class="col-md-4">Oleh</span>';
              x += '<span class="col-md-8">: '+val.JabatanCode+'</span>';
              x += '<span class="col-md-4">Status :</span>';
              x += '<span class="col-md-8">: '+StatusDoc+'</span>';
              x += '<span class="col-md-4">Verifikator</span>';
              x += '<span class="col-md-8">: '+NameVerification+'</span>';
              x += '<span class="col-md-4">Tgl. Verifikasi :</span>';
              x += '<span class="col-md-8">: '+VerificationDateDoc+'</span>';
              x += '<span class="col-md-4">Note</span>';
              x += '<span class="col-md-8">: '+NoteDoc+'</span>';
              x += '</div>';
              x += '</div>';
            });

            // x += '       </table>';
            x += '    </td>';
            x += '  </tr>';
            x += '</table>';



            $('#DocumentVerificationStatus').html(x);


        }
    });
  }

  function grpDocumentUpload(){

    var BillTypeId = $('#BillTypeId').val();
    var PenerimaanInvoiceId = '<?=$ArrData['PenerimaanInvoiceId']?>';
    $.ajax({
        type: 'POST',
        url: base_url+'PenerimaanInvoice/getGrpBillDocumentByBillTypeIdAction/',
        data: {
            // 'ProyekId': ProyekId,
            'BillTypeId': BillTypeId
        },
        success: function (data) {
            arrData = jQuery.parseJSON(data);

            var markup = "";

          $.each( arrData, function( key, value ) {
            markup += "<form enctype=\"multipart/form-data\">";
            markup += "  <br>";
            markup += "  <h2>" + value['DocumentName'] + "</h2>";
            markup += "  <br>";
            markup += "  <input id=\"file-" + key + "\" class=\"file\" type=\"file\" multiple data-min-file-count=\"1\">";
            markup += "  <br>";
            markup += "  <button type=\"submit\" class=\"btn btn-primary\">Submit</button>";
            markup += "  <button type=\"reset\" class=\"btn btn-default\">Reset</button>";
            markup += "</form>";
          });
            $("#DocumentUpload").html(markup);
        }
    });
  }

  function invoiceVerification(id){
    $.ajax({
      url: base_url+'/PenerimaanInvoice/InvoiceVerification/'+id,
      type: 'POST',
      dataType: 'JSON',
      data: {
        InvoiceVerificationStatus: $('#InvoiceVerificationStatus').val(),
        InvoiceVerificationNote: $('#InvoiceVerificationNote').val()
      },
      success: function(res){
        window.location.href = '<?=base_url("/penerimaanInvoice/update/".$IdForm);?>';
      }
    });
  }
</script>