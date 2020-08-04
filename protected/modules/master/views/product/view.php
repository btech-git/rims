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
        <?php if (Yii::app()->user->checkAccess("master.product.update")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update',array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>					
        <?php } ?>

        <!-- breadcrumbs end-->
        <h1>View Product <?php echo $model->name; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                'id',
                'code',
                'name',
                'description',
                'production_year',
                array('name'=>'product_master_category_id', 'value'=>$model->productMasterCategory->name),
                array('name'=>'product_sub_master_category_id', 'value'=>$model->productSubMasterCategory->name),
                array('name'=>'product_sub_category_id', 'value'=>$model->productSubCategory->name),
                'product_specification_type_id',
                array(
                    'name' => 'retail_price',
                    'value' => Yii::app()->numberFormatter->format("#,##0.00", $model->retail_price),
                ),
                array(
                    'name' => 'Ppn',
                    'value' => Yii::app()->numberFormatter->format("#,##0.00", $model->retailPriceTax),
                ),
                array(
                    'label' => 'Retail Price After Tax',
                    'value' => Yii::app()->numberFormatter->format("#,##0.00", $model->retailPriceAfterTax),
                ),
                array(
                    'name' => 'margin_type',
                    'value' => ($model->margin_type == 1) ? "%" : "RP",
                ),
                array(
                    'name' => 'margin_amount',
                    'value' => Yii::app()->numberFormatter->format("#,##0.00", $model->margin_amount),
                ),
                array(
                    'name' => 'recommended_selling_price',
                    'value' => Yii::app()->numberFormatter->format("#,##0.00", $model->recommended_selling_price),
                ),
                array(
                    'name' => 'hpp',
                    'value' => Yii::app()->numberFormatter->format("#,##0.00", $model->hpp),
                ),
                'minimum_selling_price',
                array('name'=>'ppn', 'value'=>$model->ppn == 1 ? 'Include': 'Exclude'),
                'minimum_stock',
            ),
        )); ?>
    </div>
</div>

<br />

<div class="row">
    <div class="large-12 columns">
        <fieldset>
            <legend>Product Price</legend>
            <table>
                <thead>
                    <th>Supplier</th>
                    <th>Quantity</th>
                    <th>Product Price</th>
                    <th>Product Date</th>
                    <th>HPP </th>
                    <th>HPP Average</th>
                </thead>
                <tbody>
                    <?php foreach ($productPrices as $key => $pp): ?>
                        <tr>
                            <td><?php echo $pp->supplier_id != "" ? $pp->supplier->name:''; ?></td>
                            <td><?php echo $pp->quantity; ?></td>
                            <td><?php echo $pp->purchase_price != "" ? $pp->purchase_price:'0'; ?></td>
                            <td><?php echo $pp->purchase_date != "" ? $pp->purchase_date:'-'; ?></td>
                            <td><?php echo $pp->hpp != "" ? $pp->hpp:'-'; ?></td>
                            <td><?php echo $pp->hpp_average != "" ? $pp->hpp_average:'-'; ?></td>
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
            <?php echo CHtml::endForm(); ?>
        </div>
    <?php endif; ?>
    <div class="clear"></div>
</div>