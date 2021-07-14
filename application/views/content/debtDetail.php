<!-- Main content -->
<div id="page-content-wrapper">
  <div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li class="active"><i class="glyphicon glyphicon-list"></i> Daftar Hutang</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
  </div>
  <div class="container-fluid">
    <div class='row'>
      <div class="pane pane-purple">
        <div class="panel-heading"><b>Daftar Hutang</b></div>
        <div class="panel-body">
          <div class='col-xs-12'>
            <div class='box'>
              <div class='box-header'>
                <div class='box box-primary'>
                  <form action="<?=base_url('DebtDetail/DebtReport')?>" method="post" id="DebtForm" class="form-horizontal">

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
                                    echo '<option value="'.$val->VendorId.'" data-tokens="'.$val->VendorName.'" >'.$val->VendorCode.' - '.$val->VendorName.'</option>';
                                  }
                                 ?>
                              </select>
                              <?php echo form_error('VendorId') ?>
                            </div>
                          </div>
                        </div>

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
                      </div>

                      <div class="col-md-12">
                        <div class="col-md-6">
                          <div class='form-group'>
                            <label class="col-md-4 control-label">Status</label>
                            <div class='col-md-8'>
                              <select class="selectpicker" name="PaymentStatus" id="PaymentStatus" title="- Pilih -" data-show-subtext="true" data-live-search="true" data-width="100%">
                                <option value="0">- Semua -</option>
                                <option value="Lunas">Lunas</option>
                                <option value="Belum Lunas">Belum lunas</option>
                                <option value="Lebih Bayar">Lebih Bayar</option>
                              </select>
                            </div>
                          </div>
                        </div>

                        <div class="col-md-6">
                          <div class="form-action pull-right">
                            <input type="button" id="PrintAll" onclick="printAll();" value="Cetak" class="btn btn-default">
                            <button type="button" id="Search" onclick="getListDebt();" class="btn btn-default">Cari</button>
                          </div>
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

    <div class='row panel'>
      <div class='col-xs-12'>
        <!-- load daftar hutang -->
        <div class="panel-body table-responsive">
          <table class="table table-bordered table-striped">
            <thead>
                <tr>
                    <th width="3%">No</th>
                    <th width="10%">No. Bukti</th>
                    <!-- <th width="15%">No. Invoice</th> -->
                    <th width="20%">Vendor</th>
                    <th width="15%">Total Tagihan</th>
                    <th width="15%">Total Pembayaran</th>
                    <th width="15%">Saldo Hutang</th>
                    <th width="15%">Status Hutang</th>
                    <th class="text-center">
                      <button type="button" id="Ekspor" title="Ekspor ke excel"><i class="glyphicon glyphicon-save-file"></i></button>
                    </th>
                </tr>
            </thead>
            <tbody id="DebtList">
            </tbody>
          </table>
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
        <h4 class="modal-title">Print Detail Pembayaran</h4>
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
  $('#PrintAll').hide();
  function modalPrint(id){
    $('#modal-print').modal('show');
    $('#modal-print #frame-pdf').attr("src", "<?=base_url('DebtDetail/ReportByInvoice/')?>"+id);
  }

  function printAll(){
    $('#modal-print').modal('show');
    var id = $('#VendorId').val();
    $('#modal-print #frame-pdf').attr("src", "<?=base_url('DebtDetail/ReportByVendor/')?>"+id);
  }

  $('#VendorId').change(function(){
    vendorSelected();
    if($(this).val()){
      $('#PrintAll').show();
    }else{
      $('#PrintAll').hide();
    }
  });

  $('#Ekspor').click(function(e) {
    e.preventDefault();
    $('#DebtForm').submit();
  });

  function vendorSelected(){
    var VendorId = $('#VendorId').val();
    $.ajax({
        type: 'POST',
        url: base_url+'Payment/invoiceSelected/',
        data: {
            'VendorId': VendorId
        },
        success: function (response) {
          // console.log(response);
          data = jQuery.parseJSON(response);

          var $PenerimaanInvoiceId = $('#PenerimaanInvoiceId');
          $PenerimaanInvoiceId.empty();
          $PenerimaanInvoiceId.append('<option value="">- Semua -</option>');
          $.each(data.DataInvoiceSelected, function (i, val) {
              $PenerimaanInvoiceId.append('<option value='+data.DataInvoiceSelected[i].PenerimaanInvoiceId+' data-tokens='+data.DataInvoiceSelected[i].InvoiceNo+' '+data.DataInvoiceSelected[i].selected+'>' + data.DataInvoiceSelected[i].InvoiceNo + '</option>').selectpicker('refresh');
          });
        }
    });
  }

  function getListDebt(){
    var VendorId = $('#VendorId').val();
    var PenerimaanInvoiceId = $('#PenerimaanInvoiceId').val();
    var PaymentStatus = $('#PaymentStatus').val();
    $.ajax({
        type: 'POST',
        url: base_url+'DebtDetail/debtList/',
        data: {
            'VendorId': VendorId,
            'PenerimaanInvoiceId': PenerimaanInvoiceId,
            'PaymentStatus': PaymentStatus
        },
        success: function (response) {
          // console.log(response);
          data = jQuery.parseJSON(response);

          var $DebtList = $('#DebtList');
          $DebtList.empty();
          var no = 0;
          if(data == ""){
            var d = '<tr>';
                d+= '<td colspan="7" align="center">';
                d+= 'Data tidak ditemukan';
                d+= '</td>';
                d+= '</tr>';
            $DebtList.append(d);
          }else{
            $.each(data, function (i, val) {
              no++;
              var d = '<tr>';
                  d+= '<td align="center">'+no+'</td>';
                  d+= '<td>'+val.BillTypeCode+val.BuktiNo+'</td>';
                  // d+= '<td>'+val.InvoiceNo+'</td>';
                  d+= '<td>'+val.VendorName+'</td>';
                  d+= '<td align="right">'+formatMoney(val.TotalValue)+'</td>';
                  d+= '<td align="right">'+formatMoney(val.TotalPayment)+'</td>';
                  d+= '<td align="right">'+formatMoney(val.SaldoHutang)+'</td>';
                  d+= '<td>'+val.PaymentStatus+'</td>';
                  d+= '<td align="center"><a href="#" id="print" onclick="javascript:modalPrint(\''+val.PenerimaanInvoiceId+'\');"><i class="glyphicon glyphicon-print"></i></a></td>';
                  d+= '</tr>';
              $DebtList.append(d);
            });
          }
          $('#Search').html("Cari");
        },
        beforeSend:function(d){
          $('#Search').html("<center><img src='"+base_url+"assets/img/loading.gif' width='20px'/></center>");
        }
    });
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
