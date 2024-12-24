<?php
/* @var $this VehicleController */
/* @var $vehicle Vehicle */

$this->breadcrumbs=array(
	'Vehicle'=>array('admin'),
	'Vehicles'=>array('admin'),
	//$vehicle->id=>array('view','id'=>$vehicle->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Vehicle', 'url'=>array('index')),
	array('label'=>'Create Vehicle', 'url'=>array('create')),
	array('label'=>'View Vehicle', 'url'=>array('view', 'id'=>$vehicle->id)),
	array('label'=>'Manage Vehicle', 'url'=>array('admin')),
);
?>

<div id="maincontent">
    <h1>Update Location Vehicle <?php echo $vehicle->plate_number; ?></h1>

    <div class="row">
        <div class="small-12 columns">
            <?php $this->widget('zii.widgets.CDetailView', array(
                'data' => $vehicle,
                'attributes' => array(
                    'plate_number',
                    'machine_number',
                    'frame_number',
                    array(
                        'name' => 'car_make', 
                        'value' => $vehicle->carMake->name
                    ),
                    array(
                        'name' => 'car_model', 
                        'value' => $vehicle->carModel->name
                    ),
                    array(
                        'name' => 'car_sub_model', 
                        'value' => $vehicle->carSubModel->name
                    ),
                    array(
                        'label' => 'Color', 
                        'value' => empty($vehicle->color_id) ? '' : $vehicle->color->name,
                    ),
                    'year',
                    'chasis.name: Chassis',
                    'status_location',
                    'notes',
                ),
            )); ?>
        </div>

        <div class="small-12 columns">
            <?php $customer = Customer::model()->findByPk($vehicle->customer_id) ?>
            <h5>Customer</h5>
            <table class="detail">
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Address</td>
                    <td>Province</td>
                    <td>City</td>
                    <td>Email</td>
                    <td>Note</td>
                </tr>

                <tr>
                    <td><?php echo CHtml::link($customer->id, array("/master/customer/view", "id"=>$customer->id), array('target' => '_blank')) ?></td>
                    <td><?php echo CHtml::link($customer->name, array("/master/customer/view", "id"=>$customer->id), array('target' => '_blank')) ?></td>
                    <td><?php echo $customer->address; ?></td>
                    <td><?php echo $customer->province_id != "" ? $customer->province->name : '-'; ?></td>
                    <td><?php echo $customer->city_id != "" ? $customer->city->name : '-'; ?></td>
                    <td><?php echo $customer->email; ?></td>
                    <td><?php echo $customer->note; ?></td>
                </tr>
            </table>
        </div>
    </div>
    
    <div class="form">
        <?php $form = $this->beginWidget('CActiveForm', array(
            'id' => 'vehicle-form',
            'enableAjaxValidation' => false,
        )); ?>
        <div class="row">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($vehicle, 'status_location', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($vehicle, 'status_location', array(
                            'Masuk Bengkel' => 'Masuk Bengkel',
                            'Waitlist' => 'Waitlist',
                            'Bongkar' => 'Bongkar',
                            'Sparepart' => 'Sparepart',
                            'Ketok/Las' => 'Ketok/Las',
                            'Dempul' => 'Dempul',
                            'Epoxy' => 'Epoxy',
                            'Cat' => 'Cat',
                            'Pasang' => 'Pasang',
                            'Cuci' => 'Cuci',
                            'Poles' => 'Poles',
                            'Finishing' => 'Finishing',
                            'Keluar Bengkel' => 'Keluar Bengkel',
                        ), array('empty' => '-- Pilih Status --')); ?>
                        <?php echo $form->error($vehicle, 'status_location'); ?>
                    </div>
                </div>			
            </div>
        </div>
        
        <hr />
        
        <div class="field buttons text-center">
            <?php echo CHtml::submitButton($vehicle->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>
