<div id="page-content-wrapper">
  <div class="container-fluid">
    <div class='row'>
      <div class='col-xs-12'>
        <div class="pane pane-purple">
          <div class="panel-heading"><b>Panel Verifikasi Tagihan</b></div>
          <div class="panel-body">
            <div class='box'>
              <div class='box-header'>
                  <div class='box box-primary'>

              <div class="form-horizontal">
                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">BTL</label>
                  <div class="col-sm-6">
                    <span class="btn btn-pocn btn-file">
                        Add files... <input id="fileupload_1" type="file" name="files">
                    </span>

                    <input type="text" id="filename_1" name="filename_1">
                    <div id="progress_1" class="progress">
                        <div id="progress-bar_1" class="progress-bar progress-bar-success"></div>
                    </div>
                  </div>
                  <div id="files_1" class="files">
                    <button type="button" id="btnCancel_1" class="btn btn-warning" style="display: none;"><span class="glyphicon glyphicon-ban-circle"></span> Cancel</button>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">REKAPAN</label>
                  <div class="col-sm-6">
                    <span class="btn btn-pocn btn-file">
                        Add files... <input id="fileupload_2" type="file" name="files">
                    </span>

                    <input type="text" id="filename_2" name="filename_2">
                    <div id="progress_2" class="progress">
                        <div id="progress-bar_2" class="progress-bar progress-bar-success"></div>
                    </div>
                  </div>
                  <div id="files_2" class="files">
                    <button type="button" id="btnCancel_2" class="btn btn-warning" style="display: none;"><span class="glyphicon glyphicon-ban-circle"></span> Cancel</button>
                  </div>
                </div>

                <div class="form-group">
                  <label for="inputEmail3" class="col-sm-2 control-label">SCAN NOTA-NOTA</label>
                  <div class="col-sm-6">
                    <span class="btn btn-pocn btn-file">
                        Add files... <input id="fileupload_3" type="file" name="files">
                    </span>
                    <input type="text" id="filename_3" name="filename_3">
                    <div id="progress_3" class="progress">
                        <div id="progress-bar_3" class="progress-bar progress-bar-success"></div>
                    </div>
                  </div>
                  <div id="files_3" class="files">
                    <button type="button" id="btnCancel_3" class="btn btn-warning" style="display: none;"><span class="glyphicon glyphicon-ban-circle"></span> Cancel</button>
                  </div>
                </div>

                <div class="form-group">
                  <div class="col-sm-offset-2 col-sm-10">
                    <input type="submit" id="btnVerifikasiSubmit" class="btn btn-one pull-right" value="Simpan">
                  </div>
                </div>
              </div>

            </div>
         </div>
       </div>
     </div>
   </div>
 </div>
</div>
</div>
</div>

        <script src="<?=base_url('public/master/BTLVerifikasiInvoice.js')?>"></script>
