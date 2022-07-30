<style type="text/css">

    nav#settings ul {
        list-style: none;
        margin: 0;
        padding: 0px;
        width: 90%;
        height: auto;
        border-bottom:1px solid #aaa;
    }

    nav#settings ul li {
        border: 1px solid #aaa;
        border-bottom:0;
        background-color: #ddd;
        color: #666;
        height: auto;
        padding: 8px 10px ;
        font-size: 1em;
    }

    nav#settings ul li:hover { color:white; background-color: #8497B0; }

    nav#settings ul li ul {
        z-index: 1000;
        list-style: none;
        margin: 0;
        margin-left:150px;
        margin-top: -32px;
        padding: 0px;
        height: auto;
        display: none;
        border-bottom: 1px solid #ccc;
    }
    nav#settings ul li ul li {
        background-color: white;
        color: black;
        height: auto;
        padding:3px 8px;
        border:1px solid #ccc;
        border-bottom:0;
    }

    nav#settings a:link { text-decoration: none; }
    nav#settings ul li:hover ul { display: block; }
    nav#settings ul ul { position: absolute; display: none;}
    nav#settings ul ul li { background: #f1f1f1;  border-top: 0; }
    nav#settings ul ul li a { color: #333;  font-size: 12px;  text-transform: none;}
    nav#settings ul ul li:hover {background: white !important}
    nav#settings ul ul li a:hover { color:#125BA5; background: white }
    .title{font-weight: bold !important;}

</style>

