<!-- Main content -->
<div id='page-content-wrapper'>
  <div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li><a href="#"><i class="glyphicon glyphicon-edit"></i> Perjanjian</a></li>
            <li class="active">SPP</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
  </div>
  <div class='container-fluid'>
    <div class='row'>
      <div class="pane pane-purple">
        <div class="panel-heading">
          <b>Form Surat Permintaan Pembelian</b>
        </div>
        <div class="panel-body">
          <div class='col-xs-12'>
            <div class='box box-primary'>
              <?=$this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>
              <form action='<?php echo $ArrData['action']; ?>' method='post' class='form-horizontal' id="_form">

                <div class="row">
                  <div class="col-md-6">

                    <div class='form-group'>
                      <label class="col-md-4 control-label">DVO&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="Dvo" id="Dvo" placeholder="" value="<?php echo $ArrData['Dvo']; ?>" <?=$ArrData['attribute']?>/>
                        <?php echo form_error('Dvo') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">CB&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="Cb" id="Cb" placeholder="" value="<?php echo $ArrData['Cb']; ?>" <?=$ArrData['attribute']?>/>
                        <?php echo form_error('Cb') ?>
                      </div>
                    </div>

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
                      <label class="col-md-4 control-label">Pemohon&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="Applicant" id="Applicant" placeholder="" value="<?php echo $ArrData['Applicant']; ?>" <?=$ArrData['attribute']?>/>
                        <?php echo form_error('Applicant') ?>
                      </div>
                    </div>

                  </div>

                  <div class="col-md-6">

                    <div class='form-group'>
                      <label class="col-md-4 control-label">NO&nbsp;:</label>
                      <div class='col-md-3'>
                        <input type="text" class="form-control" name="NoUrut" id="NoUrut" placeholder="" value="<?php echo $ArrData['NoUrut']; ?>" readonly <?=$ArrData['attribute']?>/>
                        <?php echo form_error('NoUrut') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">No SPP&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="SppNo" id="SppNo" placeholder="" value="<?php echo $ArrData['SppNo']; ?>" <?=$ArrData['attribute']?>/>
                        <?php echo form_error('SppNo') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Dikirim Ke&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="SendTo" id="SendTo" placeholder="" value="<?php echo $ArrData['SendTo']; ?>" <?=$ArrData['attribute']?>/>
                        <?php echo form_error('SendTo') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Rencana Pakai&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="UsedDate" id="UsedDate" placeholder="" value="<?php echo $ArrData['UsedDate']; ?>" <?=$ArrData['attribute']?>/>
                        <?php echo form_error('UsedDate') ?>
                      </div>
                    </div>

                  </div>
                </div>
                
                <div class="row">
                  <div class="pane pane-default" style="background-color: #efd7de">
                    <div class="col-md-6">
                      <div class='form-group'>
                        <br> 
                        <label class="col-md-4 control-label">Approver 1&nbsp;:</label>
                        <div class='col-md-8'>
                          <select class="selectpicker" name="Approval1" id="Approval1" title="- Pilih -" data-show-subtext="true" data-live-search="true" data-width="100%" <?=$ArrData['attribute']?>>
                            <?php
                              foreach ($DataApproval1 as $val) {
                                echo '<option value="'.$val->id.'" data-tokens="'.$val->name.'" '.$val->selected.'>'.$val->name.' ('.$val->JabatanName.')</option>';
                              }
                             ?>
                          </select>
                          <?php echo form_error('Approval1') ?>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-6">
                      <div class='form-group'>
                        <br>   
                        <label class="col-md-4 control-label">Approver 2&nbsp;:</label>
                        <div class='col-md-8'>
                          <select class="selectpicker" name="Approval2" id="Approval2" title="- Pilih -" data-show-subtext="true" data-live-search="true" data-width="100%" <?=$ArrData['attribute']?>>
                            <?php
                              foreach ($DataApproval2 as $val) {
                                echo '<option value="'.$val->id.'" data-tokens="'.$val->name.'" '.$val->selected.'>'.$val->name.' ('.$val->JabatanName.')</option>';
                              }
                             ?>
                          </select>
                          <?php echo form_error('Approval2') ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <div class="row">
                  <div class="col-md-12">

                    <div class='form-group'>
                      <div class='col-md-12'>
                        <div class="table-responsive">
                          <table class="table" id="listDataRequest">
                            <thead>
                              <tr>
                                <th width="10" class="text-center">NO</th>
                                <th width="50" class="text-center">KODE RESOURCE</th>
                                <th width="50" class="text-center">QUANTITY</th>
                                <th width="50" class="text-center">SATUAN</th>
                                <th width="250" class="text-center">JENIS BARANG</th>
                                <th width="200" class="text-center">UKURAN DAN SPESIFIKASI</th>
                                <th width="150" class="text-center">UNTUK PEKERJAAN</th>
                              </tr>
                            </thead>
                            <tbody>
                              <?php
                                $i = 1;
                                if($DataRequest){
                                  foreach ($DataRequest as $val) {

                                    $ResourceCode[$i] = $val->ResourceCode;
                                    $QuantitySpp[$i]     = $val->QuantitySpp;
                                    $Unit[$i]         = $val->Unit;
                                    $Jb[$i]           = $val->Item;
                                    $Spesification[$i]= $val->Spesification;
                                    $WorkFor[$i]      = $val->WorkFor;
                                    $i++;
                                    
                                  }
                                  $CountData = count($DataRequest);
                                }else{
                                  $CountData = 0;
                                }
                                
                                for ($i=1; $i <= 15; $i++) {
                                  echo "
                                    <tr>
                                      <td align='center'>$i</td>
                                      <td>
                                        <input type='text' name='ResourceCode".$i."' id='ResourceCode".$i."' class='form-control input-sm' value='".($i <= $CountData ? $ResourceCode[$i] : "")."' ".$ArrData['attribute'].">
                                      </td>
                                      <td>
                                        <input type='text' name='QuantitySpp".$i."' id='QuantitySpp".$i."' class='form-control input-sm' value='".($i <= $CountData ? $QuantitySpp[$i] : "")."' ".$ArrData['attribute'].">
                                      </td>
                                      <td>
                                        <input type='text' name='Unit".$i."' id='Unit".$i."' class='form-control input-sm' value='".($i <= $CountData ? $Unit[$i] : "")."' ".$ArrData['attribute'].">
                                      </td>
                                      <td>
                                        <input type='text' name='Jb".$i."' id='Jb".$i."' class='form-control input-sm' value='".($i <= $CountData ? $Jb[$i] : "")."'".$ArrData['attribute'].">
                                      </td>
                                      <td>
                                        <input type='text' name='Spesification".$i."' id='Spesification".$i."' class='form-control input-sm' value='".($i <= $CountData ? $Spesification[$i] : "")."' ".$ArrData['attribute'].">
                                      </td>
                                      <td>
                                        <input type='text' name='WorkFor".$i."' id='WorkFor".$i."' class='form-control input-sm' value='".($i <= $CountData ? $WorkFor[$i] : "")."' ".$ArrData['attribute'].">
                                      </td>
                                    </tr>
                                  ";
                                }
                              ?>
                            </tbody>
                          </table>
                        </div>
                      </div>
                    </div>

                  </div>
                </div>
                <?php 
                if ($ArrData['SppId'] && $ArrData['LockDate'] != NULL) {
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
                                  <button type="button" class="button save" data-action="save-png"  onclick="saveTtd('<?=$ArrData['SppId']?>', 3)">
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
                    if($ArrData['Approval1'] == $this->session->userdata('user_id') && ((!$ArrData['Approval1Status'] || !$ArrData['Approval2Status'] || $ArrData['Approval1Status'] == 3 || $ArrData['Approval2Status'] == 3))){
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
                                  <button type="button" class="button save" data-action="save-png"  onclick="saveTtd('<?=$ArrData['SppId']?>', 1)">
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
                } elseif ($ArrData['Approval2'] == $this->session->userdata('user_id') && ((!$ArrData['Approval1Status'] || !$ArrData['Approval2Status'] || $ArrData['Approval1Status'] == 3 || $ArrData['Approval2Status'] == 3))){

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
                                  <button type="button" class="button save" data-action="save-png" onclick="saveTtd('<?=$ArrData['SppId']?>', 2)">
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
                          echo '<a href="#" id="print" class="btn btn-cl pull-right" onclick="javascript:modalPrint(\''.$ArrData['SppId'].'\');">
                                  <i class="glyphicon glyphicon-print"></i> Print
                                </a>';
                        }else{
                          if($ArrData['button'] && $ArrData['LockDate'] == NULL){
                              if($this->session->userdata('role') != 9)
                              {
                                 echo '<button type="submit" class="btn btn-ok pull-right">'.$ArrData['button'].'</button>'; 
                              }
                          }
                        }
                      ?>
                      <a href='<?php echo site_url('SppPo') ?>' class='btn btn-one pull-right'>Kembali</a>
                    </div>
                  </div>
                </div>

              </form>
            </div>
          </div>
          <?php
          if ($ArrData['SppId'] && $ArrData['LockDate'] == NULL) {
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

          if($ArrData['SppId'] && $ArrData['LockDate'] == NULL){
              if($this->session->userdata('role') != 9)
              {
                echo '
                <div class="panel-heading text-center">
                  <button type="button" class="btn btn-default" id="submitData" onclick="submitData(\''.$ArrData['SppId'].'\')">Submit</button>
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
          <h4 class="modal-title">Print SPP</h4>
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
    if(!id) return false;
    $('#modal-print').modal('show');
    $('#modal-print #frame-pdf').attr("src", "<?=base_url('SppPo/Report/')?>"+id);
  }
  
  function saveTtd(SppId, Approval){
      var url = (Approval != 3 ? base_url+'SppPo/Ttd' : base_url+'SppPo/TtdVerifycator');
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
