<?php
/* @var $this PublicDayOffController */
/* @var $model PublicDayOff */

$this->breadcrumbs = array(
    'Public Day Offs' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List PublicDayOff', 'url' => array('index')),
    array('label' => 'Create PublicDayOff', 'url' => array('create')),
    array('label' => 'Update PublicDayOff', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete PublicDayOff', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage PublicDayOff', 'url' => array('admin')),
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->baseUrl . '/master/' . $ccontroller . '/admin'; ?>"><span class="fa fa-th-list"></span>Manage PublicDayOff</a>
        <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>Edit</a>
        <h1>View Hari Libur Nasional #<?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'date',
                'type',
                'description',
            ),
        )); ?>
    </div>
</div>