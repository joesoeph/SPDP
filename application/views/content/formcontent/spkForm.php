<script type="text/javascript">
  tinymce.init({
    mode : "specific_textareas",
    editor_selector : "Description",
    height: 200,
    plugins: 'table',
    style_formats: [
      { title: 'Bold text', inline: 'strong' },
      { title: 'Red text', inline: 'span', styles: { color: '#ff0000' } },
      { title: 'Red header', block: 'h1', styles: { color: '#ff0000' } },
      { title: 'Badge', inline: 'span', styles: { display: 'inline-block', border: '1px solid #2276d2', 'border-radius': '5px', padding: '2px 5px', margin: '0 2px', color: '#2276d2' } },
      { title: 'Table row 1', selector: 'tr', classes: 'tablerow1' }
    ],
    formats: {
      alignleft: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'left' },
      aligncenter: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'center' },
      alignright: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'right' },
      alignfull: { selector: 'p,h1,h2,h3,h4,h5,h6,td,th,div,ul,ol,li,table,img', classes: 'full' },
      bold: { inline: 'span', 'classes': 'bold' },
      italic: { inline: 'span', 'classes': 'italic' },
      underline: { inline: 'span', 'classes': 'underline', exact: true },
      strikethrough: { inline: 'del' },
      customformat: { inline: 'span', styles: { color: '#00ff00', fontSize: '20px' }, attributes: { title: 'My custom format' }, classes: 'example1' },
    },
    menubar:false,
    statusbar: false,
    toolbar: false,
    readonly : ('<?=$ArrData['attribute']?>' == 'disabled' ? 1 : 0)
  });
