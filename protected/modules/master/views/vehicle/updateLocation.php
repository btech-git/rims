<?php
/* @var $this VehicleController */
/* @var $model Vehicle */

$this->breadcrumbs=array(
	'Vehicle'=>array('admin'),
	'Vehicles'=>array('admin'),
	//$model->id=>array('view','id'=>$model->id),
	'Update',
);

$this->menu=array(
	array('label'=>'List Vehicle', 'url'=>array('index')),
	array('label'=>'Create Vehicle', 'url'=>array('create')),
	array('label'=>'View Vehicle', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Vehicle', 'url'=>array('admin')),
);
?>

<div id="maincontent">
    <h1>Update Location Vehicle <?php echo $model->plate_number; ?></h1>

    <div class="row">
        <div class="small-12 columns">
            <?php $this->widget('zii.widgets.CDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'plate_number',
                    'machine_number',
                    'frame_number',
                    array(
                        'name' => 'car_make', 
                        'value' => $model->carMake->name
                    ),
                    array(
                        'name' => 'car_model', 
                        'value' => $model->carModel->name
                    ),
                    array(
                        'name' => 'car_sub_model', 
                        'value' => $model->carSubModel->name
                    ),
                    array(
                        'label' => 'Color', 
                        'value' => empty($model->color_id) ? '' : $model->color->name,
                    ),
                    'year',
                    'chasis.name: Chassis',
                    'status_location',
                    'notes',
                ),
            )); ?>
        </div>

        <div class="small-12 columns">
            <?php $customer = Customer::model()->findByPk($model->customer_id) ?>
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
                        <?php echo $form->labelEx($model, 'status_location', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($model, 'status_location', array(
                            'Masuk Lokasi' => 'Masuk Lokasi',
                            'On-Progress' => 'On-Progress',
                            'Keluar Lokasi' => 'Keluar Lokasi',
                        ), array('empty' => '-- Pilih Status --')); ?>
                        <?php echo $form->error($model, 'status_location'); ?>
                    </div>
                </div>			
            </div>
        </div>
        
        <hr />
        
        <div class="field buttons text-center">
            <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>
