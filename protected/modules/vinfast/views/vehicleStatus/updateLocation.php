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
        <table class="table table-bordered table-striped">
            <tbody>
                <tr>
                    <th>Mesin #</th>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'machine_number')); ?></td>
                    <th>Plat #</th>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'plate_number')); ?></td>
                </tr>
                <tr>
                    <th>Rangka #</th>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'frame_number')); ?></td>
                    <th>Mobil Tipe</th>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($vehicle, 'carMake.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($vehicle, 'carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($vehicle, 'carSubModel.name')); ?>
                    </td>
                </tr>
                <tr>
                    <th>Warna</th>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'colors.name')); ?></td>
                    <th>Tahun</th>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'year')); ?></td>
                </tr>
                <tr>
                    <th>Transmisi</th>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'transmission')); ?></td>
                    <th>Bensin/Diesel</th>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'fuel_type')); ?></td>
                </tr>
                <tr>
                    <th>Power</th>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'power')); ?></td>
                    <th>Drivetrain</th>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'drivetrain')); ?></td>
                </tr>
                <tr>
                    <th>Asuransi</th>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'insuranceCompany.name')); ?></td>
                    <th>Chasis</th>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'chasis_code')); ?></td>
                </tr>
                <tr>
                    <th>Lokasi</th>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'status_location')); ?></td>
                    <th>Note</th>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'notes')); ?></td>
                </tr>
            </tbody>
        </table>
    </div>
        
    <div class="row">
        <?php $customer = Customer::model()->findByPk($vehicle->customer_id) ?>
        <h5>Customer</h5>
        <table class="table table-bordered table-sm">
                <tr>
                    <td>ID</td>
                    <td>Name</td>
                    <td>Type</td>
                    <td>Address</td>
                    <td>Province</td>
                    <td>City</td>
                    <td>Email</td>
                    <td>Note</td>
                </tr>

                <tr>
                    <td><?php echo CHtml::link($customer->id, array("/master/customer/view", "id"=>$customer->id), array('target' => '_blank')) ?></td>
                    <td><?php echo CHtml::link($customer->name, array("/master/customer/view", "id"=>$customer->id), array('target' => '_blank')) ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($customer, 'customer_type')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($customer, 'address')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($customer, 'province.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($customer, 'city.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($customer, 'email')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($customer, 'note')); ?></td>
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
            Status Location
            <?php echo CHtml::activeDropDownList($vehicle, 'status_location', array(
                'Masuk Lokasi' => 'Masuk Lokasi',
                'On-Progress' => 'On-Progress',
                'Keluar Lokasi' => 'Keluar Lokasi',
            ), array('empty' => '-- Pilih Status --')); ?>
            <?php echo CHtml::error($vehicle, 'status_location'); ?>
        </div>
        
        <hr />
        
        <div class="field buttons text-center">
            <?php echo CHtml::submitButton($vehicle->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton')); ?>
        </div>

        <?php $this->endWidget(); ?>

    </div><!-- form -->
</div>
