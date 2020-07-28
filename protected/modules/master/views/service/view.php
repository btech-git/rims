<?php
/* @var $this ServiceController */
/* @var $model Service */

$this->breadcrumbs=array(
	'Service'=>Yii::app()->baseUrl.'/master/service/admin',
	'Service'=>array('admin'),
	'View Service '.$model->name,
);

// $this->menu=array(
// 	array('label'=>'List Service', 'url'=>array('index')),
// 	array('label'=>'Create Service', 'url'=>array('create')),
// 	array('label'=>'Update Service', 'url'=>array('update', 'id'=>$model->id)),
// 	array('label'=>'Delete Service', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
// 	array('label'=>'Manage Service', 'url'=>array('admin')),
// );
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/service/admin';?>"><span class="fa fa-th-list"></span>Manage Services</a>
        <?php if (Yii::app()->user->checkAccess("master.service.update")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/'.$ccontroller.'/update', array('id'=>$model->id));?>"><span class="fa fa-edit"></span>edit</a>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/addProduct', array('id' => $model->id)); ?>"><span class="fa fa-plus"></span>Add Materials</a>
        <?php } ?>

        <h1>View Service <?php echo $model->name; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data'=>$model,
            'attributes'=>array(
                //'id',
                array('name'=>'service_type_code','value'=>$model->serviceType->code),
                array('name'=>'service_type_name','value'=>$model->serviceType->name),
                array('name'=>'service_category_code','value'=>$model->serviceCategory->code),
                array('name'=>'service_category_name','value'=>$model->serviceCategory->name),
                'code',
                'name',
                'description',
                array('name'=>'difficulty_level','value'=>$model->getLevel($model)),	
                //'difficulty_level',
                'status',
                'difficulty',
                'difficulty_value', 
                'regular', 
                'luxury',
                'luxury_value',
                'luxury_calc', 
                'standard_rate_per_hour',
                'flat_rate_hour', 
                'price', 
                'common_price'
            ),
        )); ?>
    </div>
</div>

<div class="row">
    <h3>Equipments</h3>
    <table >
        <thead>
            <tr>
                <th>Name</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($serviceEquipments as $key => $serviceEquipment): ?>
                <tr>
                    <?php $equipment = Equipments::model()->findByPK($serviceEquipment->equipment_id); ?>
                    <td><?php echo $equipment->name; ?></td>	
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<div class="row">
	<h3>Pricelists</h3>
	<table>
		<thead>
			<tr>
				<td>Car Make</td>
				<td>Car Model</td>
				<td>Car Sub Model</td>
				<td>Difficulty</td>
				<td>Difficulty value</td>
				<td>Regular</td>
				<td>Luxury</td>
				<td>Luxury Value</td>
				<td>Luxury Calc</td>
				<td>Standard Flat Rate per hour</td>
				<td>Flat rate Hour</td>
				<td>Price</td>
				<td>Common Price</td>
			</tr>
		</thead>
		<?php foreach ($pricelists as $key => $pricelist): ?>
			<tr>
				<td><?php echo $pricelist->carMake->name; ?></td>
				<td><?php echo $pricelist->carModel->name; ?></td>
				<td><?php echo $pricelist->carSubDetail->name; ?></td>
				<td><?php echo $pricelist->difficulty; ?></td>
				<td><?php echo $pricelist->difficulty_value; ?></td>
				<td><?php echo $pricelist->regular; ?></td>
				<td><?php echo $pricelist->luxury; ?></td>
				<td><?php echo $pricelist->luxury_value; ?></td>
				<td><?php echo $pricelist->luxury_calc; ?></td>
				<td><?php echo $pricelist->standard_flat_rate_per_hour; ?></td>
				<td><?php echo $pricelist->flat_rate_hour; ?></td>
				<td><?php echo $pricelist->price; ?></td>
				<td><?php echo $pricelist->common_price; ?></td>
			</tr>
		<?php endforeach; ?>
	</table>
</div>

<div class="row">
	<h3>Service Complement</h3>
    <table>
        <thead>
            <tr>
                <td>Service Complement</td>
            </tr>
        </thead>	
        <tbody>
        <?php foreach ($complements as $key => $complement): ?>
            <tr>
                <td><?php echo $complement->complement->name; ?></td>
            </tr>
        <?php endforeach ?>
        </tbody>
    </table>
</div>

<div class="row">
	<h3>Pemakaian Bahan Standard</h3>
    <table>
        <thead>
            <tr>
                <th style="text-align: center">Code</th>
                <th style="text-align: center">Name</th>
                <th style="text-align: center">Master Category</th>
                <th style="text-align: center">Sub Master Category</th>
                <th style="text-align: center">Sub Category</th>
                <th style="text-align: center">Brand</th>
                <th style="text-align: center">Sub Brand</th>
                <th style="text-align: center">Sub Brand Series</th>
                <th style="text-align: center">Qty Std</th>
                <th style="text-align: center">Unit</th>
            </tr>
        </thead>	
        <tbody>
            <?php foreach ($model->serviceProducts as $detail): ?>	
                <tr style="background-color: azure;">
                    <td style="text-align:center;">
                        <?php echo CHtml::encode(CHtml::value($detail, 'product.manufacturer_code')); ?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo CHtml::encode(CHtml::value($detail, 'product.brand.name')); ?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrand.name')); ?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrandSeries.name')); ?>
                    </td>
                    <td style="text-align: center;">
                        <?php echo CHtml::encode(CHtml::value($detail, 'product.productMasterCategory.name')); ?>
                    </td>
                    <td style="text-align: center;">
                        <?php echo CHtml::encode(CHtml::value($detail, 'product.productSubMasterCategory.name')); ?>
                    </td>
                    <td style="text-align: center;">
                        <?php echo CHtml::encode(CHtml::value($detail, 'product.productSubCategory.name')); ?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo CHtml::encode(CHtml::value($detail, 'unit.name')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
