<?php
/* @var $this TransactionRequestOrderController */
/* @var $model TransactionRequestOrder */

$this->breadcrumbs=array(
	'Transaction Request Orders'=>array('admin'),
	'Manage',
	);

$this->menu=array(
	array('label'=>'List TransactionRequestOrder', 'url'=>array('index')),
	array('label'=>'Create TransactionRequestOrder', 'url'=>array('create')),
	);
$listbank=new ForecastingComponents();
$paramStartdate = (isset($_GET['Forecasting']['payment_date'])?$_GET['Forecasting']['payment_date']:date('Y-m-01'));
$paramPriode = (isset($_GET['Forecasting']['priode']) ? $_GET['Forecasting']['priode']:0);

/* id bank
	3 	BCA HUFADHA | 5 	BCA PD	| 7 	BCA PT	| 10 	CIMB NIAGA | 14 	Mandiri KMK | 17 	MANDIRI TBM
*/
//$bankcoa = array(3,5,7,10,14,17);

	?>

	<div id="maincontent">
		<div class="clearfix page-action">
			<?php if (Yii::app()->user->checkAccess("accounting.forecasting.manage")) { ?>
				<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/accounting/forecasting/admin';?>"><span class="fa fa-th"></span>Manages Forecasting</a>
				<?php } ?>
				<h2>Manage Forecastings</h2>
			</div>
			<div class="row">
				<div class="small-12 medium-12 columns">
					<div class="search-bar">
						<div class="clearfix button-bar">

							<div class="row">
								<div class="medium-12 columns">
									<?php $form=$this->beginWidget('CActiveForm', array(
										'action'=>Yii::app()->createUrl($this->route),
										'method'=>'get',
										)
									);
									?>
									<div class="row">
										<div class="small-3 columns">
											<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
												'model' => $model,
												'attribute' => "payment_date",
												'options'=>array(
													'dateFormat' => 'yy-mm-dd',
													'changeMonth'=>true,
													'changeYear'=>true,
													'yearRange'=>'1900:2020',
													),
												'htmlOptions'=>array(
													'placeholder'=>'Start Date',
													'value'=>$paramStartdate,
													'id'=>'start_date',
													'style'=>'margin-bottom:0px;'
													),
												)
											);
											?>
										</div>
										<div class="small-3 columns">
											<?php echo  $form->dropDownList($model, 'priode', array('3' => '3 Month',
											'6' => '6 Month', '12' => '12 Month', ), array('prompt' => '[--Select Priode--]',"style"=>"margin-bottom:0px;")); ?>
										</div>

										<div class="small-3 columns">
											<div class="field buttons text-right">
												<?php echo CHtml::submitButton('Search', array('class' => 'button cbutton')); ?>
												<?php echo CHtml::button('Export Excel', array('class' => 'button cbutton', 'id'=>'exportXls')); ?>
											</div>
										</div>
									</div>
									<?php $this->endWidget(); ?>
								</div>
							</div>
						</div>
					</div><!-- search-form -->

					<div class="grid-view">
						<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">
							<table class="nopdg">
								<thead>
									<tr>
										<td style="padding: 0px!important;"><table class="nopadding" style="display:block;">
											<tr>
												<td rowspan="3" style="min-width:100px">Date</td>
												<!-- <td rowspan="3">Status</td> -->
												<?php 
												foreach ($forecastingBank as $key => $value) {
													echo "<td colspan=\"6\">".$value->name."</td>";
												}
												?>
											</tr>
											<tr>
												<?php 
												foreach ($forecastingBank as $key => $value) {
													echo "<td rowspan=\"2\" style=\"min-width:100px\">Status</td>";
													echo "<td colspan=\"2\" style=\"min-width:100px\">Debit</td>";
													echo "<td colspan=\"2\" style=\"min-width:100px\">Credit</td>";
													echo "<td style=\"min-width:100px\">Balance</td>";
												}
												?>
											</tr>
											<tr>
												<?php 
												foreach ($forecastingBank as $key => $value) {
													echo "<td style=\"min-width:150px\">Hutang Supplier</td>";
													echo "<td style=\"min-width:100px\">Lain Lain</td>";
													echo "<td style=\"min-width:150px\">Pelunasan/CR</td>";
													echo "<td style=\"min-width:150px\">Setoran/Pendapatan</td>";
													echo "<td style=\"min-width:150px\">Saldo</td>";
												}
												?>
											</tr>
										</table></td>
									</tr>
								</thead>

								<tbody style="display:block; height:500px; overflow:auto; margin-left: 1px;">
									<?php
									$totaldc = $listbank->getListbankValue();
									$saldoawal_array = $listbank->getListbankValue();
									foreach($daterange as $key => $date){
									// for heading and balance bulan sebelumnya
										if (($date->format("d") == "1") OR ($date->format("d") == "01")){
										// $totaldc = 0; 
											echo "<tr>";
											echo "<td style=\"min-width:100px\" width=\"100px\"></td>";
											foreach ($forecastingBank as $key => $value) {
												$bankid = Forecasting::model()->getCoaBank($value->id);
												$saldoawal = Forecasting::model()->getSaldoAwal($bankid,$date->format("Y-m-01"));
												$saldoawalKas = Forecasting::model()->getSaldoAwalKas($value->id,$date->format("Y-m-01"));
												$saldoawal_array[$value->id] = $saldoawal + $saldoawalKas;
												// var_dump($saldoawalKas . $saldoawal);
												// $totaldc[$value->id] = $totaldc[$value->id] + $saldoawal_array[$value->id];
												echo "<td colspan=\"5\" ><strong>".$date->format("F")."</strong></td>";
												// echo "<td><span class=\"numbers\">".$saldo_awal[$bankid]."</span></td>";
												echo "<td><span class=\"numbers\">".number_format((float)$totaldc[$value->id], 2, '.', ',')."</span></td>";
											}
											echo "</tr>";
										}
									// var_dump($totaldc); die();
										echo "<tr>";
										echo "<td style=\"min-width:100px\">".$date->format("Y-m-d") . "</td>";

										foreach ($forecastingBank as $key => $value) {
										// $saldo.$value->id = 0;
											$bankid = Forecasting::model()->getCoaBank($value->id);
											$id = Forecasting::model()->getValue('id',array('payment_date'=>$date->format("Y-m-d"),'bank_id'=>$bankid));
											$status = Forecasting::model()->getValue('status',array('payment_date'=>$date->format("Y-m-d"),'bank_id'=>$bankid));
											$status2 = ($status == 'OK') ? 'OK': 'NOT OK';
											$debit1 = Forecasting::model()->getValues('amount',array('payment_date'=>$date->format("Y-m-d"),'bank_id'=>$bankid,'type_forecasting'=>Forecasting::TYPE_PO));
											$debit2 = Forecasting::model()->getValues('amount',array('payment_date'=>$date->format("Y-m-d"),'coa_id'=>$value->id,'type_forecasting'=>Forecasting::TYPE_CASH_OUT));

											$credit1 = Forecasting::model()->getValues('amount',array('payment_date'=>$date->format("Y-m-d"),'bank_id'=>$bankid,'type_forecasting'=>Forecasting::TYPE_SO));
											$credit2 = Forecasting::model()->getValues('amount',array('payment_date'=>$date->format("Y-m-d"),'coa_id'=>$value->id,'type_forecasting'=>Forecasting::TYPE_CASH_IN));

											$credit1id = Forecasting::model()->getValue('id',array('payment_date'=>$date->format("Y-m-d"),'bank_id'=>$bankid,'type_forecasting'=>Forecasting::TYPE_SO));
											$credit2id = Forecasting::model()->getValue('id',array('payment_date'=>$date->format("Y-m-d"),'coa_id'=>$value->id,'type_forecasting'=>Forecasting::TYPE_CASH_OUT));

											$debit1id = Forecasting::model()->getValue('id',array('payment_date'=>$date->format("Y-m-d"),'bank_id'=>$bankid,'type_forecasting'=>Forecasting::TYPE_PO));
											$debit2id = Forecasting::model()->getValue('id',array('payment_date'=>$date->format("Y-m-d"),'coa_id'=>$value->id,'type_forecasting'=>Forecasting::TYPE_CASH_IN));

											$credit1notes = Forecasting::model()->getValue('notes',array('payment_date'=>$date->format("Y-m-d"),'bank_id'=>$bankid,'type_forecasting'=>Forecasting::TYPE_SO));
											$credit2notes = Forecasting::model()->getValue('notes',array('payment_date'=>$date->format("Y-m-d"),'coa_id'=>$value->id,'type_forecasting'=>Forecasting::TYPE_CASH_OUT));
											$debit1notes = Forecasting::model()->getValue('notes',array('payment_date'=>$date->format("Y-m-d"),'bank_id'=>$bankid,'type_forecasting'=>Forecasting::TYPE_PO));
											$debit2notes = Forecasting::model()->getValue('notes',array('payment_date'=>$date->format("Y-m-d"),'coa_id'=>$value->id,'type_forecasting'=>Forecasting::TYPE_CASH_IN));


										// $cektgl = Forecasting::model()->getValue('payment_date',array('payment_date'=>$date->format("Y-m-d"),'bank_id'=>$bankid));
											$cektgl_1 = Forecasting::model()->getValue('payment_date',array('payment_date'=>$date->format("Y-m-d"),'bank_id'=>$bankid));
											$cektgl_2 = Forecasting::model()->getValue('payment_date',array('payment_date'=>$date->format("Y-m-d"),'coa_id'=>$value->id));
										// if ($date->format("Y-m-d") == $date->format("Y-m-01")) {
										// 	$saldo_awal = Forecasting::model()->getSaldoAwal($bankid,$date->format("Y-m-01")) + $totaldc;
										// 	$totaldc += (($credit1 + $credit2) - ($debit1 + $debit2)) + $saldo_awal;
										// }else{
											$totaldc[$value->id] += (($credit1 + $credit2) - ($debit1 + $debit2));
										// }

										// $saldo_awal = $saldo_awal[$bankid] + $totaldc;

										// var_dump(Forecasting::model()->getSaldoAwal($bankid,$date->format("Y-m-01")));

											if (!empty($cektgl_1) OR !empty($cektgl_2)) {
												echo "<td  style=\"min-width:100px\"><span class=\"statusPopup has-tip\" data-tooltip aria-haspopup=\"true\" title=\"$status2\" data-id=\"$id\" style=\"display: inline\">". $status2."</span></td>";

												echo "<td  style=\"min-width:150px\"><span class=\"numbers debit has-tip\" data-tooltip aria-haspopup=\"true\" title=\"$debit1notes\" data-id=\"$debit1id\" data-type=\"".Forecasting::TYPE_PO."\" data-date=\"$cektgl_1\" data-bank=\"$bankid\">". number_format((float)$debit1,2,'.',',') ."</span></td>";
												echo "<td  style=\"min-width:100px\"><span class=\"numbers debit has-tip\" data-tooltip aria-haspopup=\"true\" title=\"$debit2notes\"data-id=\"$debit2id\" data-type=\"".Forecasting::TYPE_CASH_OUT."\" data-date=\"$cektgl_2\" data-bank=\"$bankid\">". number_format((float)$debit2,2,'.',',') ."</span></td>";

												echo "<td  style=\"min-width:150px\"><span class=\"numbers credit has-tip\" data-tooltip aria-haspopup=\"true\" title=\"$credit1notes\" data-id=\"$credit1id\" data-type=\"".Forecasting::TYPE_SO."\" data-date=\"$cektgl_1\" data-bank=\"$bankid\">". number_format((float)$credit1,2,'.',',') ."</span></td>";
												echo "<td  style=\"min-width:150px\"><span class=\"numbers credit has-tip\" data-tooltip aria-haspopup=\"true\" title=\"$credit2notes\" data-id=\"$credit2id\" data-type=\"".Forecasting::TYPE_CASH_IN."\" data-date=\"$cektgl_2\" data-bank=\"$bankid\">". number_format((float)$credit2,2,'.',',') ."</span></td>";

												echo "<td  style=\"min-width:150px\"><span class=\"numbers\">".number_format((float)$totaldc[$value->id],2,'.',',')."</span></td>";
											}else{
												echo "<td style=\"min-width:100px\"></td>";
												echo "<td style=\"min-width:150px\"></td>";
												echo "<td style=\"min-width:100px\"></td>";
												echo "<td style=\"min-width:150px\"></td>";
												echo "<td style=\"min-width:150px\"></td>";
												echo "<td style=\"min-width:100px\"></td>";
											//data-tooltip aria-haspopup="true" class="" title="Tooltips are awesome, you should totally use them!"
											}
										}
									// die();
										echo "</tr>";
									}
									?>
								</tbody>
							</table>
						</div>
					<?php /*<div class="button-group">
						<?php echo CHtml::button("Recount",array("id"=>"btnRecount", 'class'=>'button cbutton')); ?>
						<?php //echo $x = Yii::app()->request->get('Forecasting[payment_date]')?>
						<?php //echo CHtml::button("Export Excel",array("id"=>"btnExport", 'class'=>'button cbutton')); ?>
						<?php echo CHtml::button('Export Excel',
								array(
									'class'=>'button cbutton',
									'submit'=>array('forecasting/exportXls?startdate='.$paramStartdate.'&priode='.$paramPriode),
									// 'confirm' => 'Are you sure?  \r\n \r\n Export start from '.$paramStartdate.' and '.$paramPriode.'periode'
									'confirm' => 'Are you sure?'
									// or you can use 'params'=>array('id'=>$id)
								)
							);
						?>
					</div> */?>
				</div>
			</div>

		</div>
	</div>
