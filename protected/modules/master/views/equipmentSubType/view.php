<?php
/* @var $this EquipmentSubTypeController */
/* @var $model EquipmentSubType */

$this->breadcrumbs = array(
    'Equipment Sub Types' => array('admin'),
    $model->name,
);

/*
  $this->menu=array(
  array('label'=>'List EquipmentSubType', 'url'=>array('index')),
  array('label'=>'Create EquipmentSubType', 'url'=>array('create')),
  array('label'=>'Update EquipmentSubType', 'url'=>array('update', 'id'=>$model->id)),
  array('label'=>'Delete EquipmentSubType', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')), array('label'=>'Manage EquipmentSubType', 'url'=>array('admin')
  ),
  );
 */
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/equipmentSubType/admin'; ?>"><span class="fa fa-th-list"></span>Manage EquipmentSubType</a>
        <?php if (Yii::app()->user->checkAccess("masterEquipmentSubTypeEdit")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>edit</a>
        <?php } ?>
        <h1>View <?php echo $model->name ?></h1>

        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                //'equipment_type_id',
                array('name' => 'equipment_type_id', 'value' => $model->equipmentType->name),
                'name',
                'description',
                'status',
            ),
                )
        );
        ?>

    </div>
</div>
