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
                        <img src="<?php echo Yii::app()->baseUrl . '/images/company.png' ?>" /> <br/><br/>
                        <h2>Company</h2>
                        <?php $this->widget('zii.widgets.CMenu', array(
                            'items' => array(
                                array('label' => 'User', 'url' => array('/user/admin'), 'visible' => Yii::app()->user->checkAccess('generalManager')),
                                array('label' => 'Company', 'url' => array('/master/company/admin'), 'visible' => Yii::app()->user->checkAccess('generalManager')),
                                array('label' => 'Insurance Company', 'url' => array('/master/insuranceCompany/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('salesHead')),
                                array('label' => 'Branch', 'url' => array('/master/branch/admin'), 'visible' => Yii::app()->user->checkAccess('generalManager')),
                                array('label' => 'Supplier', 'url' => array('/master/supplier/admin'), 'visible' => Yii::app()->user->checkAccess('purchaseHead')),
                                array('label' => 'Employee', 'url' => array('/master/employee/admin'), 'linkOptions' => array('class' => 'titleNav'), 'visible' => Yii::app()->user->checkAccess('generalManager')),
                                array('label' => 'Deduction', 'url' => array('/master/deduction/admin'), 'visible' => Yii::app()->user->checkAccess('generalManager')),
                                array('label' => 'Incentive', 'url' => array('/master/incentive/admin'), 'visible' => Yii::app()->user->checkAccess('generalManager')),
                                array('label' => 'Position', 'url' => array('/master/position/admin'), 'visible' => Yii::app()->user->checkAccess('generalManager')),
                                array('label' => 'Division', 'url' => array('/master/division/admin'), 'visible' => Yii::app()->user->checkAccess('generalManager')),
                                array('label' => 'Level', 'url' => array('/master/level/admin'), 'visible' => Yii::app()->user->checkAccess('generalManager')),
                                array('label' => 'Unit', 'url' => array('/master/unit/admin'), 'linkOptions' => array('class' => 'titleNav'), 'visible' => Yii::app()->user->checkAccess('generalManager')),
                                array('label' => 'Unit Conversion', 'url' => array('/master/unitConversion/admin'), 'visible' => Yii::app()->user->checkAccess('generalManager')),
                                array('label' => 'Public Holiday', 'url' => array('/master/publicDayOff/admin'), 'visible' => Yii::app()->user->checkAccess('generalManager')),
                            ),
                        )); ?>
                    </div>

                    <div class="small-2 columns">
                        <img src="<?php echo Yii::app()->baseUrl . '/images/accounting.png' ?>" /> <br/><br/>
                        <h2>Accounting</h2>
                        <?php $this->widget('zii.widgets.CMenu', array(
                            'items' => array(
                                array('label' => 'Bank', 'url' => array('/master/bank/admin'), 'visible' => Yii::app()->user->checkAccess('accountingHead') || Yii::app()->user->checkAccess('financeHead')),
                                array('label' => 'COA', 'url' => array('/accounting/coa/admin'), 'visible' => Yii::app()->user->checkAccess('accountingHead') || Yii::app()->user->checkAccess('financeHead')),
                                array('label' => 'COA Category', 'url' => array('/master/coaCategory/admin'), 'visible' => Yii::app()->user->checkAccess('accountingHead') || Yii::app()->user->checkAccess('financeHead')),
                                array('label' => 'COA Sub Category', 'url' => array('/master/coaSubCategory/admin'), 'visible' => Yii::app()->user->checkAccess('accountingHead') || Yii::app()->user->checkAccess('financeHead')),
                                array('label' => 'Payment Type', 'url' => array('/master/paymentType/admin')),
                            ),
                        )); ?>
                    </div>

                    <div class="small-2 columns">
                        <img src="<?php echo Yii::app()->baseUrl . '/images/product.png' ?>" /> <br/><br/>
                        <h2>Product</h2>
                        <?php $this->widget('zii.widgets.CMenu', array(
                            'items' => array(
                                array('label' => 'Product', 'url' => array('/master/product/admin'), 'linkOptions' => array('class' => 'titleNav'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('inventoryHead') || Yii::app()->user->checkAccess('operationHead') || Yii::app()->user->checkAccess('purchaseHead') || Yii::app()->user->checkAccess('salesHead')),
                                array('label' => 'Product Category', 'url' => array('/master/productMasterCategory/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('inventoryHead') || Yii::app()->user->checkAccess('operationHead') || Yii::app()->user->checkAccess('purchaseHead') || Yii::app()->user->checkAccess('salesHead')),
                                array('label' => 'Product Sub-Master Category', 'url' => array('/master/productSubMasterCategory/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('inventoryHead') || Yii::app()->user->checkAccess('operationHead') || Yii::app()->user->checkAccess('purchaseHead') || Yii::app()->user->checkAccess('salesHead')),
                                array('label' => 'Product Sub-Category', 'url' => array('/master/productSubCategory/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('inventoryHead') || Yii::app()->user->checkAccess('operationHead') || Yii::app()->user->checkAccess('purchaseHead') || Yii::app()->user->checkAccess('salesHead')),
                                array('label' => 'Brand', 'url' => array('/master/brand/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('inventoryHead') || Yii::app()->user->checkAccess('operationHead') || Yii::app()->user->checkAccess('purchaseHead') || Yii::app()->user->checkAccess('salesHead')),
                                array('label' => 'Sub-Brand', 'url' => array('/master/subBrand/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('inventoryHead') || Yii::app()->user->checkAccess('operationHead') || Yii::app()->user->checkAccess('purchaseHead') || Yii::app()->user->checkAccess('salesHead')),
                                array('label' => 'Sub-Brand Series', 'url' => array('/master/subBrandSeries/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('inventoryHead') || Yii::app()->user->checkAccess('operationHead') || Yii::app()->user->checkAccess('purchaseHead') || Yii::app()->user->checkAccess('salesHead')),
                                array('label' => 'Equipments', 'url' => array('/master/equipments/admin'), 'linkOptions' => array('class' => 'titleNav'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('inventoryHead') || Yii::app()->user->checkAccess('operationHead') || Yii::app()->user->checkAccess('purchaseHead') || Yii::app()->user->checkAccess('salesHead')),
                                array('label' => 'Equipment Types', 'url' => array('/master/equipmentType/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('inventoryHead') || Yii::app()->user->checkAccess('operationHead') || Yii::app()->user->checkAccess('purchaseHead') || Yii::app()->user->checkAccess('salesHead')),
                                array('label' => 'Equipment Sub-types', 'url' => array('/master/equipmentSubType/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('inventoryHead') || Yii::app()->user->checkAccess('operationHead') || Yii::app()->user->checkAccess('purchaseHead') || Yii::app()->user->checkAccess('salesHead')),
                            ),
                        )); ?>
                    </div>

                    <div class="small-2 columns">
                        <img src="<?php echo Yii::app()->baseUrl . '/images/service.png' ?>" /> <br/><br/>
                        <h2>Service</h2>
                        <?php $this->widget('zii.widgets.CMenu', array(
                            'items' => array(
                                array('label' => 'Service', 'url' => array('/master/service/admin'), 'linkOptions' => array('class' => 'titleNav'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('operationHead')),
                                array('label' => 'Service Category', 'url' => array('/master/serviceCategory/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('operationHead')),
                                array('label' => 'Service Type', 'url' => array('/master/serviceType/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('operationHead')),
                                array('label' => 'Pricelist Standard', 'url' => array('/master/serviceStandardPricelist/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('operationHead')),
                                array('label' => 'Pricelist Group', 'url' => array('/master/serviceGroup/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('operationHead')),
                                array('label' => 'Pricelist Set', 'url' => array('/master/servicePricelist/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('operationHead')),
                                array('label' => 'Standard Flat Rate', 'url' => array('/master/generalStandardFr/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('operationHead')),
                                array('label' => 'Standard Value', 'url' => array('/master/generalStandardValue/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('operationHead')),
                                array('label' => 'Quick Service', 'url' => array('/master/quickService/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('operationHead')),
                                array('label' => 'Inspection', 'url' => array('/master/inspection/admin'), 'linkOptions' => array('class' => 'titleNav'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('operationHead')),
                                array('label' => 'Inspection Section', 'url' => array('/master/inspectionSection/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('operationHead')),
                                array('label' => 'Inspection Module', 'url' => array('/master/inspectionModule/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('operationHead')),
                            //array('label'=>'Equipment', 'url'=>array('/master/equipment/admin')),
                            //array('label'=>'Service Material Usage', 'url'=>array('/master/serviceMaterialUsage/admin')),
                            ),
                        )); ?>
                    </div>

                    <div class="small-2 columns">
                        <img src="<?php echo Yii::app()->baseUrl . '/images/vehicle.png' ?>" /> <br/><br/>
                        <h2>Vehicle</h2>
                        <?php $this->widget('zii.widgets.CMenu', array(
                            'items' => array(
                                array('label' => 'Manage Customer Vehicle', 'url' => array('/master/vehicle/admin'), 'linkOptions' => array('class' => 'titleNav'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('idleManagement')),
                                array('label' => 'Customer', 'url' => array('/master/customer/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('idleManagement')),
                                array('label' => 'Vehicle Car Make', 'url' => array('/master/vehicleCarMake/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('idleManagement')),
                                array('label' => 'Vehicle Car Model', 'url' => array('/master/vehicleCarModel/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('idleManagement')),
                                array('label' => 'Vehicle Car Sub Model', 'url' => array('/master/vehicleCarSubModel/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('idleManagement')),
                                array('label' => 'Vehicle Car Sub Model Detail', 'url' => array('/master/vehicleCarSubModelDetail/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('idleManagement')),
                                array('label' => 'Color', 'url' => array('/master/colors/admin'), 'visible' => Yii::app()->user->checkAccess('frontOfficeHead') || Yii::app()->user->checkAccess('idleManagement')),
                            ),
                        )); ?>
                    </div>

                    <div class="small-2 columns">
                        <img src="<?php echo Yii::app()->baseUrl . '/images/warehouse.png' ?>" /> <br/><br/>
                        <h2>Warehouse</h2>
                        <?php $this->widget('zii.widgets.CMenu', array(
                            'items' => array(
                                array('label' => 'Warehouse', 'url' => array('/master/warehouse/admin'), 'linkOptions' => array('class' => 'titleNav'), 'visible' => Yii::app()->user->checkAccess('inventoryHead') || Yii::app()->user->checkAccess('operationHead')),
                            ),
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>