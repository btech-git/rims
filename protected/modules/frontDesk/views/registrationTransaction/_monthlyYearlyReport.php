<?php
Yii::app()->clientScript->registerCss('_report', '
	.price {text-align: right;}
	table tr td{background-color:#fff;color:#000;}
');
?>
<?php //echo(CJSON::encode($orderPenjualanPendingSummary->dataProvider->data)); ?>

	
	
		<div class="reportHeader">
		    <div>PT RATU PERDANA INDAH JAYA</div>
		    <div>monthly Yearly Report</div>
		    <div>Report Type : <?php echo $type; ?></div>
		    <div>Tanggal Cetak: <?php echo date('d/m/Y'); ?></div>
		</div>
		<p></p>

		<?php 
			
			$serviceYear = 0;
			$generalYear = $bodyYear = $tbaYear = $oilYear = $carYear = $othersYear = 0 ;
			
			foreach ($transactions as $key => $transaction) {
				
				foreach ($transaction->registrationServices as $key => $service) {
					if($service->service->service_type_id == 1){
						$generalYear += $service->total_price;
					}
					elseif ($service->service->service_type_id == 2) {
						$bodyYear += $service->total_price;
					}
					elseif ($service->service->service_type_id == 3) {
						$tbaYear += $service->total_price;
					}
					elseif ($service->service->service_type_id == 4) {
						$oilYear += $service->total_price;
					}
					elseif ($service->service->service_type_id == 5) {
						$carYear += $service->total_price;
					}
					else{
						$othersYear += $service->total_price;
					}
					
				}
				$serviceYear += $transaction->total_service_price;

					
				

			}
		 ?>
		<table >
			<tr>
				<td>Year
				</td>
				<td><?php echo $year; ?></td>
			</tr>
			<?php if ($type == "Monthly"): ?>
				<tr>
					<td>Month</td>
					<td><?php echo isset($month) ? $month:''; ?></td>
				</tr>
			<?php endif ?>
			
			<tr>
				<td>Branch</td>
				<td><?php echo $branch; ?></td>
			</tr>
			<tr>
				<td>Revenue</td>
				<td></td>
			</tr>
			
			<tr>
				<td colspan="2">
					<table>
						<tr>
							<td><b>Service </b></td>
							<td><?php //echo $serviceYear; ?></td>
						</tr>
						<tr>
							<td>General Repair</td>
							<td><?php echo $generalYear; ?></td>
						</tr>
						<tr>
							<td>Body Repair</td>
							<td><?php echo $bodyYear; ?></td>
						</tr>
						<tr>
							<td>TBA</td>
							<td><?php echo $tbaYear; ?></td>
						</tr>
						<tr>
							<td>Oil</td>
							<td><?php echo $oilYear; ?></td>
						</tr>
						<tr>
							<td>Car Wash</td>
							<td><?php echo $carYear; ?></td>
						</tr>
						<tr>
							<td>Sub Pekerjaan Luar</td>
							<td></td>
						</tr>
						<tr>
							<td>Other</td>
							<td><?php echo $othersYear; ?></td>
						</tr>
						<tr>
							<td><b>Total Service</b></td>
							<td><b><?php echo $serviceYear; ?></b></td>
						</tr>
						
						<tr>
							<td><b>Parts</b></td>
							<td></td>
						</tr>

						<?php 
							$brands = Brand::model()->findAll();
							$totalYearProduct = 0;
							foreach ($brands as $key => $brand)  : ?>
								<tr>
									<td><?php echo $brand->name; ?></td>
								
								<?php //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('H'.$startrow,$brand->name);
								$prodcriteria = new CDbCriteria;
								$prodcriteria->together = 'true';
								$prodcriteria->with = array('product','registrationTransaction');
								$prodcriteria->addCondition("product.brand_id = ".$brand->id);
								$prodcriteria->addCondition("YEAR(registrationTransaction.transaction_date) =".$year);
								if($type == 'Monthly'){
									$prodcriteria->addCondition("MONTH(registrationTransaction.transaction_date) =".$month);
								}
								
								if ($branch!="") {
									$prodcriteria->addCondition("registrationTransaction.branch_id = ".$branch);
								}
								
								$products = RegistrationProduct::model()->findAll($prodcriteria);
								$productYear =0;
								foreach ($products as $key => $product) {
									$productYear += $product->total_price;
									
									
								}
								$soCriteria = new CDbCriteria;
								$soCriteria->together = 'true';
								$soCriteria->with = array('product','salesOrder');
								$soCriteria->addCondition("product.brand_id = ".$brand->id);
								$soCriteria->addCondition("YEAR(salesOrder.sale_order_date) = ".$year);
								if($type == "Monthly"){
									$soCriteria->addCondition("MONTH(salesOrder.sale_order_date) = ".$month);
								}
								if ($branch!= "") {
									$soCriteria->addCondition("salesOrder.requester_branch_id = ".$branch);
								}
								
								$soProducts = TransactionSalesOrderDetail::model()->findAll($soCriteria);
								$soYear =0;
								foreach ($soProducts as $key => $soProduct) {
									$soYear += $soProduct->total_price;
									
									
								}
								$productAll = $productYear + $soYear;
								$totalYearProduct += $productAll;?>
							

								<td><?php echo $productAll; ?></td>
							</tr>

							<?php endforeach
						 ?>

						<tr>
							<td><b>Total Product</b></td>
							<td><b><?php echo $totalYearProduct; ?></b></td>
						</tr>
						<tr>
							<td><b>Total All</b></td>
							<td><b><?php echo $totalYearProduct + $serviceYear ?></b></td>
						</tr>
					
						
					</table>
				</td>
			</tr>
			<tr>
				<td colspan="2">Service Sales By Division & Employee</td>
			</tr>
			<tr>
				<td colspan="2">
					<table>
						<tr>
							<th>Division</th>
							<th>Employee #</th>
							<th>Employee Name</th>
							<th>Service Sales (RP)</th>
						</tr>
							<?php $serviceTypes = ServiceType::model()->findAll();
							 foreach ($serviceTypes as $key => $serviceType) : ?>
							 <?php 
							 	 $serviceSalesCriteria = new CDbCriteria;
					              $serviceSalesCriteria->together = 'true';
					              $serviceSalesCriteria->with = array('employee','registrationService'=>array('with'=>array('registrationTransaction','service'=>array('with'=>array('serviceType')))));
					               $serviceSalesCriteria->addCondition("YEAR(registrationTransaction.transaction_date) = ".$year);
					               if($type == "Monthly"){
					               	$serviceSalesCriteria->addCondition("MONTH(registrationTransaction.transaction_date) = ".$month);
					               }
					              $serviceSalesCriteria->addCondition("serviceType.id = ".$serviceType->id);
					                  $yearServiceSales = RegistrationServiceEmployee::model()->findAll($serviceSalesCriteria);

					                 
					                  $lastname = $lastDiv = $lastId= "";
							  ?>
					             <tr>
					             	<td rowspan="<?php echo count($yearServiceSales)+1; ?>"><?php echo $serviceType->name; ?></td>
					             </tr>

					      <?php        
					             
					                  foreach ($yearServiceSales as $key => $yearServiceSale) :
					                  	$employees = Employee::model()->findAllByAttributes(array('id'=>$yearServiceSale->employee_id));
					                  	foreach ($employees as $key => $employee) : ?>
										<tr>
													<td><?php echo $employee->id; ?></td>
								                  	<td><?php echo $employee->name; ?></td>
								                  	<td><?php echo $yearServiceSale->registrationService->total_price; ?></td>
											
										</tr>
									       
					                  	<?php endforeach; 
					                  endforeach;

					                 
						 ?>
						 
						<?php endforeach; ?>
					</table>
				</td>
			</tr>
		</table>

			
	
	
