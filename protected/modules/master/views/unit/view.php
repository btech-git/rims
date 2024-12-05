<?php
/* @var $this UnitController */
/* @var $model Unit */

$this->breadcrumbs = array(
    'Company',
    'Units' => array('admin'),
    'View Unit ' . $model->name,
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/unit/admin'; ?>" data-reveal-id="unit"><span class="fa fa-th-list"></span>Manage Units</a>
        <?php if (Yii::app()->user->checkAccess("masterUnitEdit")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-th-list"></span>edit</a>
        <?php } ?>
        <h1>View Unit <?php echo $model->name; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'name',
                'status',
            ),
        )); ?>
    </div>
</div>