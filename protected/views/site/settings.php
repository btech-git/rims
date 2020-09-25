<div id="content">
    <div class="row">
        <div class="small-12 columns">
            <div class="breadcrumbs">
                <a href="#">Home</a>
                <span>Settings</span>
            </div>
        </div>
    </div>
    <style type="text/css">
        /*.small-1a { width: 12%; border:0px solid #ccc; border-radius: 5px; margin-right:20px; float: left !important; }*/
        #noliststyle ul {
            list-style: none;
            margin: 0;
            padding: 0px;
            height: auto;
        }
        #noliststyle ul li a:hover { text-decoration: underline;}
    </style>

    <div class="row">
        <div class="small-12 columns" >
            <div id="maincontent">
                <div class="clearfix page-action">
                    <h1>Master Settings</h1>
                </div>
                <div class="row" style="margin-top:20px" id="noliststyle">
                    <div class="small-2 columns">
                        <img src="<?php echo Yii::app()->baseUrl.'/images/company.png' ?>" /> <br/><br/>
                        <h2>Company</h2>
                        <?php $this->widget('zii.widgets.CMenu',array(
                            'items'=>array(
                                array('label'=>'User', 'url'=>array('/user/admin'), 'visible'=>Yii::app()->user->checkAccess('masterUserView')),
                                array('label'=>'Company', 'url'=>array('/master/company/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Company.View')),
                                array('label'=>'Insurance Company', 'url'=>array('/master/insuranceCompany/admin'), 'visible'=>Yii::app()->user->checkAccess('masterInsuranceCompanyView')),
                                array('label'=>'Branch', 'url'=>array('/master/branch/admin'), 'visible'=>Yii::app()->user->checkAccess('masterBranchView')),
                                array('label'=>'Customer', 'url'=>array('/master/customer/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Customer.View')),
                                array('label'=>'Supplier', 'url'=>array('/master/supplier/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Supplier.View')),
                                array('label'=>'Employee', 'url'=>array('/master/employee/admin'),'linkOptions' =>array('class' => 'titleNav'), 'visible'=>Yii::app()->user->checkAccess('Master.Employee.View')),
                                array('label'=>'Deduction', 'url'=>array('/master/deduction/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Deduction.View')),
                                array('label'=>'Incentive', 'url'=>array('/master/incentive/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Incentive.View')),
                                array('label'=>'Position', 'url'=>array('/master/position/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Position.View')),
                                array('label'=>'Division', 'url'=>array('/master/division/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Division.View')),
                                array('label'=>'Level', 'url'=>array('/master/level/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Level.View')),
                                array('label'=>'Unit', 'url'=>array('/master/unit/admin'),'linkOptions' =>array('class' => 'titleNav'), 'visible'=>Yii::app()->user->checkAccess('Master.Unit.View')),
                                array('label'=>'Unit Conversion', 'url'=>array('/master/unitConversion/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.UnitConversion.View')),
                                array('label'=>'Public Holiday', 'url'=>array('/master/publicDayOff/admin'), 'visible'=>Yii::app()->user->checkAccess('masterPublicHolidayView')),
                                //array('label'=>'Payment-Type', 'url'=>array('/master/customer/admin')),
                                ),
                            )
                        ); 
                        ?>
                    </div>

                    <div class="small-2 columns">
                        <img src="<?php echo Yii::app()->baseUrl.'/images/accounting.png' ?>" /> <br/><br/>
                        <h2>Accounting</h2>
                        <?php $this->widget('zii.widgets.CMenu',array(
                            'items'=>array(
                                array('label'=>'Bank', 'url'=>array('/master/bank/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Bank.Admin')),
                                array('label'=>'COA', 'url'=>array('/accounting/coa/admin'), 'visible'=>Yii::app()->user->checkAccess('Accounting.Coa.Admin')),
                                array('label'=>'COA Category', 'url'=>array('/master/coaCategory/admin'), 'visible'=>Yii::app()->user->checkAccess('Accounting.CoaCategory.Admin')),
                                array('label'=>'COA Sub Category', 'url'=>array('/master/coaSubCategory/admin'), 'visible'=>Yii::app()->user->checkAccess('Accounting.CoaSubCategory.Admin')),
                                array('label'=>'Payment Type', 'url'=>array('/master/paymentType/admin')),
                            ),
                        ));?>
                    </div>

                    <div class="small-2 columns">
                        <img src="<?php echo Yii::app()->baseUrl.'/images/product.png' ?>" /> <br/><br/>
                        <h2>Product</h2>
                        <?php $this->widget('zii.widgets.CMenu',array(
                            'items'=>array(
                                //array('label'=>'Inventory Detail', 'url'=>array('/master/inventoryDetail/admin')),
                                array('label'=>'Product', 'url'=>array('/master/product/admin'),'linkOptions' =>array('class' => 'titleNav'), 'visible'=>Yii::app()->user->checkAccess('Master.Product.View')),
                                // array('label'=>'Find Product', 'url'=>array('/master/findProduct/index')),
                                array('label'=>'Product Category', 'url'=>array('/master/productMasterCategory/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.ProductMasterCategory.View')),
                                array('label'=>'Product Sub-Master Category', 'url'=>array('/master/productSubMasterCategory/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.ProductSubMasterCategory.View')),
                                array('label'=>'Product Sub-Category', 'url'=>array('/master/productSubCategory/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.AroductSubCategory.View')),
                                //array('label'=>'Specification Type', 'url'=>array('/master/productSpecificationType/admin')),
                                //array('label'=>'Specification Info', 'url'=>array('/master/productSpecificationInfo/admin')),
                                array('label'=>'Brand', 'url'=>array('/master/brand/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Brand.View')),
                                array('label'=>'Sub-Brand', 'url'=>array('/master/subBrand/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.SubBrand.View')),
                                array('label'=>'Sub-Brand Series', 'url'=>array('/master/subBrandSeries/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.SubBrandSeries.View')),
                                array('label'=>'Equipments', 'url'=>array('/master/equipments/admin'),'linkOptions' =>array('class' => 'titleNav'), 'visible'=>Yii::app()->user->checkAccess('Master.Equipments.View')),
                                array('label'=>'Equipment Types', 'url'=>array('/master/equipmentType/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.EquipmentType.View')),
                                array('label'=>'Equipment Sub-types', 'url'=>array('/master/equipmentSubType/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.EquipmentSubType.View')),
                                //array('label'=>'Equipment Branches', 'url'=>array('/master/equipmentBranch/admin')),
                                //array('label'=>'Equipment Tasks', 'url'=>array('/master/equipmentTask/admin')),
                                //array('label'=>'Equipment Maintenance', 'url'=>array('/master/equipmentMaintenance/admin')),
                                ),
                            )
                            ); ?>
                        </div>

                        <div class="small-2 columns">
                            <img src="<?php echo Yii::app()->baseUrl.'/images/service.png' ?>" /> <br/><br/>
                            <h2>Service</h2>
                            <?php $this->widget('zii.widgets.CMenu',array(
                                'items'=>array(
                                    array('label'=>'Service', 'url'=>array('/master/service/admin'),'linkOptions' =>array('class' => 'titleNav'), 'visible'=>Yii::app()->user->checkAccess('Master.Service.View')),
                                    array('label'=>'Service Category', 'url'=>array('/master/serviceCategory/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.ServiceCategory.View')),
                                    array('label'=>'Service Type', 'url'=>array('/master/serviceType/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.ServiceType.View')),
                                    array('label'=>'Service Pricelist', 'url'=>array('/master/servicePricelist/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.ServicePricelist.View')),
                                    array('label'=>'Service Standard Pricelist', 'url'=>array('/master/serviceStandardPricelist/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.ServiceStandardPricelist.View')),
                                    array('label'=>'Service Group', 'url'=>array('/master/serviceGroup/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.ServiceType.View')),
                                    array('label'=>'Standard Flat Rate', 'url'=>array('/master/generalStandardFr/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.GeneralStandardFr.View')),
                                    array('label'=>'Standard Value', 'url'=>array('/master/generalStandardValue/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.GeneralStandardValue.View')),
                                    array('label'=>'Quick Service', 'url'=>array('/master/quickService/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.QuickService.View')),
                                    array('label'=>'Inspection', 'url'=>array('/master/inspection/admin'),'linkOptions' =>array('class' => 'titleNav'), 'visible'=>Yii::app()->user->checkAccess('Master.Inspection.View')),
                                    array('label'=>'Inspection Section', 'url'=>array('/master/inspectionSection/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.InspectionSection.View')),
                                    array('label'=>'Inspection Module', 'url'=>array('/master/inspectionModule/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.InspectionModule.View')),
                                    array('label'=>'Inspection Checklist Type', 'url'=>array('/master/inspectionChecklistType/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.InspectionChecklistType.View')),
                                    array('label'=>'Inspection Checklist Module', 'url'=>array('/master/inspectionChecklistModule/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.InspectionChecklistModule.View')),
                                    //array('label'=>'Equipment', 'url'=>array('/master/equipment/admin')),
                                    //array('label'=>'Service Material Usage', 'url'=>array('/master/serviceMaterialUsage/admin')),
                                    ),
                                )
                                ); ?>
                            </div>

                            <div class="small-2 columns">
                                <img src="<?php echo Yii::app()->baseUrl.'/images/vehicle.png' ?>" /> <br/><br/>
                                <h2>Vehicle</h2>
                                <?php $this->widget('zii.widgets.CMenu',array(
                                    'items'=>array(
                                        array('label'=>'Manage Customer Vehicle', 'url'=>array('/master/vehicle/admin'),'linkOptions' =>array('class' => 'titleNav'), 'visible'=>Yii::app()->user->checkAccess('Master.Vehicle.View')),
                                        array('label'=>'Vehicle Car Make', 'url'=>array('/master/vehicleCarMake/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.VehicleCarMake.View')),
                                        array('label'=>'Vehicle Car Model', 'url'=>array('/master/vehicleCarModel/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.VehicleCarModel.View')),
                                        array('label'=>'Vehicle Car Sub Model', 'url'=>array('/master/vehicleCarSubModel/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.VehicleCarSubModel.View')),
                                        array('label'=>'Vehicle Car Sub Model Detail', 'url'=>array('/master/vehicleCarSubModelDetail/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.VehicleCarSubModelDetail.View')),
                                        //array('label'=>'Chassis Code', 'url'=>array('/master/chasisCode/admin')),
                                        array('label'=>'Color', 'url'=>array('/master/colors/admin'), 'visible'=>Yii::app()->user->checkAccess('Master.Colors.View')),
                                        //array('label'=>'Power CC', 'url'=>array('/master/powercc/admin')),
                                        ),
                                    )
                                );
                                ?>
                            </div>

                            <div class="small-2 columns">
                                <img src="<?php echo Yii::app()->baseUrl.'/images/warehouse.png' ?>" /> <br/><br/>
                                <h2>Warehouse</h2>
                                <?php $this->widget('zii.widgets.CMenu',array(
                                    'items'=>array(
                                        array('label'=>'Warehouse', 'url'=>array('/master/warehouse/admin'),'linkOptions' =>array('class' => 'titleNav'), 'visible'=>Yii::app()->user->checkAccess('Master.Warehouse.View')),
                                            //array('label'=>'Section', 'url'=>array('/master/section/admin')),
                                            //array('label'=>'Section Detail', 'url'=>array('/master/sectionDetail/admin')),
                                        ),
                                    )
                                    ); ?>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>

        </div>
