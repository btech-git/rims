<?php
/* @var $this UnitConversionController */
/* @var $model UnitConversion */

$this->breadcrumbs = array(
    'Company',
    'Unit Conversions' => array('admin'),
    $model->id,
);

/* $this->menu=array(
  array('label'=>'List UnitConversion', 'url'=>array('index')),
  array('label'=>'Create UnitConversion', 'url'=>array('create')),
  array('label'=>'Update UnitConversion', 'url'=>array('update', 'id'=>$model->id)),
  array('label'=>'Delete UnitConversion', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
  array('label'=>'Manage UnitConversion', 'url'=>array('admin')),
  ); */
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/UnitConversion/admin'; ?>"><span class="fa fa-th-list"></span>Manage Unit Conversions</a>
        <?php if (Yii::app()->user->checkAccess("masterConversionEdit")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>edit</a>					
        <?php } ?>

        <h1>View UnitConversion #<?php echo $model->id; ?></h1>

        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                //'id',
                array('name' => 'unit_from_id', 'value' => $model->unitFrom->name),
                array('name' => 'unit_to_id', 'value' => $model->unitTo->name),
                //'unit_from_id',
                //'unit_to_id',
                'multiplier',
            ),
        ));
        ?>
    </div>
</div>