<?php
/* @var $this SubBrandController */
/* @var $model SubBrand */

$this->breadcrumbs = array(
    'Product',
    'Sub-Brands' => array('admin'),
    'View Sub-Brand ' . $model->name,
);

/* $this->menu=array(
  array('label'=>'List SubBrand', 'url'=>array('index')),
  array('label'=>'Create SubBrand', 'url'=>array('create')),
  array('label'=>'Update SubBrand', 'url'=>array('update', 'id'=>$model->id)),
  array('label'=>'Delete SubBrand', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
  array('label'=>'Manage SubBrand', 'url'=>array('admin')),
  ); */
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/subBrand/admin'; ?>"><span class="fa fa-th-list"></span>Manage Sub-Brand</a>
        <?php if (Yii::app()->user->checkAccess("masterSubBrandEdit")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>">
                <span class="fa fa-edit"></span>edit
            </a>
        <?php } ?>
            
        <h1>View <?php echo $model->name ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                array('name' => 'brand_id', 'value' => $model->brand->name),
                'name',
            ),
        )); ?>

    </div>
</div>