<?php
/* @var $this MovementInHeaderController */
/* @var $model MovementInHeader */

$this->breadcrumbs=array(
	'Movement In Headers'=>array('admin'),
	$model->id,
);

$this->menu=array(
	array('label'=>'List MovementInHeader', 'url'=>array('admin')),
	array('label'=>'Create MovementInHeader', 'url'=>array('create')),
	array('label'=>'Update MovementInHeader', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete MovementInHeader', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage MovementInHeader', 'url'=>array('admin')),
);
?>

<!--<h1>View MovementInHeader #<?php echo $model->id; ?></h1>-->
<div id="maincontent">
	<div class="clearfix page-action">
		<?php $ccontroller = Yii::app()->controller->id; ?>
		<?php $ccaction = Yii::app()->controller->action->id; ?>
		<?php echo CHtml::link('<span class="fa fa-list"></span>Manage Movement In', Yii::app()->baseUrl.'/transaction/movementInHeader/admin', array('class'=>'button cbutton right', 'visible'=>Yii::app()->user->checkAccess("transaction.movementInHeader.admin"))) ?>
		
		<?php if(($model->status != 'Approved') && ($model->status != 'Delivered') && ($model->status != 'Finished') && $model->status != 'Rejected'): ?>
			<?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl.'/transaction/movementInHeader/update?id=' . $model->id, array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.movementInHeader.update"))) ?>
				<?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl.'/transaction/movementInHeader/updateApproval?headerId=' . $model->id , array('class'=>'button cbutton right','style'=>'margin-right:10px', 'visible'=>Yii::app()->user->checkAccess("transaction.movementInHeader.updateApproval"))) ?>
			
			<!-- <a class="button cbutton right" style="margin-right:10px;" href="<?php //echo Yii::app()->createUrl('/transaction/'.$ccontroller.'/updateStatus',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>Update Status</a> -->
			
		<?php endif ?>
		<?php /*echo CHtml::button('Update Delivered', array(
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
            ));*/ ?>
        <?php if ($model->status != 'Finished'): ?>
            <?php echo CHtml::button('Update Received', array(
                'id' => 'detail-button',
                'name' => 'Detail',
                'class'=>'button cbutton right',
                'style'=>'margin-right:10px',
                'disabled'=>$model->status == 'Approved' ? false : true,
                'onclick' => ' 
                    $.ajax({
                        type: "POST",
                        //dataType: "JSON",
                        url: "' . CController::createUrl('updateReceived', array('id'=> $model->id)) . '",
                        data: $("form").serialize(),
                        success: function(html) {
                            alert("Status Succesfully Updated");
                            location.reload();
                        },
                    })
                '
            )); ?>
		<?php endif ?>
		<br>
		<h1>View MovementInHeader #<?php echo $model->id; ?></h1>

		<?php $this->widget('zii.widgets.CDetailView', array(
			'data'=>$model,
			'attributes'=>array(
				//'id',
				'movement_in_number',
				'date_posting',
				array('name'=>'branch_id', 'value'=>$model->branch_id == "" ? '-' : $model->branch->name),
				//'branch_id',
				//array('name'=>'movement_type', 'value'=>$model->movement_type == 1 ? 'Receive Item' : 'Return Item'),
				//'movement_type',
				//'receive_item_id',
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
	        		$movementType = "Receive Item";
        		}elseif ($model->movement_type == 2) {
        			$movementType = "Return Item";
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
  		$receive = TransactionReceiveItem::model()->findByPk($model->receive_item_id);
		if(count($receive) != 0) {
			if($receive->request_type == "Internal Delivery Order"){
				$type = "Internal Delivery Order";
				$requestNumber = $receive->deliveryOrder->delivery_order_no;
			}
			elseif ($receive->request_type == "Purchase Order") {
				$type = "Purchase Order";
				$requestNumber = $receive->purchaseOrder->purchase_order_no;
			}
			elseif ($receive->request_type == "Consignment In") {
				$type = "Consignment In";
				$requestNumber = $receive->consignmentIn->consignment_in_number;
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
  	<?php else: ?>
  		<div class="row">
		    <div class="small-8">
		      <div class="row">
		        <div class="small-3 columns">
		          <label for="right-label" class="right" style="font-weight:bold;">Reference #</label>
		        </div>
		        <div class="small-9 columns">
		        	
	        		
	        		<label for=""><?php echo $model->return_item_id != "" ? $model->returnItem->return_item_no : ""; ?></label>
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