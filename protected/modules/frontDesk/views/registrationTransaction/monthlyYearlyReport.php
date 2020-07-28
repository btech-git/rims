
<?php 
$this->breadcrumbs= array(
    'Report',
    'MONTHLY YEARLY REPORT FORM',
    );
    ?>
<?php
Yii::app()->clientScript->registerScript('report', '
	 
     $("#branch").val("' . $branch . '");
    
');
//Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>
<div class="tab reportTab">
    <div class="tabHead">
        <?php //$this->renderPartial('../../../admin/views/layouts/_menu_report');?>
    </div>
    <div class="tabBody">
		<div id="detail_div">
			<div>
				<div class="myForm">
                    <h1>MONTHLY YEARLY REPORT FORM</h1>
					<?php echo CHtml::beginForm(array(''), 'get'); ?>
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Show Report </span>
                                    </div>
                                     <div class="small-8 columns">
                                        <?php echo CHtml::dropDownlist('type', $type, array('Yearly'=>'Yearly','Monthly' => 'Monthly')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     
                     <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Year </span>
                                    </div>
                                     <div class="small-8 columns">
                                        <?php echo CHtml::dropDownlist('year', $year, array('2016'=>'2016','2017' => '2017')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Month </span>
                                    </div>
                                     <div class="small-8 columns">
                                        <?php echo CHtml::dropDownlist('month', $month, array('1'=>'January','2' => 'February','3'=>'March','4' => 'April','5'=>'May','6' => 'June','7'=>'July','8' => 'August','9'=>'September','10' => 'October','11'=>'November','12' => 'December')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
					<div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <span class="prefix">Branch </span>
                                    </div>
                                     <div class="small-8 columns">
                                        <?php echo CHtml::dropDownlist('branch', $branch, CHtml::listData(Branch::model()->findAllbyAttributes(array('status'=>'Active')), 'id','name'), array('empty'=>'-- All Branch --')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
					<div><?php //echo $getCoa == "" ? '-' : $getCoa; ?></div>
                    <div><?php //print_r($allCoa); ?></div>
					
                    <div class="clear"></div>
                    <?php //echo CHtml::hiddenField('sort', '', array('id'=>'CurrentSort')); ?>
                    <div class="row buttons">
                        <?php //echo CHtml::submitButton('Show Year', array('name' => 'showYear')); ?>
                        <?php //echo CHtml::submitButton('Show Month', array('name' => 'showMonth')); ?>
                        <?php echo CHtml::submitButton('Tampilkan', array('onclick'=>'$("#CurrentSort").val(""); return true;')); ?>
                       
                      <!--  <button type="reset" value="Reset" id="reset">Reset</button> -->
						<?php echo CHtml::submitButton('Yearly Monthly Form Excel', array('name' => 'SaveExcel')); ?>
            <?php echo CHtml::submitButton('Monthly Form Excel', array('name' => 'SaveExcelMonth')); ?>
                    </div>
					
					
                    <?php echo CHtml::endForm(); ?>
                    <div class="clear"></div>

				</div>

				<hr />

				<div class="relative">
					<div class="reportDisplay">

          <?php 
         
                $this->renderPartial('_monthlyYearlyReport', array('transactions'=>$transactions,'branch'=>$branch,'year'=>$year,'month'=>$month,'type'=>$type)); 
           

            ?>
                        <?php 
                        // $serviceTypes = ServiceType::model()->findAll();
                        // foreach ($serviceTypes as $key => $serviceType) {
                        //   echo $serviceType->name;
                        //   echo "<br>";
                        //    $serviceSalesCriteria = new CDbCriteria;
                        //   $serviceSalesCriteria->together = 'true';
                        //   $serviceSalesCriteria->with = array('employee','registrationService'=>array('with'=>array('service'=>array('with'=>array('serviceType')))));
                        //   $serviceSalesCriteria->addCondition("serviceType.id = ".$serviceType->id);
                        //       $yearServiceSales = RegistrationServiceEmployee::model()->findAll($serviceSalesCriteria);

                        //       $row = 40;
                        //       $lastname = $lastDiv = $lastId= "";
                        //       foreach ($yearServiceSales as $key => $yearServiceSale) {
                        //         //$objPHPExcel->setActiveSheetIndex(0)->setCellValue('C'.$row,$yearServiceSale->service->serviceType->name);
                               
                        //         //echo $yearServiceSale->registrationService->service->serviceType->name ;

                        //         //echo $lastname == $yearServiceSale->employee->name? '' :$yearServiceSale->employee->name; 
                        //         echo $yearServiceSale->employee->name; 
                        //         echo '<br>';
                               

                        //       }

                        // }
                       
                       //  $regServiceCriteria = new CDbCriteria;
                       //  // $regServiceEmpCriteria->select = "rims_service.service_type_id as Service_type, sum(t.total_price) as total,rims_registration_service_employee.employee_id ,rims_employee.name as name";
                       //  // $regServiceEmpCriteria->join = "join rims_registration_transaction on rims_registration_transaction.id = t.registration_transaction_id join rims_registration_service_employee on t.id = rims_registration_service_employee.registration_service_id join rims_employee on rims_registration_service_employee.employee_id = rims_employee.id join rims_service on t.service_id = rims_service.id";
                       //  $regServiceCriteria->with = array('registrationTransaction','service','registrationServiceEmployees');
                       //  $regServiceCriteria->addCondition("year(registrationTransaction.transaction_date) = 2016");
                       //  //$regServiceEmpCriteria->group = "rims_registration_service_employee.employee_id";
                       //  $regServiceEmps = RegistrationService::model()->findAll($regServiceCriteria);
                        
                       // //print_r($regServiceEmps);
                       // foreach ($regServiceEmps as $key => $regServiceEmp) {
                       //     $regServiceEmpCriteria = new CDbCriteria;
                       //     $regServiceEmpCriteria->with= array('employee','registrationService');
                           
                       //     $regServiceEmpCriteria->select = "sum(registrationService.total_price) as total";
                       //     $regServiceEmpCriteria->addCondition("t.registration_service_id = registrationService.id");
                       //     $regServiceEmpCriteria->group = "employee_id";
                       //     $regSerEmployees = RegistrationServiceEmployee::model()->findAll($regServiceEmpCriteria);
                       //     echo count($regSerEmployees);
                       //     foreach ($regSerEmployees as $key => $value) {
                       //        echo $value->employee_id . '<br>';

                       //     }
                       // }
                        ?>
						<?php //echo ReportHelper::summaryText($saleSummary->dataProvider); ?>
						<?php //echo ReportHelper::sortText($transaksiPembelianSummary->dataProvider->sort, array('Jenis Persediaan', 'Tanggal SO', 'Pelanggan')); ?>
					</div>
					
				<div class="clear"></div>
			</div>
			<br/>
				
			<div class="hide">
				<div class="right">
					

				</div>
				<div class="clear"></div>
			</div>
		</div>
	</div>
</div>

