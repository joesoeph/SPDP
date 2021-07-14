<?php
//echo "<pre>"; var_dump($DataInvoice);
?>
<!-- Main content -->
<div id='page-content-wrapper'>
  <div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li class="active"><i class="glyphicon glyphicon-envelope"></i> Info Pembayaran</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
  </div>
  <div class='container-fluid'>
  <div class='row'>
    <div class="pane pane-purple">
      <div class="panel-heading">
        <b>Form Informasi Pembayaran</b>
      </div>
      <div class="panel-body">
        <div class='col-xs-12'>
          <div class='box box-primary'>
            <!-- <form action='<?php echo $ArrData['action']; ?>' method='post' class='form-horizontal'> -->
            <form action="<?=base_url('Payment/Report')?>" method="post" class="form-horizontal">
              <div class="row">
                <div class="col-md-12">
                  <div class="col-md-6">
                    <div class='form-group'>
                      <label class="col-md-4 control-label">Vendor </label>
                      <div class='col-md-8'>
                        <select class="selectpicker" name="VendorId" id="VendorId" title="- Pilih -" data-show-subtext="true" data-live-search="true" data-width="100%">
                          <option value="">- Semua -</option>
                          <?php
                            foreach ($DataVendor as $val) {
                              echo '<option value="'.$val->VendorId.'" data-tokens="'.$val->VendorName.'" '.$val->selected.'>'.$val->VendorName.'</option>';
                            }
                           ?>
                        </select>
                        <?php echo form_error('VendorId') ?>
                      </div>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="form-group">
                      <div class="col-md-6">
                          <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                            <input type="text" class="form-control" name="From" id="From" placeholder="Dari">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                            <input type="text" class="form-control" name="To" id="To" placeholder="Sampai">
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="col-md-12">
                  <div class="col-md-6">

                    <div class='form-group'>
                      <label class="col-md-4 control-label">No. Invoice </label>
                      <div class='col-md-8'>
                        <select class="selectpicker" name="PenerimaanInvoiceId" id="PenerimaanInvoiceId" title="- Pilih -" data-show-subtext="true" data-live-search="true" data-width="100%">
                        </select>
                        <?php echo form_error('PenerimaanInvoiceId') ?>
                      </div>
                    </div>

                  </div>
                  <div class="col-md-6">
                    <div class="form-action pull-right">
                      <button type="button" id="Search" class="btn btn-default btn-sm">Cari</button>
                      <!-- <input type="button" id="Search" value="Cari" > -->
                      <input type="submit" value="Ekspor" class="btn btn-default btn-sm">
                      <a href="<?=base_url('ImportCsv')?>">
                        <button type="button" class="btn btn-primary btn-sm">Impor</button>
                      </a>
                    </div>
                  </div>
                </div>

              </div>

              <div class="row" id="form-input">

                <div class="col-md-12">
                  <div class="pane" style="background-color:#F6F6F6;">
                    <div class="panel-heading"><b>Detail Pembayaran</b></div>
                      <div class="panel-body">
                        <div class='box box-primary'>
                          
                          <div class="row">
                            <div class='col-md-5'>
                              <div class="pane" style="background-color:#F6F6F6;">
                                <div class="panel-body">
                                  <div class='box box-primary'>
                                    <div class='form-group'>
                                      <div class="table-responsive">
                                        <table class="table">
                                          <thead>
                                            <tr>
                                              <th>INVOICE</th>
                                              <th>TGL. TERIMA</th>
                                              <th class="pull-right">TOTAL VALUE</th>
                                            </tr>
                                          </thead>
                                          <tbody id="DetailTagihan">
                                            
                                          </tbody>
                                        </table>
                                        <input type="hidden" id="row" name="row" value="">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            
                            <div class='col-md-7'>
                              <div class="pane" style="background-color:#F6F6F6;">
                                <div class="panel-body">
                                  <div class='box box-primary'>
                                    <div class='form-group'>
                                      <div class="table-responsive">
                                        <table class="table">
                                          <thead>
                                            <tr>
                                              <th>TGL BAYAR</th>
                                              <th>INVOICE</th>
                                              <th class="pull-right">NILAI BAYAR</th>
                                            </tr>
                                          </thead>
                                          <tbody id="DetailPembayaran">
                                            
                                          </tbody>
                                          <tfoot>
                                            <tr>
                                              <td colspan="2">
                                                Tambah data pembayaran
                                              </td>
                                              <td id="response"></td>
                                            </tr>
                                            <tr>
                                              <td>
                                                <input type='hidden' size='15' id="PaymentId" readonly/>
                                                <input type='text' size='10' id='PaymentDate' value='<?php echo date("Y-m-d")?>'/>
                                              </td>
                                              <td>
                                                <input type='text' size='15' id="InvoiceNo" readonly/>
                                              </td>
                                              <td align='right'>
                                                <input type='text' size='12' id='PaymentValue'/>
                                              </td>
                                              <td align="center">
                                                <button id="addPayment"><i class="glyphicon glyphicon-floppy-disk"></i></button>
                                              </td>
                                            </tr>
                                          </tfoot>
                                        </table>
                                        <input type="hidden" id="row" name="row" value="">
                                      </div>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>

                            <div class='col-md-12'>
                              <div class='form-group'>
                                <div class="table-responsive">
                                  <table class="table">
                                    <tbody id="DetailTagihan">
                                      <tr>
                                        <td width="25%"> TOTAL TAGIHAN</td>
                                        <td width="25%" id="TotalTagihan" align="right"></td>
                                        <td width="25%" colspan="2"> TOTAL PEMBAYARAN</td>
                                        <td width="25%" align="right" id="TotalPembayaran"></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <input type="hidden" id="row" name="row" value="">
                                </div>
                              </div>

                            </div>

                            <div class='col-md-12'>
                              <div class='form-group'>
                                <div class="table-responsive">
                                  <table class="table">
                                    <tbody id="DetailTagihan">
                                      <tr>
                                        <td> SALDO HUTANG</td>
                                        <td align="right" id="SaldoHutang"></td>
                                      </tr>
                                    </tbody>
                                  </table>
                                  <input type="hidden" id="row" name="row" value="">
                                </div>
                              </div>

                            </div>

                          </div>
                      </div>
                  </div>
                </div>
                </div>
              </div>
            </form>

            <div class="row" id="lampiran">
              <div class="col-md-12">
                <div class="pane pane-purple">
                  <div class="panel-heading"><b>Lampiran</b></div>
                  <div class="panel-body">
                    <div id="divimgs" class="text-center"></div>
                    <form method="post" action="" id="UploadBukti" name="UploadBukti">
                      <div class='form-group col-md-8'>
                        <div class='col-md-2 pull-left'>
                          <label class="col-md-2 pull-left">SSP</label>
                        </div>  
                        <div class='col-md-1 pull-left'>
                          <label class="col-md-3 pull-left">:</label>
                        </div>
                        <div class='col-md-4 pull-left'>
                          <div id="SspNotAvailable">
                              
                          </div>
                          <div id="SspAvailable">
                              
                          </div>
                        </div>
                      </div>

                      <div class='form-group col-md-8'>
                        <div class='col-md-2 pull-left'>
                          <label class="col-md-2 pull-left">Bukti&nbsp;Potong</label>
                        </div>  
                        <div class='col-md-1 pull-left'>
                          <label class="col-md-3 pull-left">:</label>
                        </div>
                        <div class='col-md-4 pull-left'>
                            <div id="BuktiPotongNotAvailable">
                             
                           </div>
                           <div id="BuktiPotongAvailable">
                            
                          </div>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div><!-- /.col -->
  </div>