<nav id="settings">
    <ul>
        <?php if (
            Yii::app()->user->checkAccess('masterUserCreate') || 
            Yii::app()->user->checkAccess('masterUserEdit') || 
            Yii::app()->user->checkAccess('masterUserApproval') || 
            Yii::app()->user->checkAccess('masterCompanyCreate') || 
            Yii::app()->user->checkAccess('masterCompanyEdit') || 
            Yii::app()->user->checkAccess('masterCompanyApproval') || 
            Yii::app()->user->checkAccess('masterInsuranceCreate') || 
            Yii::app()->user->checkAccess('masterInsuranceEdit') || 
            Yii::app()->user->checkAccess('masterInsuranceApproval') || 
            Yii::app()->user->checkAccess('masterBranchCreate') || 
            Yii::app()->user->checkAccess('masterBranchEdit') || 
            Yii::app()->user->checkAccess('masterBranchApproval') || 
            Yii::app()->user->checkAccess('masterSupplierCreate') || 
            Yii::app()->user->checkAccess('masterSupplierEdit') || 
            Yii::app()->user->checkAccess('masterSupplierApproval') || 
            Yii::app()->user->checkAccess('masterEmployeeCreate') || 
            Yii::app()->user->checkAccess('masterEmployeeEdit') || 
            Yii::app()->user->checkAccess('masterEmployeeApproval') || 
            Yii::app()->user->checkAccess('masterDeductionCreate') || 
            Yii::app()->user->checkAccess('masterDeductionEdit') || 
            Yii::app()->user->checkAccess('masterDeductionApproval') || 
            Yii::app()->user->checkAccess('masterIncentiveCreate') || 
            Yii::app()->user->checkAccess('masterIncentiveEdit') || 
            Yii::app()->user->checkAccess('masterIncentiveApproval') || 
            Yii::app()->user->checkAccess('masterPositionCreate') || 
            Yii::app()->user->checkAccess('masterPositionEdit') || 
            Yii::app()->user->checkAccess('masterPositionApproval') || 
            Yii::app()->user->checkAccess('masterDivisionCreate') || 
            Yii::app()->user->checkAccess('masterDivisionEdit') || 
            Yii::app()->user->checkAccess('masterDivisionApproval') || 
            Yii::app()->user->checkAccess('masterLevelCreate') || 
            Yii::app()->user->checkAccess('masterLevelEdit') || 
            Yii::app()->user->checkAccess('masterLevelApproval') || 
            Yii::app()->user->checkAccess('masterUnitCreate') || 
            Yii::app()->user->checkAccess('masterUnitEdit') || 
            Yii::app()->user->checkAccess('masterUnitApproval') || 
            Yii::app()->user->checkAccess('masterConversionCreate') || 
            Yii::app()->user->checkAccess('masterConversionEdit') || 
            Yii::app()->user->checkAccess('masterConversionApproval') || 
            Yii::app()->user->checkAccess('masterHolidayCreate') || 
            Yii::app()->user->checkAccess('masterHolidayEdit') || 
            Yii::app()->user->checkAccess('masterHolidayApproval')
        ): ?>
            <li>
                Company <?php $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array(
                            'label' => 'User', 
                            'url' => array('/user/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterUserCreate') || Yii::app()->user->checkAccess('masterUserEdit') || Yii::app()->user->checkAccess('masterUserApproval')
                        ),
                        array(
                            'label' => 'Company', 
                            'url' => array('/master/company/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterCompanyCreate') || Yii::app()->user->checkAccess('masterCompanyEdit') || Yii::app()->user->checkAccess('masterCompanyApproval')
                        ),
                        array(
                            'label' => 'Insurance Company', 
                            'url' => array('/master/insuranceCompany/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterInsuranceCreate') || Yii::app()->user->checkAccess('masterInsuranceEdit') || Yii::app()->user->checkAccess('masterInsuranceApproval')
                        ),
                        array(
                            'label' => 'Branch', 
                            'url' => array('/master/branch/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterBranchCreate') || Yii::app()->user->checkAccess('masterBranchEdit') || Yii::app()->user->checkAccess('masterBranchApproval')
                        ),
                        array(
                            'label' => 'Supplier', 
                            'url' => array('/master/supplier/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterSupplierCreate') || Yii::app()->user->checkAccess('masterSupplierEdit') || Yii::app()->user->checkAccess('masterSupplierApproval')
                        ),
                        array(
                            'label' => 'Employee', 
                            'url' => array('/master/employee/admin'), 
                            'linkOptions' => array('class' => 'titleNav'), 
                            'visible' => Yii::app()->user->checkAccess('masterEmployeeCreate') || Yii::app()->user->checkAccess('masterEmployeeEdit') || Yii::app()->user->checkAccess('masterEmployeeApproval')
                        ),
                        array(
                            'label' => 'Deduction', 
                            'url' => array('/master/deduction/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterDeductionCreate') || Yii::app()->user->checkAccess('masterDeductionEdit') || Yii::app()->user->checkAccess('masterDeductionApproval')
                        ),
                        array(
                            'label' => 'Incentive', 
                            'url' => array('/master/incentive/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterIncentiveCreate') || Yii::app()->user->checkAccess('masterIncentiveEdit') || Yii::app()->user->checkAccess('masterIncentiveApproval')
                        ),
                        array(
                            'label' => 'Position', 
                            'url' => array('/master/position/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterPositionCreate') || Yii::app()->user->checkAccess('masterPositionEdit') || Yii::app()->user->checkAccess('masterPositionApproval')
                        ),
                        array(
                            'label' => 'Division', 
                            'url' => array('/master/division/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterDivisionCreate') || Yii::app()->user->checkAccess('masterDivisionEdit') || Yii::app()->user->checkAccess('masterDivisionApproval')
                        ),
                        array(
                            'label' => 'Level',
                            'url' => array('/master/level/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterLevelCreate') || Yii::app()->user->checkAccess('masterLevelEdit') || Yii::app()->user->checkAccess('masterLevelApproval')
                        ),
                        array(
                            'label' => 'Unit', 
                            'url' => array('/master/unit/admin'), 
                            'linkOptions' => array('class' => 'titleNav'), 
                            'visible' => Yii::app()->user->checkAccess('masterUnitCreate') || Yii::app()->user->checkAccess('masterUnitEdit') || Yii::app()->user->checkAccess('masterUnitApproval')
                        ),
