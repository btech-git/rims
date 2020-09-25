<?php
/* @var $this VehicleCarMakeController */
/* @var $model VehicleCarMake */

$this->breadcrumbs = array(
    'Vehicle' => Yii::app()->baseUrl . '/master/vehicle/admin',
    'Vehicle Car Makes' => array('admin'),
    'View Vehicle Car Make ' . $model->name,
);

$this->menu = array(
    array('label' => 'List VehicleCarMake', 'url' => array('index')),
    array('label' => 'Create VehicleCarMake', 'url' => array('create')),
    array('label' => 'Update VehicleCarMake', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete VehicleCarMake', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage VehicleCarMake', 'url' => array('admin')),
);
?>
<!--<div class="row">
        <div class="small-12 columns">
                <div class="breadcrumbs">
                        <a href="<?php echo Yii::app()->baseUrl . '/site/index'; ?>">Home</a>
                        <a href="<?php echo Yii::app()->baseUrl . '/master/vehicle/admin'; ?>">Vehicle</a>
                        <a href="<?php echo Yii::app()->baseUrl . '/master/vehicleCarMake/admin'; ?>">Vehicle Car Make</a>
                        
                        <span>View Vehicle Car Make </span>
                </div>
        </div>
</div>-->
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/admin'); ?>"><span class="fa fa-th-list"></span>Manage Vehicle Car Makes </a>
        <?php if (Yii::app()->user->checkAccess("master.vehicleCarMake.update")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>edit</a>
        <?php } ?>
        <h1>View Vehicle Car Make <?php echo $model->name; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'name',
                'status',
            ),
        )); ?>
    </div>
</div>