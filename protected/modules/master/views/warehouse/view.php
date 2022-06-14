<?php
/* @var $this WarehouseController */
/* @var $model Warehouse */

$this->breadcrumbs = array(
    'Warehouse' => array('admin'),
    'Warehouses' => array('admin'),
    'View Warehouse ' . $model->name,
);

$this->menu = array(
        // array('label'=>'List Warehouse', 'url'=>array('index')),
        // array('label'=>'Create Warehouse', 'url'=>array('create')),
        // array('label'=>'Update Warehouse', 'url'=>array('update', 'id'=>$model->id)),
        // array('label'=>'Delete Warehouse', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
        // array('label'=>'Manage Warehouse', 'url'=>array('admin')),
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/warehouse/admin'; ?>"><span class="fa fa-th-list"></span>Manage Warehouses</a>
        <?php if (Yii::app()->user->checkAccess("masterWarehouseEdit")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-th-list"></span>edit</a>
        <?php } ?>
        <h1>View Warehouse <?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                //'id',
                'code',
                'name',
                'description',
                'status',
                'branch.name'
            ),
        )); ?>
    </div>
</div>

<!-- <div class="row">
        <h3>Branch</h5>
        <table >
                <thead>
                        <tr>
                                <td>Name</td>
                                
                        </tr>
                </thead>
<?php //foreach ($branchesWarehouses as $key => $branchesWarehouse): ?>
                        <tr>
<?php //$branch = Branch::model()->findByPK($branchesWarehouse->branch_id);  ?>
                                <td><?php //echo $branch->name;  ?></td>	
                                
                        </tr>
<?php //endforeach  ?>
        </table>
</div> -->
<div class="row">
    <h3>Division</h3>
    <table >
        <thead>
            <tr>
                <td>Name</td>
            </tr>
        </thead>
        <?php foreach ($warehouseDivisions as $key => $warehouseDivision): ?>
            <tr>
                <?php $division = Division::model()->findByPK($warehouseDivision->division_id); ?>
                <td><?php echo CHtml::encode(CHtml::value($division, 'name')); ?></td>	
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<div class="row">
    <h3>Section</h3>
    <table >
        <thead>
            <tr>
                <td>Code</td>
                <td>Product</td>
                <td>Rack Number</td>
            </tr>
        </thead>
        <?php foreach ($warehouseSections as $key => $warehouseSection): ?>
            <tr>
                <td><?php echo $warehouseSection->code; ?></td>
                <?php $product = Product::model()->findByPK($warehouseSection->product_id); ?>
                <td><?php echo $product->name; ?></td>	
                <td><?php echo $warehouseSection->rack_number; ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
</div>

<!--<div class="row">
    <?php /*$form = $this->beginWidget('CActiveForm', array(
        'id' => 'warehouse-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>

    <?php echo cHtml::activeCheckBoxList($model, 'warehouses', CHtml::listData(Warehouse::model()->findAll('id != ' . $model->id), 'id', 'name')); ?>

    <?php echo CHtml::button('Assign Section', array(
        'class' => 'button cbutton',
        'confirm' => 'All previously assigned sections will be lost. Are you sure?',
        'onclick' => '
            $.ajax({
                type: "POST",
                //dataType: "JSON",
                url: "' . CController::createUrl('ajaxAssignSection', array('id' => $model->id)) . '",
                data: $("form").serialize(),
                success: function(data){
                    //$("#section").html(data);
                },
            });
        '
    )); ?>

    <?php $this->endWidget();*/ ?>
</div>-->

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