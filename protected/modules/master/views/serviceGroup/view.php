<?php
/* @var $this ServiceGroupController */
/* @var $model ServiceGroup */

$this->breadcrumbs = array(
    'Service Groups' => array('index'),
    $model->name,
);

$this->menu = array(
    array('label' => 'List ServiceGroup', 'url' => array('index')),
    array('label' => 'Create ServiceGroup', 'url' => array('create')),
    array('label' => 'Update ServiceGroup', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete ServiceGroup', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage ServiceGroup', 'url' => array('admin')),
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/serviceGroup/admin';?>"><span class="fa fa-th-list"></span>Manage Service Group</a>
        
        <?php if (Yii::app()->user->checkAccess("master.supplier.update")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update', array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/addVehicle', array('id' => $model->id)); ?>"><span class="fa fa-plus"></span>Add Vehicle Model</a>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/addService', array('id' => $model->id));?>"><span class="fa fa-plus"></span>Add Service</a>
        <?php } ?>
            
        <h1>View Service Group #<?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'name',
                'standard_flat_rate',
                'description',
            ),
        )); ?>
    </div>
</div>

<br />

<div>
    <table>
        <thead>
            <tr>
                <th>Car Make</th>
                <th>Car Model</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($model->vehicleCarModels as $detail): ?>
            <tr>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'carMake.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'description')); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<br />

<div>
    <table>
        <thead>
            <tr>
                <th>Code</th>
                <th>Service</th>
                <th>Category</th>
                <th>Type</th>
                <th>Flat Rate Hour</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($model->servicePricelists as $detail): ?>
            <tr>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'service.code')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'service.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'service.serviceCategory.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'service.serviceType.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($detail, 'flat_rate_hour')); ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
