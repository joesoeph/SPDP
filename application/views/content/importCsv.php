<!-- Main content -->
<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class='row'>
      <div class='col-xs-12'>
        <div class="pane pane-purple">
          <div class="panel-heading"><b>Impor Pembayaran</b></div>
          <div class="panel-body">
            <div class='box'>
              <?php echo $this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>
              <form method="post" action="<?php echo base_url('ImportCsv/importcsv') ?>" enctype="multipart/form-data" class="form-horizontal">
                <div class="form-group">
                  <div class="col-md-6">
                    <input type="file" name="userfile" class="form-control"><br>
                  </div>
                  <div class="col-md-6">
                    <input type="submit" name="submit" value="UPLOAD" class="btn btn-primary btn-sm">
                    <a href="<?=base_url('Payment')?>">
                      <button type="button" class="btn btn-default btn-sm">Kembali</button>
                    </a>
                  </div>
                </div>
              </form>
              <?php
                if($TempData) {
                  echo '<div class="table-responsive">
                          <table class="table">
                            <thead>
                              <tr>
                                <th>No Invoice</th>
                                <th>Tipe Berkas</th>
                                <th>Nomor Bukti</th>
                                <th>Vendor</th>
                                <th>Proyek</th>
                                <th>Nilai</th>
                                <th>Tgl Bayar</th>
                              </tr>
                            </thead>
                            <tbody>';
                              foreach ($TempData as $val) {
                                echo '
                                <tr>
                                  <td>'.$val->InvoiceNo.'</td>
                                  <td>'.$val->BillTypeCode.'</td>
                                  <td>'.$val->BuktiNo.'</td>
                                  <td>'.$val->VendorName.'</td>
                                  <td>'.$val->ProyekName.'</td>
                                  <td>'.number_format($val->PaymentValue).'</td>
                                  <td>'.$val->PaymentDate.'</td>
                                </tr>
                                ';
                              }
                        echo '</tbody>
                          </table>
                        </div>';
                  echo '<a href="'.base_url('ImportCsv/Validate').'">
                          <button type="button" class="btn btn-default btn-sm">Ok</button>
                        </a>';
                  echo '<a href="'.base_url('ImportCsv/Cancel').'">
                          <button type="button" class="btn btn-danger btn-sm">Batal</button>
                        </a>';
                }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>