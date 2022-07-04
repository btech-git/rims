<?php
/* @var $this SubBrandSeriesController */
/* @var $model SubBrandSeries */

$this->breadcrumbs = array(
    'Product',
    'Sub-Brand Series' => array('admin'),
    'View Sub-Brand Series ' . $model->name,
);

/* $this->menu=array(
  array('label'=>'List SubBrandSeries', 'url'=>array('index')),
  array('label'=>'Create SubBrandSeries', 'url'=>array('create')),
  array('label'=>'Update SubBrandSeries', 'url'=>array('update', 'id'=>$model->id)),
  array('label'=>'Delete SubBrandSeries', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
  array('label'=>'Manage SubBrandSeries', 'url'=>array('admin')),
  ); */
?>




<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/subBrandSeries/admin'; ?>"><span class="fa fa-th-list"></span>Manage Sub-Brand Series</a>
        <?php if (Yii::app()->user->checkAccess("masterSubBrandSeriesEdit")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>edit</a>
        <?php } ?>
        <h1>View <?php echo $model->name ?></h1>

        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                array(
                    'label' => 'Brand',
                    'value' => $model->subBrand->brand->name,
                ),
                array(
                    'name' => 'sub_brand_id',
                    'label' => 'Sub Brand',
                    'value' => $model->subBrand->name,
                ),
                'name',
            ),
        ));
        ?>

    </div>
</div>