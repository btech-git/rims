<?php
/* @var $this ServiceController */
/* @var $model Service */

$this->breadcrumbs = array(
    'Service' => Yii::app()->baseUrl . '/master/service/admin',
    'Service' => array('admin'),
    'View Service ' . $model->name,
);

?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/service/admin'; ?>"><span class="fa fa-th-list"></span>Manage Services</a>
        <?php if (Yii::app()->user->checkAccess("masterServiceEdit")) { ?>
            <a class="button warning right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>edit</a>
            <a class="button success right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/addProduct', array('id' => $model->id)); ?>"><span class="fa fa-plus"></span>Add Materials</a>
        <?php } ?>

        <h1>View Service <?php echo $model->name; ?></h1>

        <?php
        $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'id',
                array('name' => 'service_type_name', 'value' => $model->serviceType->name),
                array('name' => 'service_category_name', 'value' => $model->serviceCategory->name),
                'code',
                'name',
                'description',
                'status',
                'standard_rate_per_hour',
                'flat_rate_hour',
                'common_price',
                'price_easy',
                'price_medium',
                'price_hard',
                'price_luxury',
                'status',
                array(
                    'label' => 'Created by',
                    'name' => 'user_id', 
                    'value' => $model->user->username
                ),
                array(
                    'label' => 'Created',
                    'value' => $model->created_datetime,
                ),
                array(
                    'label' => 'Approved',
                    'value' => $model->date_approval,
                ),
            ),
        ));
        ?>
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
                <th style="text-align: center">Category</th>
                <th style="text-align: center">Brand</th>
                <th style="text-align: center">Qty Std</th>
                <th style="text-align: center">Unit</th>
            </tr>
        </thead>	
        <tbody>
            <?php foreach ($model->serviceProducts as $detail): ?>	
                <tr style="background-color: azure;">
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'product.manufacturer_code')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($detail, 'product.name')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($detail, 'product.brand.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrand.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($detail, 'product.subBrandSeries.name')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($detail, 'product.productMasterCategory.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($detail, 'product.productSubMasterCategory.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($detail, 'product.productSubCategory.name')); ?>
                    </td>
                    <td style="text-align:center;">
                        <?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?>
                    </td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($detail, 'unit.name')); ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<br/>

<div class="row">
    <h3>Penjualan</h3>
    <table>
        <thead>
            <tr>
                <th style="text-align: center; width: 3%"></th>
                <th style="text-align: center">Invoice #</th>
                <th style="text-align: center">Tanggal</th>
                <th style="text-align: center">Customer</th>
                <th style="text-align: center">Vehicle</th>
                <th style="text-align: center">Plat #</th>
                <th style="text-align: center">Price</th>
            </tr>
        </thead>	
        <tbody>
            <?php foreach ($invoiceDetails as $i => $invoiceDetail): ?>	
                <tr style="background-color: azure;">
                    <td><?php echo $i + 1; ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($invoiceDetail, 'invoice.invoice_number')); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", strtotime(CHtml::value($invoiceDetail, 'invoice.invoice_date')))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($invoiceDetail, 'invoice.customer.name')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($invoiceDetail, 'invoice.vehicle.carMake.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($invoiceDetail, 'invoice.vehicle.carModel.name')); ?> - 
                        <?php echo CHtml::encode(CHtml::value($invoiceDetail, 'invoice.vehicle.carSubModel.name')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($invoiceDetail, 'invoice.vehicle.plate_number')); ?></td>
                    <td style="text-align:right;"><?php echo number_format(CHtml::encode(CHtml::value($invoiceDetail, 'unit_price')), 2); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
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