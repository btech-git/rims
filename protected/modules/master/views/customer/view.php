<?php
/* @var $this CustomerController */
/* @var $model Customer */

$this->breadcrumbs = array(
    'Company',
    'Customers' => array('admin'),
    'View Customer ' . $model->name,
);

// $this->menu=array(
// 	array('label'=>'List Customer', 'url'=>array('index')),
// 	array('label'=>'Create Customer', 'url'=>array('create')),
// 	array('label'=>'Update Customer', 'url'=>array('update', 'id'=>$model->id)),
// 	array('label'=>'Delete Customer', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
// 	array('label'=>'Manage Customer', 'url'=>array('admin')),
// );
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>

        <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/customer/admin'; ?>"><span class="fa fa-th-list"></span>Manage Customer</a>
        <?php if (Yii::app()->user->checkAccess("master.customer.update")) { ?>
            <a class="button warning right" style="margin-right:10px;"
               href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id));
            ?>"><span class="fa fa-pencil"></span>edit</a>
       <?php } ?>
        <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/addVehicle', array('id' => $model->id)); ?>">
            <span class="fa fa-plus"></span>Add Vehicle
        </a>
        <!--        <a class="button cbutton right" style="margin-right:10px;"
                   href="<?php /* echo Yii::app()->createUrl('/frontDesk/registrationTransaction/create',
             array('type' => 1, 'id' => $model->id)); */ ?>"><span class="fa fa-plus"></span>Registration</a>-->
        <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/transaction/consignmentOutHeader/create'); ?>">
            <span class="fa fa-plus"></span>Consignment Out
        </a>
             
        <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/transaction/transactionSalesOrder/create'); ?>">
            <span class="fa fa-plus"></span>Sales
        </a>

        <h1>View <?php echo $model->name ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'name',
                'address',
                array('name' => 'province_name', 'value' => $model->province->name),
                array('name' => 'city_name', 'value' => $model->city->name),
                array('name' => 'coa_name', 'value' => $model->coa ? $model->coa->name : ''),
                array('name' => 'coa_code', 'value' => $model->coa ? $model->coa->code : ''),
                'zipcode',
                'phone',
                'mobile_phone',
                'fax',
                'email',
                'note',
                'customer_type',
                'tenor',
                'status',
                'birthdate',
                'flat_rate',
            ),
        )); ?>
    </div>
</div>

<div class="row">
    <h5>Customer PIC</h5>
    <?php if ($picDetails) { ?>
        <table class="detail">
            <thead>
                <tr>
                    <td>Name</td>
                    <td>Address</td>
                    <td>Province</td>
                    <td>City</td>
                    <td>Zipcode</td>
                    <td>Fax</td>
                    <td>Email</td>
                    <td>Note</td>
                    <td>Birthdate</td>
                    <td>Action</td>
                </tr>
            </thead>
            
            <?php foreach ($picDetails as $key => $picDetail): ?>
                <tr>
                    <td><?php echo $picDetail->name; ?></td>
                    <td><?php echo $picDetail->address; ?></td>
                    <td><?php echo ($picDetail->province ? $picDetail->province->name : ''); ?></td>
                    <td><?php echo ($picDetail->city ? $picDetail->city->name : ''); ?></td>
                    <td><?php echo $picDetail->zipcode; ?></td>
                    <td><?php echo $picDetail->fax; ?></td>
                    <td><?php echo $picDetail->email; ?></td>
                    <td><?php echo $picDetail->note; ?></td>
                    <td><?php echo $picDetail->birthdate; ?></td>
                    <td>
                        <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/updatePic', array('custId' => $model->id, 'picId' => $picDetail->id)); ?>">
                            <span class="fa fa-pencil"></span>edit
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php
    } else {
        echo "<h6><b>No Pic for this Customer.</b></h6>";
    }
    ?>
</div>

