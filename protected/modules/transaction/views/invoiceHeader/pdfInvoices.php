<?php $ccontroller = Yii::app()->controller->id; ?>
<?php $ccaction = Yii::app()->controller->action->id; ?>

<?php foreach ($invoices as $key => $invoice): ?>
	<?php $details = InvoiceDetail::model()->findAllByAttributes(array('invoice_id'=>$invoice->id)); ?>
    <header class="clearfix">
      <table width="100%">
      	<tr>
      		<td width="40%" align="left">
      		    <div id="company" >
			        <div><strong>RAPERIND</strong> Motor</div>
			        <div>JL. Kalimalang, No. 8, Kampung Dua,<br />Bekasi City, West Java</div>
			        <div>(021) 8843656</div>
			        <div><a href="mailto:company@example.com">company@example.com</a></div>
			    </div>
      		</td>
      		<td width="20%">
		      <div id="logo">
		        <img src="<?php echo Yii::app()->baseUrl; ?>/images/logo_invoice.png" style="max-width: 90px;">
		      </div>
      		</td>
      		<td width="40%">
		      <div id="project">
			       <div><span>Reference Number #:</span> <?php if ($invoice->reference_type == 1): ?>
								<?php echo $invoice->salesOrder->sale_order_no; ?>
							<?php else :?>
								<?php echo $invoice->registration_transaction_id; ?>
							<?php endif ?></div>
	               <div><span>Reference Type #:</span> <?php echo $invoice->reference_type == 1 ? 'Sales Order' : 'Retail Sales'; ?></div>
	               <div><span>Created:</span> <?php echo $invoice->invoice_date; ?></div>
	               <div><span>Due:</span> <?php echo $invoice->due_date; ?></div>
	               <div><span style="background-color:red;color:white"><?php echo $invoice->status; ?></span>
		      </div>
			</td>
      	</tr>
      </table>
      <h1 >INVOICE #<?php echo $invoice->invoice_number; ?></h1>

    </header>
	<div style="height: 800px">
    <main>
		<?php 
			$productCriteria = new CDbCriteria;
			$productCriteria->addCondition('invoice_id ='.$invoice->id);
			$productCriteria->addCondition('product_id != ""');
			$products = InvoiceDetail::model()->findAll($productCriteria);
		 ?>
		<?php 
			$serviceCriteria = new CDbCriteria;
			$serviceCriteria->addCondition('invoice_id ='.$invoice->id);
			$serviceCriteria->addCondition('service_id != ""');
		$services = InvoiceDetail::model()->findAll($serviceCriteria); ?>
		<?php 
			$QserviceCriteria = new CDbCriteria;
			$QserviceCriteria->addCondition('invoice_id ='.$invoice->id);
			$QserviceCriteria->addCondition('quick_service_id != ""');
		$Qservices = InvoiceDetail::model()->findAll($QserviceCriteria); ?>
			<?php if(count($products) > 0) : ?>
				<table>
	    	    <thead>
		    	    <tr>
						<th>Product</th>
						<th>Quantity</th>
						<th width="200px">Unit Price</td>
						<th width="200px">Price</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($details as $i => $detail): ?>
						<?php if($detail->product_id != ""): ?>
				          <tr>
				            <td class="desc"><?php echo $detail->product->name; ?></td>
				            <td class="qty"><?php echo $detail->quantity; ?></td>
				            <!-- <td class="unit"></td> -->
				            <td class="qty"><?php echo number_format($detail->unit_price, 2, ',', '.'); ?></td>
				            <td class="total"><?php echo number_format($detail->total_price, 2, ',', '.'); ?></td>
				          </tr>
						<?php endif; ?>
					<?php endforeach; ?>

				</tbody>
				
			</table>
		<?php endif; ?>
		<?php if(count($services) > 0 ) : ?>
			<table>
	    	    <thead>
		    	    <tr>
					<th>Service</th>
					<th colspan="2"></th>
					<th width="200px">Price</th>
				    </tr>
				</thead>
				<tbody>
					<?php foreach ($details as $i => $detail): ?>
					<?php if ($detail->service_id != ""): ?>
				          <tr>
				            <td class="desc"><?php echo $detail->service->name; ?></td>
				            <td colspan="2">&nbsp;</td>
				            <td class="total"><?php echo number_format($detail->total_price, 2, ',', '.'); ?></td>
				          </tr>
					<?php endif ?>
					<?php endforeach; ?>
				</tbody>
			</table>
			<?php endif; ?>
			<?php if (count($Qservices) >0 ): ?>
			<table>
	    	    <thead>
		    	    <tr>
						<th>Quick Service</th>
			            <th>&nbsp;</th>
						<th width="200px">Unit Price</th>
						<th width="200px">Price</th>
				    </tr>
				</thead>
				<tbody>
						<?php foreach ($details as $i => $detail): ?>
							<?php if ($detail->quick_service_id != ""): ?>
			 		        	<tr>
						            <td class="desc"><?php echo $detail->quickService->name; ?></td>
						            <td>&nbsp;</td>
						            <td class="qty"><?php echo number_format($detail->unit_price, 2, ',', '.'); ?></td>
						            <td class="total"><?php echo number_format($detail->total_price, 2, ',', '.'); ?></td>
						        </tr>
							<?php endif ?>
						<?php endforeach; ?>
					</tbody>
				</table>
			<?php endif ?>

				<table>
					<tr>
						<td>Service Price</td>
						<td class="total" width="200px"><?php echo number_format($invoice->service_price, 2, ',', '.') ?></td>
					</tr>
					<tr>
						<td>Product Price</td>
						<td width="200px"><?php echo number_format($invoice->product_price, 2, ',', '.') ?></td>
					</tr>
					<tr>
						<td>Quick Service Price</td>
						<td width="200px"><?php echo number_format($invoice->quick_service_price, 2, ',', '.') ?></td>
					</tr>
					<?php if ($invoice->ppn == 1): ?>
						<tr>
							<td>PPN (10%) </td>
							<td width="200px"><?php echo number_format($invoice->ppn_total, 2, ',', '.') ?></td>
						</tr>
					<?php endif ?>
					<?php if ($invoice->pph == 1): ?>
						<tr>
							<td>PPH (2%) </td>
							<td width="200px"><?php echo number_format($invoice->pph_total, 2, ',', '.') ?></td>
						</tr>
					<?php endif ?>
					
					<tr>
						<td>Total Price</td>
						<td width="200px"><?php echo number_format($invoice->total_price, 2, ',', '.') ?></td>
					</tr>
				</table>
      <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
      </div>
    </main>
    <footer>
      Invoice was created on a computer and is valid without the signature and seal.
    </footer>
  	</div>
</div>
<?php /*
       <table cellpadding="0" cellspacing="0" width="100%">
            
            <tr class="information">
                <td colspan="2">
                    <table width="700px;">
						<tr>
							<td>Reference Number</td>
							<td><?php if ($invoice->reference_type == 1): ?>
								<?php echo $invoice->salesOrder->sale_order_no; ?>
							<?php else :?>
								<?php echo $invoice->registration_transaction_id; ?>
							<?php endif ?></td>
							<td>Branch</td>
							<td><?php echo $invoice->branch->name; ?></td>
						</tr>
						<tr>
							<td>Status</td>
							<td background-color="red"><label for="" style="background-color:red;color:white"> <?php echo $invoice->status; ?></label></td>
							<td>User_id</td>
							<td><?php echo $invoice->user_id; ?></td>
						</tr>
                    </table>
                </td>
            </tr>
            </table> */?>
<?php endforeach ?>
