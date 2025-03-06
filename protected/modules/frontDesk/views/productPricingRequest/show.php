<?php
/* @var $this BrandController */
/* @var $model Brand */

$this->breadcrumbs = array(
    'Permintaan Harga' => array('admin'),
    'View ' . $model->product_name,
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/frontDesk/productPricingRequest/admin'; ?>">
            <span class="fa fa-th-list"></span>Manage
        </a>
        <?php if (empty($model->user_id_reply)): ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/frontDesk/' . $ccontroller . '/update', array('id' => $model->id)); ?>">
                <span class="fa fa-edit"></span>Reply
            </a>
        <?php endif; ?>
        <a class="button cbutton success right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/product/add', array('pricingId' => $model->id)); ?>">
            <span class="fa fa-plus"></span>Add to Master Product
        </a>
        <h1>View <?php echo $model->product_name ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'product_name',
                'production_year',
                'request_date',
                'request_time',
                'quantity',
                array(
                    'label' => 'Car Make', 
                    'value' => CHtml::encode(CHtml::value($model, 'vehicleCarMake.name'))
                ),
                array(
                    'label' => 'Car Model', 
                    'value' => CHtml::encode(CHtml::value($model, 'vehicleCarModel.name'))
                ),
                array(
                    'label' => 'Merk', 
                    'value' => CHtml::encode(CHtml::value($model, 'brand.name'))
                ),
                array(
                    'label' => 'Sub Brand', 
                    'value' => CHtml::encode(CHtml::value($model, 'subBrand.name'))
                ),
                array(
                    'label' => 'Sub Brand Series', 
                    'value' => CHtml::encode(CHtml::value($model, 'subBrandSeries.name'))
                ),
                array(
                    'label' => 'Kategori', 
                    'value' => CHtml::encode(CHtml::value($model, 'productMasterCategory.name'))
                ),
                array(
                    'label' => 'Sub Master Kategori', 
                    'value' => CHtml::encode(CHtml::value($model, 'productSubMasterCategory.name'))
                ),
                array(
                    'label' => 'Sub Kategori', 
                    'value' => CHtml::encode(CHtml::value($model, 'productSubCategory.name'))
                ),
                array(
                    'label' => 'User Request', 
                    'value' => CHtml::encode(CHtml::value($model, 'userIdRequest.username'))
                ),
                'request_note',
                array(
                    'label' => 'Branch Request', 
                    'value' => CHtml::encode(CHtml::value($model, 'branchIdRequest.name'))
                ),
                'reply_date',
                'reply_time',
                'recommended_price',
                array(
                    'label' => 'User Reply', 
                    'value' => CHtml::encode(CHtml::value($model, 'userIdReply.username'))
                ),
                'reply_note',
                array(
                    'label' => 'Branch Reply', 
                    'value' => CHtml::encode(CHtml::value($model, 'branchIdReply.name'))
                ),
            ),
        )); ?>
    </div>

    <hr />

    <div style="text-align: center">
        <h2>Uploaded Image</h2>
        <?php echo CHtml::image(Yii::app()->baseUrl . '/images/product_pricing_request/' . $model->id . '.' . $model->extension, "image", array("width" => "30%")); ?>  
    </div>
</div>