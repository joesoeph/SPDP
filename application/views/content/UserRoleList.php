<!-- css rata tengah column datatable -->
<style type="text/css">
    #table-list td:nth-child(3)
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
                <li><a href="#"><i class="glyphicon glyphicon-wrench"></i> Pengaturan</a></li>
                <li class="active">Hak Akses</li>
            </ul>
            <!--breadcrumbs end -->
        </div>
      </div>
      <div class='container-fluid'>
        <div class='row panel'>
          <div class='col-lg-12'>
            <header class="panel-heading">
                <a href="javascript:formModal();" class="btn btn-ok btn-sm" id="link">
                    <i class="fa fa-plus"></i>
                    <span class="link-title">Add</span>
                </a>
            </header>
            <div class='clearfix'></div>
            <div class="panel-body table-responsive">
                <table id="table-list" class="table table-hover table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Role</th>
                            <th width="60%">Description</th>
                            <th width="10%"></th>
                        </tr>
                    </thead>
                    <tbody id="ListData">
                        <!-- load list data -->
                    </tbody>
                </table>
            </div>
        </div>
      </div>
    </div>
</div>

<div aria-hidden="true" aria-labelledby="myModalLabel" role="dialog" tabindex="-1" id="formModal" class="modal fade">
  <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button>
              <h4 class="modal-title">Form Role Access</h4>
          </div>
          <div class="modal-body">
              <!-- load modal -->
          </div>
      </div>
  </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        //datatables list
        var tablelist = $('#table-list').DataTable({

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
                "oPaginate": {
                    "sPrevious": "<button class='btn btn-default'><i class='fa fa-caret-left'></i></button>",
                    "sNext": "<button class='btn btn-default'><i class='fa fa-caret-right'></i></button>"
                }
            },

            // Load data pake Ajax source
            "ajax": {
                "url": base_url+'UserRoles/ListData',
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

    function formModal(id){
        $("#formModal").modal();
        $.ajax({
            url: base_url+'UserRoles/FormModal',
            type: 'POST',
            dataType: 'HTML',
            cache : false,
            data: {'id': id},
            success: function(res){
                $(".modal-body").html(res);
            },
            beforeSend:function(d){
                $('.modal-body').html("<center><img src='"+base_url+"assets/img/loading.gif' width='20px'/></center>");
            }
        }); 
    }

    function saveData(){
        $form = $("form[name=formModal]");
        var action = $form.attr('action');        
        var method = $form.attr('method');
        var data   = $form.serializeArray();
        // console.log(data);
        $.ajax({
          type: method,
          url: action,
          data : data,
          dataType : 'JSON',
          success: function(res){
            if(res.res){
                $('#status').html('<div class="alert alert-success">'+res.msg+'</div>');
                dt = $('#table-list').dataTable();
                dt.fnDraw();
            }else{
                $('#status').html('<div class="alert alert-warning">'+res.msg+'</div>');
            }
          },
          beforeSend:function(d){
            $('#status').html("<center><img src='"+base_url+"assets/img/loading.gif' width='20px'/></center>");
          }
        });
                      
    }
</script>
