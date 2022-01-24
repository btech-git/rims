<?php
/* @var $this InventoryController */
/* @var $model Inventory */

$this->breadcrumbs=array(
	'Inventory' => array('check'),
	$product->name,
);

?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php if (Yii::app()->user->checkAccess("master.inventory.admin")) { ?>
        <a class="button success right" href="<?php echo Yii::app()->baseUrl.'/frontDesk/inventory/check';?>"><span class="fa fa-plus"></span>Stock Check</a>
        <?php } ?>

        <?php //$product = Product::model()->findByPk($_GET['id']); ?>
        <h2>Stok Detail for <?php echo $product->name; ?></h2>
        <table style="border: 1px solid">
            <tr>
                <td style="text-align: center; font-weight: bold">ID</td>
                <td style="text-align: center; font-weight: bold">Manufacturer Code</td>
                <td style="text-align: center; font-weight: bold">Category</td>
                <td style="text-align: center; font-weight: bold">Brand</td>
                <td style="text-align: center; font-weight: bold">Sub Brand</td>
                <td style="text-align: center; font-weight: bold">Sub Brand Series</td>
                <td style="text-align: center; font-weight: bold">Unit</td>
            </tr>
            <tr>
                <td><?php echo $product->id; ?></td>
                <td><?php echo $product->manufacturer_code; ?></td>
                <td><?php echo $product->masterSubCategoryCode; ?></td>
                <td><?php echo $product->brand->name; ?></td>
                <td><?php echo $product->subBrand->name; ?></td>
                <td><?php echo $product->subBrandSeries->name; ?></td>
                <td><?php echo $product->unit->name; ?></td>
            </tr>
        </table>
        
        <h3>Total Stock : <span id="stockme"></span></h3>
        
        <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => $detailTabs,
            // additional javascript options for the tabs plugin
            'options' => array(
                'collapsible' => true,
            ),
            // set id for this widgets
            'id' => 'view_tab',
        )); ?>
    </div>
</div>

<?php Yii::app()->clientScript->registerScript('stockme', "
    var var_stockme = $('#total_stockme').text();
     $('#stockme').text(var_stockme);
    // console.log(var_stockme);
"); ?>