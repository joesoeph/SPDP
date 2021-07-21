<?php
$recipientTtdDisplay = 'none';
$creatorTtdDisplay = 'none';
$approval1TtdDisplay = 'none';
$approval2TtdDisplay = 'none';
$approvalDoneDisplay = 'none';
?>
<!-- Main content -->
<div id='page-content-wrapper'>
  <div class="row">
    <div class="col-md-12">
        <!--breadcrumbs start -->
        <ul class="breadcrumb">
            <li class="active">Pengajuan Dana (A-02)</li>
        </ul>
        <!--breadcrumbs end -->
    </div>
  </div>
  <div class='container-fluid'>
    <div class='row'>
      <div class="pane pane-purple">
        <div class="panel-heading">
          <b>Form Pengajuan Dana (A-02)</b>
        </div>
        <div class="panel-body">
          <div class='col-xs-12'>
            <div class='box box-primary'>
              <?=$this->session->userdata('message') <> '' ? '<div class="alert alert-success">'.$this->session->userdata('message').'</div>' : ''; ?>
              <form action='<?php echo $ArrData['action']; ?>' method='post' class='form-horizontal' id="_form" enctype="multipart/form-data">

                <div class="row">
                  <div class="col-md-6">

										<div class='form-group'>
                      <label class="col-md-4 control-label">Tgl. Berkas&nbsp;:</label>
                      <div class='col-md-5'>
                        <div class="input-group date" data-provide="datepicker" data-date-format="yyyy-mm-dd">
                            <input type="text" class="form-control" name="BudgetRequestDate" id="BudgetRequestDate" placeholder="" value="<?php echo $ArrData['BudgetRequestDate']; ?>" <?=$ArrData['attribute']?>>
                            <div class="input-group-addon">
                                <span class="glyphicon glyphicon-th"></span>
                            </div>
                        </div>
                        <?php echo form_error('BudgetRequestDate') ?>
                      </div>
                    </div>

										<div class='form-group'>
											<label class="col-md-4 control-label">Klasifikasi&nbsp;:</label>
											<div class='col-md-8'>
												<input type="text" class="form-control" name="Classification" id="Classification" placeholder="" value="<?php echo $ArrData['Classification']; ?>" <?=$ArrData['attribute']?>/>
												<?php echo form_error('Classification') ?>
											</div>
										</div>

                  </div>

                  <div class="col-md-6">

                    <div class='form-group' style="display: none;">
                      <label class="col-md-4 control-label">NO&nbsp;:</label>
                      <div class='col-md-3'>
                        <input type="text" class="form-control" name="NoUrut" id="NoUrut" placeholder="" value="<?php echo $ArrData['NoUrut']; ?>" readonly <?=$ArrData['attribute']?>/>
                        <?php echo form_error('NoUrut') ?>
                      </div>
                    </div>

                    <div class='form-group'>
                      <label class="col-md-4 control-label">No Berkas&nbsp;:</label>
                      <div class='col-md-8'>
                        <input type="text" class="form-control" name="BudgetRequestNo" id="BudgetRequestNo" placeholder="" value="<?php echo $ArrData['BudgetRequestNo']; ?>" <?=$ArrData['attribute']?>/>
                        <?php echo form_error('BudgetRequestNo') ?>
                      </div>
                    </div>

                  </div>
                </div>
                
                <div class="row">
									<div class="col-md-4">
										<div class='form-group'>
											<div class='col-md-12'>
													<label class="control-label">Approver 1&nbsp;:</label>
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

									<div class="col-md-4">
										<div class='form-group'>
											<div class='col-md-12'>
												<label class="control-label">Approver 2&nbsp;:</label>
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
									
									<div class="col-md-4">
										<div class='form-group'>
												<label class="control-label">Penerima&nbsp;:</label>
												<select class="selectpicker" name="Recipient" id="Recipient" title="- Pilih -" data-show-subtext="true" data-live-search="true" data-width="100%" <?=$ArrData['attribute']?>>
													<?php
														foreach ($DataRecipient as $val) {
															echo '<option value="'.$val->id.'" data-tokens="'.$val->name.'" '.$val->selected.'>'.$val->name.' ('.$val->JabatanName.')</option>';
														}
														?>
												</select>
												<?php echo form_error('Recipient') ?>
										</div>
									</div>
                </div>


								<div class='form-group'>
									<div class='col-md-12'>
										<button type="button" class="add-row pull-right" name="button" <?=$ArrData['attribute']?>>
											<i class="glyphicon glyphicon-plus"></i>
										</button>
										<div class="table-responsive">
											<table class="table" id="DataRequest">
												<thead>
													<tr>
														<th width="20" class="text-center">NO</th>
														<th width="50">URAIAN</th>
														<th width="50">QTY</th>
														<th width="100">HARGA SATUAN</th>
														<th width="100">TOTAL</th>
													</tr>
												</thead>
												<tbody>
													<?php
														$n = 0;
														if($DataRequest){
															foreach ($DataRequest as $val) {
																$n++;
																echo "
																	<tr>
																		<td><input onkeyup='sum()' type='text' class='form-control' value='".$n."' ".$ArrData['attribute']."></td>
																		<td><input onkeyup='sum()' type='text' class='form-control' name='Spesification[".$n."]' id='Spesification".$n."' placeholder='Uraian' value='".$val->Spesification."' ".$ArrData['attribute']."></td>
																		<td><input onkeyup='sum()' type='text' class='form-control' name='Quantity[".$n."]' id='Quantity".$n."' placeholder='Quantity' value='".$val->Quantity."' ".$ArrData['attribute']."></td>
																		<td><input onkeyup='sum()' type='text' class='form-control Currency' name='Price[".$n."]' id='Price".$n."' placeholder='Harga' value='".$val->Price."' ".$ArrData['attribute']."></td>
																		<td><input onkeyup='sum()' type='text' class='form-control Currency' name='Amount[".$n."]' id='Amount".$n."' placeholder='Jumlah' value='".$val->Amount."' ".$ArrData['attribute']."></td>
																	</tr>
																";
															}
														}
													?>

												</tbody>
												<tfoot>
													<tr>
														<th colspan="4" class="text-right">Total Jumlah</th>
														<th>
															<input type="text" class="form-control" onKeyPress="tandaPemisahTitik(this);" name="TotalAmount" id="TotalAmount" value="<?php echo $ArrData['TotalAmount']; ?>" readonly <?=$ArrData['attribute']?>/>
															<?php echo form_error('TotalAmount') ?>
														</th>
													</tr>
												</tfoot>
											</table>
											<input type="hidden" id="row" name="row" value="<?=$n?>">
										</div>
										<?php echo form_error('DataRequest') ?>
									</div>
								</div>

								<?php
									if($ArrData['BudgetRequestId'] && $ArrData['LockDate'] == NULL) {
										if($ArrData['Recipient'] == $this->session->userdata('user_id')) {
											$recipientTtdDisplay = 'block';
										}
										if($ArrData['CreatedByUserId'] == $this->session->userdata('user_id')) {
											$creatorTtdDisplay = 'block';
										}
									}
								?>

                <?php 
                if ($ArrData['BudgetRequestId'] && $ArrData['LockDate'] != NULL) {
									if($ArrData['Approval1'] == $this->session->userdata('user_id') && ((!$ArrData['Approval1Status'] || !$ArrData['Approval2Status'] || $ArrData['Approval1Status'] == 3 || $ArrData['Approval2Status'] == 3))){
										$approval1TtdDisplay = 'block';
									} // if($ArrData['Approval1'] == $this->session->userdata('user_id') && ((!$ArrData['Approval1Status'] || !$ArrData['Approval2Status'] || $ArrData['Approval1Status'] == 3 || $ArrData['Approval2Status'] == 3)))
									
									if ($ArrData['Approval2'] == $this->session->userdata('user_id') && ((!$ArrData['Approval1Status'] || !$ArrData['Approval2Status'] || $ArrData['Approval1Status'] == 3 || $ArrData['Approval2Status'] == 3))){
										$approval2TtdDisplay = 'block';
									} // elseif ($ArrData['Approval2'] == $this->session->userdata('user_id') && ((!$ArrData['Approval1Status'] || !$ArrData['Approval2Status'] || $ArrData['Approval1Status'] == 3 || $ArrData['Approval2Status'] == 3)))
										
									if (($ArrData['Approval1Status'] && $ArrData['Approval2Status']) && ($ArrData['Approval1Status'] != 3 && $ArrData['Approval2Status'] != 3)){
										$approvalDoneDisplay = 'block';
									} //if (($ArrData['Approval1Status'] && $ArrData['Approval2Status']) && ($ArrData['Approval1Status'] != 3 && $ArrData['Approval2Status'] != 3))
              	} // if ($ArrData['BudgetRequestId'] && $ArrData['LockDate'] != NULL)
                ?>
								
								
								<div class="col-md-6" style="display: <?=$recipientTtdDisplay?>;">
									<div class="pane" style="background-color:#F6F6F6;">
										<div class="panel-heading"><b>Penerima</b></div>
										<div class="panel-body">
											<div class='box box-primary'>
												<div class="row">
													<div class="col-md-12">
														<div id="signature-pad-recipient" class="m-signature-pad">
															<div class="m-signature-pad--body">
																<input type="hidden" id="ttdValuerecipient" value="<?=$ArrData['RecipientTtd']?>">
																<img src="<?=$ArrData['RecipientTtd']?>" width="100%" id="ttdImagerecipient">
																<canvas></canvas>
															</div>
															<div class="m-signature-pad--footer">
																<div class="description">Tanda tangan</div>
																<div class="description" id="MessageTtdrecipient"></div>
																<div class="left">
																	<button type="button" class="button clear" data-action="clear">
																		<i class="glyphicon glyphicon-trash"></i>
																		Kosongkan TTD
																	</button>
																</div>
																<div class="right">
																	<button type="button" class="button save" data-action="save-png"  onclick="saveTtdNonApproval('<?=$ArrData['BudgetRequestId']?>', 'recipient')">
																		<i class="glyphicon glyphicon-floppy-disk"></i>
																		Simpan TTD
																	</button>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6" style="display: <?=$creatorTtdDisplay?>;">
									<div class="pane" style="background-color:#F6F6F6;">
										<div class="panel-heading"><b>Pembuat</b></div>
										<div class="panel-body">
											<div class='box box-primary'>
												<div class="row">
													<div class="col-md-12">
														<div id="signature-pad-creator" class="m-signature-pad">
															<div class="m-signature-pad--body">
																<input type="hidden" id="ttdValuecreator" value="<?=$ArrData['CreatorTtd']?>">
																<img src="<?=$ArrData['CreatorTtd']?>" width="100%" id="ttdImagecreator">
																<canvas></canvas>
															</div>
															<div class="m-signature-pad--footer">
																<div class="description">Tanda tangan</div>
																<div class="description" id="MessageTtdcreator"></div>
																<div class="left">
																	<button type="button" class="button clear" data-action="clear">
																		<i class="glyphicon glyphicon-trash"></i>
																		Kosongkan TTD
																	</button>
																</div>
																<div class="right">
																	<button type="button" class="button save" data-action="save-png"  onclick="saveTtdNonApproval('<?=$ArrData['BudgetRequestId']?>', 'creator')">
																		<i class="glyphicon glyphicon-floppy-disk"></i>
																		Simpan TTD
																	</button>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6" style="display: <?=$approval1TtdDisplay?>;">
									<div class="pane" style="background-color:#F6F6F6;">
										<div class="panel-heading"><b>Approver 1</b></div>
										<div class="panel-body">
											<div class='box box-primary'>
												<div class="row">
													<div class="col-md-12">
														<div class='form-group'>
															<label class="col-md-3 control-label">Status :</label>
															<div class='col-md-4'>
																<select class="selectpicker" name="Approval1Status" id="Approval1Status" data-show-subtext="false" data-live-search="false" data-width="100%">
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
																<textarea class="form-control" name="Approval1Note" id="Approval1Note"><?=$ArrData['Approval1Note']?></textarea>
															</div>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-12">
														<div id="signature-pad-1" class="m-signature-pad">
															<div class="m-signature-pad--body">
																<input type="hidden" id="ttdValue1" value="<?=$ArrData['Approval1Ttd']?>">
																<img src="<?=$ArrData['Approval1Ttd']?>" width="100%" id="ttdImage1">
																<canvas></canvas>
															</div>
															<div class="m-signature-pad--footer">
																<div class="description">Tanda tangan</div>
																<div class="description" id="MessageTtd1"></div>
																<div class="left">
																	<button type="button" class="button clear" data-action="clear">
																		<i class="glyphicon glyphicon-trash"></i>
																		Kosongkan TTD
																	</button>
																</div>
																<div class="right">
																	<button type="button" class="button save" data-action="save-png"  onclick="saveTtd('<?=$ArrData['BudgetRequestId']?>', 1)">
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
								<div class="col-md-6" style="display: <?=$approval2TtdDisplay?>;">
									<div class="pane" style="background-color:#F6F6F6;">
										<div class="panel-heading"><b>Approver 2</b></div>
										<div class="panel-body">
											<div class='box box-primary'>
												<div class="row">
													<div class="col-md-12">
														<div class='form-group'>
															<label class="col-md-3 control-label">Status :</label>
															<div class='col-md-4'>
																<select class="selectpicker" name="Approval2Status" id="Approval2Status" data-show-subtext="false" data-live-search="false" data-width="100%">
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
																<textarea class="form-control" name="Approval2Note" id="Approval2Note"><?=$ArrData['Approval2Note']?></textarea>
															</div>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-md-12">
														<div id="signature-pad-2" class="m-signature-pad">
															<div class="m-signature-pad--body">
																<input type="hidden" id="ttdValue2" value="<?=$ArrData['Approval2Ttd']?>">
																<img src="<?=$ArrData['Approval2Ttd']?>" width="100%" id="ttdImage1">
																<canvas></canvas>
															</div>
															<div class="m-signature-pad--footer">
																<div class="description">Tanda tangan</div>
																<div class="description" id="MessageTtd2"></div>
																<div class="left">
																	<button type="button" class="button clear" data-action="clear">
																		<i class="glyphicon glyphicon-trash"></i>
																		Kosongkan TTD
																	</button>
																</div>
																<div class="right">
																	<button type="button" class="button save" data-action="save-png" onclick="saveTtd('<?=$ArrData['BudgetRequestId']?>', 2)">
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

								<div class="col-md-6" style="display: <?=$approvalDoneDisplay?>;">
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
								<div class="col-md-6" style="display: <?=$approvalDoneDisplay?>;">
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

                <div class="row">
                  <div class="col-md-12">
                    <div class='form-action'>
                    <div class="MessageApproval"></div>
                      <?php
                        if(($ArrData['Approval1Status'] && $ArrData['Approval2Status']) && ($ArrData['Approval1Status'] != 3 && $ArrData['Approval2Status'] != 3)){
                          echo '<a href="#" id="print" class="btn btn-cl pull-right" onclick="javascript:modalPrint(\''.$ArrData['BudgetRequestId'].'\');">
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
                      <a href='<?php echo site_url('BudgetRequest') ?>' class='btn btn-one pull-right'>Kembali</a>
                    </div>
                  </div>
                </div>

              </form>
            </div>
          </div>
          <?php
          if ($ArrData['BudgetRequestId'] && $ArrData['LockDate'] == NULL) {
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

          if($ArrData['BudgetRequestId'] && $ArrData['LockDate'] == NULL) {
						echo '
						<div class="panel-heading text-center">
							<button type="button" class="btn btn-default" id="submitData" onclick="submitData(\''.$ArrData['BudgetRequestId'].'\')">Submit</button>
						</div>';
          }
          ?>
        </div>
      </div><!-- /.col -->
    </div>
  </div>
	
	<!--  && $this->session->userdata('jabatanid') == 99 -->
	<?php if($ArrData['BudgetRequestId'] && ($this->session->userdata('jabatanid') == 99 || $this->session->userdata('user_id') == $ArrData['CreatedByUserId'])) : ?>
	<div class="pane pane-purple">
		<div class="panel-heading">
			<b>Form Upload</b>
		</div>
		<div class="panel-body">
			<div class="col-xs-12">
				<form action='<?= site_url('BudgetRequest/store_upload/' . $ArrData['BudgetRequestId']) ?>' method='post' class='form-horizontal' id="_form" enctype="multipart/form-data">
					<div class='form-group'>
						<label class="col-md-2 control-label">Lampiran&nbsp;:</label>
						<div class='col-md-4'>
							<input type="file" class="form-control" name="Attachment" id="Attachment">
							<?php if($ArrData['Attachment']) : ?> <a href="<?=base_url('upload/' . $ArrData['Attachment'])?>">See this attachment</a> <?php endif; ?>
							<?php echo form_error('Attachment') ?>
						</div>
					</div>
					<?php if($this->session->userdata('jabatanid') == 99) :?>
					<button type="submit" class="btn btn-ok pull-right">Upload</button>
					<a href="<?=site_url('BudgetRequest/delete_upload/' . $ArrData['BudgetRequestId'])?>" class="btn btn-one pull-right">Hapus</a>
					<?php endif; ?>
				</form>
			</div>
		</div>
	</div>
	<?php endif; ?>

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
          <h4 class="modal-title">Print</h4>
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

	$(".add-row").click(function(){
		var row = $('#row').val();
		row++;
		$('#row').val(row);
			let markup = `
				<tr>
					<td><input onkeyup='sum()' type='text' class='form-control' value='${row}'></td>
					<td><input onkeyup='sum()' type='text' class='form-control' name='Spesification[${row}]' id='Spesification${row}' placeholder='Uraian' value=''></td>
					<td><input onkeyup='sum()' type='text' class='form-control' name='Quantity[${row}]' id='Quantity${row}' placeholder='Quantity' value=''></td>
					<td><input onkeyup='sum()' type='text' class='form-control Currency' name='Price[${row}]' id='Price${row}' placeholder='Harga Satuan' value=''></td>
					<td><input onkeyup='sum()' type='text' class='form-control Currency' name='Amount[${row}]' id='Amount${row}' placeholder='Jumlah' value=''></td>
				</tr>
			`;
			$("#DataRequest").append(markup);
	});


	function sum(){
		var row   = $('#row').val();
		var Total = 0;
		var Amount= 0;

		for(var i=1; i<=row; i++){
			if($('#Quantity'+i).val() || $('#Price'+i).val()){
				a = parseInt(parseCurrency($('#Quantity'+i).val()));
				b = parseInt(parseCurrency($('#Price'+i).val()));
				Amount = (a * b);
				$('#Amount'+i).val(Amount);
				Total+=parseInt(parseCurrency($('#Amount'+i).val()));
			}
		}

		$('#TotalAmount').val(Total);
	}

	function parseCurrency( num ) {
			return parseFloat( num.replace( /,/g, '') );
	}
	
	var sp = [];
	function initSignature(type) {
		console.log(type)
		var wrapper = document.getElementById('signature-pad-' + type),
				clearButton = wrapper.querySelector("[data-action=clear]"),
				canvas = wrapper.querySelector("canvas"),
				signaturePad;
	
		// Adjust canvas coordinate space taking into account pixel ratio,
		// to make it look crisp on mobile devices.
		// This also causes canvas to be cleared.
		function resizeCanvas() {
				// When zoomed out to less than 100%, for some very strange reason,
				// some browsers report devicePixelRatio as less than 1
				// and only part of the canvas is cleared then.
				var ratio =  Math.max(window.devicePixelRatio || 1, 1);
				canvas.width = canvas.offsetWidth * ratio;
				canvas.height = canvas.offsetHeight * ratio;
				canvas.getContext("2d").scale(ratio, ratio);
		}
	
		window.onresize = resizeCanvas;
		resizeCanvas();
		
		sp['signature-pad-' + type] = new SignaturePad(canvas);
		clearButton.addEventListener("click", function (event) {
				$('#ttdImage' + type).hide();
				$('#ttdValue' + type).val('');
				sp['signature-pad-' + type].clear();
		});
	}

	<?php if($ArrData['Recipient'] == $this->session->userdata('user_id')) : ?>
	initSignature("recipient");
	<?php endif; ?>

	<?php if($ArrData['CreatedByUserId'] == $this->session->userdata('user_id')) : ?>
	initSignature("creator");
	<?php endif; ?>

	<?php if($ArrData['Approval1'] == $this->session->userdata('user_id')) : ?>
	initSignature("1");
	<?php endif; ?>

	<?php if($ArrData['Approval2'] == $this->session->userdata('user_id')) : ?>
	initSignature("2");
	<?php endif; ?>


	$(document).ready(function(){
		$('#TotalAmount, .Currency').inputmask('decimal',
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
    $('#modal-print #frame-pdf').attr("src", "<?=base_url('BudgetRequest/Report/')?>"+id);
  }
  
  function saveTtd(Id, Approval){
      var url = base_url + 'BudgetRequest/Ttd';
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
                  var pngFile = (sp['signature-pad-' + Approval].isEmpty()) ? $('#ttdValue' + Approval).val() : sp['signature-pad-' + Approval].toDataURL();
                  if (!pngFile) {
                    $('#MessageTtd'+Approval).html('<strong>Tanda tangan kosong</strong>');
                  } else {
                    var ApprovalStatus = $('#Approval' + Approval + 'Status').val();
                    var ApprovalNote   = $('#Approval' + Approval + 'Note').val();
                    $.ajax({
                      url: url,
                      type: 'POST',
                      dataType: 'html',
                      data: {
                        Id: Id,
                        Ttd: pngFile,
                        Approval: Approval,
                        ApprovalStatus: ApprovalStatus,
                        ApprovalNote: ApprovalNote
                      },  
                      success: function(respons){
                        $('#MessageTtd'+Approval).html('<strong>'+respons+'</strong>');
                        location.reload();
                      },
                      error: function(){
                        $('#MessageTtd'+Approval).html('<strong>Error</strong>');
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
  
  function saveTtdNonApproval(Id, type){
      var url = base_url + 'BudgetRequest/TtdNonApproval';
      $.confirm({
          title: 'Simpan Tanda tangan?',
          content: 'Pastikan tanda tangan sudah sesuai!',
          useBootstrap: false,
          offsetTop: '20',
          boxWidth: '40%',
          buttons: {
            'confirm': {
                text: 'Ya',
                keys: ['enter'],
                action: function () {
                  var pngFile = (sp["signature-pad-" + type].isEmpty()) ? $('#ttdValue'+type).val() : sp["signature-pad-" + type].toDataURL();
                  if (!pngFile) {
                    $('#MessageTtd'+type).html('<strong>Tanda tangan kosong</strong>');
                  } else {
                    $.ajax({
                      url: url,
                      type: 'POST',
                      dataType: 'html',
                      data: {
                        Id: Id,
                        Ttd: pngFile,
                        Type: type,
                      },  
                      success: function(respons){
                        $('#MessageTtd'+type).html('<strong>'+respons+'</strong>');
                        location.reload();
                      },
                      error: function(){
                        $('#MessageTtd'+type).html('<strong>Error</strong>');
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

    function submitData(Id){
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
                    url: base_url + 'BudgetRequest/Lock',
                    type: 'POST',
                    dataType: 'html',
                    data: {
                      Id: Id
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
