<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, shrink-to-fit=no, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Bantaeng</title>
  </head>
  <link href="<?= base_url('assets/css/bootstrap.min.css'); ?>" rel="stylesheet">
  <link rel="stylesheet" href="<?= base_url('assets/css/style-login.css'); ?>">
  <script src="<?=base_url('assets/js/jquery-2.1.4.min.js')?>"></script>
  <body>
    <div class="wrapper">
    <form class="form-monitor" action="#" name="form-monitor">
      <p class="pocn-icon">Bantaeng</p>
      <div class="form-group">
        <div class="row col-md-12">
          <div class="col-md-8">
            <input type="text" class="form-control" id="keyword" placeholder="Masukan Kode" title="Masukan Kode Bukti" />
          </div>
          <div class="col-md-4">
            <button class="btn btn-default pull-left" type="button" id="btnSearch" onclick="search();">
              &nbsp;&nbsp;Cari&nbsp;&nbsp;
            </button>
          </div>
        </div>
      </div>
    </form>
    <div class="form-monitor">
      <div class="row col-md-12">
        <div class="panel-body table-responsive" id="SearchResult">
          <!-- search result -->
         </div>
      </div>
    </div>
  </div>
  <script type="text/javascript">
    var $btnSearch = $("#btnSearch");
    function search(){
      var keyword = $("#keyword").val();
      if(keyword){
        var $SearchResult = $("#SearchResult");
        $.ajax({
          url: '<?= base_url('Monitor/Search'); ?>',
          type: 'POST',
          dataType: 'JSON',
          data: {
            keyword: keyword
          },
          success: function (res){
            $SearchResult.empty();
            markup = '';
            $.each(res, function(i, val) {
              markup+= '<div class="list-group">';
              markup+= '<a href="javascript:detailPembayaran(\''+res[i].PenerimaanInvoiceId+'\')" class="list-group-item">';
              markup+= '<table class="wd-wide">';
              markup+= '<tbody>';
              markup+= '<tr>';
              markup+= '<td>';
              markup+= '<div class="ph">';
              markup+= '<small class="text-muted">Nomor Bukti :</small>';
              markup+= '<h4 class="media-box-heading">'+res[i].BuktiNo+'</h4>';
              markup+= '</div>';
              markup+= '</td>';
              markup+= '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
              markup+= '<td>';
              markup+= '<div class="ph">';
              markup+= '<small class="text-muted">Nomor Invoice :</small>';
              markup+= '<h4 class="media-box-heading">'+res[i].InvoiceNo+'</h4>';
              markup+= '</div>';
              markup+= '</td>';
              markup+= '<td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
              markup+= '<td>';
              markup+= '<div class="ph">';
              markup+= '<small class="text-muted">Vendor :</small>';
              markup+= '<h4 class="media-box-heading">'+res[i].VendorName+'</h4>';
              markup+= '</div>';
              markup+= '</td>';
              markup+= '</tr>';
              markup+= '</tbody>';
              markup+= '</table>';
              markup+= '</a>';
              markup+= '</div>';
            });
            $SearchResult.append(markup);
            $btnSearch.html("&nbsp;&nbsp;Cari&nbsp;&nbsp;");
          },
          beforeSend:function(d){
            $btnSearch.html("<center><img src='<?=base_url('assets/img/loading.gif')?>' width='20px'/></center>");
          }
       })
       .done(function() {
         $btnSearch.html("&nbsp;&nbsp;Cari&nbsp;&nbsp;");
       })
       .fail(function() {
         $SearchResult.empty();
         markup = '';
         markup+= '<div class="list-group" style="background: #FFF;">';
         markup+= 'Hasil dari '+keyword+' tidak ditemukan';
         markup+= '</div>';
         $SearchResult.append(markup);
         $btnSearch.html("&nbsp;&nbsp;Cari&nbsp;&nbsp;");
       })
       .always(function() {
         $btnSearch.html("&nbsp;&nbsp;Cari&nbsp;&nbsp;");
       });
      }
    }

    $('#keyword').keypress(function (e) {
     var key = e.which;
     if(key == 13)  // the enter key code
      {
        search();
        return false;  
      }
    });

    function detailPembayaran(id){
      var $SearchResult = $("#SearchResult");
      var TotalPembayaran = 0;
       $.ajax({
          url: '<?= base_url('Monitor/detailPembayaran'); ?>',
          type: 'POST',
          dataType: 'JSON',
          data: {
            id: id
          },
          success: function (res){
            console.log(res);
            $SearchResult.empty();
            markup = '';
            markup+= '<div class="list-group" style="background: #FFF; border-radius:5px;">';          
            markup+= '<table class="table">';
            markup+= '<thead>';
            markup+='<tr>';
            markup+='<th colspan="2" class="text-center">Informasi Pembayaran</th>';
            markup+='</tr>';
            markup+='<tr>';
            markup+='<td>Nomor Bukti</td>';
            markup+='<td>: '+res.DataInvoice[0].BuktiNo+'</td> ';
            markup+='</tr>';
            markup+='<tr>';
            markup+='<tr>';
            markup+='<td>Nomor Invoice</td>';
            markup+='<td>: '+res.DataInvoice[0].InvoiceNo+'</td> ';
            markup+='</tr>';
            markup+='<tr>';
            markup+='<tr>';
            markup+='<td>Vendor</td>';
            markup+='<td>: '+res.DataInvoice[0].VendorName+'</td> ';
            markup+='</tr>';
            markup+='<tr>';
            markup+='<td>Total Tagihan</td>';
            markup+='<td>: '+formatMoney(res.DataInvoice[0].TotalValue)+'</td> ';
            markup+='</tr>';

        

            markup+='<tr>';
            markup+='<th colspan="2" class="text-center">Detail Pembayaran</th>';
            markup+='</tr>';
            markup+= '<tr>';
            markup+= '<td><b>Tanggal Bayar</b></td>';
            markup+= '<td align="right"><b>Nilai Bayar</b></td>';
            markup+= '</tr>';
            markup+= '</thead>';
            markup+= '<tbody id="DetailPembayaran">';

            $.each(res.DataPembayaran, function(i, val) {
              PaymentValue = formatMoney(res.DataPembayaran[i].PaymentValue);
              markup+='<tr>';
              markup+='<td>'+res.DataPembayaran[i].PaymentDate+'</td>';
              markup+='<td align="right">'+PaymentValue+'</td> ';
              markup+='</tr>';

              TotalPembayaran+=parseInt(res.DataPembayaran[i].PaymentValue);
            });

            markup+='<tr>';
            markup+='<td><b>Total Pembayaran</b></td>';
            markup+='<td align="right"><b>'+formatMoney(TotalPembayaran)+'</b></td> ';
            markup+='</tr>';
            markup+='<tr>';
            markup+='<td><b>Saldo Hutang<b></td>';
            markup+='<td align="right"><b>'+formatMoney(parseInt(res.DataInvoice[0].TotalValue-TotalPembayaran))+'</b></td> ';
            markup+='</tr>';
            
            var urllamp = '<?= base_url('upload/lampiran/'); ?>';
            var Ssp = (res.DataLampiran[0].SspLocation && res.DataLampiran[0].SspUploadDate) ? '<a href="' + urllamp + res.DataLampiran[0].SspLocation + '" target="_blank">Available</a>' : 'NA';
            var BuktiPotong = (res.DataLampiran[0].BuktiPotongLocation && res.DataLampiran[0].BuktiPotongUploadDate) ? '<a href="' + urllamp + resDataLampiran[0].BuktiPotongLocation + '" target="_blank">Available</a>' : 'NA';
            markup+='<tr>';
            markup+='<td></td>';
            markup+='<td align="right"></td> ';
            markup+='</tr>';
            markup+='<tr>';
            markup+='<td>SSP</td>';
            markup+='<td align="right">' + Ssp + '</td> ';
            markup+='</tr>';
            markup+='<td>Bukti Potong</td>';
            markup+='<td align="right">' + BuktiPotong + '</td> ';
            markup+='</tr>';
            
            markup+= '</tbody>';
            markup+= '</table>';
            markup+= '</div>';
            $SearchResult.append(markup);
          },
          beforeSend:function(d){
            $SearchResult.html("<center><img src='<?=base_url('assets/img/loading.gif')?>' width='50px'/></center>");
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
  </body>
</html>