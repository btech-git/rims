<?php
/* @var $this InventoryController */
/* @var $model Inventory */

$this->breadcrumbs=array(
	'Inventory'=>array('admin'),
	'Inventories'=>array('admin'),
	//$product->header->name=>array('view','id'=>$product->header->id),
	'Update Inventory',
);

/*$this->menu=array(
	array('label'=>'List Inventory', 'url'=>array('index')),
	array('label'=>'Create Inventory', 'url'=>array('create')),
	array('label'=>'View Inventory', 'url'=>array('view', 'id'=>$model->id)),
	array('label'=>'Manage Inventory', 'url'=>array('admin')),
);*/
?>
	<div id="maincontent">
			<div class="clearfix page-action">
				<?php if (Yii::app()->user->checkAccess("master.inventory.admin")) { ?>
				<a class="button success right" href="<?php echo Yii::app()->baseUrl.'/master/inventory/admin';?>"><span class="fa fa-plus"></span>Manage Inventory</a>
				<?php } ?>

				<h2>Inventory Detail for <?php echo Product::model()->findByPk($_GET['product_id'])->name; ?></h2>
				<h2>Total Stock : <span id="stockme"></span></h2>
				<?php 
					/*$this->widget('zii.widgets.jui.CJuiTabs',array(
	    				'tabs'=>array(
	        				'StaticTab 1'=>'Content for tab 1',
	        				'StaticTab 2'=>array('content'=>'Content for tab 2', 'id'=>'tab2'),
	        
	    				),
	    				// additional javascript options for the tabs plugin
	    				'options'=>array(
	        				'collapsible'=>true,
	    				),
					));*/
				?>

				<?php
					$warehouses = InventoryDetail::model()->with(array('warehouse'=>array('condition'=>'status="Active"')))->findAll(array(
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
									<th>Product ID</th>
									<th>Transaction Type</th>
									<th>Transaction Number</th>
									<th>Transaction Date</th>
									<th>Stock In</th>
									<th>Stock Out</th>
									<th>Total</th>
									<th>Notes</th>
								</tr>';

						$datarow = 0; $totalstockin = 0; $totalstockout =0; $currentstock = 0;
						foreach ($details as $key => $detail) {
							if($detail->warehouse_id == $warehouse->warehouse_id){
								//echo 'Warehouse ' . $warehouse->warehouse_id;
								$totalstockout += $detail->stock_out;
								$totalstockin += $detail->stock_in;
								$currentstock = $currentstock + ($currentstock + $detail->stock_in) - ($currentstock - $detail->stock_out);
								$tableContent .= '
									<tr>
										<td>' . $detail->product_id . '</td>
										<td>' . $detail->transaction_type . '</td>
										<td>' . $detail->transaction_number . '</td>
										<td>' . $detail->transaction_date . '</td>
										<td>' . $detail->stock_in . '</td>
										<td>' . $detail->stock_out . '</td>
										<td>' . $currentstock . '</td>
										<td>' . $detail->notes . '</td>
									</tr>';
			
								$datarow ++;
							}
						}
						$stockme1 = ($totalstockin  + $totalstockout); 

						$tableContent .= '<tr><td colspan="4" class="text-right"><strong>Total</strong></td><td>'.$totalstockin.'</td><td>'.$totalstockout.'</td><td>'.$stockme1.'</td><td></td></tr>';

						$tableContent .= '</table>';
						if ($datarow !=0) {
							$tabarray["Warehouse " . $warehouse->warehouse_id]=$tableContent;
						}
					}

					$tableTotal = '
						<table>
							<tr>
								<th>Product ID</th>
								<th>Transaction Type</th>
								<th>Transaction Number</th>
								<th>Transaction Date</th>
								<th>Stock In</th>
								<th>Stock Out</th>
								<th>Total</th>
								<th>Notes</th>
							</tr>
					';
					$totaltstockin = 0; $totaltstockout =0; 
					foreach ($details as $key => $detail) {
						$totaltstockout += $detail->stock_out;
						$totaltstockin += $detail->stock_in;

						$tableTotal .= '
							<tr>
								<td>' . $detail->product_id . '</td>
								<td>' . $detail->transaction_type . '</td>
								<td>' . $detail->transaction_number . '</td>
								<td>' . $detail->transaction_date . '</td>
								<td>' . $detail->stock_in . '</td>
								<td>' . $detail->stock_out . '</td>
								<td>' . ($detail->stock_in + $detail->stock_out) . '</td>
								<td>' . $detail->notes . '</td>
							</tr>
						';
					}
					$stockme =  ($totaltstockin  + $totaltstockout); 
					$tableTotal .= '<tr><td colspan="4" class="text-right"><strong>Total</strong></td><td>'.$totaltstockin.'</td><td>'.$totaltstockout.'</td><td><span id="total_stockme">'. $stockme .'</span></td><td></td></tr>';
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

<?php		
	Yii::app()->clientScript->registerScript('stockme', "
		var var_stockme = $('#total_stockme').text();
		 $('#stockme').text(var_stockme);
		// console.log(var_stockme);

	");
?>