//                        array(
//                            'label' => 'Unit Conversion', 
//                            'url' => array('/master/unitConversion/admin'), 
//                            'visible' => Yii::app()->user->checkAccess('masterConversionCreate') || Yii::app()->user->checkAccess('masterConversionEdit') || Yii::app()->user->checkAccess('masterConversionApproval')
//                        ),
                        array(
                            'label' => 'Public Holiday', 
                            'url' => array('/master/publicDayOff/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterHolidayCreate') || Yii::app()->user->checkAccess('masterHolidayEdit') || Yii::app()->user->checkAccess('masterHolidayApproval')
                        ),
                    ),
                )); ?>
            </li>
        <?php endif; ?>
            
        <?php if (
            Yii::app()->user->checkAccess('masterBankCreate') || 
            Yii::app()->user->checkAccess('masterBankEdit') || 
            Yii::app()->user->checkAccess('masterBankApproval') || 
            Yii::app()->user->checkAccess('masterCoaCreate') || 
            Yii::app()->user->checkAccess('masterCoaEdit') || 
            Yii::app()->user->checkAccess('masterCoaApproval') || 
            Yii::app()->user->checkAccess('masterCoaCategoryCreate') || 
            Yii::app()->user->checkAccess('masterCoaCategoryEdit') || 
            Yii::app()->user->checkAccess('masterCoaCategoryApproval') || 
            Yii::app()->user->checkAccess('masterCoaSubCategoryCreate') || 
            Yii::app()->user->checkAccess('masterCoaSubCategoryEdit') || 
            Yii::app()->user->checkAccess('masterCoaSubCategoryApproval') || 
            Yii::app()->user->checkAccess('masterPaymentTypeCreate') || 
            Yii::app()->user->checkAccess('masterPaymentTypeEdit') || 
            Yii::app()->user->checkAccess('masterPaymentTypeApproval')
        ): ?>
            <li>
                Accounting <?php $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array(
                            'label' => 'Bank', 
                            'url' => array('/master/bank/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterBankCreate') || Yii::app()->user->checkAccess('masterBankEdit') || Yii::app()->user->checkAccess('masterBankApproval')
                        ),
                        array(
                            'label' => 'COA', 
                            'url' => array('/accounting/coa/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterCoaCreate') || Yii::app()->user->checkAccess('masterCoaEdit') || Yii::app()->user->checkAccess('masterCoaApproval')
                        ),
                        array(
                            'label' => 'COA Category', 
                            'url' => array('/master/coaCategory/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterCoaCategoryCreate') || Yii::app()->user->checkAccess('masterCoaCategoryEdit') || Yii::app()->user->checkAccess('masterCoaCategoryApproval')
                        ),
                        array(
                            'label' => 'COA Sub Category', 
                            'url' => array('/master/coaSubCategory/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterCoaSubCategoryCreate') || Yii::app()->user->checkAccess('masterCoaSubCategoryEdit') || Yii::app()->user->checkAccess('masterCoaSubCategoryApproval')
                        ),
                        array(
                            'label' => 'Payment Type', 
                            'url' => array('/master/paymentType/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterPaymentTypeCreate') || Yii::app()->user->checkAccess('masterPaymentTypeEdit') || Yii::app()->user->checkAccess('masterPaymentTypeApproval')
                        ),
                        array(
                            'label' => 'Asset Category', 
                            'url' => array('/master/assetCategory/admin')
                        ),
                    ),
                )); ?>
            </li>
                    
        <?php endif; ?>
            
        <?php if (
            Yii::app()->user->checkAccess('masterProductCreate') || 
            Yii::app()->user->checkAccess('masterProductEdit') || 
            Yii::app()->user->checkAccess('masterProductApproval') || 
            Yii::app()->user->checkAccess('masterProductCategoryCreate') || 
            Yii::app()->user->checkAccess('masterProductCategoryEdit') || 
            Yii::app()->user->checkAccess('masterProductCategoryApproval') || 
            Yii::app()->user->checkAccess('masterProductSubMasterCategoryCreate') || 
            Yii::app()->user->checkAccess('masterProductSubMasterCategoryEdit') || 
            Yii::app()->user->checkAccess('masterProductSubMasterCategoryApproval') || 
            Yii::app()->user->checkAccess('masterProductSubCategoryCreate') || 
            Yii::app()->user->checkAccess('masterProductSubCategoryEdit') || 
            Yii::app()->user->checkAccess('masterProductSubCategoryApproval') || 
            Yii::app()->user->checkAccess('masterBrandCreate') || 
            Yii::app()->user->checkAccess('masterBrandEdit') || 
            Yii::app()->user->checkAccess('masterBrandApproval') || 
            Yii::app()->user->checkAccess('masterSubBrandCreate') || 
            Yii::app()->user->checkAccess('masterSubBrandEdit') || 
            Yii::app()->user->checkAccess('masterSubBrandApproval') || 
            Yii::app()->user->checkAccess('masterSubBrandSeriesCreate') || 
            Yii::app()->user->checkAccess('masterSubBrandSeriesEdit') || 
            Yii::app()->user->checkAccess('masterSubBrandSeriesApproval') || 
            Yii::app()->user->checkAccess('masterEquipmentCreate') || 
            Yii::app()->user->checkAccess('masterEquipmentEdit') || 
            Yii::app()->user->checkAccess('masterEquipmentApproval') || 
            Yii::app()->user->checkAccess('masterEquipmentTypeCreate') || 
            Yii::app()->user->checkAccess('masterEquipmentTypeEdit') || 
            Yii::app()->user->checkAccess('masterEquipmentTypeApproval') || 
            Yii::app()->user->checkAccess('masterEquipmentSubTypeCreate') || 
            Yii::app()->user->checkAccess('masterEquipmentSubTypeEdit') || 
            Yii::app()->user->checkAccess('masterEquipmentSubTypeApproval')
        ): ?>
            <li>
                Product <?php $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array(
                            'label' => 'Product', 
                            'url' => array('/master/product/admin'), 
                            'linkOptions' => array('class' => 'titleNav'), 
                            'visible' => Yii::app()->user->checkAccess('masterProductCreate') || Yii::app()->user->checkAccess('masterProductEdit') || Yii::app()->user->checkAccess('masterProductApproval')
                        ),
                        array(
                            'label' => 'Product Category', 
                            'url' => array('/master/productMasterCategory/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterProductCategoryCreate') || Yii::app()->user->checkAccess('masterProductCategoryEdit') || Yii::app()->user->checkAccess('masterProductCategoryApproval')
                        ),
                        array(
                            'label' => 'Product Sub-Master Category', 
                            'url' => array('/master/productSubMasterCategory/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterProductSubMasterCategoryCreate') || Yii::app()->user->checkAccess('masterProductSubMasterCategoryEdit') || Yii::app()->user->checkAccess('masterProductSubMasterCategoryApproval')
                        ),
                        array(
                            'label' => 'Product Sub-Category', 
                            'url' => array('/master/productSubCategory/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterProductSubCategoryCreate') || Yii::app()->user->checkAccess('masterProductSubCategoryEdit') || Yii::app()->user->checkAccess('masterProductSubCategoryApproval')
                        ),
                        array(
                            'label' => 'Brand', 
                            'url' => array('/master/brand/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterBrandCreate') || Yii::app()->user->checkAccess('masterBrandEdit') || Yii::app()->user->checkAccess('masterBrandApproval')
                        ),
                        array(
                            'label' => 'Sub-Brand', 
                            'url' => array('/master/subBrand/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterSubBrandCreate') || Yii::app()->user->checkAccess('masterSubBrandEdit') || Yii::app()->user->checkAccess('masterSubBrandApproval')
                        ),
                        array(
                            'label' => 'Sub-Brand Series', 
                            'url' => array('/master/subBrandSeries/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterSubBrandSeriesCreate') || Yii::app()->user->checkAccess('masterSubBrandSeriesEdit') || Yii::app()->user->checkAccess('masterSubBrandSeriesApproval')
                        ),
                        array(
                            'label' => 'Equipments', 
                            'url' => array('/master/equipments/admin'), 
                            'linkOptions' => array('class' => 'titleNav'), 
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
                        ),
                    ),
                )); ?>
            </li>
        <?php endif; ?>
            
        <?php if (
            Yii::app()->user->checkAccess('masterServiceCreate') || 
            Yii::app()->user->checkAccess('masterServiceEdit') || 
            Yii::app()->user->checkAccess('masterServiceApproval') || 
            Yii::app()->user->checkAccess('masterServiceCategoryCreate') || 
            Yii::app()->user->checkAccess('masterServiceCategoryEdit') || 
            Yii::app()->user->checkAccess('masterServiceCategoryApproval') || 
            Yii::app()->user->checkAccess('masterServiceTypeCreate') || 
            Yii::app()->user->checkAccess('masterServiceTypeEdit') || 
            Yii::app()->user->checkAccess('masterServiceTypeApproval') || 
            Yii::app()->user->checkAccess('masterPricelistStandardCreate') || 
            Yii::app()->user->checkAccess('masterPricelistStandardEdit') || 
            Yii::app()->user->checkAccess('masterPricelistStandardApproval') || 
            Yii::app()->user->checkAccess('masterPricelistGroupCreate') || 
            Yii::app()->user->checkAccess('masterPricelistGroupEdit') || 
            Yii::app()->user->checkAccess('masterPricelistGroupApproval') || 
            Yii::app()->user->checkAccess('masterPricelistSetCreate') || 
            Yii::app()->user->checkAccess('masterPricelistSetEdit') || 
            Yii::app()->user->checkAccess('masterPricelistSetApproval') || 
            Yii::app()->user->checkAccess('masterStandardFlatrateCreate') || 
            Yii::app()->user->checkAccess('masterStandardFlatrateEdit') || 
            Yii::app()->user->checkAccess('masterStandardFlatrateApproval') || 
            Yii::app()->user->checkAccess('masterStandardValueCreate') || 
            Yii::app()->user->checkAccess('masterStandardValueEdit') || 
            Yii::app()->user->checkAccess('masterStandardValueApproval') || 
            Yii::app()->user->checkAccess('masterQuickServiceCreate') || 
            Yii::app()->user->checkAccess('masterQuickServiceEdit') || 
            Yii::app()->user->checkAccess('masterQuickServiceApproval') || 
            Yii::app()->user->checkAccess('masterInspectionCreate') || 
            Yii::app()->user->checkAccess('masterInspectionEdit') || 
            Yii::app()->user->checkAccess('masterInspectionApproval') || 
            Yii::app()->user->checkAccess('masterInspectionSectionCreate') || 
            Yii::app()->user->checkAccess('masterInspectionSectionEdit') || 
            Yii::app()->user->checkAccess('masterInspectionSectionApproval') || 
            Yii::app()->user->checkAccess('masterInspectionModuleCreate') || 
            Yii::app()->user->checkAccess('masterInspectionModuleEdit') || 
            Yii::app()->user->checkAccess('masterInspectionModuleApproval')
        ): ?>
            <li>
                Service <?php $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array(
                            'label' => 'Service', 
                            'url' => array('/master/service/admin'), 
                            'linkOptions' => array('class' => 'titleNav'), 
                            'visible' => Yii::app()->user->checkAccess('masterServiceCreate') || Yii::app()->user->checkAccess('masterServiceEdit') || Yii::app()->user->checkAccess('masterServiceApproval')
                        ),
                        array(
                            'label' => 'Service Category', 
                            'url' => array('/master/serviceCategory/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterServiceCategoryCreate') || Yii::app()->user->checkAccess('masterServiceCategoryEdit') || Yii::app()->user->checkAccess('masterServiceCategoryApproval')
                        ),
                        array(
                            'label' => 'Service Type', 
                            'url' => array('/master/serviceType/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterServiceTypeCreate') || Yii::app()->user->checkAccess('masterServiceTypeEdit') || Yii::app()->user->checkAccess('masterServiceTypeApproval')
                        ),
                        array(
                            'label' => 'Pricelist Standard', 
                            'url' => array('/master/serviceStandardPricelist/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterPricelistStandardCreate') || Yii::app()->user->checkAccess('masterPricelistStandardEdit') || Yii::app()->user->checkAccess('masterPricelistStandardApproval')
                        ),
                        array(
                            'label' => 'Pricelist Group', 
                            'url' => array('/master/serviceGroup/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterPricelistGroupCreate') || Yii::app()->user->checkAccess('masterPricelistGroupEdit') || Yii::app()->user->checkAccess('masterPricelistGroupApproval')
                        ),
                        array(
                            'label' => 'Pricelist Set', 
                            'url' => array('/master/servicePricelist/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterPricelistSetCreate') || Yii::app()->user->checkAccess('masterPricelistSetEdit') || Yii::app()->user->checkAccess('masterPricelistSetApproval')
                        ),
                        array(
                            'label' => 'Standard Flat Rate', 
                            'url' => array('/master/generalStandardFr/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterStandardFlatrateCreate') || Yii::app()->user->checkAccess('masterStandardFlatrateEdit') || Yii::app()->user->checkAccess('masterStandardFlatrateApproval')
                        ),
                        array(
                            'label' => 'Standard Value', 
                            'url' => array('/master/generalStandardValue/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterStandardValueCreate') || Yii::app()->user->checkAccess('masterStandardValueEdit') || Yii::app()->user->checkAccess('masterStandardValueApproval')
                        ),
                        array(
                            'label' => 'Quick Service', 
                            'url' => array('/master/quickService/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterQuickServiceCreate') || Yii::app()->user->checkAccess('masterQuickServiceEdit') || Yii::app()->user->checkAccess('masterQuickServiceApproval')
                        ),
                        array(
                            'label' => 'Inspection', 
                            'url' => array('/master/inspection/admin'), 
                            'linkOptions' => array('class' => 'titleNav'), 
                            'visible' => Yii::app()->user->checkAccess('masterInspectionCreate') || Yii::app()->user->checkAccess('masterInspectionEdit') || Yii::app()->user->checkAccess('masterInspectionApproval')
                        ),
                        array(
                            'label' => 'Inspection Section', 
                            'url' => array('/master/inspectionSection/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterInspectionSectionCreate') || Yii::app()->user->checkAccess('masterInspectionSectionEdit') || Yii::app()->user->checkAccess('masterInspectionSectionApproval')
                        ),
                        array(
                            'label' => 'Inspection Module', 
                            'url' => array('/master/inspectionModule/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterInspectionModuleCreate') || Yii::app()->user->checkAccess('masterInspectionModuleEdit') || Yii::app()->user->checkAccess('masterInspectionModuleApproval')
                        ),
                    ),
                )); ?>
            </li>
        <?php endif; ?>
            
        <?php if (
            Yii::app()->user->checkAccess('masterVehicleCreate') || 
            Yii::app()->user->checkAccess('masterVehicleEdit') || 
            Yii::app()->user->checkAccess('masterVehicleApproval') || 
            Yii::app()->user->checkAccess('masterCustomerCreate') || 
            Yii::app()->user->checkAccess('masterCustomerEdit') || 
            Yii::app()->user->checkAccess('masterCustomerApproval') || 
            Yii::app()->user->checkAccess('masterCarMakeCreate') || 
            Yii::app()->user->checkAccess('masterCarMakeEdit') || 
            Yii::app()->user->checkAccess('masterCarMakeApproval') || 
            Yii::app()->user->checkAccess('masterCarModelCreate') || 
            Yii::app()->user->checkAccess('masterCarModelEdit') || 
            Yii::app()->user->checkAccess('masterCarModelApproval') || 
            Yii::app()->user->checkAccess('masterCarSubModelCreate') || 
            Yii::app()->user->checkAccess('masterCarSubModelEdit') || 
            Yii::app()->user->checkAccess('masterCarSubModelApproval') || 
            Yii::app()->user->checkAccess('masterCarSubModelDetailCreate') || 
            Yii::app()->user->checkAccess('masterCarSubModelDetailEdit') || 
            Yii::app()->user->checkAccess('masterCarSubModelDetailApproval') || 
            Yii::app()->user->checkAccess('masterColorCreate') || 
            Yii::app()->user->checkAccess('masterColorEdit') || 
            Yii::app()->user->checkAccess('masterColorApproval')
        ): ?>
            <li>
                Vehicle <?php $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array(
                            'label' => 'Customer Vehicle', 
                            'url' => array('/master/vehicle/admin'), 
                            'linkOptions' => array('class' => 'titleNav'), 
                            'visible' => Yii::app()->user->checkAccess('masterVehicleCreate') || Yii::app()->user->checkAccess('masterVehicleEdit') || Yii::app()->user->checkAccess('masterVehicleApproval')
                        ),
                        array(
                            'label' => 'Customer', 
                            'url' => array('/master/customer/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterCustomerCreate') || Yii::app()->user->checkAccess('masterCustomerEdit') || Yii::app()->user->checkAccess('masterCustomerApproval')
                        ),
                        array(
                            'label' => 'Vehicle Car Make', 
                            'url' => array('/master/vehicleCarMake/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterCarMakeCreate') || Yii::app()->user->checkAccess('masterCarMakeEdit') || Yii::app()->user->checkAccess('masterCarMakeApproval')
                        ),
                        array(
                            'label' => 'Vehicle Car Model', 
                            'url' => array('/master/vehicleCarModel/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterCarModelCreate') || Yii::app()->user->checkAccess('masterCarModelEdit') || Yii::app()->user->checkAccess('masterCarModelApproval')
                        ),
                        array(
                            'label' => 'Vehicle Car Sub Model', 
                            'url' => array('/master/vehicleCarSubModel/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterCarSubModelCreate') || Yii::app()->user->checkAccess('masterCarSubModelEdit') || Yii::app()->user->checkAccess('masterCarSubModelApproval')
                        ),
                        array(
                            'label' => 'Vehicle Car Sub Model Detail', 
                            'url' => array('/master/vehicleCarSubModelDetail/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterCarSubModelDetailCreate') || Yii::app()->user->checkAccess('masterCarSubModelDetailEdit') || Yii::app()->user->checkAccess('masterCarSubModelDetailApproval')
                        ),
                        array(
                            'label' => 'Color', 
                            'url' => array('/master/colors/admin'), 
                            'visible' => Yii::app()->user->checkAccess('masterColorCreate') || Yii::app()->user->checkAccess('masterColorEdit') || Yii::app()->user->checkAccess('masterColorApproval')
                        ),
                    ),
                ));
                ?>
            </li>
        <?php endif; ?>
            
        <?php if (
            Yii::app()->user->checkAccess('masterWarehouseCreate') || 
            Yii::app()->user->checkAccess('masterWarehouseEdit') || 
            Yii::app()->user->checkAccess('masterWarehouseApproval')
        ): ?>
            <li>
                Warehouse <?php $this->widget('zii.widgets.CMenu', array(
                    'items' => array(
                        array(
                            'label' => 'Warehouse', 
                            'url' => array('/master/warehouse/admin'), 
                            'linkOptions' => array('class' => 'titleNav'), 
                            'visible' => Yii::app()->user->checkAccess('masterWarehouseCreate') || Yii::app()->user->checkAccess('masterWarehouseEdit') ||Yii::app()->user->checkAccess('masterWarehouseApproval')
                        ),
                    ),
                )); ?>
            </li>
        <?php endif; ?>
    </ul>
</nav>