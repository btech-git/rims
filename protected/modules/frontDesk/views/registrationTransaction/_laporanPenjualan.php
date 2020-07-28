<?php
Yii::app()->clientScript->registerCss('_report', '
	.price {text-align: right;}
	.report table{
		border-collapse:collapse;
		border:none;
	}
	.report td,th {
		 border:none;
	}
	.expButton {background-color: transparent; color:black;}
	.expButton:hover {background-color:transparent; color:black;}
	.expButton:active {background-color:transparent; color:black;}
	.expButton:focus {background-color:transparent; color:black;}
');
?>
<?php //echo(CJSON::encode($orderPenjualanPendingSummary->dataProvider->data)); ?>

	<style type="text/css">
		
	</style>
	
		<div class="reportHeader">
		    <div>PT RATU PERDANA INDAH JAYA</div>
		    <div>LAPORAN PENJUALAN (REGISTRATION)</div>
		    <div>Periode: <?php echo $tanggal_mulai .' s/d '.$tanggal_sampai; ?></div>
		   	<div>Branch: <?php echo $branch; ?></div>
		    <span></span><br>
		    <div>Tanggal Cetak: <?php echo date('d/m/Y'); ?></div>
		</div>
		<p></p>
		<table class="report">
		<tr style="background:#fff;border:0px solid;">
			<th style="width:5px;"></th>
			<th>Tanggal</th>
			<th>No Dokumen</th>
			<th>NO WO</th>
			<th>NO Polisi</th>
			<th>Car Make </th>
			<th>Car Sub Model</th>
			<th>Customer</th>
			<th>T/K</th>
			<th>Subtotal</th>
			<th>Discount Product</th>
			<th>Discount Service</th>
			<th>PPN</th>
			<th>PPH</th>
			<th>Total</th>
		</tr>
		<tr style="background:#efefef;border:0px;">
			<th></th>
			<th>Product Code</th>
			<th>Product Name</th>
			<th>Product Master Category</th>
			<th>Product Sub Master Category</th>
			<th>Product Sub Category</th>
			<th></th>
			<th>Quantity</th>
			<th>Unit Price</th>
			<th>Brutto</th>
			<th>Discounts</th>
			<th>Discount Price</th>
			<th>Netto</th>
			<th>Biaya</th>
			<th>Total</th>
		</tr>
		<tr style="background:#efefef;border:0px;">
			<th></th>
			<th>SERVICE Code</th>
			<th>SERVICE Name</th>
			<th>SERVICE Category</th>
			<th>SERVICE TYPE</th>
			<th></th>
			<th></th>
			<th>HOUR</th>
			<th>Price</th>
			<th>Brutto</th>
			<th>Discount Type</th>
			<th>Discount Price</th>
			<th>Netto</th>
			<th>Biaya</th>
			<th>Total</th>
		</tr>
		<tr style="background:#efefef;border:0px;">
		<th></th>
			<th>QS Code</th>
			<th>QS Name</th>
			<th></th>
			<th></th>
			<th></th>
			<th></th>
			<th>HOUR</th>
			<th>Price</th>
			<th>Brutto</th>
			<th></th>
			<th></th>
			<th>Netto</th>
			<th>Biaya</th>
			<th>Total</th>
		</tr>
			<?php $grandsub = $grandDiscountProduct = $grandDiscountService = $grandPpn = $grandPph = $grandTotal = 0; ?>
			<?php foreach ($transactions as $key => $transaction): ?>
				<tr style="background:#fff;border:1px solid;"> 
					<td>
						<?php /*echo CHtml::button('detail', array('class' => 'hello','disabled'=>count($regServices) == 0 ? true : false,
										'onclick'=>'$("#detail-'.$i.'").toggle();
									')); */?>
										
						<?php 
							echo CHtml::tag('button', array(
							    // 'name'=>'btnSubmit',
								//'disabled'=>count($regServices) == 0 ? true : false,
						        'type'=>'button',
						        'class' => 'expButton button expand',
						        'onclick'=>'$("#detail-'.$key.'").toggle();'
						      ), '<span class="fa fa-caret-down"></span>'
						    );
						    ?>
					</td>
					<td><?php echo $transaction->transaction_date; ?></td>
					<td><?php echo $transaction->transaction_number; ?></td>
					<td><?php echo $transaction->work_order_number == "" ? '-' : $transaction->work_order_number; ?></td>
					<td><?php echo $transaction->vehicle->plate_number == "" ? '-': $transaction->vehicle->plate_number; ?></td>
					<td><?php echo $transaction->vehicle->carMake->name == "" ? '-': $transaction->vehicle->carMake->name; ?></td>
					<td><?php echo $transaction->vehicle->carSubModel->name == "" ? '-': $transaction->vehicle->carSubModel->name; ?></td>
					<td><?php echo $transaction->customer->name; ?></td>
					<td></td>
					<td><?php echo number_format($transaction->subtotal,2); ?></td>
					<td><?php echo number_format($transaction->discount_product,2); ?></td>
					<td><?php echo number_format($transaction->discount_service,2); ?></td>
					<td><?php echo number_format($transaction->ppn_price,2); ?></td>
					<td><?php echo number_format($transaction->pph_price,2); ?></td>
					<td><?php echo number_format($transaction->grand_total,2); ?></td>
				</tr>
				<tr id="detail-<?php echo $key?>" class="hide">
					<td colspan="15">
						<table>
							<?php foreach ($transaction->registrationProducts as $key => $transactionDetail): ?>
								<tr style="background:#efefef;border:0px;">
									<td><?php echo $transactionDetail->product->code; ?></td>
									<td><?php echo $transactionDetail->product->name; ?></td>
									<td><?php echo $transactionDetail->product->productMasterCategory->name; ?></td>
									<td><?php echo $transactionDetail->product->productSubMasterCategory->name; ?></td>
									<td><?php echo $transactionDetail->product->productSubCategory->name; ?></td>
									<td>B</td>
									<td><?php echo $transactionDetail->quantity; ?></td>
									<td><?php echo number_format($transactionDetail->sale_price,2); ?></td>
									<td><?php echo number_format($transactionDetail->quantity * $transactionDetail->sale_price,2); ?></td>
									
									<td>
										<?php echo $transactionDetail->discount_type; ?>
									</td>
									<td><?php echo number_format($transactionDetail->discount,2); ?></td>
									<td><?php echo number_format($transactionDetail->total_price,2); ?></td>
									<td></td>
									<td><?php echo number_format($transactionDetail->total_price,2); ?></td>
								</tr>
							<?php endforeach ?>
							
							<?php foreach ($transaction->registrationServices as $key => $serviceDetail): ?>
							
								<?php if ($serviceDetail->is_quick_service == 0 && $serviceDetail->is_body_repair == 0): ?>
									
										<tr style="background:#efefef;border:0px;">
										<td><?php echo $serviceDetail->service->code; ?></td>
										<td><?php echo $serviceDetail->service->name; ?></td>
										<td><?php echo $serviceDetail->service->serviceCategory->name; ?></td>
										<td><?php echo $serviceDetail->service->serviceType->name; ?></td>
										<td>&nbsp;</td>
										<td>J</td>
										<td><?php echo $serviceDetail->hour; ?></td>
										<td><?php echo number_format($serviceDetail->price,2); ?></td>
										<td>&nbsp;</td>
										
										<td>
											<?php echo $serviceDetail->discount_type; ?>
										</td>
										<td><?php echo number_format($serviceDetail->discount_price,2); ?></td>
										<td><?php echo number_format($serviceDetail->total_price,2); ?></td>
										<td></td>
										<td><?php echo number_format($serviceDetail->total_price,2); ?></td>
									</tr>
									<?php endif ?>
									
							
								<?php endforeach ?>
							
							<?php foreach ($transaction->registrationQuickServices as $key => $qsDetail): ?>
								<tr style="background:#efefef;border:0px;">
									<td><?php echo $qsDetail->quickService->code; ?></td>
									<td><?php echo $qsDetail->quickService->name; ?></td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>&nbsp;</td>
									<td>QS</td>
									<td><?php echo $qsDetail->hour; ?></td>
									<td><?php echo number_format($qsDetail->price,2); ?></td>
									<td>&nbsp;</td>
									
									<td>
										&nbsp;
									</td>
									<td>&nbsp;</td>
									<td><?php echo number_format($qsDetail->price,2); ?></td>
									<td></td>
									<td><?php echo number_format($qsDetail->price,2); ?></td>
								</tr>
							<?php endforeach ?>
							<tr style="background:#fff;border:0px;"><td colspan="14"></td></tr>
							 <?php 
							 	$grandsub += $transaction->subtotal;
							 	$grandDiscountProduct += $transaction->discount_product;
							 	$grandDiscountService += $transaction->discount_service;
							 	$grandPpn += $transaction->ppn_price;
							 	$grandPph += $transaction->pph_price;
							 	$grandTotal += $transaction->grand_total;
							?>
						
						</table>
					</td>
					
				</tr>
				
				<?php endforeach ?>

			<tr>
					<td colspan="6"></td>
					<td colspan="2">GrandTotal</td>
					<td><?php echo number_format($grandsub,2); ?></td>
					<td><?php echo number_format($grandDiscountProduct,2); ?></td>
					<td><?php echo number_format($grandDiscountService,2); ?></td>
					<td><?php echo number_format($grandPpn,2); ?></td>
					<td><?php echo number_format($grandPph,2); ?></td>
					<td><?php echo number_format($grandTotal,2); ?></td>
			</tr>
		</table>

			
	
	
