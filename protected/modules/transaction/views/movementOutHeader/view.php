<?php
/* @var $this MovementOutHeaderController */
/* @var $model MovementOutHeader */

$this->breadcrumbs=array(
	'Movement Out Headers'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MovementOutHeader', 'url'=>array('index')),
	array('label'=>'Create MovementOutHeader', 'url'=>array('create')),
	array('label'=>'Update MovementOutHeader', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MovementOutHeader', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MovementOutHeader', 'url'=>array('admin')),
);
?>

<!--<h1>View MovementOutHeader #<?php echo $model->id; ?></h1>-->
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>
		<?php echo CHtml::link('<span class="fa fa-list"></span>Manage Movement Out', Yii::app()->baseUrl.'/transaction/movementOutHeader/admin', array('class'=>'button cbutton right', 'visible'=>Yii::app()->user->checkAccess("transaction.movementOutHeader.admin"))) ?>
		<?php if (($model->status != 'Approved') && ($model->status != 'Delivered') && ($model->status != 'Finished') && $model->status != 'Rejected'): ?>
			<?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl.'/transaction/movementOutHeader/update?id=' . $model->id, array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.movementOutHeader.update"))) ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl.'/transaction/movementOutHeader/updateApproval?headerId=' . $model->id , array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.movementOutHeader.updateApproval"))) ?>
		<?php endif; ?>
        
        <?php if ($model->status != 'Finished'): ?>
            <?php echo CHtml::button('Update Delivered', array(
                'id' => 'detail-button',
                'name' => 'Detail',
                'class'=>'button cbutton right',
                'style'=>'margin-right:10px',
                'disabled'=>$model->status == 'Approved' ? false : true,
                'onclick' => ' 
                    $.ajax({
                    type: "POST",
                    //dataType: "JSON",
                    url: "' . CController::createUrl('updateDelivered', array('id'=> $model->id)) . '",
                    data: $("form").serialize(),
                    success: function(html) {
                        alert("Status Succesfully Updated");
                        location.reload();
                    },})
                '
            )); ?>
        <?php endif ?>
        
		<?php /*echo CHtml::button('Update Received', array(
        'id' => 'detail-button',
        'name' => 'Detail',
        'class'=>'button cbutton right',
        'style'=>'margin-right:10px',
        'disabled'=>$model->status == 'Delivered' ? false : true,
        'onclick' => ' 
            $.ajax({
            type: "POST",
            //dataType: "JSON",
            url: "' . CController::createUrl('updateReceived', array('id'=> $model->id)) . '",
            data: $("form").serialize(),
            success: function(html) {

                alert("Status Succesfully Updated");
                location.reload();
            },})
        '
        )); */?>
		<br>
		<h1>View MovementOutHeader #<?php echo $model->id; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				//'id',
				'movement_out_no',
				'date_posting',
				array('name'=>'branch_id', 'value'=>$model->branch_id == "" ? '-' : $model->branch->name),
				//'delivery_order_id',
				//'branch_id',
				'user.username',
				//'supervisor_id',
				'status',
			),
		)); ?>
	</div>
