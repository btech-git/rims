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
        <h1>View <?php echo $model->product_name ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'product_name',
                'request_date',
                'quantity',
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
        <?php echo CHtml::image('/images/product_pricing_request/' . $model->id . '.' . $model->extension, "image", array("width" => "30%")); ?>  
    </div>
</div>