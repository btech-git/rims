<?php
/* @var $this ProductController */
/* @var $model Product */

$this->breadcrumbs=array(
	'Product'=>array('admin'),
	'Products'=>array('admin'),
	'View Product '.$model->name,
);

$this->menu=array(
	array('label'=>'List Product', 'url'=>array('index')),
	array('label'=>'Create Product', 'url'=>array('create')),
	array('label'=>'Update Product', 'url'=>array('update', 'id'=>$model->id)),
	array('label'=>'Delete Product', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
	array('label'=>'Manage Product', 'url'=>array('admin')),
);
?>
<!-- breadcrumbs start-->


<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/product/admin';?>"><span class="fa fa-th-list"></span>Manage Products</a>
        <?php if (Yii::app()->user->checkAccess("masterProductEdit")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>					
        <?php } ?>

        <!-- breadcrumbs end-->
        <h1>View Product <?php echo $model->name; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                'id',
                'code',
                'manufacturer_code',
                'name',
                'description',
                'production_year',
                array('name'=>'product_master_category_id', 'value'=>$model->productMasterCategory->name),
                array('name'=>'product_sub_master_category_id', 'value'=>$model->productSubMasterCategory->name),
                array('name'=>'product_sub_category_id', 'value'=>$model->productSubCategory->name),
                array(
                    'name' => 'hpp',
                    'value' => Yii::app()->numberFormatter->format("#,##0.00", $model->hpp),
                    'visible' => Yii::app()->user->checkAccess('director'),
                ),
                array(
                    'name' => 'retail_price',
                    'value' => Yii::app()->numberFormatter->format("#,##0.00", $model->retail_price),
                    'visible' => Yii::app()->user->checkAccess('director'),
                ),
                array(
                    'name'=>'ppn', 
                    'value'=>$model->ppn == 1 ? 'Include': 'Exclude',
                    'visible' => Yii::app()->user->checkAccess('director'),
                ),
                array(
                    'name' => 'Ppn',
                    'value' => Yii::app()->numberFormatter->format("#,##0.00", $model->retailPriceTax),
                    'visible' => Yii::app()->user->checkAccess('director'),
                ),
                array(
                    'label' => 'Retail Price After Tax',
                    'value' => Yii::app()->numberFormatter->format("#,##0.00", $model->retailPriceAfterTax),
                    'visible' => Yii::app()->user->checkAccess('director'),
                ),
                array(
                    'name' => 'margin_type',
                    'value' => ($model->margin_type == 1) ? "%" : "RP",
                    'visible' => Yii::app()->user->checkAccess('director'),
                ),
                array(
                    'name' => 'margin_amount',
                    'value' => Yii::app()->numberFormatter->format("#,##0.00", $model->margin_amount),
                    'visible' => Yii::app()->user->checkAccess('director'),
                ),
                array(
                    'name' => 'recommended_selling_price',
                    'value' => Yii::app()->numberFormatter->format("#,##0.00", $model->recommended_selling_price),
                    'visible' => Yii::app()->user->checkAccess('director'),
                ),
                array(
                    'name' => 'minimum_selling_price',
                    'value' => Yii::app()->numberFormatter->format("#,##0.00", $model->minimum_selling_price),
                    'visible' => Yii::app()->user->checkAccess('director'),
                ),
                'minimum_stock',
                'date_posting',
                array(
                    'label' => 'Created by',
                    'name' => 'user_id', 
                    'value' => $model->user->username
                ),
                array(
                    'name' => 'user_id_approval',
                    'value' => empty($model->user_id_approval) ? "N/A" : $model->userIdApproval->username,
                ),
                array(
                    'name' => 'date_approval',
                    'value' => empty($model->date_approval) ? "N/A" : $model->date_approval,
                ),
            ),
        )); ?>
    </div>
</div>

<br />