</div>
</div>

<!-- Modal -->
<div id="modal-edit" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content modal-dialog modal-sm">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Edit Pembayaran</h4>
      </div>
      <div class="modal-body">
        <div class="portlet-body form">
            
        </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Tutup</button>
      </div>
    </div>

  </div>
</div>

<!-- Modal print -->
  <div id="modal-print" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content modal-dialog modal-lg">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Lampiran</h4>
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
<!-- End Modal print -->

    <!--Upload Lampiran -->
        <div id="modal-UploadSsp" class="modal fade" role="dialog">
          <div class="modal-dialog">
          <!-- Modal content-->
            <div class="modal-content modal-dialog modal-lg">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Upload SSP</h4>

              </div>
              <div class="modal-body">
                <div class="portlet-body form">
                  <!-- BEGIN FORM-->
                  <?php
                  $texse = "<b><font color='green'><i>SSP Berhasil diupload</i></font></b>";
                   echo ' <script>
                      $(function() {
                        $( "#UploadSsp" ).on("submit", function(e) {
                          $("#divimgSsp" ).html("<img src='."'".base_url("assets/img/lo7.gif")."'>".'");
                          e.preventDefault();
                          console.log(new FormData(this));
                          $.ajax({
                            url     : "'.base_url("PenerimaanInvoice/UploadSsp").'",
                            type:"post",
                            dataType:"html",
                            data:new FormData(this),
                            contentType:false,
                            cache:false,
                            processData:false,
                            success:function(data){
                              $("#divimgSsp").html(data);
                              if(data=="'.$texse.'"){
                                window.location.href = "'.base_url('/Payment').'";
                              }
                            },
                          })
                        });
                      });
                    </script>';
                  ?>
                  <br><br>
                  SSP
                  <div id="divimgSsp"></div>
                  <div id="divLookSsp" class="form-horizontal col-md-8">
                    <form method="post" action="<?=base_url("PenerimaanInvoice/UploadSsp/");?>" id="UploadSsp" name="UploadSsp">
                      <input id="file_Ssp" name="file_Ssp" class="file" type="file" multiple data-min-file-count="1">
                      <input type="hidden" id="hdnSspPenerimaanInvoiceId" name="hdnSspPenerimaanInvoiceId" value="">
                      <button type="submit" class="btn btn-primary" name="sbtSsp" id="sbtSsp">Submit</button>
                      <button type="reset" class="btn btn-default" name="resSsp" id="resSsp">Reset</button>
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
        
        <div id="modal-UploadBuktiPotong" class="modal fade" role="dialog">
          <div class="modal-dialog">
          <!-- Modal content-->
            <div class="modal-content modal-dialog modal-lg">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Upload Bukti Potong</h4>

              </div>
              <div class="modal-body">
                <div class="portlet-body form">
                  <!-- BEGIN FORM-->
                  <?php
                  $texse = "<b><font color='green'><i>Bukti Potong Berhasil diupload</i></font></b>";
                   echo ' <script>
                      $(function() {
                        $( "#UploadBuktiPotong").on("submit", function(e) {
                          $("#divimgBuktiPotong" ).html("<img src='."'".base_url("assets/img/lo7.gif")."'>".'");
                          e.preventDefault();
                          console.log(new FormData(this));
                          $.ajax({
                            url     : "'.base_url("PenerimaanInvoice/UploadBuktiPotong").'",
                            type:"post",
                            dataType:"html",
                            data:new FormData(this),
                            contentType:false,
                            cache:false,
                            processData:false,
                            success:function(data){
                              $("#divimgBuktiPotong").html(data);
                              if(data=="'.$texse.'"){ 
                                window.location.href = "'.base_url('/Payment').'";
                                $("#SspAvailable").html('."'".'<a href="#" id="modalPrintSsp" onclick="javascript:modalPrintSsp();">Available</a>&nbsp;&nbsp;<a href="#" onclick="javascript:modalUploadSsp();">[Edit]</a>'."'".');
                                $("#SspNotAvailable").html(""); 
                              }
                            },
                          })
                        });
                      });
                    </script>';
                  ?>
                  <br><br>
                  Bukti Potong
                  <div id="divimgBuktiPotong"></div>
                  <div id="divLookBuktiPotong" class="form-horizontal col-md-8">
                    <form method="post" action="<?=base_url("PenerimaanInvoice/UploadBuktiPotong/");?>" id="UploadBuktiPotong" name="UploadBuktiPotong">
                      <input id="file_BuktiPotong" name="file_BuktiPotong" class="file" type="file" multiple data-min-file-count="1">
                      <input type="hidden" id="hdnBuktiPotongPenerimaanInvoiceId" name="hdnBuktiPotongPenerimaanInvoiceId" value="">
                      <button type="submit" class="btn btn-primary" name="sbtBuktiPotong" id="sbtBuktiPotong">Submit</button>
                      <button type="reset" class="btn btn-default" name="resBuktiPotong" id="resBuktiPotong">Reset</button>
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
    <!--END Upload Lampiran -->
    
    

<script type="text/javascript" src="<?=base_url('assets/js/Payment.js')?>"></script>
<script>
  function modalPrintSsp(){
    $('#modal-print').modal('show');
    $('#modal-print #frame-pdf').attr("src", "<?=base_url('upload/lampiran/Doc_')?>"+$('#hdnSspPenerimaanInvoiceId').val() + '_Ssp.pdf');
  }
  
  function modalPrintBuktiPotong(){
    $('#modal-print').modal('show');
    $('#modal-print #frame-pdf').attr("src", "<?=base_url('upload/lampiran/Doc_')?>"+$('#hdnBuktiPotongPenerimaanInvoiceId').val()+ '_BuktiPotong.pdf');
  }
  
  function modalUploadSsp(){
    $('#modal-UploadSsp').modal('show');
  }
  
  function modalUploadBuktiPotong(){
    $('#modal-UploadBuktiPotong').modal('show');
  }
</script>