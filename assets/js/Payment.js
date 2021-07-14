$('#form-input').hide();
$('#lampiran').hide();
$btnSearch = $('#Search');

$('#PaymentDate').datepicker({
  autoclose: true,
  todayBtn: true,
  format: 'yyyy-mm-dd',
  startDate: "2010-02-14"
});

$(document).ready(function(){
  $('#PaymentValue').inputmask('decimal',
  { 'alias': 'numeric',
    'groupSeparator': ',',
    'autoGroup': true,
    'digits': 2,
    'radixPoint': ".",
    'digitsOptional': false,
    'allowMinus': false,
    'placeholder': '0'
  });

  $( "#UploadBukti" ).on("submit", function(e) {
    var PenerimaanInvoiceId = $('#PenerimaanInvoiceId').val();
    $("#divimgs" ).html("<img src='./assets/img/loading.gif'>");  
    e.preventDefault();
    console.log($(this).serializeArray());
    $.ajax({
      url     : base_url+"PenerimaanInvoice/UploadDocumentLampiran/"+PenerimaanInvoiceId,
      type:"post",
      dataType:"html",
      data:new FormData(this),
      contentType:false,
      cache:false,
      processData:false,
      success:function(data){
        $('#divimgs').html('<div class="alert alert-success">'+data+'</div>');
        $("#UploadBukti")[0].reset();
        getLampiran(PenerimaanInvoiceId);
      },
    });
  });
});

$('#InvoiceNo').val('');
$('#PaymentValue').val('');

$('#addPayment').click(function(e){
  e.preventDefault();
  addPayment();
});

$btnSearch.click(function() {
  detailPayment();
  $('#form-input').show();
  if($('#PenerimaanInvoiceId').val()){
    $('#lampiran').show();
    getLampiran($('#PenerimaanInvoiceId').val());
  }
  else
  {
     $('#lampiran').hide();
  }
});

$('#VendorId').change(function(){
  vendorSelected();
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
        $PenerimaanInvoiceId.append('<option value="">- Semua -</option>').selectpicker('refresh');
        $.each(data.DataInvoiceSelected, function (i, val) {
            $PenerimaanInvoiceId.append('<option value='+data.DataInvoiceSelected[i].PenerimaanInvoiceId+' data-tokens='+data.DataInvoiceSelected[i].InvoiceNo+' >' + data.DataInvoiceSelected[i].BillTypeCode + data.DataInvoiceSelected[i].BuktiNo + '(' + data.DataInvoiceSelected[i].InvoiceNo + ')</option>').selectpicker('refresh');
        });
      }
  });
}

$('#PenerimaanInvoiceId').change(function(){
  PenerimaanInvoiceSelected();
});

function PenerimaanInvoiceSelected(){
  var PenerimaanInvoiceId = $('#PenerimaanInvoiceId').val();
  if(PenerimaanInvoiceId)
  {
    $('#hdnSspPenerimaanInvoiceId').val(PenerimaanInvoiceId);
    $('#hdnBuktiPotongPenerimaanInvoiceId').val(PenerimaanInvoiceId); 
  }
}

function detailPayment(){
  var VendorId = $('#VendorId').val();
  var PenerimaanInvoiceId = $('#PenerimaanInvoiceId').val();
  var From = $('#From').val();
  var To = $('#To').val();
  $.ajax({
      type: 'POST',
      url: base_url+'Payment/getDetailPayment/',
      data: {
          'VendorId': VendorId,
          'PenerimaanInvoiceId' : PenerimaanInvoiceId,
          'From' : From,
          'To' : To,
      },
      success: function (response) {
        // console.log(response);
        data = jQuery.parseJSON(response);

        var markupTagihan = "";
        var markupPembayaran = "";
        var TotalTagihan = 0;
        var TotalPembayaran = 0;
        var SaldoHutang = 0;
        var InvoiceNo = 0;
        var PaymentValue = 0;
        var TotalValue = 0;
        
        $.each(data.DataInvoice, function (i, val) {

          TotalValue = formatMoney(data.DataInvoice[i].TotalValue);

          markupTagihan+="<tr>";
          markupTagihan+="<td>"+data.DataInvoice[i].InvoiceNo+"</td>";
          markupTagihan+="<td>"+data.DataInvoice[i].ReceivedDate+"</td>";
          markupTagihan+="<td align='right'>"+TotalValue+"</td>";
          markupTagihan+="</tr>";
          TotalTagihan+=parseInt(data.DataInvoice[i].TotalValue);
          InvoiceNo = data.DataInvoice[i].InvoiceNo;
        });

        $("#DetailTagihan").html(markupTagihan);
        $("#TotalTagihan").html(formatMoney(TotalTagihan));

        $.each(data.DataPembayaran, function (i, val) {
          
          PaymentValue = formatMoney(data.DataPembayaran[i].PaymentValue);

          markupPembayaran+='<tr>';
          markupPembayaran+='<td>'+data.DataPembayaran[i].PaymentDate+'</td>';
          markupPembayaran+='<td>'+data.DataPembayaran[i].InvoiceNo+'</td>';
          markupPembayaran+='<td align="right">'+PaymentValue+'</td> ';
          markupPembayaran+='<td align="right">';
          markupPembayaran+='<a href="#" onclick="return editPayment(\''+data.DataPembayaran[i].PaymentId+'\')"><i class="glyphicon glyphicon-pencil"></i></a> | ';
          markupPembayaran+='<a href="#" onclick="return deletePayment(\''+data.DataPembayaran[i].PaymentId+'\')"><i class="glyphicon glyphicon-trash"></i></a>';
          markupPembayaran+='</td>';
          markupPembayaran+='</tr>';

          TotalPembayaran+=parseInt(data.DataPembayaran[i].PaymentValue);
        });

        $('#InvoiceNo').val(InvoiceNo);
        $('#PaymentValue').val('');
        $("#DetailPembayaran").html(markupPembayaran);
        $("#TotalPembayaran").html(formatMoney(TotalPembayaran));
        $("#SaldoHutang").html(formatMoney(parseInt(TotalTagihan-TotalPembayaran)));
        $btnSearch.html("Cari");
      },
      beforeSend:function(d){
        $btnSearch.html("<center><img src='"+base_url+"assets/img/lo7.gif' width='20px'/></center>");
      }
  });
}