</script>
<!-- Main content -->
<div id='page-content-wrapper'>
  <div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="#"><i class="glyphicon glyphicon-edit"></i> Perjanjian</a></li>
            <li class="active">SPK</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
  </div>
  <div class='container-fluid'>
    <div class='row'>
      <div class="pane pane-purple">
        <div class="panel-heading">
          <b>Form SPK</b>
        </div>
        <div class="panel-body">
          <div class='col-xs-12'>
            <div class='box box-primary'>
              <?=$this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>

              <form action='<?php echo $ArrData['action']; ?>' method='post' class='form-horizontal'>

                <div class="row">
                  <div class="col-md-6">

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Proyek&nbsp;:</label>
                      <div class='col-md-8'>
                        <select class="selectpicker" name="ProyekId" id="ProyekId" title="- Pilih -" data-show-subtext="true" data-live-search="true" data-width="100%" <?=$ArrData['attribute']?>>
                          <?php
                            foreach ($DataProyek as $val) {
                              echo '<option value="'.$val->ProyekId.'" data-tokens="'.$val->ProyekName.'" '.$val->selected.'>'.$val->ProyekCode.' - '.$val->ProyekName.'</option>';
                            }
                           ?>
                        </select>
                        <?php echo form_error('ProyekId') ?>
                      </div>
                    </div>
                    
                    <div class='form-group'>
                      <label class="col-md-4 control-label">Nama/Mandor&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="Foreman" id="Foreman" placeholder="" value="<?php echo $ArrData['Foreman']; ?>" <?=$ArrData['attribute']?>/>
                        <?php echo form_error('Foreman') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Alamat&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="Address" id="Address" placeholder="" value="<?php echo $ArrData['Address']; ?>" <?=$ArrData['attribute']?>/>
                        <?php echo form_error('Address') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Jenis Pekerjaan&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="WorkType" id="WorkType" placeholder="" value="<?php echo $ArrData['WorkType']; ?>" <?=$ArrData['attribute']?>/>
                        <?php echo form_error('WorkType') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Lokasi Pekerjaan&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="WorkPlace" id="WorkPlace" placeholder="" value="<?php echo $ArrData['WorkPlace']; ?>" <?=$ArrData['attribute']?>/>
                        <?php echo form_error('WorkPlace') ?>
                      </div>
                    </div>

                  </div>

                  <div class="col-md-6">

                    <div class='form-group'>
                      <label class="col-md-4 control-label">NO&nbsp;:</label>
                      <div class='col-md-3'>
                        <input type="text" class="form-control" name="SpkNoUrut" id="SpkNoUrut" placeholder="" value="<?php echo $ArrData['SpkNoUrut']; ?>" readonly <?=$ArrData['attribute']?>/>
                        <?php echo form_error('SpkNoUrut') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">No SPK&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="SpkNo" id="SpkNo" placeholder="" value="<?php echo $ArrData['SpkNo']; ?>" <?=$ArrData['attribute']?>/>
                        <?php echo form_error('SpkNo') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Tgl. SPK&nbsp;:</label>
                      <div class='col-md-5'>
                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                            <input type="text" class="form-control" name="DateSpk" id="DateSpk" placeholder="" value="<?php echo $ArrData['DateSpk']; ?>" <?=$ArrData['attribute']?>>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                        <?php echo form_error('DateSpk') ?>
                      </div>
                    </div>

                  </div>

                  <div class='form-group'>
                    <div class='col-md-12'>
                      <button type="button" class="add-row pull-right" name="button" <?=$ArrData['attribute']?>>
                        <i class="glyphicon glyphicon-plus"></i>
                      </button>
                      <div class="table-responsive">
                        <table class="table" id="SeqSpk">
                          <thead>
                            <tr>
                              <th width="20" class="text-center">NO</th>
                              <th width="50" class="text-center">WBS</th>
                              <th width="200" class="text-center">PEKERJAAN</th>
                              <th width="50" class="text-center">SATUAN</th>
                              <th width="20" class="text-center">VOLUME</th>
                              <th width="100" class="text-center">HARGA SATUAN</th>
                              <th width="100" class="text-center">TOTAL</th>
                            </tr>
                          </thead>
                          <tbody>
                            <?php
                              $n = 0;
                              if($SeqSpk){
                                foreach ($SeqSpk as $val) {
                                  $n++;
                                  echo "
                                    <tr>
                                      <td><input onkeyup='sum()' type='text' class='form-control' value='".$n."' ".$ArrData['attribute']."></td>
                                      <td><input onkeyup='sum()' type='text' class='form-control' name='WbsCode[".$n."]' id='WbsCode".$n."' placeholder='WbsCode' value='".$val->WbsCode."' ".$ArrData['attribute']."></td>
                                      <td><input type='text' class='form-control' rows='2' name='Working[".$n."]' id='Working".$n."' placeholder='Working' value='".$val->Working."' ".$ArrData['attribute']."/></td>
                                      <td><input onkeyup='sum()' type='text' class='form-control' name='Unit[".$n."]' id='Unit".$n."' placeholder='Unit' value='".$val->Unit."' ".$ArrData['attribute']."></td>
                                      <td><input onkeyup='sum()' type='text' class='form-control' name='Volume[".$n."]' id='Volume".$n."' placeholder='Volume' value='".$val->Volume."' ".$ArrData['attribute']."></td>
                                      <td><input onkeyup='sum()' type='text' class='form-control Amount' name='UnitPrice[".$n."]' id='UnitPrice".$n."' placeholder='Unit Price' value='".$val->UnitPrice."' ".$ArrData['attribute']."></td>
                                      <td><input onkeyup='sum()' type='text' class='form-control Amount' name='TotalAmount[".$n."]' id='TotalAmount".$n."' placeholder='TotalAmount' value='".$val->TotalAmount."' ".$ArrData['attribute']."></td>
                                    </tr>
                                  ";
                                }
                              }
                            ?>

                          </tbody>
                          <tfoot>
                            <tr>
                              <th colspan="5" class="text-right"> Jumlah</th>
                              <th colspan="2">
                                <input type="text" class="form-control" onKeyPress="tandaPemisahTitik(this);" name="TotalValue" id="TotalValue" value="<?php echo $ArrData['TotalValue']; ?>" readonly <?=$ArrData['attribute']?>/>
                              </th>
                            </tr>
                          </tfoot>
                        </table>
                        <input type="hidden" id="row" name="row" value="<?=$n?>">
                      </div>
                      <?php echo form_error('SeqSpk') ?>
                    </div>
                  </div>

                </div>

                <div class="row">
                  <div class="pane pane-default" style="background-color: #efd7de">
                    <div class="col-md-6" style="margin-top: 10px;">
                      <div class='form-group'>
                        <label class="col-md-4 control-label">Penanggung Jawab 1&nbsp;:</label>
                        <div class='col-md-8'>
                          <select class="selectpicker" name="Giver1" id="Giver1" title="- Pilih -" data-show-subtext="true" data-live-search="true" data-width="100%" <?=$ArrData['attribute']?>>
                            <?php
                              foreach ($Giver1 as $val) {
                                echo '<option value="'.$val->id.'" data-tokens="'.$val->name.'" '.$val->selected.'>'.$val->name.' ('.$val->JabatanName.')</option>';
                              }
                             ?>
                          </select>
                          <?php echo form_error('Giver1') ?>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6" style="margin-top: 10px;">
                      <div class='form-group'>
                        <label class="col-md-4 control-label">Penanggung Jawab 2&nbsp;:</label>
                        <div class='col-md-8'>
                          <select class="selectpicker" name="Giver2" id="Giver2" title="- Pilih -" data-show-subtext="true" data-live-search="true" data-width="100%" <?=$ArrData['attribute']?>>
                            <?php
                              foreach ($Giver2 as $val) {
                                echo '<option value="'.$val->id.'" data-tokens="'.$val->name.'" '.$val->selected.'>'.$val->name.' ('.$val->JabatanName.')</option>';
                              }
                             ?>
                          </select>
                          <?php echo form_error('Giver2') ?>
                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="col-md-12">
                    <div class='form-group'>
                      <label class="col-md-2 control-label">Term of condition :</label>
                      <div class='col-md-10'>
                        <textarea class="form-control Description" rows="3" name="Term"><?php echo $ArrData['Term']; ?></textarea>
                      </div>
                    </div>
                  </div>

                <?php 
                if ($ArrData['SpkId'] && $ArrData['LockDate'] != NULL) {
                  if($DataVerifycationStatus && $DataVerifycationStatus[0]['Status'] != 1){
                    if($DataVerifycationStatus[0]['JabatanId'] == $this->session->userdata('jabatanid')){
                ?>
                <div class="col-md-6">
                  <div class="pane" style="background-color:#F6F6F6;">
                    <div class="panel-heading"><b>Verikator</b></div>
                    <div class="panel-body">
                      <div class='box box-primary'>
                        <div class="row">
                          <div class="col-md-12">
                            <div class='form-group'>
                              <label class="col-md-3 control-label">Status :</label>
                              <div class='col-md-4'>
                                <select class="selectpicker" name="ApprovalStatus" id="ApprovalStatus" data-show-subtext="false" data-live-search="false" data-width="100%">
                                  <option value="0" <?=($DataVerifycationStatus[0]['Status'] == NULL ? "selected" : "")?>>Menunggu</option>
                                  <option value="1" <?=($DataVerifycationStatus[0]['Status'] == 1 ? "selected" : "")?>>Terima</option>
                                  <option value="2" <?=($DataVerifycationStatus[0]['Status'] == 2 ? "selected" : "")?>>Tolak</option>
                                  <option value="3" <?=($DataVerifycationStatus[0]['Status'] == 3 ? "selected" : "")?>>Revisi</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row" style="margin-top: 10px;">
                          <div class="col-md-12">
                            <div class='form-group'>
                              <label class="col-md-3 control-label">Catatan :</label>
                              <div class='col-md-9'>
                                <textarea class="form-control" name="ApprovalNote" id="ApprovalNote"><?=$DataVerifycationStatus[0]['Note']?></textarea>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                            <div id="signature-pad" class="m-signature-pad">
                              <div class="m-signature-pad--body">
                                <input type="hidden" id="ttdValue" value="<?=$DataVerifycationStatus[0]['Ttd']?>">
                                <img src="<?=$DataVerifycationStatus[0]['Ttd']?>" width="100%" id="ttdImage">
                                <canvas></canvas>
                              </div>
                              <div class="m-signature-pad--footer">
                                <div class="description">Tanda tangan</div>
                                <div class="description" id="MessageTtd"></div>
                                <div class="left">
                                  <button type="button" class="button clear" data-action="clear">
                                    <i class="glyphicon glyphicon-trash"></i>
                                    Kosongkan TTD
                                  </button>
                                </div>
                                <div class="right">
                                  <button type="button" class="button save" data-action="save-png"  onclick="saveTtd('<?=$ArrData['SpkId']?>', 3)">
                                    <i class="glyphicon glyphicon-floppy-disk"></i>
                                    Verifikasi
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- verifikasi status spp -->
                      </div>
                    </div>
                  </div>
                </div>
                <?php 
                    }
                  }else if(!$DataVerifycationStatus || ($DataVerifycationStatus && $DataVerifycationStatus[0]['Status'] == 1)){
                    if($ArrData['Giver1'] == $this->session->userdata('user_id') && ((!$ArrData['Approval1Status'] || !$ArrData['Approval2Status'] || $ArrData['Approval1Status'] == 3 || $ArrData['Approval2Status'] == 3))){
                ?>
                <div class="col-md-6">
                  <div class="pane" style="background-color:#F6F6F6;">
                    <div class="panel-heading"><b>Approver 1</b></div>
                    <div class="panel-body">
                      <div class='box box-primary'>
                        <div class="row">
                          <div class="col-md-12">
                            <div class='form-group'>
                              <label class="col-md-3 control-label">Status :</label>
                              <div class='col-md-4'>
                                <select class="selectpicker" name="ApprovalStatus" id="ApprovalStatus" data-show-subtext="false" data-live-search="false" data-width="100%">
                                  <option value="0" <?=($ArrData['Approval1Status'] == 0 ? "selected" : "")?>>Menunggu</option>
                                  <option value="1" <?=($ArrData['Approval1Status'] == 1 ? "selected" : "")?>>Terima</option>
                                  <option value="2" <?=($ArrData['Approval1Status'] == 2 ? "selected" : "")?>>Tolak</option>
                                  <option value="3" <?=($ArrData['Approval1Status'] == 3 ? "selected" : "")?>>Revisi</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row" style="margin-top: 10px;">
                          <div class="col-md-12">
                            <div class='form-group'>
                              <label class="col-md-3 control-label">Catatan :</label>
                              <div class='col-md-9'>
                                <textarea class="form-control" name="ApprovalNote" id="ApprovalNote"><?=$ArrData['Approval1Note']?></textarea>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                            <div id="signature-pad" class="m-signature-pad">
                              <div class="m-signature-pad--body">
                                <input type="hidden" id="ttdValue" value="<?=$ArrData['Approval1Ttd']?>">
                                <img src="<?=$ArrData['Approval1Ttd']?>" width="100%" id="ttdImage">
                                <canvas></canvas>
                              </div>
                              <div class="m-signature-pad--footer">
                                <div class="description">Tanda tangan</div>
                                <div class="description" id="MessageTtd"></div>
                                <div class="left">
                                  <button type="button" class="button clear" data-action="clear">
                                    <i class="glyphicon glyphicon-trash"></i>
                                    Kosongkan TTD
                                  </button>
                                </div>
                                <div class="right">
                                  <button type="button" class="button save" data-action="save-png"  onclick="saveTtd('<?=$ArrData['SpkId']?>', 1)">
                                    <i class="glyphicon glyphicon-floppy-disk"></i>
                                    Verifikasi
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- verifikasi status spp -->
                      </div>
                    </div>
                  </div>
                </div>
                <?php 
                } elseif ($ArrData['Giver2'] == $this->session->userdata('user_id') && ((!$ArrData['Approval1Status'] || !$ArrData['Approval2Status'] || $ArrData['Approval1Status'] == 3 || $ArrData['Approval2Status'] == 3))){

                ?>
                <div class="col-md-6">
                  <div class="pane" style="background-color:#F6F6F6;">
                    <div class="panel-heading"><b>Approver 2</b></div>
                    <div class="panel-body">
                      <div class='box box-primary'>
                        <div class="row">
                          <div class="col-md-12">
                            <div class='form-group'>
                              <label class="col-md-3 control-label">Status :</label>
                              <div class='col-md-4'>
                                <select class="selectpicker" name="ApprovalStatus" id="ApprovalStatus" data-show-subtext="false" data-live-search="false" data-width="100%">
                                  <option value="0" <?=($ArrData['Approval2Status'] == 0 ? "selected" : "")?>>Menunggu</option>
                                  <option value="1" <?=($ArrData['Approval2Status'] == 1 ? "selected" : "")?>>Terima</option>
                                  <option value="2" <?=($ArrData['Approval2Status'] == 2 ? "selected" : "")?>>Tolak</option>
                                  <option value="3" <?=($ArrData['Approval2Status'] == 3 ? "selected" : "")?>>Revisi</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row" style="margin-top: 10px;">
                          <div class="col-md-12">
                            <div class='form-group'>
                              <label class="col-md-3 control-label">Catatan :</label>
                              <div class='col-md-9'>
                                <textarea class="form-control" name="ApprovalNote" id="ApprovalNote"><?=$ArrData['Approval2Note']?></textarea>
                              </div>
                            </div>
                          </div>
                        </div>

                        <div class="row">
                          <div class="col-md-12">
                            <div id="signature-pad" class="m-signature-pad">
                              <div class="m-signature-pad--body">
                                <input type="hidden" id="ttdValue" value="<?=$ArrData['Approval2Ttd']?>">
                                <img src="<?=$ArrData['Approval2Ttd']?>" width="100%" id="ttdImage">
                                <canvas></canvas>
                              </div>
                              <div class="m-signature-pad--footer">
                                <div class="description">Tanda tangan</div>
                                <div class="description" id="MessageTtd"></div>
                                <div class="left">
                                  <button type="button" class="button clear" data-action="clear">
                                    <i class="glyphicon glyphicon-trash"></i>
                                    Kosongkan TTD
                                  </button>
                                </div>
                                <div class="right">
                                  <button type="button" class="button save" data-action="save-png" onclick="saveTtd('<?=$ArrData['SpkId']?>', 2)">
                                    <i class="glyphicon glyphicon-floppy-disk"></i>
                                    Verifikasi
                                  </button>
                                </div>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <!-- verifikasi status spp -->
                      </div>
                    </div>
                  </div>
                </div>
                <?php 
                  } 

                  if (($ArrData['Approval1Status'] && $ArrData['Approval2Status']) && ($ArrData['Approval1Status'] != 3 && $ArrData['Approval2Status'] != 3)){
                ?>
                <div class="col-md-6">
                  <div class="pane" style="background-color:#F6F6F6;">
                    <div class="panel-heading"><b>Approver 1</b></div>
                    <div class="panel-body">
                      <div class='box box-primary'>
                        <div class="row">
                          <div class="col-md-12">
                            <div class='form-group'>
                              <label class="col-md-3 control-label">Status :</label>
                              <div class='col-md-4'>
                                <select class="selectpicker" name="Approval1Status" id="Approval1Status" data-show-subtext="false" data-live-search="false" data-width="100%" disabled>
                                  <option value="0" <?=($ArrData['Approval1Status'] == 0 ? "selected" : "")?>>Menunggu</option>
                                  <option value="1" <?=($ArrData['Approval1Status'] == 1 ? "selected" : "")?>>Terima</option>
                                  <option value="2" <?=($ArrData['Approval1Status'] == 2 ? "selected" : "")?>>Tolak</option>
                                  <option value="3" <?=($ArrData['Approval1Status'] == 3 ? "selected" : "")?>>Revisi</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-md-12">
                            <div class='form-group'>
                              <label class="col-md-3 control-label">Catatan :</label>
                              <div class='col-md-9'>
                                <textarea class="form-control" name="Approval1Note" id="Approval1Note" disabled><?=$ArrData['Approval1Note']?></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- verifikasi status invoice -->
                      </div>
                    </div>
                  </div>
                </div>
                <div class="col-md-6">
                  <div class="pane" style="background-color:#F6F6F6;">
                    <div class="panel-heading"><b>Approver 2</b></div>
                    <div class="panel-body">
                      <div class='box box-primary'>
                        <div class="row">
                          <div class="col-md-12">
                            <div class='form-group'>
                              <label class="col-md-3 control-label">Status :</label>
                              <div class='col-md-4'>
                                <select class="selectpicker" name="Approval2Status" id="Approval2Status" data-show-subtext="false" data-live-search="false" data-width="100%" disabled>
                                  <option value="0" <?=($ArrData['Approval2Status'] == 0 ? "selected" : "")?>>Menunggu</option>
                                  <option value="1" <?=($ArrData['Approval2Status'] == 1 ? "selected" : "")?>>Terima</option>
                                  <option value="2" <?=($ArrData['Approval2Status'] == 2 ? "selected" : "")?>>Tolak</option>
                                  <option value="3" <?=($ArrData['Approval2Status'] == 3 ? "selected" : "")?>>Revisi</option>
                                </select>
                              </div>
                            </div>
                          </div>
                        </div>
                        
                        <div class="row">
                          <div class="col-md-12">
                            <div class='form-group'>
                              <label class="col-md-3 control-label">Catatan :</label>
                              <div class='col-md-9'>
                                <textarea class="form-control" name="Approval2Note" id="Approval2Note" disabled><?=$ArrData['Approval2Note']?></textarea>
                              </div>
                            </div>
                          </div>
                        </div>
                        <!-- verifikasi status invoice -->
                      </div>
                    </div>
                  </div>
                </div>
                <?php 
                  }
                }
              }
                ?>

                <div class="row">
                  <div class="col-md-12">
                    <div class='form-action'>
                    <div class="MessageApproval"></div>
                      <?php
                        if(($ArrData['Approval1Status'] && $ArrData['Approval2Status']) && ($ArrData['Approval1Status'] != 3 && $ArrData['Approval2Status'] != 3)){
                          echo '<a href="#" id="print" class="btn btn-cl pull-right" onclick="javascript:modalPrint(\''.$ArrData['SpkId'].'\');">
                                  <i class="glyphicon glyphicon-print"></i> Print
                                </a>';
                        }else{
                          if($ArrData['button'] && $ArrData['LockDate'] == NULL){
                              if($this->session->userdata('role') != 9)
                              {
                                 echo '<button type="submit" class="btn btn-one pull-right">'.$ArrData['button'].'</button>'; 
                              }
                          }
                        }
                      ?>
                      <a href='<?php echo site_url('Spk') ?>' class='btn btn-pocn pull-right'>Kembali</a>
                    </div>
                  </div>
                </div>

              </form>
            </div>
          </div>
          <?php
          if ($ArrData['SpkId'] && $ArrData['LockDate'] == NULL) {
            if($DataVerifycationStatus && $DataVerifycationStatus[0]['Status'] == 3){
              echo '
              <div class="row">
                <div class="col-md-12">
                  Catatan verifikator : '.$DataVerifycationStatus[0]['Note'].' 
                </div>
              </div>
              ';
            }

            if($ArrData['Approval1Status'] == 3 || $ArrData['Approval2Status'] == 3){
              echo '
              <div class="row">
                <div class="col-md-12">
                  Catatan Approver 1 : '.$ArrData['Approval1Note'].'
                  <br> 
                  Catatan Approver 2 : '.$ArrData['Approval2Note'].' 
                </div>
              </div>
              ';
            }
          }

          if($ArrData['SpkId'] && $ArrData['LockDate'] == NULL){
              if($this->session->userdata('role') != 9)
              {
                echo '
                <div class="panel-heading text-center">
                  <button type="button" class="btn btn-default" id="submitData" onclick="submitData(\''.$ArrData['SpkId'].'\')">Submit</button>
                </div>';
              }
          }
          ?>
        </div>
      </div><!-- /.col -->
    </div>
  </div>
    <br>
    <div class="row" <?php if ($this->uri->segment(2) == "create" || $this->uri->segment(2) == "create_action"): echo 'style="display:none;"'; endif;?>>
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

