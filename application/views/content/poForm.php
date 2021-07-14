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
            <li class="active">PO</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
  </div>
  <div class='container-fluid'>
    <div class='row'>
      <div class="pane pane-purple">
        <div class="panel-heading">
          <b>Form Purchase Order</b>
        </div>
        <div class="panel-body">
          <div class='col-xs-12'>
            <div class='box box-primary'>
              <?=$this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>
              <!-- <a href="#" id="print" class="" onclick="javascript:modalSpp('<?=$ArrData['SppId']?>');">
                Lihat SPP
              </a> -->
              <form action='<?php echo $ArrData['action']; ?>' method='post' class='form-horizontal'>
                <input type="hidden" name="PoId" value="<?=$ArrData['PoId']?>">
                <div class="row">
                  <div class="col-md-6">

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Kepada&nbsp;:</label>
                      <div class='col-md-8'>
                        <select class="selectpicker" name="VendorId" id="VendorId" title="- Pilih -" data-show-subtext="true" data-live-search="true" data-width="100%" <?=$ArrData['attribute']?>>
                          <?php
                            foreach ($DataVendor as $val) {
                              echo '<option value="'.$val->VendorId.'" data-tokens="'.$val->VendorName.'" '.$val->selected.'>'.$val->VendorName.'</option>';
                            }
                           ?>
                        </select>
                        <?php echo form_error('VendorId') ?>
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
                      <label class="col-md-4 control-label">Proyek&nbsp;:</label>
                      <div class='col-md-8'>
                        <select class="selectpicker" name="ProyekId" id="ProyekId" title="- Pilih -" data-show-subtext="true" data-live-search="true" data-width="100%" <?=$ArrData['attribute']?>>
                          <option>- Pilih Proyek -</option>
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
                      <label class="col-md-4 control-label">
                        SPP No&nbsp;:
                      </label>
                      <div class='col-md-8' id="list-spp">
                        
                      </div>
                      <input type="hidden" name="TotalSpp" id="TotalSpp">
                    </div>

                  </div>

                  <div class="col-md-6">

                    <div class='form-group'>
                      <label class="col-md-4 control-label">NO&nbsp;:</label>
                      <div class='col-md-3'>
                        <input type="text" class="form-control text-center" name="NoUrut" id="NoUrut" placeholder="NoUrut" value="<?php echo $ArrData['NoUrut']; ?>" readonly <?=$ArrData['attribute']?>/>
                        <?php echo form_error('NoUrut') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">No PO&nbsp;:</label>
                      <div class="col-md-8">
                        <input type="text" class="form-control" name="PoNo" id="PoNo" placeholder="" value="<?php echo $ArrData['PoNo']; ?>" <?=$ArrData['attribute']?>/>
                        <?php echo form_error('PoNo') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Tanggal PO&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="PoDate" id="PoDate" placeholder="" value="<?php echo $ArrData['PoDate']; ?>" <?=$ArrData['attribute']?>/>
                        <?php echo form_error('PoDate') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">Kode Pemasok&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="SuplierCode" id="SuplierCode" placeholder="" value="<?php echo $ArrData['SuplierCode']; ?>" <?=$ArrData['attribute']?>/>
                        <?php echo form_error('SuplierCode') ?>
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
                    <?php
                      if(!$ArrData['PoId'] || $ArrData['LockDate'] == NULL){
                    ?>
                      <div class='form-group'>
                        <label class="col-md-2 control-label">
                          <button type="button" class="btn btn-default btn-sm" id="btnLoadSppItem" onclick="loadSppItem();">
                            Muat Barang
                          </button>
                        </label>
                      </div>
                    <?php 
                      }
                    ?>

                    <div class='form-group'>
                      <div class='col-md-12'>
                        <div class="table-responsive">
                          <table class="table" id="listDataRequest">
                            <thead>
                              <tr>
                                <th width="10" class="text-center">NO</th>
                                <th width="50" class="text-center">QUANTITY</th>
                                <th width="50" class="text-center">SATUAN</th>
                                <th width="250" class="text-center">URAIAN BARANG</th>
                                <th width="200" class="text-center">SPESIFIKASI</th>
                                <th width="150" class="text-center">HAGRA SATUAN</th>
                                <th width="150" class="text-center">JUMLAH</th>
                              </tr>
                            </thead>
                            <tbody id="list-item">
                              <?php
                              if($DataRequest){
                                $i=0;
                                foreach ($DataRequest as $val) {
                                  $i++;
                                  echo "
                                      <tr>
                                        <td align='center'>$i</td>
                                        <td>
                                          <input type='text' onkeyup='sum()' name='QuantityPo".$i."' id='QuantityPo".$i."' class='form-control input-sm' value='".$val->QuantityPo."' ".$ArrData['attribute'].">
                                          <input type='hidden' onkeyup='sum()' name='QuantitySpp".$i."' id='QuantitySpp".$i."' class='form-control input-sm' value='".$val->QuantitySpp."'>
                                          <input type='hidden' name='Id".$i."' id='Id".$i."' class='form-control input-sm' value='".$val->Id."'>
                                        </td>
                                        <td>
                                          <input type='text' name='Unit".$i."' id='Unit".$i."' class='form-control input-sm' value='".$val->Unit."' readonly ".$ArrData['attribute'].">
                                        </td>
                                        <td>
                                          <input type='text' name='Jb".$i."' id='Jb".$i."' class='form-control input-sm' value='".$val->Item."' readonly ".$ArrData['attribute'].">
                                        </td>
                                        <td>
                                          <input type='text' name='Spesification".$i."' id='Spesification".$i."' class='form-control input-sm' value='".$val->Spesification."' readonly ".$ArrData['attribute'].">
                                        </td>
                                        <td>
                                          <input type='text' onkeyup='sum()' name='Price".$i."' id='Price".$i."' class='form-control input-sm amount-format' value='".$val->Price."' ".$ArrData['attribute'].">
                                        </td>
                                        <td>
                                          <input type='text' name='Amount".$i."' id='Amount".$i."' class='form-control input-sm amount-format' value='".$val->Amount."' readonly ".$ArrData['attribute'].">
                                        </td>
                                      </tr>
                                    ";
                                }
                              }
                              ?>
                            </tbody>
                            <tfoot>
                              <tr>
                                <td colspan="7" align="right">
                                  <div class='form-group'>
                                    <label class="col-md-4">&nbsp;</label>
                                    <div class='col-md-8'>
                                      <select class="selectpicker" name="WithPpn" id="WithPpn" data-width="22.5%" <?=$ArrData['attribute']?> onchange="sum();">
                                        <option value="0" <?=($ArrData['WithPpn'] == 0 ? 'selected' : '')?>>Tanpa PPN</option>
                                        <option value="1" <?=($ArrData['WithPpn'] == 1 ? 'selected' : '')?>>Dengan PPN</option>
                                      </select>
                                    </div>
                                  </div> 
                                </td>
                              </tr>
                              <tr>
                                <td colspan="6">
                                  <input type="hidden" name="TotalItem" id="TotalItem">
                                </td>
                                <td>
                                  <input type="text" name="TotalAmount" id="TotalAmount" value="<?=$ArrData['TotalAmount']?>" class="form-control input-sm amount-format" placeholder="Total Amount" readonly <?=$ArrData['attribute']?>>
                                </td>
                              </tr>
                              <tr>
                                <td colspan="7">&nbsp;</td>
                              </tr>
                            </tfoot>
                          </table>
                        </div>
                      </div>
                    </div>

                  </div>

                  <div class="col-md-12">
                    <span class="col-md-12"><b>Keterangan</b></span>
                    <div class="col-md-6">
                      <div class='form-group'>
                        <label class="col-md-4 control-label">Tanggal Terima Barang&nbsp;:</label>
                        <div class='col-md-8'>
                          <textarea class="form-control Description" rows="3" name="ReceiveDate"><?php echo $ArrData['ReceiveDate']; ?></textarea>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class='form-group'>
                        <label class="col-md-4 control-label">Harga&nbsp;:</label>
                        <div class='col-md-8'>
                          <textarea class="form-control Description" rows="2" name="DescriptionPrice" id="DescriptionPrice"><?php echo $ArrData['DescriptionPrice']; ?></textarea>
                          <?php echo form_error('DescriptionPrice') ?>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class='form-group'>
                        <label class="col-md-4 control-label">Cara Pembayaran&nbsp;:</label>
                        <div class='col-md-8'>
                          <textarea class="form-control Description" rows="2" name="DescriptionTypePayment" id="DescriptionTypePayment"><?php echo $ArrData['DescriptionTypePayment']; ?></textarea>
                          <?php echo form_error('DescriptionTypePayment') ?>
                        </div>
                      </div>
                    </div>
                    <div class="col-md-6">
                      <div class='form-group'>
                        <label class="col-md-4 control-label">Syarat-syarat&nbsp;:</label>
                        <div class='col-md-8'>
                          <textarea class="form-control Description" rows="2" name="DescriptionTerm" id="DescriptionTerm"><?php echo $ArrData['DescriptionTerm']; ?></textarea>
                          <?php echo form_error('DescriptionTerm') ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>

                <?php 
                if ($ArrData['PoId'] && $ArrData['LockDate'] != NULL) {
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
                                  <button type="button" class="button save" data-action="save-png"  onclick="saveTtd('<?=$ArrData['PoId']?>', 3)">
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
                                  <button type="button" class="button save" data-action="save-png"  onclick="saveTtd('<?=$ArrData['PoId']?>', 1)">
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
                                  <button type="button" class="button save" data-action="save-png" onclick="saveTtd('<?=$ArrData['PoId']?>', 2)">
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
                          echo '<a href="#" id="print" class="btn btn-cl pull-right" onclick="javascript:modalPrint(\''.$ArrData['PoId'].'\');">
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
                      <a href='<?php echo site_url('Po') ?>' class='btn btn-one pull-right'>Kembali</a>
                    </div>
                  </div>
                </div>

              </form>
            </div>
          </div>
          <?php
          if ($ArrData['PoId'] && $ArrData['LockDate'] == NULL) {
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

          if($ArrData['PoId'] && $ArrData['LockDate'] == NULL){
              if($this->session->userdata('role') != 9)
              {
                echo '
                <div class="panel-heading text-center">
                  <button type="button" class="btn btn-default" id="submitData" onclick="submitData(\''.$ArrData['PoId'].'\')">Submit</button>
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
  </div>

  <!-- Modal -->
  <div id="modal-print" class="modal fade" role="dialog">
    <div class="modal-dialog">

      <!-- Modal content-->
      <div class="modal-content modal-dialog modal-lg">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title">Print PO</h4>
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
sum();

function sum(){
    var Total = 0;
    var Amount= 0;
    var PPN   = 0;
    var WithPpn = $('#WithPpn').val();

    for(var i=1; i<=15; i++){
        if($('#QuantityPo'+i).val() || $('#Price'+i).val()){
          if($('#QuantityPo'+i).val() > $('#QuantitySpp'+i).val()){
            $('#QuantityPo'+i).val($('#QuantitySpp'+i).val());
          }
          a = parseInt($('#QuantityPo'+i).val());
          b = parseInt(parseCurrency($('#Price'+i).val()));
          Amount = (a * b);
          $('#Amount'+i).val(Amount);
          Total+=parseInt(Amount);
        }
    }
    PPN = (WithPpn == 1) ? parseInt(Total*10/100) : 0;
    Total = parseInt(Total+PPN);
    $('#TotalAmount').val(Total);
}

function parseCurrency( num ) {
    return parseFloat( num.replace( /,/g, '') );
}

$(document).ready(function(){
  $('.amount-format').inputmask('decimal',
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
    $('#modal-print #frame-pdf').attr("src", "<?=base_url('Po/Report/')?>"+id);
  }

  function modalSpp(id){
    if(!id) return false;
    $('#modal-spp').modal('show');
    $('#modal-spp #frame-spp').attr("src", "<?=base_url('SppPo/update/')?>"+id);
  }

  function approve(step){
    var remark = $("#Approval"+step+"Note").val();
    $.ajax({
      url: base_url+'SppPo/approve/PO',
      type: 'POST',
      dataType: 'json',
      data: {
        Id: '<?=$ArrData['PoId']?>',
        ApproverFrom: step,
        ApprovalStatus: 'Y',
        ApprovalNote: remark
      }
    })
    .done(function(respons) {
      location.reload();
    })
    .fail(function() {
      $('.MessageApproval').html('<div class="alert alert-success"><strong>'+respons.Message+'</strong></div>');
    });
  }

  function loadSpp(){
    var ProyekId = $("#ProyekId").val();
    $.ajax({
      url: base_url+'Po/LoadSpp/<?=$ArrData['PoId']?>',
      type: 'POST',
      dataType: 'json',
      data: {
        ProyekId: ProyekId
      },
      beforeSend:function(d){
        $('#list-spp').html("<center><img src='<?=base_url('assets/img/loading.gif')?>' width='20px'/></center>");
      }
    })
    .done(function(respons) {
      console.log(respons);
      var markup = "";
      $.each(respons.DataSpp, function(i, val) {
          markup+= "<div class='checkbox'>";
          markup+= "<label><input type='checkbox' name='SppId"+i+"' class='SppId' "+respons.DataSpp[i].checked+" value='"+respons.DataSpp[i].SppId+"'>"+respons.DataSpp[i].SppNo+"</label>";
          markup+= "</div>";
      });
      $("#list-spp").html(markup);
      $("#TotalSpp").val(respons.TotalSpp);
    })
    .fail(function() {
      $('#list-spp').html('<div class="alert alert-success"><strong>error</strong></div>');
    });
  }

  function loadSppItem() {
    var TotalSpp = $("#TotalSpp").val();
    var $listItem = $("#list-item");
    $listItem.empty();

    var z = 0;
    for (var i = 0; i < TotalSpp; i++) {
      var SppId = $('input[name="SppId'+i+'"]:checked').val(); 
      var PoId  = '<?=$ArrData['PoId']?>';
      $.ajax({
        url: base_url+'Po/loadSppItem/',
        type: 'POST',
        dataType: 'json',
        data: {
          SppId: SppId,
          PoId: PoId
        },
        beforeSend:function(d){
          $('#btnLoadSppItem').html("<center><img src='<?=base_url('assets/img/loading.gif')?>' width='20px'/></center>");
        }
      })
      .done(function(respons) {
        console.log(respons);
        var markup = "";
        $.each(respons, function(j, val) {
            z++;
            markup+="<tr>";
            markup+="<td align='center'>";
            markup+=z;
            markup+="</td>"; 
            markup+="<td>"; 
            markup+="<input type='text' onkeyup='sum()' name='QuantityPo"+z+"' id='QuantityPo"+z+"' ";
            markup+="class='form-control input-sm' value='"+respons[j].QuantitySpp+"'>";
            markup+="<input type='hidden' name='QuantitySpp"+z+"' id='QuantitySpp"+z+"' class='form-control input-sm'";
            markup+=" value='"+respons[j].QuantitySpp+"'>";
            markup+="<input type='hidden' name='Id"+z+"' id='Id"+z+"' class='form-control input-sm'";
            markup+=" value='"+respons[j].Id+"'>";
            markup+="</td>";
            markup+="<td>";
            markup+="<input type='text' name='Unit"+z+"' id='Unit"+z+"' class='form-control input-sm' ";
            markup+="value='"+respons[j].Unit+"' readonly>";
            markup+="</td>";
            markup+="<td>";
            markup+="<input type='text' name='Jb"+z+"' id='Jb"+z+"' class='form-control input-sm' ";
            markup+="value='"+respons[j].Item+"' readonly>";
            markup+="</td>";
            markup+="<td>";
            markup+="<input type='text' name='Spesification"+z+"' id='Spesification"+z+"' class='form-control input-sm'";
            markup+=" value='"+respons[j].Spesification+"' readonly>";
            markup+="</td>";
            markup+="<td>";
            markup+="<input type='text' onkeyup='sum()' name='Price"+z+"' id='Price"+z+"' ";
            markup+="class='form-control input-sm amount-format' value='0'>";
            markup+="</td>"
            markup+="<td>";
            markup+="<input type='text' name='Amount"+z+"' id='Amount"+z+"' class='form-control input-sm amount-format' ";
            markup+="value='0' readonly>";
            markup+="</td>";
            markup+="</tr>";
        });
        console.log(markup);
        $('#TotalItem').val(z);
        $("#list-item").append(markup);
        $('#btnLoadSppItem').html("Muat Barang");
      })
      .fail(function() {
        $('#list-item').html('<div class="alert alert-success"><strong>error</strong></div>');
      });
    }
  }

  $('#ProyekId option').each(function() {
    if($(this).is(':selected')){
      loadSpp();
    }
  });

  $('#ProyekId').change(function() {
    loadSpp();
  });

  function saveTtd(PoId, Approval){
    var url = (Approval != 3 ? base_url+'Po/Ttd' : base_url+'Po/TtdVerifycator');
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
                      PoId: PoId,
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

  function submitData(PoId){
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
                  url: base_url+'Po/LockPo',
                  type: 'POST',
                  dataType: 'html',
                  data: {
                    PoId: PoId
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
