
<!-- Main content -->
<div id='page-content-wrapper'>
  <div class='container-fluid'>
  <div class='row'>
    <div class='col-xs-12'>
      <div class="pane pane-purple">
        <div class="panel-heading"><b>Pengguna :</b></div>
          <div class="panel-body">
            <div class='box box-primary'>
              <script>
                $(function() {
                  $( "#upload" ).on("submit", function(e)
                  {
                    $("#loadingUpload").html("<img src='<?=base_url("assets/img/ajax-loader.gif");?>'>");
                    e.preventDefault();
                    console.log(new FormData(this));
                    $.ajax({
                          url     : "<?=$ArrData['action']; ?>",
                          type:"post",dataType:"html",
                          data:new FormData(this),
                          contentType:false,
                          cache:false,
                          processData:false,
                          success:function(data)
                            {
                              if (data=='' || data=='berhasil') {
                                window.location.href = '<?=base_url("/Users");?>';
                              } else {
                                alert(data);
                              }
                         },
                       });
                      });
                     });
              </script>
              <form action="<?php echo $ArrData['action']; ?>" method="post"  encytype="multipart/form-data" id="upload" class="form-horizontal">
                <div class="row">
                  <div id="message-password">
                  </div>
                  <div class="col-md-6">
                    <div class='form-group'>
                      <label class="col-md-4 control-label">Nama Lengkap :</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="name" id="name" placeholder="Nama Lengkap" value="<?php echo $ArrData['name']; ?>" <?php if($this->session->userdata('role') != 1) echo "disabled"; ?>/>
                         <?php echo form_error('name') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Username :</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="username" id="username" placeholder="Username" value="<?php echo $ArrData['username']; ?>" <?php if($this->session->userdata('role') != 1) echo "disabled"; ?>/>
                        <?php echo form_error('username') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Email :</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="email" id="email" placeholder="Email" value="<?php echo $ArrData['email']; ?>" <?php if($this->session->userdata('role') != 1) echo "disabled"; ?>/>

                        <?php echo form_error('email') ?>
                      </div>
                    </div>
                    <div class='form-group'>
                      <label class="col-md-4 control-label">Password :</label>
                      <div class='col-md-8'>
                        <input type="password" class="form-control" name="password" id="password" placeholder="password" value="<?php echo $ArrData['password']; ?>" <?php if($this->session->userdata('role') != 1) echo "disabled"; ?>/>
                        <?php echo form_error('password') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Role :</label>
                      <div class='col-md-8'>
                        <select class="selectpicker" name="role" id="role" title="- Chose -" data-width="200px" <?php if($this->session->userdata('role') != 1) echo "disabled"; ?> >
                          <option>- Pilih Role -</option>';
                          <?php
                            foreach ($DataRole as $val) {
                                    echo '<option value="'.$val->RoleId.'" '.$val->selected.'>'.$val->RoleName.'</option>';
                                }
                          ?>
                        </select>
                        <?php echo form_error('role') ?>
                      </div>
                    </div>
                    <div class='form-group'>
                      <label class="col-md-4 control-label">Jabatan :</label>
                      <div class='col-md-8'>
                        <select class="selectpicker" name="JabatanId" id="JabatanId" title="- Pilih -" data-width="200px" <?php if($this->session->userdata('role') != 1) echo "disabled"; ?> >
                          <?php
                            foreach ($DataJabatan as $val) {
                              echo '<option value="'.$val->JabatanId.'" data-tokens="'.$val->JabatanName.'" '.$val->selected.'>'.$val->JabatanCode.' - '.$val->JabatanName.'</option>';
                            }
                           ?>
                        </select>
                        <?php echo form_error('JabatanId') ?>
                      </div>
                    </div>
                    <div class='form-group'>
                      <label class="col-md-4 control-label">Hard TTD :</label>
                      <div class='col-md-8'>
                        <input type="file" id="TtdHard" name="TtdHard" disabled>
                        <?php echo form_error('TtdHard') ?>
                      </div>
                    </div>

                    <?php if ($this->uri->segment(2) == "read" || $this->uri->segment(2) == "update" || $this->uri->segment(2) == "update_action"): ?>
                    <div class="form-group">
                      <label class="col-md-4 control-label">Password Lama </label>
                      <div class="col-md-8">
                        <input type="password" class="form-control" name="oldpassword" id="oldpassword" placeholder="Masukan password lama"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4 control-label">Password Baru </label>
                      <div class="col-md-8">
                        <input type="password" class="form-control" name="newpassword" id="newpassword" placeholder="Masukan password baru"/>
                      </div>
                    </div>
                    <div class="form-group">
                      <label class="col-md-4 control-label">Konfirmasi Password </label>
                      <div class="col-md-8">
                        <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Masukan ulang password"/>
                      </div>
                    </div>
                    <?php endif; ?>

                  </div>
                </div>

                <div class="col-md-6">
                  <div id="loadingUpload"></div><div id="postUpload"></div>
                  <!--<input type="reset" class="btn btn-pocn pull-right">-->
                  <?php 
                  if($this->session->userdata('role') == 1){
                    echo '<input type="submit" class="btn btn-ok pull-right" value="Simpan">';
                  }
                  ?>
                  <?php if ($this->uri->segment(2) == "read" || $this->uri->segment(2) == "update" || $this->uri->segment(2) == "update_action"): ?>
                  <button type="button" id="changePassword" class="btn btn-ok pull-right" style="width:150px;">Perbarui Password</button>
                  <?php endif; ?>
                </div>
              </form>
            </div>
          </div>
      </div><!-- /.col -->
    <br>
    <div class="row"  <?php if ($this->uri->segment(2) == "create" || $this->uri->segment(2) == "create_action"): echo 'style="display:none;"'; endif;?>>
      <div class="col-md-12">
          <div class="pane pane-default" style="background-color: #efd7de">
            <div class="panel-heading"><b>Activity</b></div>
            <div class="panel-body">
              <table>
                <tr style="border-top: 1px solid #000; border-left: 1px solid #000; border-right: 1px solid #000;">
                  <td align="right" width="200" style="padding: 10px;">Created&nbsp;</td>
                  <td align="left" width="200" style="border-right: 1px solid #000; color: #af0c0c">: <?=$this->getdetailusers->GetById($ArrData['CreatedByUserId'], 'name')?></td>
                  <td align="right" width="200">Last Change&nbsp;</td>
                  <td align="left" width="200" style="border-right: 1px solid #000; color: #af0c0c">: <?=$this->getdetailusers->GetById($ArrData['LastChangedByUserId'], 'name')?></td>
                  <td align="right" width="200">Deleted&nbsp;</td>
                  <td align="left" width="200">: <?=$this->getdetailusers->GetById($ArrData['DeletedUserId'], 'name')?></td>
                </tr>
                <tr style="border-bottom: 1px solid #000; border-right: 1px solid #000; border-left: 1px solid #000;">
                  <td align="right" style="padding: 10px;">Created Date&nbsp;</td>
                  <td align="left" style="border-right: 1px solid #000; color: #af0c0c">: <?=$ArrData['CreatedDate']?></td>
                  <td align="right">Last Change Date&nbsp;</td>
                  <td align="left" style="border-right: 1px solid #000; color: #af0c0c">: <?=$ArrData['LastChangedDate']?></td>
                  <td align="right">Deleted Date&nbsp;</td>
                  <td align="left">: <?=$ArrData['DeletedDate']?></td>
                </tr>
              </table>
            </div>
          </div>
      </div>
    </div>
  </div>
</div>
</div>
</div>

<script type="text/javascript">
  $(document).ready(function() {
    $("#changePassword").on("click", function() {
      var userid = "<?=$ArrData['id']?>";
      var oldpassword = $('#oldpassword').val();
      var newpassword = $('#newpassword').val();
      var confirmpassword = $('#confirmpassword').val();

      $.ajax({
        url: base_url+'auth/changePassword',
        type: 'POST',
        dataType: 'json',
        data: {
          userid: userid,
          oldpassword : oldpassword,
          newpassword : newpassword,
          confirmpassword : confirmpassword
        },
        success: function(result, status, xhr) {
          alert(result.message);
        },
        error: function(xhr, status, error) {
          alert("Terjadi error silahkan hubungi administrator");
          console.log(xhr, status, error);
        }
      });
    });
  });
</script>
