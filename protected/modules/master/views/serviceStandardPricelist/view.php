<?php
/* @var $this ServiceStandardPricelistController */
/* @var $model ServiceStandardPricelist */

$this->breadcrumbs = array(
    'Service' => Yii::app()->baseUrl . '/master/service/admin',
    'Service Standard Pricelists' => array('admin'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List ServiceStandardPricelist', 'url' => array('index')),
    array('label' => 'Create ServiceStandardPricelist', 'url' => array('create')),
    array('label' => 'Update ServiceStandardPricelist', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete ServiceStandardPricelist', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage ServiceStandardPricelist', 'url' => array('admin')),
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/serviceStandardPricelist/admin'; ?>"><span class="fa fa-th-list"></span>Manage Service Standard Pricelists</a>
        <?php if (Yii::app()->user->checkAccess("masterPricelistStandardEdit")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>edit</a>		
        <?php } ?>
        <h1>View Service Standard Pricelist <?php echo $model->id; ?></h1>

        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'service_id',
                'difficulty',
                'difficulty_value',
                'regular',
                'luxury',
                'luxury_value',
                'luxury_calc',
                'standard_rate_per_hour',
                'flat_rate_hour',
                'price',
                'common_price',
            ),
        ));
        ?>
    </div>
</div>