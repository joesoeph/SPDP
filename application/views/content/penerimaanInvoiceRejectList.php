<!-- css rata tengah column datatable -->
<style type="text/css">
    #kotak td:nth-child(1),
    #kotak td:nth-child(7)
    {
        text-align : center;
    }
</style>
<?php echo $this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>

<!-- Main content -->
<div id='page-content-wrapper'>
  <div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="#"><i class="glyphicon glyphicon-thumbs-up"></i> Tagihan & Verifikasi</a></li>
            <li class="active">Invoice Reject</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
  </div>
  <div class='container-fluid'>
    <div class='row panel'>
      <div class='col-lg-12'>
    <?php //echo anchor(site_url('penerimaanInvoice/create/'),' <i class="glyphicon glyphicon-plus"></i> Tambah','class="btn btn-pocn"');?>
        <div class='clearfix'></div>
        <div class="panel-body table-responsive">
          <table class="table table-bordered table-hover" id="kotak" width="100%" cellspacing="0">
            <thead>
                <tr>
                    <th width="15px">No</th>
                    <th>No. Bukti</th>
                    <th>No. Invoice</th>
                    <th>Vendor</th>
                    <th>Tgl. Masuk</th>
                    <th>Telah Riject Oleh</th>
                    <th></th>
                  </tr>
              </thead>

              <tbody>
              <!-- list data -->
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

  $(document).ready(function() {
    //datatables list
    var tablelist = $('#kotak').DataTable({

        "processing": true,
        "serverSide": true,
        "order": [],
        "oLanguage": {
            "sSearch": "<i class='fa fa-search fa-fw'></i> Search : ",
            "sLengthMenu": "_MENU_ &nbsp;&nbsp;Data Per Page",
            "sInfo": "Showing _START_ s/d _END_ from _TOTAL_ data",
            "sInfoFiltered": "(filtered from _MAX_ total data)",
            "sZeroRecords": "Result not found",
            "sEmptyTable": "Data empty",
            "sLoadingRecords": "<center><img src='"+base_url+"assets/img/loading.gif' width='20px'/></center>",
            "sProcessing": "<center><img src='"+base_url+"assets/img/loading.gif' width='20px'/></center>",
        },

        // Load data pake Ajax source
        "ajax": {
            "url": base_url+'PenerimaanInvoice/ListDataReject',
            "type": "POST",
            error: function(){
                $(".my-grid-error").html("");
                $("#my-grid").append('<tbody class="my-grid-error"><tr><td colspan="6">Data not found</td></tr></tbody>');
                $("#my-grid_processing").css("display","none");
            }
        },

        //set properties datatablenya
        "columnDefs": [
        {
            "targets": [ 0 ],
            "orderable": true,
        },
        ],
    });

});
</script>