<div class="row">
    <h5>Vehicles</h5>
    <table class="detail">
        <thead>
            <tr>
                <td>Plat Number</td>
                <td>Machine Number</td>
                <td>Frame Number</td>
                <td>Car Make</td>
                <td>Car Model</td>
                <td>Car Sub Model</td>
                <td>Color</td>
                <td>Year</td>
                <td>Chasis Code</td>
                <td>Power CC</td>
                <td>Notes</td>
                <td colspan="3" style="text-align:center">Action</td>
            </tr>
        </thead>
        <?php foreach ($vehicleDetails as $key => $vehicleDetail): ?>
            <tr>
                <td><?php echo CHtml::link($vehicleDetail->plate_number, Yii::app()->createUrl("master/vehicle/view", array("id" => $vehicleDetail->id)), array('target' => '_blank')); ?></td>
                <td><?php echo $vehicleDetail->machine_number; ?></td>
                <td><?php echo $vehicleDetail->frame_number; ?></td>
                <td><?php echo $vehicleDetail->carMake ? $vehicleDetail->carMake->name : ''; ?></td>
                <td><?php echo $vehicleDetail->carModel ? $vehicleDetail->carModel->name : ''; ?></td>
                <td><?php echo $vehicleDetail->carSubModel ? $vehicleDetail->carSubModel->name : ''; ?></td>
                <?php $color = Colors::model()->findByPk($vehicleDetail->color_id); ?>
                <td><?php echo $color->name == '' ? '' : $color->name; ?></td>
                <td><?php echo $vehicleDetail->year; ?></td>
                <td><?php echo $vehicleDetail->chasis_code; ?></td>
                <td><?php echo $vehicleDetail->power; ?></td>
                <td><?php echo $vehicleDetail->notes; ?></td>
                <td>
                    <a class="button warning center" style="margin-right:10px;" 
                       href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/updateVehicle', array('custId' => $model->id, 'vehicleId' => $vehicleDetail->id)); ?>">
                        <span class="fa fa-pencil"></span>edit
                    </a>
                    
                    <a class="button success center" style="margin-right:10px;" 
                       href="<?php echo Yii::app()->createUrl('/frontDesk/generalRepairRegistration/create', array('vehicleId' => $vehicleDetail->id)); ?>">
                        GR
                    </a>
                    
                    <a class="button success center" style="margin-right:10px;" 
                       href="<?php echo Yii::app()->createUrl('/frontDesk/bodyRepairRegistration/create', array('vehicleId' => $vehicleDetail->id)); ?>">
                        BR
                    </a>
                </td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<div class="row">
    <h5>Service Exception Rates</h5>
    <table class="detail">
        <thead>
            <tr>
                <td>Service Type</td>
                <td>Service Category</td>
                <td>Service</td>
                <td>Car Make</td>
                <td>Car Model</td>
                <td>Car Sub Model</td>
                <td>Rate</td>
                <td>Action</td>
            </tr>
        </thead>
        <?php foreach ($rateDetails as $key => $rateDetail): ?>
            <tr>
                <?php $service; ?>
                <td><?php echo $rateDetail->serviceType ? $rateDetail->serviceType->name : ''; ?></td>
                <td><?php echo $rateDetail->serviceCategory ? $rateDetail->serviceCategory->name : ''; ?></td>
                <td><?php echo $rateDetail->service ? $rateDetail->service->name . ' (' . $rateDetail->service->code . ')' : ''; ?></td>
                <td><?php echo $rateDetail->carMake ? $rateDetail->carMake->name : ''; ?></td>
                <td><?php echo $rateDetail->carModel ? $rateDetail->carModel->name : ''; ?></td>
                <td><?php echo $rateDetail->carSubModel ? $rateDetail->carSubModel->name : ''; ?></td>
                <td><?php echo $rateDetail->rate; ?></td>
                <td>
                    <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/updatePrice', array('custId' => $model->id, 'priceId' => $rateDetail->id)); ?>">
                        <span class="fa fa-pencil"></span>edit
                    </a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<br/>

<div>
    <?php if ((int) $model->is_approved === 0): ?>
        <div style="float: left; margin-left: 20px;">
            <?php echo CHtml::beginForm(); ?>
                <?php echo CHtml::submitButton('APPROVE', array('name' => 'Approve', 'class' => 'button success')); ?>
            <?php echo CHtml::endForm(); ?>
        </div>
    <?php endif; ?>
    <div class="clear"></div>
</div>