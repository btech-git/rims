<?php
/* @var $this InspectionSectionController */
/* @var $model InspectionSection */

$this->breadcrumbs = array(
    'Service',
    'Inspection Sections' => array('admin'),
    'View Inspection Section ' . $model->name,
);

/* $this->menu=array(
  array('label'=>'List InspectionSection', 'url'=>array('index')),
  array('label'=>'Create InspectionSection', 'url'=>array('create')),
  array('label'=>'Update InspectionSection', 'url'=>array('update', 'id'=>$model->id)),
  array('label'=>'Delete InspectionSection', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
  array('label'=>'Manage InspectionSection', 'url'=>array('admin')),
  ); */
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/inspectionSection/admin'; ?>"><span class="fa fa-th-list"></span>Manage Inspection Section</a>
        <?php if (Yii::app()->user->checkAccess("masterInspectionSectionEdit")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>edit</a>
        <?php } ?>
        <h1>View <?php echo $model->name ?></h1>

        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                //'id',
                'code',
                'name',
            ),
        ));
        ?>
    </div>
</div>
