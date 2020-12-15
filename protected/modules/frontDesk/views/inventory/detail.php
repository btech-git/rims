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

        <?php $product = Product::model()->findByPk($_GET['id']); ?>
        <h2>Stok Detail for <?php echo $product->name; ?></h2>
        <table style="border: 1px solid">
            <tr>
                <td style="text-align: center; font-weight: bold">Manufacturer Code</td>
                <td style="text-align: center; font-weight: bold">Category</td>
                <td style="text-align: center; font-weight: bold">Brand</td>
                <td style="text-align: center; font-weight: bold">Sub Brand</td>
                <td style="text-align: center; font-weight: bold">Sub Brand Series</td>
                <td style="text-align: center; font-weight: bold">Unit</td>
            </tr>
            <tr>
                <td><?php echo $product->manufacturer_code; ?></td>
                <td><?php echo $product->masterSubCategoryCode; ?></td>
                <td><?php echo $product->brand->name; ?></td>
                <td><?php echo $product->subBrand->name; ?></td>
                <td><?php echo $product->subBrandSeries->name; ?></td>
                <td><?php echo $product->unit->name; ?></td>
            </tr>
        </table>
        <h3>Total Stock : <span id="stockme"></span></h3>
        
        <?php $warehouses = InventoryDetail::model()->with(array(
            'warehouse'=>array('condition'=>'status="Active"')
            ))->findAll(array(
            // $warehouses = InventoryDetail::model()->findAll(array(
                'select'=>'t.warehouse_id',
                'group'=>'t.warehouse_id',
                'distinct'=>true,
            ));

            foreach ($warehouses as $key => $warehouse) {
                $tableContent = '';
                $tableContent .= '
                    <table>
                        <tr>
                            <th>Transaction Type</th>
                            <th>Transaction Number</th>
                            <th>Transaction Date</th>
                            <th>Stock In</th>
                            <th>Stock Out</th>
                            <th>Total</th>
                            <th>Warehouse</th>
                            <th>Notes</th>
                        </tr>';

                $datarow = 0; $totalstockin = 0; $totalstockout =0; $currentstock = 0;
                foreach ($details as $key => $detail) {
                    if ($detail->warehouse->branch_id == $warehouse->warehouse->branch_id){
                        //echo 'Warehouse ' . $warehouse->warehouse_id;
                        $totalstockout += $detail->stock_out;
                        $totalstockin += $detail->stock_in;
                        $currentstock = $currentstock + ($currentstock + $detail->stock_in) - ($currentstock - $detail->stock_out);
                        $tableContent .= '
                            <tr>
                                <td>' . $detail->transaction_type . '</td>
                                <td>' . CHtml::link($detail->transaction_number, Yii::app()->createUrl("frontDesk/inventory/redirectTransaction", array("codeNumber" => $detail->transaction_number)), array('target' => '_blank')) . '</td>
                                <td>' . $detail->transaction_date . '</td>
                                <td>' . $detail->stock_in . '</td>
                                <td>' . $detail->stock_out . '</td>
                                <td>' . $currentstock . '</td>
                                <td>' . $detail->warehouse->code . '</td>
                                <td>' . $detail->notes . '</td>
                            </tr>';

                        $datarow ++;
                    }
                }
                $stockme1 = ($totalstockin  + $totalstockout); 

                $tableContent .= '<tr><td colspan="3" class="text-right"><strong>Total</strong></td><td>'.$totalstockin.'</td><td>'.$totalstockout.'</td><td>'.$stockme1.'</td><td></td></tr>';

                $tableContent .= '</table>';
                if ($datarow !=0) {
                    $tabarray[" " . $warehouse->warehouse->branch->name]=$tableContent;
                }
            }

            $tableTotal = '
                <table>
                    <tr>
                        <th>Transaction Type</th>
                        <th>Transaction Number</th>
                        <th>Transaction Date</th>
                        <th>Stock In</th>
                        <th>Stock Out</th>
                        <th>Total</th>
                        <th>Gudang</th>
                        <th>Notes</th>
                    </tr>
            ';
            $totaltstockin = 0; $totaltstockout =0; $totalcurrentstock = 0;
            foreach ($details as $key => $detail) {
                $totaltstockout += $detail->stock_out;
                $totaltstockin += $detail->stock_in;
                $totalcurrentstock = $totalcurrentstock + ($totalcurrentstock + $detail->stock_in) - ($totalcurrentstock - $detail->stock_out);

                $tableTotal .= '
                    <tr>
                        <td>' . $detail->transaction_type . '</td>
                        <td>' . $detail->transaction_number . '</td>
                        <td>' . $detail->transaction_date . '</td>
                        <td>' . $detail->stock_in . '</td>
                        <td>' . $detail->stock_out . '</td>
                        <td>' . $totalcurrentstock . '</td>
                        <td>' . $detail->warehouse->code . '</td>
                        <td>' . $detail->notes . '</td>
                    </tr>
                ';
            }
            $stockme =  ($totaltstockin  + $totaltstockout); 
            $tableTotal .= '<tr><td colspan="3" class="text-right"><strong>Total</strong></td><td>'.$totaltstockin.'</td><td>'.$totaltstockout.'</td><td><span id="total_stockme">'. $stockme .'</span></td><td></td></tr>';
            $tableTotal .= '</table>';
            $tabarray["Total"]=$tableTotal;

            $this->widget('zii.widgets.jui.CJuiTabs',array(
                'tabs'=>$tabarray,
                // additional javascript options for the accordion plugin
                'options' => array(
                    'collapsible' => true,        
                ),
                'id'=>'MyTab-Menu1'
            ));
        ?> 
    </div>
</div>

<?php Yii::app()->clientScript->registerScript('stockme', "
    var var_stockme = $('#total_stockme').text();
     $('#stockme').text(var_stockme);
    // console.log(var_stockme);
"); ?>