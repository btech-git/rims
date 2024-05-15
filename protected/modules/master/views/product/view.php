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
                <table>
                    <thead>
                        <th>Supplier</th>
                        <th>Purchase Date</th>
                        <th>Quantity</th>
                        <th>HPP </th>
                        <th>HPP Average</th>
                    </thead>
                    <tbody>
                        <?php foreach ($productPrices as $key => $pp): ?>
                            <tr>
                                <td><?php echo $pp->purchaseOrder != "" ? $pp->purchaseOrder->supplier->name:''; ?></td>
                                <td><?php echo $pp->purchaseOrder != "" ? $pp->purchaseOrder->purchase_order_date : '-'; ?></td>
                                <td><?php echo Yii::app()->numberFormatter->format("#,##0", $pp->quantity); ?></td>
                                <td style="text-align: right"><?php echo $pp->unit_price != "" ? Yii::app()->numberFormatter->format("#,##0.00", $pp->unit_price) : '0'; ?></td>
                                <td style="text-align: right"><?php echo $pp->product_id != "" ? Yii::app()->numberFormatter->format("#,##0.00", $pp->product->averageCogs) : '-'; ?></td>
                            </tr>
                        <?php endforeach ?>
                    </tbody>
                </table>
            </fieldset>
        </div>
    </div>

    <br />
<?php endif; ?>

<div class="row">
    <div class="large-12 columns">
        <fieldset>
            <legend>Product Sales</legend>
            <table>
                <thead>
                    <th>Transaction #</th>
                    <th>Date</th>
                    <th>Quantity</th>
                    <th>Price </th>
                    <th>Total</th>
                </thead>
                <tbody>
                    <?php foreach ($productSales as $productSale): ?>
                        <tr>
                            <td><?php echo CHtml::encode(CHtml::value($productSale, 'registrationTransaction.transaction_number')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($productSale, 'registrationTransaction.transaction_date')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($productSale, 'quantity')); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($productSale, 'sale_price'))); ?></td>
                            <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format("#,##0.00", CHtml::value($productSale, 'total_price'))); ?></td>
                        </tr>
                    <?php endforeach ?>
                </tbody>
            </table>
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