</div>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
	'id' => 'forcasting-dialog',
	// additional javascript options for the dialog plugin
	'options' => array(
		'title' => 'Forecasting Finance',
		'autoOpen' => false,
		'width' => 'auto',
		'modal' => true,
		),));
		?>
		<div class="row">
			<div class="medium-12 columns">
				<?php $form=$this->beginWidget('CActiveForm', array(
					'action'=>Yii::app()->createUrl($this->route),
					'method'=>'post',
					'enableAjaxValidation'=>false,
					'htmlOptions'=>array(
						'id'=>'forecasting-form',
	           // 'onsubmit'=>"return false;",/* Disable normal form submit */
	           // 'onkeypress'=>" if(event.keyCode == 13){ send(); } " /* Do ajax call when user presses enter key */
						),
						)); ?>
						<div class="row">
							<div class="small-12 columns">
								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<?php echo $form->labelEx($model,'type_forecasting', array('class'=>'prefix')); ?>
										</div>
										<div class="small-8 columns">
											<?php echo $form->hiddenField($model,'id',array('size'=>30,'maxlength'=>30, 'readonly'=>'readonly')); ?>
											<?php echo $form->textField($model,'type_forecasting',array('size'=>30,'maxlength'=>30, 'disabled'=>'disabled')); ?>
											<?php echo $form->error($model,'type_forecasting'); ?>
										</div>
									</div>
								</div>			 
								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<?php echo $form->labelEx($model,'amount', array('class'=>'prefix')); ?>
										</div>
										<div class="small-8 columns">
											<?php echo $form->textField($model,'amount',array('size'=>30,'maxlength'=>30, 'disabled'=>'disabled')); ?>
											<?php echo $form->error($model,'amount'); ?>
										</div>
									</div>
								</div>			 
								<div class="field">
									<div class="row collapse">
										<div class="small-4 columns">
											<?php echo $form->labelEx($model,'payment_date', array('class'=>'prefix')); ?>
										</div>
										<div class="small-8 columns">

											<?php //echo $form->textField($model,'payment_date',array('size'=>30,'maxlength'=>30)); ?>
											<?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
												'model' => $model,
												'attribute' => "payment_date",
												'options'=>array(
													'dateFormat' => 'yy-mm-dd',
													'changeMonth'=>true,
													'changeYear'=>true,
													'yearRange'=>'1900:2020'
													),
												'htmlOptions'=>array(
													'value'=>date('Y-m-d'),
							        //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
													),
												));
												?>
												<?php echo $form->error($model,'payment_date'); ?>
											</div>
										</div>
									</div>			 
									<div class="field">
										<div class="row collapse">
											<div class="small-4 columns">
												<?php echo $form->labelEx($model,'notes', array('class'=>'prefix')); ?>
											</div>
											<div class="small-8 columns">
												<?php echo $form->textField($model,'notes',array('size'=>30,'maxlength'=>30)); ?>
												<?php echo $form->error($model,'notes'); ?>
											</div>
										</div>
									</div>			 
								</div>

								<div class="small-12 columns">
									<?php echo $form->errorSummary($model); ?>

									<div class="field buttons text-right">
										<?php echo CHtml::submitButton('Save', array('class' => 'button cbutton', 'id'=>'saveBtn')); ?>
									</div>
								</div>
							</div>
							<?php $this->endWidget(); ?>
						</div>
					</div>
					<?php $this->endWidget(); ?>



					<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
						'id' => 'forcasting-status-dialog',
						// additional javascript options for the dialog plugin
						'options' => array(
							'title' => 'Forecasting Finance Status',
							'autoOpen' => false,
							'width' => 'auto',
							'modal' => true,
							),));
							?>
							<div class="row">
								<div class="medium-12 columns">
									<?php $form=$this->beginWidget('CActiveForm', array(
										'action'=>Yii::app()->createUrl($this->route),
										'method'=>'post',
										'enableAjaxValidation'=>false,
										'htmlOptions'=>array(
											'id'=>'forecasting-status-form',
											// 'onsubmit'=>"return false;",/* Disable normal form submit */
											// 'onkeypress'=>" if(event.keyCode == 13){ send(); } " /* Do ajax call when user presses enter key */
											),
											)); ?>
											<div class="row">
												<div class="small-12 columns">
													<div class="field">
														<div class="row collapse">
															<div class="small-4 columns">
																<?php echo $form->labelEx($model,'status', array('class'=>'prefix')); ?>
															</div>
															<div class="small-8 columns">
																<?php echo $form->hiddenField($model,'id',array('size'=>30,'maxlength'=>30,'id'=>'Forecasting_id_status','readonly'=>'readonly')); ?>
																<?php echo $form->dropDownList($model, 'status', array('OK' => 'Ok','NOTOK' => 'Not OK', ), array('prompt' => 'Select',)); ?>
																<?php echo $form->error($model,'status'); ?>
															</div>
														</div>
													</div>			 
													<div class="small-12 columns">
														<?php echo $form->errorSummary($model); ?>

														<div class="field buttons text-right">
															<?php echo CHtml::submitButton('Save', array('class' => 'button cbutton', 'id'=>'saveBtnStatus')); ?>
														</div>
													</div>
												</div>
												<?php $this->endWidget(); ?>
											</div>
										</div>
										<?php $this->endWidget(); ?>
										<?php
											// Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/vendor/jquery.number.min.js', CClientScript::POS_HEAD);
											// Yii::app()->clientScript->registerScript('myjavascript', '
											// 	$(".numbers").number( true,2, ".", ",");
										 //    ', CClientScript::POS_END);


										Yii::app()->clientScript->registerScript('search', "

											$('#exportXls').click(function(e){
												var proode = $('#Forecasting_priode option:selected').val();
												var cstartdate = $('#start_date').val();

												console.log(proode + cstartdate);
												if (proode == '' || cstartdate == '') {
													alert('Please select starting date and priode !');
												}else{
													e.preventDefault();
													window.location = '".Yii::app()->baseUrl."/accounting/forecasting/exportXls?startdate='+cstartdate+'&priode='+proode;
												}
											});
											$('#saveBtn').click(function() {
												var data=$('#forecasting-form').serialize();
			// console.log(data);
												$.ajax({
													type: 'POST',
													url: '".Yii::app()->createAbsoluteUrl('accounting/forecasting/ajax')."',
													data:data,
													success:function(data){
														console.log(data); 
														setTimeout(function() {
															window.location.reload();
														},0); 
														$('#forcasting-dialog').dialog('close'); return false;
													},
													error: function(data) { 
														alert('Error occured.please try again');
					// alert(data);
													},
													dataType:'html'
												});
												return false;
											});

											$('.statusPopup').click(function() {
												var id = $(this).attr('data-id');
												$('#Forecasting_id_status').val(id);
			// alert(id);
												$('#forcasting-status-dialog').dialog('open'); return false;
											});

											$('#saveBtnStatus').click(function() {
			// console.log('arg;');
												var data=$('#forecasting-status-form').serialize();
												console.log(data);
												$.ajax({
													type: 'POST',
													url: '".Yii::app()->createAbsoluteUrl('accounting/forecasting/updatestatus')."',
													data:data,
													success:function(data){
					// console.log(data);
														setTimeout(function() {
															window.location.reload();
														},0); 
														$('#forcasting-status-dialog').dialog('close'); return false;
													},
													error: function(data) { 
														alert('Error occured.please try again');
					// alert(data);
													},
													dataType:'html'
												});
												return false;
											});

											$('form').submit(function(){
			// $('#transaction-request-order-grid').yiiGridView('update', {
			// 	data: $(this).serialize()
			// });
			// return false;
											});

											$('.credit').click(function() {
												var tgl = $(this).attr('data-date');
												var id = $(this).attr('data-id');
												var tipe = $(this).attr('data-type');
												var bankid = $(this).attr('data-bank');
												var amount = $(this).text();
												var url = '".Yii::app()->baseUrl."/accounting/forecasting/detail?date='+tgl+'&bankid='+bankid+'&tipe='+tipe;
												if (amount == '0.00') {
													return false;
												}else{
											        newwindow=window.open(url,'name','height=600,width=1200,left=100');
													if (window.focus) {newwindow.focus()}
													// newwindow.onbeforeunload = function(){  $.fn.yiiGridView.update('registration-transaction-grid')}
													// newwindow.onunload = function(){  $.fn.yiiGridView.update('registration-transaction-grid')}
													return false;
												}
											});

											$('.debit').click(function() {
												var tgl = $(this).attr('data-date');
												var id = $(this).attr('data-id');
												var tipe = $(this).attr('data-type');
												var bankid = $(this).attr('data-bank');
												var amount = $(this).text();
												var url = '".Yii::app()->baseUrl."/accounting/forecasting/detail?date='+tgl+'&bankid='+bankid+'&tipe='+tipe;
												if (amount == '0.00') {
													return false;
												}else{
											        newwindow=window.open(url,'name','height=600,width=1200,left=100');
													if (window.focus) {newwindow.focus()}
													newwindow.onbeforeunload = function(){location.reload()}
													newwindow.onunload = function(){location.reload()}
													return false;
												}
											});

											");
											?>

											<?php 
    // Yii::app()->clientScript->registerCssFile('//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/css/jqueryui-editable.css');    
    // Yii::app()->clientScript->registerScriptFile('//cdnjs.cloudflare.com/ajax/libs/x-editable/1.5.0/jqueryui-editable/js/jqueryui-editable.min.js'); 
											?>
