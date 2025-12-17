<div id="content">
    <div class="row">
        <div class="small-32 columns">
            <div class="breadcrumbs">
                <a href="#">Home</a>
                <span>Settings</span>
            </div>
        </div>
    </div>
    <style type="text/css">
        /*.small-3a { width: 12%; border:0px solid #ccc; border-radius: 5px; margin-right:20px; float: left !important; }*/
        #noliststyle ul {
            list-style: none;
            margin: 0;
            padding: 0px;
            height: auto;
        }
        #noliststyle ul li a:hover { text-decoration: underline;}
    </style>

    <div class="row">
        <div class="small-32 columns" >
            <div id="maincontent">
                <div class="clearfix page-action">
                    <h1>Master Settings</h1>
                </div>
                <div class="row" style="margin-top:20px" id="noliststyle">
                    <div class="small-3 columns">
                        <img src="<?php echo Yii::app()->baseUrl . '/images/company.png' ?>" /> <br/><br/>
                        
                        <?php if (
                            Yii::app()->user->checkAccess('masterUserCreate') || 
                            Yii::app()->user->checkAccess('masterUserEdit') || 
                            Yii::app()->user->checkAccess('masterUserView') || 
                            Yii::app()->user->checkAccess('masterUserApproval') || 
                            Yii::app()->user->checkAccess('masterCompanyCreate') || 
                            Yii::app()->user->checkAccess('masterCompanyEdit') || 
                            Yii::app()->user->checkAccess('masterCompanyView') || 
                            Yii::app()->user->checkAccess('masterCompanyApproval') || 
                            Yii::app()->user->checkAccess('masterBranchCreate') || 
                            Yii::app()->user->checkAccess('masterBranchEdit') || 
                            Yii::app()->user->checkAccess('masterBranchView') || 
                            Yii::app()->user->checkAccess('masterBranchApproval') || 
                            Yii::app()->user->checkAccess('masterSupplierCreate') || 
                            Yii::app()->user->checkAccess('masterSupplierEdit') || 
                            Yii::app()->user->checkAccess('masterSupplierView') || 
                            Yii::app()->user->checkAccess('masterSupplierApproval') || 
                            Yii::app()->user->checkAccess('masterDeductionCreate') || 
                            Yii::app()->user->checkAccess('masterDeductionEdit') || 
                            Yii::app()->user->checkAccess('masterDeductionView') || 
                            Yii::app()->user->checkAccess('masterDeductionApproval') || 
                            Yii::app()->user->checkAccess('masterIncentiveCreate') || 
                            Yii::app()->user->checkAccess('masterIncentiveEdit') || 
                            Yii::app()->user->checkAccess('masterIncentiveView') || 
                            Yii::app()->user->checkAccess('masterIncentiveApproval') || 
                            Yii::app()->user->checkAccess('masterPositionCreate') || 
                            Yii::app()->user->checkAccess('masterPositionEdit') || 
                            Yii::app()->user->checkAccess('masterPositionView') || 
                            Yii::app()->user->checkAccess('masterPositionApproval') || 
                            Yii::app()->user->checkAccess('masterDivisionCreate') || 
                            Yii::app()->user->checkAccess('masterDivisionEdit') || 
                            Yii::app()->user->checkAccess('masterDivisionView') || 
                            Yii::app()->user->checkAccess('masterDivisionApproval') || 
                            Yii::app()->user->checkAccess('masterLevelCreate') || 
                            Yii::app()->user->checkAccess('masterLevelEdit') || 
                            Yii::app()->user->checkAccess('masterLevelView') || 
                            Yii::app()->user->checkAccess('masterLevelApproval')
                        ): ?>
                            <h2>Company</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'User', 
                                        'url' => array('/user/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterUserCreate') || Yii::app()->user->checkAccess('masterUserEdit') || Yii::app()->user->checkAccess('masterUserView') || Yii::app()->user->checkAccess('masterUserApproval')
                                    ),
                                    array(
                                        'label' => 'Company', 
                                        'url' => array('/master/company/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterCompanyCreate') || Yii::app()->user->checkAccess('masterCompanyEdit') || Yii::app()->user->checkAccess('masterCompanyView') || Yii::app()->user->checkAccess('masterCompanyApproval')
                                    ),
                                    array(
                                        'label' => 'Branch', 
                                        'url' => array('/master/branch/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterBranchCreate') || Yii::app()->user->checkAccess('masterBranchEdit') || Yii::app()->user->checkAccess('masterBranchView') || Yii::app()->user->checkAccess('masterBranchApproval')
                                    ),
                                    array(
                                        'label' => 'Supplier', 
                                        'url' => array('/master/supplier/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterSupplierCreate') || Yii::app()->user->checkAccess('masterSupplierEdit') || Yii::app()->user->checkAccess('masterSupplierView') || Yii::app()->user->checkAccess('masterSupplierApproval')
                                    ),
                                    array(
                                        'label' => 'Deduction', 
                                        'url' => array('/master/deduction/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterDeductionCreate') || Yii::app()->user->checkAccess('masterDeductionEdit') || Yii::app()->user->checkAccess('masterDeductionView') || Yii::app()->user->checkAccess('masterDeductionApproval')
                                    ),
                                    array(
                                        'label' => 'Incentive', 
                                        'url' => array('/master/incentive/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterIncentiveCreate') || Yii::app()->user->checkAccess('masterIncentiveEdit') || Yii::app()->user->checkAccess('masterIncentiveView') || Yii::app()->user->checkAccess('masterIncentiveApproval')
                                    ),
                                    array(
                                        'label' => 'Position', 
                                        'url' => array('/master/position/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterPositionCreate') || Yii::app()->user->checkAccess('masterPositionEdit') || Yii::app()->user->checkAccess('masterPositionView') || Yii::app()->user->checkAccess('masterPositionApproval')
                                    ),
                                    array(
                                        'label' => 'Division', 
                                        'url' => array('/master/division/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterDivisionCreate') || Yii::app()->user->checkAccess('masterDivisionEdit') || Yii::app()->user->checkAccess('masterDivisionView') || Yii::app()->user->checkAccess('masterDivisionApproval')
                                    ),
                                    array(
                                        'label' => 'Level',
                                        'url' => array('/master/level/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterLevelCreate') || Yii::app()->user->checkAccess('masterLevelEdit') || Yii::app()->user->checkAccess('masterLevelView') || Yii::app()->user->checkAccess('masterLevelApproval')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>

                    <div class="small-3 columns">
                        <img src="<?php echo Yii::app()->baseUrl . '/images/vehicle.png' ?>" /> <br/><br/>
                        <?php if (
                            Yii::app()->user->checkAccess('masterVehicleCreate') || 
                            Yii::app()->user->checkAccess('masterVehicleEdit') || 
                            Yii::app()->user->checkAccess('masterVehicleView') || 
                            Yii::app()->user->checkAccess('masterVehicleApproval') || 
                            Yii::app()->user->checkAccess('masterCustomerCreate') || 
                            Yii::app()->user->checkAccess('masterCustomerEdit') || 
                            Yii::app()->user->checkAccess('masterCustomerView') || 
                            Yii::app()->user->checkAccess('masterCustomerApproval') || 
                            Yii::app()->user->checkAccess('masterInsuranceCreate') || 
                            Yii::app()->user->checkAccess('masterInsuranceEdit') || 
                            Yii::app()->user->checkAccess('masterInsuranceView') || 
                            Yii::app()->user->checkAccess('masterInsuranceApproval') ||
                            Yii::app()->user->checkAccess('masterCarMakeCreate') || 
                            Yii::app()->user->checkAccess('masterCarMakeEdit') || 
                            Yii::app()->user->checkAccess('masterCarMakeView') || 
                            Yii::app()->user->checkAccess('masterCarMakeApproval') || 
                            Yii::app()->user->checkAccess('masterCarModelCreate') || 
                            Yii::app()->user->checkAccess('masterCarModelEdit') || 
                            Yii::app()->user->checkAccess('masterCarModelView') || 
                            Yii::app()->user->checkAccess('masterCarModelApproval') || 
                            Yii::app()->user->checkAccess('masterCarSubModelCreate') || 
                            Yii::app()->user->checkAccess('masterCarSubModelEdit') || 
                            Yii::app()->user->checkAccess('masterCarSubModelView') || 
                            Yii::app()->user->checkAccess('masterCarSubModelApproval') || 
                            Yii::app()->user->checkAccess('masterCarSubModelDetailCreate') || 
                            Yii::app()->user->checkAccess('masterCarSubModelDetailEdit') || 
                            Yii::app()->user->checkAccess('masterCarSubModelDetailView') || 
                            Yii::app()->user->checkAccess('masterCarSubModelDetailApproval') || 
                            Yii::app()->user->checkAccess('masterColorCreate') || 
                            Yii::app()->user->checkAccess('masterColorEdit') || 
                            Yii::app()->user->checkAccess('masterColorView') || 
                            Yii::app()->user->checkAccess('masterColorApproval')
                        ): ?>
                            <h2>Vehicle</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Customer Vehicle', 
                                        'url' => array('/master/vehicle/admin'), 
//                                        'linkOptions' => array('class' => 'titleNav'), 
                                        'visible' => Yii::app()->user->checkAccess('masterVehicleCreate') || Yii::app()->user->checkAccess('masterVehicleEdit') || Yii::app()->user->checkAccess('masterVehicleView') || Yii::app()->user->checkAccess('masterVehicleApproval')
                                    ),
                                    array(
                                        'label' => 'Customer', 
                                        'url' => array('/master/customer/admin'), 
//                                        'linkOptions' => array('class' => 'titleNav'), 
                                        'visible' => Yii::app()->user->checkAccess('masterCustomerCreate') || Yii::app()->user->checkAccess('masterCustomerEdit') || Yii::app()->user->checkAccess('masterCustomerView') || Yii::app()->user->checkAccess('masterCustomerApproval')
                                    ),
                                    array(
                                        'label' => 'Insurance Company', 
                                        'url' => array('/master/insuranceCompany/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterInsuranceCreate') || Yii::app()->user->checkAccess('masterInsuranceEdit') || Yii::app()->user->checkAccess('masterInsuranceView') || Yii::app()->user->checkAccess('masterInsuranceApproval')
                                    ),
                                    array(
                                        'label' => 'Vehicle Car Make', 
                                        'url' => array('/master/vehicleCarMake/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterCarMakeCreate') || Yii::app()->user->checkAccess('masterCarMakeEdit') || Yii::app()->user->checkAccess('masterCarMakeView') || Yii::app()->user->checkAccess('masterCarMakeApproval')
                                    ),
                                    array(
                                        'label' => 'Vehicle Car Model', 
                                        'url' => array('/master/vehicleCarModel/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterCarModelCreate') || Yii::app()->user->checkAccess('masterCarModelEdit') || Yii::app()->user->checkAccess('masterCarModelView') || Yii::app()->user->checkAccess('masterCarModelApproval')
                                    ),
                                    array(
                                        'label' => 'Vehicle Car Sub Model', 
                                        'url' => array('/master/vehicleCarSubModel/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterCarSubModelCreate') || Yii::app()->user->checkAccess('masterCarSubModelEdit') || Yii::app()->user->checkAccess('masterCarSubModelView') || Yii::app()->user->checkAccess('masterCarSubModelApproval')
                                    ),
                                    array(
                                        'label' => 'Vehicle Car Sub Model Detail', 
                                        'url' => array('/master/vehicleCarSubModelDetail/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterCarSubModelDetailCreate') || Yii::app()->user->checkAccess('masterCarSubModelDetailEdit') || Yii::app()->user->checkAccess('masterCarSubModelDetailView') || Yii::app()->user->checkAccess('masterCarSubModelDetailApproval')
                                    ),
                                    array(
                                        'label' => 'Color', 
                                        'url' => array('/master/colors/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterColorCreate') || Yii::app()->user->checkAccess('masterColorEdit') || Yii::app()->user->checkAccess('masterColorView') || Yii::app()->user->checkAccess('masterColorApproval')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>
                    
                    <div class="small-3 columns">
                        <img src="<?php echo Yii::app()->baseUrl . '/images/in-stock.png'; ?>"  width="100" /> <br/><br/>
                        <?php if (
                            Yii::app()->user->checkAccess('masterProductCreate') || 
                            Yii::app()->user->checkAccess('masterProductEdit') || 
                            Yii::app()->user->checkAccess('masterProductView') || 
                            Yii::app()->user->checkAccess('masterProductApproval') || 
                            Yii::app()->user->checkAccess('masterProductCategoryCreate') || 
                            Yii::app()->user->checkAccess('masterProductCategoryEdit') || 
                            Yii::app()->user->checkAccess('masterProductCategoryView') || 
                            Yii::app()->user->checkAccess('masterProductCategoryApproval') || 
                            Yii::app()->user->checkAccess('masterProductSubMasterCategoryCreate') || 
                            Yii::app()->user->checkAccess('masterProductSubMasterCategoryEdit') || 
                            Yii::app()->user->checkAccess('masterProductSubMasterCategoryView') || 
                            Yii::app()->user->checkAccess('masterProductSubMasterCategoryApproval') || 
                            Yii::app()->user->checkAccess('masterProductSubCategoryCreate') || 
                            Yii::app()->user->checkAccess('masterProductSubCategoryEdit') || 
                            Yii::app()->user->checkAccess('masterProductSubCategoryView') || 
                            Yii::app()->user->checkAccess('masterProductSubCategoryApproval') || 
                            Yii::app()->user->checkAccess('masterBrandCreate') || 
                            Yii::app()->user->checkAccess('masterBrandEdit') || 
                            Yii::app()->user->checkAccess('masterBrandView') || 
                            Yii::app()->user->checkAccess('masterBrandApproval') || 
                            Yii::app()->user->checkAccess('masterSubBrandCreate') || 
                            Yii::app()->user->checkAccess('masterSubBrandEdit') || 
                            Yii::app()->user->checkAccess('masterSubBrandView') || 
                            Yii::app()->user->checkAccess('masterSubBrandApproval') || 
                            Yii::app()->user->checkAccess('masterSubBrandSeriesCreate') || 
                            Yii::app()->user->checkAccess('masterSubBrandSeriesEdit') || 
                            Yii::app()->user->checkAccess('masterSubBrandSeriesView') || 
                            Yii::app()->user->checkAccess('masterSubBrandSeriesApproval') ||
                            Yii::app()->user->checkAccess('masterUnitCreate') || 
                            Yii::app()->user->checkAccess('masterUnitEdit') || 
                            Yii::app()->user->checkAccess('masterUnitView') || 
                            Yii::app()->user->checkAccess('masterUnitApproval')
                        ): ?>
                            <h2>Product</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Product', 
                                        'url' => array('/master/product/admin'), 
//                                        'linkOptions' => array('class' => 'titleNav'), 
                                        'visible' => Yii::app()->user->checkAccess('masterProductCreate') || Yii::app()->user->checkAccess('masterProductEdit') || Yii::app()->user->checkAccess('masterProductView') || Yii::app()->user->checkAccess('masterProductApproval')
                                    ),
                                    array(
                                        'label' => 'Product Category', 
                                        'url' => array('/master/productMasterCategory/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterProductCategoryCreate') || Yii::app()->user->checkAccess('masterProductCategoryEdit') || Yii::app()->user->checkAccess('masterProductCategoryView') || Yii::app()->user->checkAccess('masterProductCategoryApproval')
                                    ),
                                    array(
                                        'label' => 'Product Sub-Master Category', 
                                        'url' => array('/master/productSubMasterCategory/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterProductSubMasterCategoryCreate') || Yii::app()->user->checkAccess('masterProductSubMasterCategoryEdit') || Yii::app()->user->checkAccess('masterProductSubMasterCategoryView') || Yii::app()->user->checkAccess('masterProductSubMasterCategoryApproval')
                                    ),
                                    array(
                                        'label' => 'Product Sub-Category', 
                                        'url' => array('/master/productSubCategory/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterProductSubCategoryCreate') || Yii::app()->user->checkAccess('masterProductSubCategoryEdit') || Yii::app()->user->checkAccess('masterProductSubCategoryView') || Yii::app()->user->checkAccess('masterProductSubCategoryApproval')
                                    ),
                                    array(
                                        'label' => 'Brand', 
                                        'url' => array('/master/brand/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterBrandCreate') || Yii::app()->user->checkAccess('masterBrandEdit') || Yii::app()->user->checkAccess('masterBrandView') || Yii::app()->user->checkAccess('masterBrandApproval')
                                    ),
                                    array(
                                        'label' => 'Sub-Brand', 
                                        'url' => array('/master/subBrand/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterSubBrandCreate') || Yii::app()->user->checkAccess('masterSubBrandEdit') || Yii::app()->user->checkAccess('masterSubBrandView') || Yii::app()->user->checkAccess('masterSubBrandApproval')
                                    ),
                                    array(
                                        'label' => 'Sub-Brand Series', 
                                        'url' => array('/master/subBrandSeries/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterSubBrandSeriesCreate') || Yii::app()->user->checkAccess('masterSubBrandSeriesEdit') || Yii::app()->user->checkAccess('masterSubBrandSeriesView') || Yii::app()->user->checkAccess('masterSubBrandSeriesApproval')
                                    ),
                                    array(
                                        'label' => 'Satuan', 
                                        'url' => array('/master/unit/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterUnitCreate') || Yii::app()->user->checkAccess('masterUnitEdit') || Yii::app()->user->checkAccess('masterUnitView') || Yii::app()->user->checkAccess('masterUnitApproval')
                                    ),
                                    array(
                                        'label' => 'Konversi Satuan', 
                                        'url' => array('/master/unitConversion/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterUnitCreate') || Yii::app()->user->checkAccess('masterUnitEdit') || Yii::app()->user->checkAccess('masterUnitView') || Yii::app()->user->checkAccess('masterUnitApproval')
                                    ),
                                    array(
                                        'label' => 'Ukuran Ban', 
                                        'url' => array('/master/tireSize/admin'), 
//                                        'visible' => Yii::app()->user->checkAccess('masterUnitCreate') || Yii::app()->user->checkAccess('masterUnitEdit') || Yii::app()->user->checkAccess('masterUnitView') || Yii::app()->user->checkAccess('masterUnitApproval')
                                    ),
                                    array(
                                        'label' => 'Oli Spesifikasi', 
                                        'url' => array('/master/oilSae/admin'), 
//                                        'visible' => Yii::app()->user->checkAccess('masterUnitCreate') || Yii::app()->user->checkAccess('masterUnitEdit') || Yii::app()->user->checkAccess('masterUnitView') || Yii::app()->user->checkAccess('masterUnitApproval')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>

                    <div class="small-3 columns">
                        <img src="<?php echo Yii::app()->baseUrl . '/images/service.png' ?>" /> <br/><br/>
                        <?php if (
                            Yii::app()->user->checkAccess('masterServiceCreate') || 
                            Yii::app()->user->checkAccess('masterServiceEdit') || 
                            Yii::app()->user->checkAccess('masterServiceView') || 
                            Yii::app()->user->checkAccess('masterServiceApproval') || 
                            Yii::app()->user->checkAccess('masterServiceCategoryCreate') || 
                            Yii::app()->user->checkAccess('masterServiceCategoryEdit') || 
                            Yii::app()->user->checkAccess('masterServiceCategoryView') || 
                            Yii::app()->user->checkAccess('masterServiceCategoryApproval') || 
                            Yii::app()->user->checkAccess('masterServiceTypeCreate') || 
                            Yii::app()->user->checkAccess('masterServiceTypeEdit') || 
                            Yii::app()->user->checkAccess('masterServiceTypeView') || 
                            Yii::app()->user->checkAccess('masterServiceTypeApproval') || 
                            Yii::app()->user->checkAccess('masterQuickServiceCreate') || 
                            Yii::app()->user->checkAccess('masterQuickServiceEdit') || 
                            Yii::app()->user->checkAccess('masterQuickServiceView') || 
                            Yii::app()->user->checkAccess('masterQuickServiceApproval') || 
                            Yii::app()->user->checkAccess('masterInspectionCreate') || 
                            Yii::app()->user->checkAccess('masterInspectionEdit') || 
                            Yii::app()->user->checkAccess('masterInspectionView') || 
                            Yii::app()->user->checkAccess('masterInspectionApproval') || 
                            Yii::app()->user->checkAccess('masterInspectionSectionCreate') || 
                            Yii::app()->user->checkAccess('masterInspectionSectionEdit') || 
                            Yii::app()->user->checkAccess('masterInspectionSectionView') || 
                            Yii::app()->user->checkAccess('masterInspectionSectionApproval') || 
                            Yii::app()->user->checkAccess('masterInspectionModuleCreate') || 
                            Yii::app()->user->checkAccess('masterInspectionModuleEdit') || 
                            Yii::app()->user->checkAccess('masterInspectionModuleView') || 
                            Yii::app()->user->checkAccess('masterInspectionModuleApproval')
                        ): ?>
                        <h2>Service</h2>
                        <?php $this->widget('zii.widgets.CMenu', array(
                            'items' => array(
                                array(
                                    'label' => 'Service', 
                                    'url' => array('/master/service/admin'), 
//                                    'linkOptions' => array('class' => 'titleNav'), 
                                    'visible' => Yii::app()->user->checkAccess('masterServiceCreate') || Yii::app()->user->checkAccess('masterServiceEdit') || Yii::app()->user->checkAccess('masterServiceView') || Yii::app()->user->checkAccess('masterServiceApproval')
                                ),
                                array(
                                    'label' => 'Service Category', 
                                    'url' => array('/master/serviceCategory/admin'), 
                                    'visible' => Yii::app()->user->checkAccess('masterServiceCategoryCreate') || Yii::app()->user->checkAccess('masterServiceCategoryEdit') || Yii::app()->user->checkAccess('masterServiceCategoryView') || Yii::app()->user->checkAccess('masterServiceCategoryApproval')
                                ),
                                array(
                                    'label' => 'Service Type', 
                                    'url' => array('/master/serviceType/admin'), 
                                    'visible' => Yii::app()->user->checkAccess('masterServiceTypeCreate') || Yii::app()->user->checkAccess('masterServiceTypeEdit') || Yii::app()->user->checkAccess('masterServiceTypeView') || Yii::app()->user->checkAccess('masterServiceTypeApproval')
                                ),
                                array(
                                    'label' => 'Quick Service', 
                                    'url' => array('/master/quickService/admin'), 
                                    'visible' => Yii::app()->user->checkAccess('masterQuickServiceCreate') || Yii::app()->user->checkAccess('masterQuickServiceEdit') || Yii::app()->user->checkAccess('masterQuickServiceView') || Yii::app()->user->checkAccess('masterQuickServiceApproval')
                                ),
                            ),
                        )); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="small-32 columns" >
            <div id="maincontent">
                <div class="row" style="margin-top:20px" id="noliststyle">

                    <div class="small-3 columns">
                        <img src="<?php echo Yii::app()->baseUrl . '/images/accounting.png' ?>" /> <br/><br/>
                        <?php if (
                            Yii::app()->user->checkAccess('masterBankCreate') || 
                            Yii::app()->user->checkAccess('masterBankEdit') || 
                            Yii::app()->user->checkAccess('masterBankView') || 
                            Yii::app()->user->checkAccess('masterBankApproval') || 
                            Yii::app()->user->checkAccess('masterCoaCreate') || 
                            Yii::app()->user->checkAccess('masterCoaEdit') || 
                            Yii::app()->user->checkAccess('masterCoaView') || 
                            Yii::app()->user->checkAccess('masterCoaApproval') || 
                            Yii::app()->user->checkAccess('masterCoaCategoryCreate') || 
                            Yii::app()->user->checkAccess('masterCoaCategoryEdit') || 
                            Yii::app()->user->checkAccess('masterCoaCategoryView') || 
                            Yii::app()->user->checkAccess('masterCoaCategoryApproval') || 
                            Yii::app()->user->checkAccess('masterCoaSubCategoryCreate') || 
                            Yii::app()->user->checkAccess('masterCoaSubCategoryEdit') || 
                            Yii::app()->user->checkAccess('masterCoaSubCategoryView') || 
                            Yii::app()->user->checkAccess('masterCoaSubCategoryApproval') || 
                            Yii::app()->user->checkAccess('masterPaymentTypeCreate') || 
                            Yii::app()->user->checkAccess('masterPaymentTypeEdit') || 
                            Yii::app()->user->checkAccess('masterPaymentTypeView') || 
                            Yii::app()->user->checkAccess('masterPaymentTypeApproval')
                        ): ?>
                            <h2>Accounting</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Bank', 
                                        'url' => array('/master/bank/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterBankCreate') || Yii::app()->user->checkAccess('masterBankEdit') || Yii::app()->user->checkAccess('masterBankView') || Yii::app()->user->checkAccess('masterBankApproval')
                                    ),
                                    array(
                                        'label' => 'COA', 
                                        'url' => array('/accounting/coa/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterCoaCreate') || Yii::app()->user->checkAccess('masterCoaEdit') || Yii::app()->user->checkAccess('masterCoaView') || Yii::app()->user->checkAccess('masterCoaApproval')
                                    ),
                                    array(
                                        'label' => 'COA Category', 
                                        'url' => array('/master/coaCategory/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterCoaCategoryCreate') || Yii::app()->user->checkAccess('masterCoaCategoryEdit') || Yii::app()->user->checkAccess('masterCoaCategoryView') || Yii::app()->user->checkAccess('masterCoaCategoryApproval')
                                    ),
                                    array(
                                        'label' => 'COA Sub Category', 
                                        'url' => array('/master/coaSubCategory/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterCoaSubCategoryCreate') || Yii::app()->user->checkAccess('masterCoaSubCategoryEdit') || Yii::app()->user->checkAccess('masterCoaSubCategoryView') || Yii::app()->user->checkAccess('masterCoaSubCategoryApproval')
                                    ),
                                    array(
                                        'label' => 'Payment Type', 
                                        'url' => array('/master/paymentType/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterPaymentTypeCreate') || Yii::app()->user->checkAccess('masterPaymentTypeEdit') || Yii::app()->user->checkAccess('masterPaymentTypeView') || Yii::app()->user->checkAccess('masterPaymentTypeApproval')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>

                    <div class="small-3 columns">
                        <img src="<?php echo Yii::app()->baseUrl . '/images/product.png' ?>" /> <br/><br/>
                        <?php if (
                            Yii::app()->user->checkAccess('masterEquipmentCreate') || 
                            Yii::app()->user->checkAccess('masterEquipmentEdit') || 
                            Yii::app()->user->checkAccess('masterEquipmentView') || 
                            Yii::app()->user->checkAccess('masterEquipmentApproval') || 
                            Yii::app()->user->checkAccess('masterEquipmentTypeCreate') || 
                            Yii::app()->user->checkAccess('masterEquipmentTypeEdit') || 
                            Yii::app()->user->checkAccess('masterEquipmentTypeView') || 
                            Yii::app()->user->checkAccess('masterEquipmentTypeApproval') || 
                            Yii::app()->user->checkAccess('masterEquipmentSubTypeCreate') || 
                            Yii::app()->user->checkAccess('masterEquipmentSubTypeEdit') || 
                            Yii::app()->user->checkAccess('masterEquipmentSubTypeView') || 
                            Yii::app()->user->checkAccess('masterEquipmentSubTypeApproval')
                        ): ?>
                            <h2>Equipments</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Equipments', 
                                        'url' => array('/master/equipments/admin'), 
//                                        'linkOptions' => array('class' => 'titleNav'), 
                                        'visible' => Yii::app()->user->checkAccess('masterEquipmentCreate') || Yii::app()->user->checkAccess('masterEquipmentEdit') || Yii::app()->user->checkAccess('masterEquipmentApproval')
                                    ),
                                    array(
                                        'label' => 'Equipment Types', 
                                        'url' => array('/master/equipmentType/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterEquipmentTypeCreate') || Yii::app()->user->checkAccess('masterEquipmentTypeEdit') || Yii::app()->user->checkAccess('masterEquipmentTypeApproval')
                                    ),
                                    array(
                                        'label' => 'Equipment Sub-types', 
                                        'url' => array('/master/equipmentSubType/admin'), 
                                        'visible' => Yii::app()->user->checkAccess('masterEquipmentSubTypeCreate') || Yii::app()->user->checkAccess('masterEquipmentSubTypeEdit') || Yii::app()->user->checkAccess('masterEquipmentSubTypeApproval')
                                    ),
                                    array(
                                        'label' => 'Permintaan Maintenance', 
                                        'url' => array('/frontDesk/maintenanceRequest/admin'), 
                //                        'visible' => (Yii::app()->user->checkAccess('maintenanceRequestCreate') || Yii::app()->user->checkAccess('maintenanceRequestEdit'))
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>

                    <div class="small-3 columns">
                        <img src="<?php echo Yii::app()->baseUrl . '/images/price-list.png'; ?>" width="100"/> <br/><br/>
                        <?php if (
                            Yii::app()->user->checkAccess('masterPricelistStandardCreate') || 
                            Yii::app()->user->checkAccess('masterPricelistStandardEdit') || 
                            Yii::app()->user->checkAccess('masterPricelistStandardView') || 
                            Yii::app()->user->checkAccess('masterPricelistStandardApproval') || 
                            Yii::app()->user->checkAccess('masterPricelistGroupCreate') || 
                            Yii::app()->user->checkAccess('masterPricelistGroupEdit') || 
                            Yii::app()->user->checkAccess('masterPricelistGroupView') || 
                            Yii::app()->user->checkAccess('masterPricelistGroupApproval') || 
                            Yii::app()->user->checkAccess('masterPricelistSetCreate') || 
                            Yii::app()->user->checkAccess('masterPricelistSetEdit') || 
                            Yii::app()->user->checkAccess('masterPricelistSetView') || 
                            Yii::app()->user->checkAccess('masterPricelistSetApproval') || 
                            Yii::app()->user->checkAccess('masterStandardFlatrateCreate') || 
                            Yii::app()->user->checkAccess('masterStandardFlatrateEdit') || 
                            Yii::app()->user->checkAccess('masterStandardFlatrateView') || 
                            Yii::app()->user->checkAccess('masterStandardFlatrateApproval') || 
                            Yii::app()->user->checkAccess('masterStandardValueCreate') || 
                            Yii::app()->user->checkAccess('masterStandardValueEdit') || 
                            Yii::app()->user->checkAccess('masterStandardValueView') || 
                            Yii::app()->user->checkAccess('masterStandardValueApproval')
                        ): ?>
                        <h2>Price List</h2>
                        <?php $this->widget('zii.widgets.CMenu', array(
                            'items' => array(
                                array(
                                    'label' => 'Pricelist Standard', 
                                    'url' => array('/master/serviceStandardPricelist/admin'), 
                                    'visible' => Yii::app()->user->checkAccess('masterPricelistStandardCreate') || Yii::app()->user->checkAccess('masterPricelistStandardEdit') || Yii::app()->user->checkAccess('masterPricelistStandardView') || Yii::app()->user->checkAccess('masterPricelistStandardApproval')
                                ),
                                array(
                                    'label' => 'Pricelist Group', 
                                    'url' => array('/master/serviceGroup/admin'), 
                                    'visible' => Yii::app()->user->checkAccess('masterPricelistGroupCreate') || Yii::app()->user->checkAccess('masterPricelistGroupEdit') || Yii::app()->user->checkAccess('masterPricelistGroupView') || Yii::app()->user->checkAccess('masterPricelistGroupApproval')
                                ),
                                array(
                                    'label' => 'Pricelist Set', 
                                    'url' => array('/master/servicePricelist/admin'), 
                                    'visible' => Yii::app()->user->checkAccess('masterPricelistSetCreate') || Yii::app()->user->checkAccess('masterPricelistSetEdit') || Yii::app()->user->checkAccess('masterPricelistSetView') || Yii::app()->user->checkAccess('masterPricelistSetApproval')
                                ),
                                array(
                                    'label' => 'Standard Flat Rate', 
                                    'url' => array('/master/generalStandardFr/admin'), 
                                    'visible' => Yii::app()->user->checkAccess('masterStandardFlatrateCreate') || Yii::app()->user->checkAccess('masterStandardFlatrateEdit') || Yii::app()->user->checkAccess('masterStandardFlatrateView') || Yii::app()->user->checkAccess('masterStandardFlatrateApproval')
                                ),
                                array(
                                    'label' => 'Standard Value', 
                                    'url' => array('/master/generalStandardValue/admin'), 
                                    'visible' => Yii::app()->user->checkAccess('masterStandardValueCreate') || Yii::app()->user->checkAccess('masterStandardValueEdit') || Yii::app()->user->checkAccess('masterStandardValueView') || Yii::app()->user->checkAccess('masterStandardValueApproval')
                                ),
                            ),
                        )); ?>
                        <?php endif; ?>
                    </div>

                    <div class="small-3 columns">
                        <img src="<?php echo Yii::app()->baseUrl . '/images/warehouse.png' ?>" /> <br/><br/>
                        <?php if (
                            Yii::app()->user->checkAccess('masterWarehouseCreate') || 
                            Yii::app()->user->checkAccess('masterWarehouseEdit') || 
                            Yii::app()->user->checkAccess('masterWarehouseView') || 
                            Yii::app()->user->checkAccess('masterWarehouseApproval')
                        ): ?>
                            <h2>Warehouse</h2>
                            <?php $this->widget('zii.widgets.CMenu', array(
                                'items' => array(
                                    array(
                                        'label' => 'Warehouse', 
                                        'url' => array('/master/warehouse/admin'), 
//                                        'linkOptions' => array('class' => 'titleNav'), 
                                        'visible' => Yii::app()->user->checkAccess('masterWarehouseCreate') || Yii::app()->user->checkAccess('masterWarehouseEdit') || Yii::app()->user->checkAccess('masterWarehouseView') || Yii::app()->user->checkAccess('masterWarehouseApproval')
                                    ),
                                    array(
                                        'label' => 'Kategori Aset', 
                                        'url' => array('/master/assetCategory/admin'), 
//                                        'linkOptions' => array('class' => 'titleNav'), 
//                                        'visible' => Yii::app()->user->checkAccess('masterWarehouseCreate') || Yii::app()->user->checkAccess('masterWarehouseEdit') || Yii::app()->user->checkAccess('masterWarehouseView') || Yii::app()->user->checkAccess('masterWarehouseApproval')
                                    ),
                                ),
                            )); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
        <div class="small-32 columns" >
            <div id="maincontent">
                <div class="row" style="margin-top:20px" id="noliststyle">
                    <div class="small-3 columns">
                        <img src="<?php echo Yii::app()->baseUrl . '/images/service.png' ?>" /> <br/><br/>
                        <?php if ( 
                            Yii::app()->user->checkAccess('masterInspectionCreate') || 
                            Yii::app()->user->checkAccess('masterInspectionEdit') || 
                            Yii::app()->user->checkAccess('masterInspectionView') || 
                            Yii::app()->user->checkAccess('masterInspectionApproval') || 
                            Yii::app()->user->checkAccess('masterInspectionSectionCreate') || 
                            Yii::app()->user->checkAccess('masterInspectionSectionEdit') || 
                            Yii::app()->user->checkAccess('masterInspectionSectionView') || 
                            Yii::app()->user->checkAccess('masterInspectionSectionApproval') || 
                            Yii::app()->user->checkAccess('masterInspectionModuleCreate') || 
                            Yii::app()->user->checkAccess('masterInspectionModuleEdit') || 
                            Yii::app()->user->checkAccess('masterInspectionModuleView') || 
                            Yii::app()->user->checkAccess('masterInspectionModuleApproval')
                        ): ?>
                        <h2>System Check & Reports</h2>
                        <?php $this->widget('zii.widgets.CMenu', array(
                            'items' => array(
                                array(
                                    'label' => 'Inspection Reports Form', 
                                    'url' => array('/master/inspection/admin'), 
//                                    'linkOptions' => array('class' => 'titleNav'), 
                                    'visible' => Yii::app()->user->checkAccess('masterInspectionCreate') || Yii::app()->user->checkAccess('masterInspectionEdit') || Yii::app()->user->checkAccess('masterInspectionView') || Yii::app()->user->checkAccess('masterInspectionApproval')
                                ),
                                array(
                                    'label' => 'System(s) to Check', 
                                    'url' => array('/master/inspectionSection/admin'), 
                                    'visible' => Yii::app()->user->checkAccess('masterInspectionSectionCreate') || Yii::app()->user->checkAccess('masterInspectionSectionEdit') || Yii::app()->user->checkAccess('masterInspectionSectionView') || Yii::app()->user->checkAccess('masterInspectionSectionApproval')
                                ),
                                array(
                                    'label' => 'Function & Components in System', 
                                    'url' => array('/master/inspectionModule/admin'), 
                                    'visible' => Yii::app()->user->checkAccess('masterInspectionModuleCreate') || Yii::app()->user->checkAccess('masterInspectionModuleEdit') || Yii::app()->user->checkAccess('masterInspectionModuleView') || Yii::app()->user->checkAccess('masterInspectionModuleApproval')
                                ),
                            ),
                        )); ?>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>