<?php if (Yii::app()->user->checkAccess('director')): ?>
    <div class="row">
        <div class="large-12 columns">
            <fieldset>
                <legend>Product Price</legend>
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'purchase-grid',
                    'dataProvider' => $purchaseOrderDetailDataProvider,
                    'filter' => null,
                    'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        array(
                            'header' => 'ID',
                            'value' => 'empty($data->purchase_order_id) ? "" : $data->purchase_order_id',
                        ),
                        array(
                            'header' => 'Supplier',
                            'value' => 'empty($data->purchase_order_id) ? "" : $data->purchaseOrder->supplier->name',
                        ),
                        array(
                            'header' => 'PO #',
                            'value' => 'empty($data->purchase_order_id) ? "" : CHtml::link($data->purchaseOrder->purchase_order_no, array("/transaction/transactionPurchaseOrder/view", "id" => $data->purchase_order_id), array("target" => "blank"))',
                        ),
                        array(
                            'header' => 'Tanggal',
                            'value' => 'empty($data->purchase_order_id) ? "" : $data->purchaseOrder->purchase_order_date',
                        ),
                        array(
                            'header' => 'Quantity',
                            'value' => 'number_format($data->quantity, 0)',
                            'htmlOptions' => array('style' => 'text-align: center'),
                        ),
                        array(
                            'header' => 'HPP',
                            'value' => 'number_format($data->unit_price, 2)',
                            'htmlOptions' => array('style' => 'text-align: right'),
                        ),
                        array(
                            'header' => 'HPP Average',
                            'value' => 'empty($data->product_id) ? "" : number_format($data->product->averageCogs, 2)',
                            'htmlOptions' => array('style' => 'text-align: right'),
                        ),
                    ),
                )); ?>
            </fieldset>
        </div>
    </div>

    <br />
<?php endif; ?>

<div class="row">
    <div class="large-12 columns">
        <fieldset>
            <legend>Product Sales</legend>
            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'sale-grid',
                'dataProvider' => $productSalesDataProvider,
                'filter' => null,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    array(
                        'header' => 'ID',
                        'value' => 'empty($data->registration_transaction_id) ? "" : $data->registration_transaction_id',
                    ),
                    array(
                        'header' => 'Customer',
                        'value' => 'empty($data->registration_transaction_id) ? "" : $data->registrationTransaction->customer->name',
                    ),
                    array(
                        'header' => 'Sales #',
                        'value' => 'empty($data->registration_transaction_id) ? "" : CHtml::link($data->registrationTransaction->transaction_number, array("/frontDesk/generalRepair/view", "id" => $data->registration_transaction_id), array("target" => "blank"))',
                    ),
                    array(
                        'header' => 'Tanggal',
                        'value' => 'empty($data->registration_transaction_id) ? "" : $data->registrationTransaction->transaction_date',
                    ),
                    array(
                        'header' => 'Quantity',
                        'value' => 'number_format($data->quantity, 0)',
                        'htmlOptions' => array('style' => 'text-align: center'),
                    ),
                    array(
                        'header' => 'DPP',
                        'value' => 'number_format($data->unitPriceBeforeTax, 2)',
                        'htmlOptions' => array('style' => 'text-align: right'),
                    ),
                    array(
                        'header' => 'PPn',
                        'value' => '$data->registrationTransaction->ppnLiteral',
                        'htmlOptions' => array('style' => 'text-align: center'),
                    ),
                    array(
                        'header' => 'Sell Price',
                        'value' => 'number_format($data->unitPriceAfterTax, 2)',
                        'htmlOptions' => array('style' => 'text-align: right'),
                    ),
                    array(
                        'header' => 'Total',
                        'value' => 'number_format($data->total_price, 2)',
                        'htmlOptions' => array('style' => 'text-align: right'),
                    ),
                ),
            )); ?>
        </fieldset>
    </div>
</div>

<br/>

<div>
    <?php if ((int) $model->is_approved === 0): ?>
        <div style="float: left; margin-left: 20px;">
            <?php echo CHtml::beginForm(); ?>
            <?php echo CHtml::submitButton('APPROVE', array('name' => 'Approve', 'class' => 'button success')); ?>
            <?php echo CHtml::submitButton('REJECT', array('name' => 'Reject', 'class' => 'button warning')); ?>
            <?php echo CHtml::endForm(); ?>
        </div>
    <?php endif; ?>
    <div class="clear"></div>
</div>