$('#PaymentValue').keypress(function (e) {
 var key = e.which;
 if(key == 13)  // the enter key code
  {
    addPayment();
    return false;  
  }
});

function addPayment(){
  var VendorId = $('#VendorId').val();
  var PaymentId = $('#PaymentId').val();
  var PenerimaanInvoiceId = $('#PenerimaanInvoiceId').val();
  var PaymentDate = $('#PaymentDate').val();
  var PaymentValue = $('#PaymentValue').val();
  
  $.ajax({
    type: 'POST',
    url: base_url+'Payment/create_action/',
    data: {
        'VendorId': VendorId,
        'PaymentId': PaymentId,
        'PenerimaanInvoiceId' : PenerimaanInvoiceId,
        'PaymentDate' : PaymentDate,
        'PaymentValue': PaymentValue
    },
    success: function (response) {
      // console.log(data);
      $('#response').html(response);
      $('#PaymentId').val('');
      $('#PaymentValue').val('');
      detailPayment();
      $("#addPayment").html("<i class='glyphicon glyphicon-floppy-disk'></i>");
    },
    beforeSend:function(d){
      $("#addPayment").html("<center><img src='"+base_url+"assets/img/loading.gif' width='15px'/></center>");
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

function editPayment(id){
  $.ajax({
    url: base_url+'Payment/getPaymentById/'+id,
    type: 'GET',
    dataType: 'JSON',
    success: function(res){
      $('#PaymentId').val(res.PaymentId);
      $('#PaymentDate').val(res.PaymentDate);
      $('#InvoiceNo').val(res.InvoiceNo);
      $('#PaymentValue').val(res.PaymentValue);
    }
  });
  return false;
}

function deletePayment(id){
  if(confirm('Hapus data pembayaran ?')){
    $.ajax({
      url: base_url+'Payment/delete/'+id,
      type: 'GET',
      success: function(res){
        $('#response').html(response);
        detailPayment();
      }
    });
  }
  
  return false;
}

function getLampiran(id){
  $.ajax({
    type: 'POST',
    url: base_url+'PenerimaanInvoice/GetLampiran/',
    data: {
        'PenerimaanInvoiceId': id
    },
    success: function (data) {
      var x = JSON.parse(data);
         if(x[0].SspLocation)
          {
              $('#SspAvailable').html('<a href="#" id="modalPrintSsp" onclick="javascript:modalPrintSsp();">Available</a>&nbsp;&nbsp;<a href="#" onclick="javascript:modalUploadSsp();">[Edit]</a>');
              $('#SspNotAvailable').html('');
          }
          else 
          {
              $('#SspNotAvailable').html('<a href="#" id="modalUploadSsp" onclick="javascript:modalUploadSsp();">Not Available</a>&nbsp;&nbsp;<a href="#" onclick="javascript:modalUploadSsp();">[Upload]</a>');
              $('#SspAvailable').html('');
          }
          
          if(x[0].BuktiPotongLocation)
          {
              $('#BuktiPotongAvailable').html('<a href="#" id="modalPrintBuktiPotong" onclick="javascript:modalPrintBuktiPotong();">Available</a>&nbsp;&nbsp;<a href="#" onclick="javascript:modalUploadBuktiPotong();">[Edit]</a>');
              $('#BuktiPotongNotAvailable').html('');
          }
          else
          {
              $('#BuktiPotongNotAvailable').html('<a href="#" id="modalUploadBuktiPotong" onclick="javascript:modalUploadBuktiPotong();">Not Available</a>&nbsp;&nbsp;<a href="#" onclick="javascript:modalUploadBuktiPotong();">[Upload]</a>');
              $('#BuktiPotongAvailable').html('');
          } 
      
    }
  });
}