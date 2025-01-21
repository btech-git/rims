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
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/frontDesk/productPricingRequest/admin'; ?>"><span class="fa fa-th-list"></span>Manage Permintaan Harga</a>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/frontDesk/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>Reply</a>
        <h1>View <?php echo $model->product_name ?></h1>

        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                'product_name',
                'request_date',
                'quantity',
                'userIdRequest.username',
                'request_note',
                'branchIdRequest.name',
                'reply_date',
                'recommended_price',
                'userIdReply.username',
                'reply_note',
                'branchIdReply.code',
            ),
        ));
        ?>

    </div>
</div>