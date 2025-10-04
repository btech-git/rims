<?php
/* @var $this BrandController */
/* @var $model Brand */

$this->breadcrumbs = array(
    'Permintaan Harga' => array('admin'),
    'View ' . $model->transaction_number,
);
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/frontDesk/productPricingRequest/adminPending'; ?>">
            <span class="fa fa-th-list"></span>Pending List
        </a>
        <?php if (empty($model->user_id_reply)): ?>
            <a class="button warning right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/frontDesk/' . $ccontroller . '/reply', array('id' => $model->id)); ?>">
                <span class="fa fa-edit"></span>Reply
            </a>
        <?php endif; ?>
<!--        <a class="button cbutton success right" style="margin-right:10px;" href="<?php //echo Yii::app()->createUrl('/master/product/add', array('pricingId' => $model->id)); ?>">
            <span class="fa fa-plus"></span>Add to Master Product
        </a>-->
        <h1>View <?php echo $model->transaction_number ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                array(
                    'label' => 'Vehicle', 
                    'value' => CHtml::encode(CHtml::value($model, 'vehicleCarMake.name')) . ' - ' . CHtml::encode(CHtml::value($model, 'vehicleCarModel.name')) . ' - ' . CHtml::encode(CHtml::value($model, 'vehicleCarSubModel.name')),
                ),
                'production_year',
                array(
                    'label' => 'User Request', 
                    'value' => CHtml::encode(CHtml::value($model, 'userIdRequest.username'))
                ),
                'request_date',
                'request_time',
                'request_note',
                array(
                    'label' => 'Branch Request', 
                    'value' => CHtml::encode(CHtml::value($model, 'branchIdRequest.name'))
                ),
                array(
                    'label' => 'User Reply', 
                    'value' => CHtml::encode(CHtml::value($model, 'userIdReply.username'))
                ),
                'reply_date',
                'reply_time',
                'reply_note',
                array(
                    'label' => 'Branch Reply', 
                    'value' => CHtml::encode(CHtml::value($model, 'branchIdReply.name'))
                ),
            ),
        )); ?>
    </div>

    <hr />

    <div>
        <table>
            <thead>
                <tr>
                    <td>Product</td>
                    <td>Brand</td>
                    <td>Category</td>
                    <td>Quantity</td>
                    <td>Recommended Price</td>
                    <td>Memo</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach($model->productPricingRequestDetails as $detail): ?>
                    <tr>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'product_name')); ?></td>
                        <td>
                            <?php echo CHtml::encode(CHtml::value($detail, 'brand.name')); ?>
                            <?php echo CHtml::encode(CHtml::value($detail, 'subBrand.name')); ?>
                            <?php echo CHtml::encode(CHtml::value($detail, 'subBrandSeries.name')); ?>
                        </td>
                        <td>
                            <?php echo CHtml::encode(CHtml::value($detail, 'productMasterCategory.name')); ?>
                            <?php echo CHtml::encode(CHtml::value($detail, 'productSubMasterCategory.name')); ?>
                            <?php echo CHtml::encode(CHtml::value($detail, 'productSubCategory.name')); ?>
                        </td>
                        <td style="text-align: center">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'quantity'))); ?>
                        </td>
                        <td style="text-align: right">
                            <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'recommended_price'))); ?>
                        </td>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <hr />

    <div style="text-align: center">
        <h2>Uploaded Image</h2>
        <?php echo CHtml::image(Yii::app()->baseUrl . '/images/uploads/product_pricing_request/' . $model->id . '.' . $model->extension, "image", array("width" => "30%")); ?>  
    </div>
</div>