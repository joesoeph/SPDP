<div class='navbar navbar-pocn-in' id='nav'>
  <a href='#' class='navbar-brand'>Pending Dokumen Penerimaan Invoice</a>
</div>

<?php echo $this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>

<!-- Main content -->
<div id='page-content-wrapper'>
  <div class='container-fluid'>
    <div class='row'>
      <div class='col-lg-12'>
        <div class='clearfix'></div>
        <table class="table table-bordered table-striped" id="kotak">
            <thead>
                <tr>
                    <th width="15px">No</th>
                    <th>No. Bukti</th>
                    <th>No. Invoice</th>
            		    <th>Tgl. Invoice</th>
            		    <th>Vendor</th>
                    <th>Tg. Terima</th>
            		    <th></th>
                  </tr>
              </thead>

              <tbody>
              <?php
              $start = 0;
              foreach ($ArrData as $penerimaaninvoice)
              {
                  ?>
                  <tr>
            		    <td align="center"><?php echo ++$start ?></td>
                    <td><?=$penerimaaninvoice->BillTypeCode.$penerimaaninvoice->BuktiNo;?></td>
                    <td><?=$penerimaaninvoice->InvoiceNo;?></td>
            		    <td><?=date("d F Y", strtotime($penerimaaninvoice->InvoiceDate));?></td>
            		    <td><?=$penerimaaninvoice->VendorName;?></td>
                    <td><?=date("d F Y", strtotime($penerimaaninvoice->ReceivedDate));?></td>
            		    <td style="text-align:center" width="140px">
                      <a href="#" id="print" onclick="javascript:modalPrint('<?=$penerimaaninvoice->PenerimaanInvoiceId?>');"><i class="glyphicon glyphicon-print"></i></a>
                			<?php
                      // echo anchor(site_url('penerimaanInvoice/report/'.$penerimaaninvoice->PenerimaanInvoiceId),'<i class="glyphicon glyphicon-print"></i>',array('title'=>'Print', 'id'=>'print'));
                			echo '  ';
                			echo anchor(site_url('penerimaanInvoice/update/'.$penerimaaninvoice->PenerimaanInvoiceId),'<i class="glyphicon glyphicon-pencil"></i>',array('title'=>'Edit'));
                			echo '  ';
                			echo anchor(site_url('penerimaanInvoice/delete/'.$penerimaaninvoice->PenerimaanInvoiceId),'<i class="glyphicon glyphicon-remove"></i>','title="Delete" onclick="javasciprt: return confirm(\'Are You Sure ?\')"');
                			?>
                    </td>

                  </tr>
                  <?php
                }
              ?>
              </tbody>
          </table>
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
    function modalPrint(id){
      $('#modal-print').modal('show');
      $('#modal-print #frame-pdf').attr("src", "<?=base_url('penerimaanInvoice/reportCheckList/')?>"+id);
    }
    
    function saveTtd(SppId, Approval){
    $.confirm({
        title: 'Verifikasi data..?',
        content: 'Pastikan tanda tangan sudah valid !',
        useBootstrap: false,
        offsetTop: '20',
        boxWidth: '40%',
        buttons: {
          'confirm': {
              text: 'Ya',
              keys: ['enter'],
              action: function () {
                var pngFile = (signaturePad.isEmpty()) ? $('#ttdValue').val() : signaturePad.toDataURL();
                if (!pngFile) {
                  $('#MessageTtd').html('<strong>Tanda tangan kosong</strong>');
                } else {
                  var ApprovalStatus = $('#ApprovalStatus').val();
                  var ApprovalNote   = $('#ApprovalNote').val();
                  $.ajax({
                    url: base_url+'SppPo/Ttd',
                    type: 'POST',
                    dataType: 'html',
                    data: {
                      SppId: SppId,
                      Ttd: pngFile,
                      Approval: Approval,
                      ApprovalStatus: ApprovalStatus,
                      ApprovalNote: ApprovalNote
                    },  
                    success: function(respons){
                      $('#MessageTtd').html('<strong>'+respons+'</strong>');
                      location.reload();
                    },
                    error: function(){
                      $('#MessageTtd').html('<strong>Error</strong>');
                    }
                  });
                }
              },
            },
            'cancel': {
              text: 'Batal',
              keys: ['esc']
          }
      }
    });
  }

  function submitData(SppId){
    $.confirm({
        title: 'Yakin submit data..?',
        content: 'Setelah data disubmit data akan terkunci !',
        useBootstrap: false,
        offsetTop: '20',
        boxWidth: '40%',
        buttons: {
          'confirm': {
              text: 'Ya',
              keys: ['enter'],
              action: function () {
                $.ajax({
                  url: base_url+'SppPo/LockSpp',
                  type: 'POST',
                  dataType: 'html',
                  data: {
                    SppId: SppId
                  },  
                  success: function(respons){
                    location.reload();
                    $('#submitData').html('Submit');
                  },
                  beforeSend:function(d){
                    $('#submitData').html("<center><img src='<?=base_url('assets/img/loading.gif')?>' width='20px'/></center>");
                  },
                  error: function(){
                    alert('Error');
                    $('#submitData').html('Coba lagi');
                  }
                });
              },
            },
            'cancel': {
              text: 'Batal',
              keys: ['esc']
          }
      }
    });
  }
    
</script>