<!-- Modal -->
<div id="modal-print" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content modal-dialog modal-lg">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Print SPK</h4>
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
    // $('.datepicker').datepicker({
    //   autoclose: true,
    //   todayBtn: true,
    //   startDate: "2010-02-14"
    // });

    sum();

    $(".add-row").click(function(){
      var row = $('#row').val();
      row++;
      $('#row').val(row);
        var markup = "<tr>";
        markup+="<td><input type='text' class='form-control' value='"+row+"'></td>";
        markup+="<td><input onkeyup=\"sum()\" type='text' class='form-control' name='WbsCode["+row+"]' id='WbsCode"+row+"' placeholder='WbsCode' value=''></td>";
        markup+="<td><input onkeyup=\"sum()\" type='text' class='form-control' name='Working["+row+"]' id='Working"+row+"' placeholder='Working' value=''></td>";
        markup+="<td><input onkeyup=\"sum()\" type='text' class='form-control' name='Unit["+row+"]' id='Unit"+row+"' placeholder='Unit' value=''></td>";
        markup+="<td><input onkeyup=\"sum()\" type='text' class='form-control' name='Volume["+row+"]' id='Volume"+row+"' placeholder='Volume' value=''></td>";
        markup+="<td><input onkeyup=\"sum()\" type='text' class='form-control Amount' name='UnitPrice["+row+"]' id='UnitPrice"+row+"' placeholder='Unit Price' value=''></td>";
        markup+="<td><input onkeyup=\"sum()\" type='text' class='form-control Amount' name='TotalAmount["+row+"]' id='TotalAmount"+row+"' placeholder='TotalAmount' value=''></td>";
        markup+="</tr>";
        $("#SeqSpk").append(markup);
    });


    function sum(){
        var row   = $('#row').val();
        var Total = 0;
        var Amount= 0;

        for(var i=1; i<=row; i++){
            if($('#Volume'+i).val() || $('#UnitPrice'+i).val()){
                a = parseInt(parseCurrency($('#Volume'+i).val()));
                b = parseInt(parseCurrency($('#UnitPrice'+i).val()));
                Amount = (a * b);
                $('#TotalAmount'+i).val(Amount);
                Total+=parseInt(parseCurrency($('#TotalAmount'+i).val()));
            }
        }

        $('#TotalValue').val(Total);
    }

    function parseCurrency( num ) {
        return parseFloat( num.replace( /,/g, '') );
    }

    $(document).ready(function(){
      $('#TotalValue, .Amount').inputmask('decimal',
      { 'alias': 'numeric',
        'groupSeparator': ',',
        'autoGroup': true,
        'digits': 2,
        'radixPoint': ".",
        'digitsOptional': false,
        'allowMinus': false,
        'placeholder': '0'
      });
    });

    function modalPrint(id){
      if(!id) return false;
      $('#modal-print').modal('show');
      $('#modal-print #frame-pdf').attr("src", "<?=base_url('Spk/Report/')?>"+id);
    }

    function saveTtd(SpkId, Approval){
      var url = (Approval != 3 ? base_url+'Spk/Ttd' : base_url+'Spk/TtdVerifycator');
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
                      url: url,
                      type: 'POST',
                      dataType: 'html',
                      data: {
                        SpkId: SpkId,
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

    function submitData(SpkId){
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
                    url: base_url+'Spk/LockSpk',
                    type: 'POST',
                    dataType: 'html',
                    data: {
                      SpkId: SpkId
                    },  
                    success: function(respons){
                      $('#submitData').html('Submit');
                      location.reload();
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
