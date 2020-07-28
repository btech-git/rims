<?php foreach ($requestOrder->details as $i => $detail): ?>
	<table>
		<tr>
			<td>
				Product : <?php echo CHtml::activeHiddenField($detail, "[$i]product_id", array('size'=>20,'maxlength'=>20)); ?>
				<?php echo CHtml::activeTextField($detail,"[$i]product_name", array(
					'size'=>15,
					'maxlength'=>10,
					'rel'=>$i,
					'onclick' => '
						currentProduct=$(this).attr("rel");
						// currentProductValue["A"+currentProduct]=$(this).val();
						// console.log(currentProduct); console.log(currentProductValue);
						$("#product-dialog").dialog("open"); 
						return false;
					',
					'value' => $detail->product_id == "" ? '': Product::model()->findByPk($detail->product_id)->name
					)
				); 
				?>
			</td>
			<td>
				Supplier:
				<?php echo CHtml::activeHiddenField($detail, "[$i]supplier_id", array('size'=>20,'maxlength'=>20)); ?>
				<?php 
				echo CHtml::activeTextField($detail,"[$i]supplier_name",array(
					'size'=>15,
					'rel'=>$i,
					'maxlength'=>10,
					'onclick' => '
						currentSupplier=$(this).attr("rel");
						// currentSupplierValue["A"+currentSupplier]=$(this).val();
						// console.log(currentSupplier); console.log(currentSupplierValue);
						$("#supplier-dialog").dialog("open"); return false;
					',
					'value' => $detail->supplier_id == "" ? '': Supplier::model()->findByPk($detail->supplier_id)->name
					)
				); 
				?>
			</td>
			<td>
				<br />
				<?php
					echo CHtml::button('X', array(
						'onclick' => CHtml::ajax(array(
							'type' => 'POST',
							'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $requestOrder->header->id, 'index' => $i)),
							'update' => '#price',
						)),
					));
				?>
			</td>
		</tr>
		<tr>
			<td colspan="3"> content
				<?php 
				$this->widget('zii.widgets.jui.CJuiTabs', array(
					'tabs' => array(
						'Detail Item'=>array(
							'id'=>'test',
							'content'=>$this->renderPartial('_detail1',array(
								'i'=>$i,
								'detail'=>$detail,
								'priceDataProvider'=>$priceDataProvider,
								'price'=>$price),TRUE)
						),
						'Detail Approval'=>array(
							'id'=>'test1',
							'content'=>$this->renderPartial('_detailApproval',array(
								'i'=>$i,
								'requestOrder'=>$requestOrder),TRUE)
						),
						'Detail Ordered'=>array(
							'id'=>'test2',
							'content'=>$this->renderPartial('_detailOrder',array(
								'i'=>$i,
								'detail'=>$detail),TRUE)
						),
						'Detail Receive'=>'',
					),
					'options' => array( 'collapsible' => TRUE),
					'id'=>'Request'.$i.'tab',
					)
				);
				?>
			</td>
		</tr>
	</table>
<?php
Yii::app()->clientScript->registerScript('myjquery'.$i, '
	var adanilai'.$i.' = $("#TransactionRequestOrderDetail_'.$i.'_discount_step option:selected").text();
	console.log(adanilai'.$i.');
	if (adanilai'.$i.' == 1) {
		$("#step1_'.$i.'").show();
		$("#step2_'.$i.'").hide();
		$("#step3_'.$i.'").hide();
		$("#step4_'.$i.'").hide();
		$("#step5_'.$i.'").hide();
	}else if (adanilai'.$i.' == 2) {
		$("#step1_'.$i.'").show();
		$("#step2_'.$i.'").show();
		$("#step3_'.$i.'").hide();
		$("#step4_'.$i.'").hide();
		$("#step5_'.$i.'").hide();
	}else if (adanilai'.$i.' == 3) {
		$("#step1_'.$i.'").show();
		$("#step2_'.$i.'").show();
		$("#step3_'.$i.'").show();
		$("#step4_'.$i.'").hide();
		$("#step5_'.$i.'").hide();
	}else if (adanilai'.$i.' == 4) {
		$("#step1_'.$i.'").show();
		$("#step2_'.$i.'").show();
		$("#step3_'.$i.'").show();
		$("#step4_'.$i.'").show();
		$("#step5_'.$i.'").hide();
	}else if (adanilai'.$i.' == 5) {
		$("#step1_'.$i.'").show();
		$("#step2_'.$i.'").show();
		$("#step3_'.$i.'").show();
		$("#step4_'.$i.'").show();
		$("#step5_'.$i.'").show();
	}else{
		$("#step1_'.$i.'").hide();
		$("#step2_'.$i.'").hide();
		$("#step3_'.$i.'").hide();
		$("#step4_'.$i.'").hide();
		$("#step5_'.$i.'").hide();
	}
');
?>

<?php endforeach; ?>

<?php
/*Yii::app()->clientScript->registerScript('myjquery', '
	var TransactionRequestOrderDetail_0_discount_step
	$("div[id^=step1_]").hide();
	$("div[id^=step2_]").hide();
	$("div[id^=step3_]").hide();
	$("div[id^=step4_]").hide();
	$("div[id^=step5_]").hide();
');
*/?>