</div>
<br>
<div class="detail">
	<div class="row">
	    <div class="small-8">
	      <div class="row">
	        <div class="small-3 columns">
	          <label for="right-label" class="right" style="font-weight:bold;">Movement Type</label>
	        </div>
	        <div class="small-9 columns">
	        	<?php if($model->movement_type == 1){
	        		$movementType = "Delivery Order";
        		}elseif ($model->movement_type == 2) {
        			$movementType = "Return Order";
        		}elseif ($model->movement_type == 3) {
        			$movementType = "Retail Sales";
        		}else{
        			$movementType = "";
        		} ?>
        		
        		<label for=""><?php echo $movementType; ?></label>
	         <!--  <input type="text" id="right-label" value="<?php //echo $movementType; ?>" readonly="true"> -->
	        </div>
	      </div>
	    </div>
  </div>
  <?php if($model->movement_type == 1): ?>
  	<?php 
  		
		$delivery = TransactionDeliveryOrder::model()->findByPk($model->delivery_order_id);
			if(count($delivery) != 0) {
				if($delivery->request_type == "Sales Order"){
					$type = "Sales Order";
					$requestNumber = $delivery->salesOrder->sale_order_no;
				}
				elseif ($delivery->request_type == "Sent Request") {
					$type = "Sent Request";
					$requestNumber = $delivery->sentRequest->sent_request_no;
				}
				elseif ($delivery->request_type == "Consignment Out") {
					$type = "Consignment out";
					$requestNumber = $delivery->consignmentOut->consignment_out_no;
				}
				elseif ($delivery->request_type == "Transfer Request") {
					$type = "Transfer Request";
					$requestNumber = $delivery->transferRequest->transfer_request_no;
				}
			}
	 ?>
	  <div class="row">
		    <div class="small-8">
		      <div class="row">
		        <div class="small-3 columns">
		          <label for="right-label" class="right" style="font-weight:bold;">Reference Type</label>
		        </div>
		        <div class="small-9 columns">

	        		<label for=""><?php echo $type; ?></label>
		         <!--  <input type="text" id="right-label" value="<?php //echo $movementType; ?>" readonly="true"> -->
		        </div>
		      </div>
		    </div>
	  </div>
	  <div class="row">
		    <div class="small-8">
		      <div class="row">
		        <div class="small-3 columns">
		          <label for="right-label" class="right" style="font-weight:bold;">Reference #</label>
		        </div>
		        <div class="small-9 columns">
		        	
	        		
	        		<label for=""><?php echo $requestNumber; ?></label>
		         <!--  <input type="text" id="right-label" value="<?php //echo $movementType; ?>" readonly="true"> -->
		        </div>
		      </div>
		    </div>
	  </div>
  	<?php elseif($model->movement_type == 2): ?>
  		<div class="row">
		    <div class="small-8">
		      <div class="row">
		        <div class="small-3 columns">
		          <label for="right-label" class="right" style="font-weight:bold;">Reference #</label>
		        </div>
		        <div class="small-9 columns">
		        	
	        		
	        		<label for=""><?php echo $model->return_order_id != "" ? $model->returnOrder->return_order_no : ""; ?></label>
		         <!--  <input type="text" id="right-label" value="<?php //echo $movementType; ?>" readonly="true"> -->
		        </div>
		      </div>
		    </div>
	  </div>
	<?php else: ?>
  		<div class="row">
		    <div class="small-8">
		      <div class="row">
		        <div class="small-3 columns">
		          <label for="right-label" class="right" style="font-weight:bold;">Reference #</label>
		        </div>
		        <div class="small-9 columns">
		        	
	        		
	        		<label for=""><?php echo $model->registration_transaction_id != "" ? $model->registrationTransaction->transaction_number : ""; ?></label>
		         <!--  <input type="text" id="right-label" value="<?php //echo $movementType; ?>" readonly="true"> -->
		        </div>
		      </div>
		    </div>
	  </div>
	<?php endif ?>
</div>
<br>
	<div class="detail">
		<?php 
				$this->widget('zii.widgets.jui.CJuiTabs', array(
			    'tabs' => array(
			        'Detail Item'=>array('id'=>'test1','content'=>$this->renderPartial(
                                        '_viewDetail',
                                        array('details'=>$details),TRUE)),
			        'Detail Approval'=>array('id'=>'test2','content'=>$this->renderPartial(
                                        '_viewDetailApproval',
                                        array('historis'=>$historis),TRUE)),
			       	'Detail Distribution'=>array('id'=>'test3','content'=>$this->renderPartial(
                                        '_viewDetailShipping',
                                        array('shippings'=>$shippings),TRUE)),
			       
			  ),                       
			       
			 
			    // additional javascript options for the tabs plugin
			    'options' => array(
			        'collapsible' => true,
			    ),
			    // set id for this widgets
			    'id'=>'view_tab',
			));
	?>
		
	</div>