<?php echo $this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>
<!-- Main content -->
<div id="page-content-wrapper">
    <div class="row">
        <div class="col-md-12">
            <!--breadcrumbs start -->
            <ul class="breadcrumb">
                <li><a href="#"><i class="glyphicon glyphicon-hdd"></i> Data Master</a></li>
                <li class="active">Tipe Pembayaran</li>
            </ul>
            <!--breadcrumbs end -->
        </div>
      </div>
      <div class="container-fluid">
        <div class='row panel'>
          <div class="col-lg-12">
            <?php echo anchor(site_url('PaymentType/create/'),' <i class="glyphicon glyphicon-plus"></i> Tambah','class="btn btn-pocn"');?>
            <div class="clearfix"></div>
            <table id="kotak" class="table table-bordered table-striped">
              <thead>
                  <tr>
                        <th>No</th>
                        <th>Kode Tipe Pembayaran</th>
                        <th>Nama Pembayaran</th>
                        <th></th>
                  </tr>
              </thead>
            <tbody>
              <?php
              foreach ($ArrData['data'] as $val)
                {
                    ?>
                    <tr>
                            <td width="80px"><?php echo ++$ArrData['start'] ?></td>
                            <td><?php echo $val->PaymentTypeCode ?></td>
                            <td><?php echo $val->PaymentTypeName ?></td>
                            <td style="text-align:center" width="200px">
                                <?php
                        echo anchor(site_url('PaymentType/read/'.$val->PaymentTypeId),'<i class="glyphicon glyphicon-eye-open"></i>',array('title'=>'detail'));
                            echo '  ';
                            echo anchor(site_url('PaymentType/update/'.$val->PaymentTypeId),'<i class="glyphicon glyphicon-pencil"></i>',array('title'=>'edit'));
                            echo '  ';
                            echo anchor(site_url('PaymentType/delete/'.$val->PaymentTypeId),'<i class="glyphicon glyphicon-remove"></i>','title="delete" onclick="javasciprt: return confirm(\'Anda yakin ?\')"');
                                ?>
                            </td>
                        </tr>
                    <?php
                }
                ?>
            </tbody>
          </table>
        </div><!-- /.col -->
      </div>
    </div>
</div>
