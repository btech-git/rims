<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="language" content="en" />
        <link rel="icon" type="image/png" href="/app/images/favicon.png" />

        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/foundation.min.css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/font-awesome.min.css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/fontface.css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/foundation-datepicker.css" />
        <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/css/rims.css?v=0.2" />
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/modernizr.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/jquery.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/foundation.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/foundation-datepicker.js"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/bootstrap-hover-dropdown.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/isotope.pkgd.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/vendor/imagesloaded.pkgd.min.js"></script>
        <script src="<?php echo Yii::app()->request->baseUrl; ?>/js/main.js"></script>
        <style type="text/css">
            #utilities { background:#ccc; padding:5px 0; }
            #utilities .row div {font-size:12px; text-align: right; padding:0 20px;}
            #utilities .row div a { color:#213782;  }
            #utilities .row div a:hover {text-decoration: underline;}
            /*Added 19-09-2015*/
            #utilities .row ul{text-decoration: none; margin:0;}
            #utilities .row ul li{display:inline; }
            #mainmenu ul ul {min-width: 110px}

            #rcorners4 {

                border-radius: 100%;
                background: #FF0000;
                padding: 2px; 
                width: 12px;
                height: 13px;    
                font-size:9px;
                font-weight: bold;
                color:white;
                text-align:center;
                position: absolute; /* Position the badge within the relatively positioned button */
                top: 0;

            }
            .leftside{
                text-align :left !important;

            }
            .dropdown{
                /*display:none;*/
                z-index: 99;
                border-bottom:none;
                list-style-type: none;

            }
            .dropdown ul li{
                display: block !important;
                text-align: left !important;
                color:#000;
            }
        </style>
        
        <script>
            $(document).ready(function () {
                $('[data-hover="dropdown"]').bootstrapDropdownHover();
            });
        </script>
        
        <?php $id = 2; ?>

        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <?php $is_login = ($ccontroller == "login") ? true : false; ?>
        <title><?php echo CHtml::encode($this->pageTitle); ?></title>
    </head>
    
    <body class="<?php //echo ($is_login) ? "login" : ""; ?>">
        
        <?php
        $count = 0;
        if (!Yii::app()->user->isGuest) {
            $branchId = User::model()->findByPk(Yii::app()->user->getId())->branch_id;
            $date = date_create(date('d-m-Y'));
            date_sub($date, date_interval_create_from_date_string("7 days"));

//            if ($branchId) {
                $requestCriteria = new CDbCriteria;
                $requestCriteria->addInCondition('main_branch_id', Yii::app()->user->branch_ids);
                $requestCriteria->addCondition(" DATE(request_order_date) >= (NOW() - INTERVAL 7 DAY)");
                $requestOrder = TransactionRequestOrder::model()->findAll($requestCriteria);
                
                $purchaseCriteria = new CDbCriteria;
                $purchaseCriteria->addInCondition('main_branch_id', Yii::app()->user->branch_ids);
                $purchaseCriteria->addCondition(" DATE(purchase_order_date) >= (NOW() - INTERVAL 7 DAY)");
                $purchase = TransactionPurchaseOrder::model()->findAll($purchaseCriteria);

                $salesCriteria = new CDbCriteria;
                $salesCriteria->addInCondition('requester_branch_id', Yii::app()->user->branch_ids);
                $salesCriteria->addCondition(" DATE(sale_order_date) >= (NOW() - INTERVAL 7 DAY)");
                $sales = TransactionSalesOrder::model()->findAll($salesCriteria);

                $transferCriteria = new CDbCriteria;
                $transferCriteria->addInCondition('destination_branch_id', Yii::app()->user->branch_ids);
                $transferCriteria->addCondition(" DATE(transfer_request_date) >= (NOW() - INTERVAL 7 DAY)");
                $transfer = TransactionTransferRequest::model()->findAll($transferCriteria);

                $sentCriteria = new CDbCriteria;
                $sentCriteria->addInCondition('destination_branch_id', Yii::app()->user->branch_ids);
                $sentCriteria->addCondition(" DATE(sent_request_date) >= (NOW() - INTERVAL 7 DAY)");
                $sent = TransactionSentRequest::model()->findAll($sentCriteria);

                $consignmentCriteria = new CDbCriteria;
                $consignmentCriteria->addInCondition('branch_id', Yii::app()->user->branch_ids);
                $consignmentCriteria->addCondition(" DATE(date_posting) >= (NOW() - INTERVAL 7 DAY)");
                $consignment = ConsignmentOutHeader::model()->findAll($consignmentCriteria);

                $consignmentInCriteria = new CDbCriteria;
                $consignmentInCriteria->addInCondition('receive_branch', Yii::app()->user->branch_ids);
                $consignmentInCriteria->addCondition(" DATE(date_posting) >= (NOW() - INTERVAL 7 DAY)");
                $consignmentIn = ConsignmentInHeader::model()->findAll($consignmentInCriteria);

                $movementCriteria = new CDbCriteria;
                $movementCriteria->addInCondition('branch_id', Yii::app()->user->branch_ids);
                $movementCriteria->addCondition(" DATE(date_posting) >= (NOW() - INTERVAL 7 DAY)");
                $movement = MovementOutHeader::model()->findAll($movementCriteria);

                $movementInCriteria = new CDbCriteria;
                $movementInCriteria->addInCondition('branch_id', Yii::app()->user->branch_ids);
                $movementInCriteria->addCondition(" DATE(date_posting) >= (NOW() - INTERVAL 7 DAY)");
                $movementIn = MovementInHeader::model()->findAll($movementInCriteria);

                $count = count($requestOrder) + count($purchase) + count($sales) + count($transfer) + count($sent) + count($consignment) + count($consignmentIn) + count($movement) + count($movementIn);
//            }
        }
        ?>

        <div id="utilities">
            <div class="row">
                <div class="small-12 columns ">
                    <div class="small-1 columns leftside ">
                        <?php if (!Yii::app()->user->isGuest): ?>

                            <li class="dropdown" >
                                <a href="<?php echo Yii::app()->baseUrl . '/transaction/pendingTransaction'; ?>" class="dropdown-toggle" data-toggle="dropdown"  data-delay="1000" data-close-others="false">
                                    <i class="fa fa-bell" style="font-size:16px;" ><i id="rcorners4"><?php echo $count; ?></i></i>
                                </a>
                                
                                <ul class="dropdown-menu">
                                    <li><?php echo CHtml::link('Request (' . count($requestOrder) . ')', array('/transaction/transactionRequestOrder/admin'), array('target' => '_blank')); ?></li>
                                    <li><?php echo CHtml::link('Purchase (' . count($purchase) . ')', array('/transaction/transactionPurchaseOrder/admin'), array('target' => '_blank')); ?></li>
                                    <li><?php echo CHtml::link('Sales (' . count($sales) . ')', array('/transaction/transactionSalesOrder/admin'), array('target' => '_blank')); ?></li>
                                    <li><?php echo CHtml::link('Transfer (' . count($transfer) . ')', array('/transaction/transferRequest/admin'), array('target' => '_blank')); ?></li>
                                    <li><?php echo CHtml::link('Sent (' . count($sent) . ')', array('/transaction/transactionSentRequest/admin'), array('target' => '_blank')); ?></li>
                                    <li><?php echo CHtml::link('Consignment In (' . count($consignmentIn) . ')', array('/transaction/consignmentInHeader/admin'), array('target' => '_blank')); ?></li>
                                    <li><?php echo CHtml::link('Consignment Out (' . count($consignment) . ')', array('/transaction/consignmentOutHeader/admin'), array('target' => '_blank')); ?></li>
                                    <li><?php echo CHtml::link('Movement In (' . count($movementIn) . ')', array('/transaction/movementInHeader/admin'), array('target' => '_blank')); ?></li>
                                    <li><?php echo CHtml::link('Movement Out (' . count($movement) . ')', array('/transaction/movementOutHeader/admin'), array('target' => '_blank')); ?></li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </div>
                    
                    <div class="small-11 columns">
                        <?php $this->widget('zii.widgets.CMenu', array(
                            'items' => array(
                                array('label' => 'Home', 'url' => array('/site/index')),
                                array('label' => 'Setting', 'url' => array('/site/setting'), 'template' => '/ {menu}', 'visible' =>
                                    Yii::app()->user->checkAccess('masterCompany') ||
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
                                    Yii::app()->user->checkAccess('masterHolidayApproval') ||
                                    Yii::app()->user->checkAccess('masterAccounting') ||
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
                                    Yii::app()->user->checkAccess('masterPaymentTypeApproval') ||
                                    Yii::app()->user->checkAccess('masterProductInventory') ||
                                    Yii::app()->user->checkAccess('masterProductCreate') ||
                                    Yii::app()->user->checkAccess('masterProductEdit') ||
                                    Yii::app()->user->checkAccess('masterProductApproval') ||
                                    Yii::app()->user->checkAccess('masterProductCategoryCreate') ||
                                    Yii::app()->user->checkAccess('masterProductCategoryEdit') ||
                                    Yii::app()->user->checkAccess('masterProductCategoryApproval') ||
                                    Yii::app()->user->checkAccess('masterProductSubMasterCategoryCreate') ||
                                    Yii::app()->user->checkAccess('masterProductSubMasterCategoryEdit') ||
                                    Yii::app()->user->checkAccess('masterProductSubMasterCategoryApproval') ||
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
                                    Yii::app()->user->checkAccess('masterEquipmentSubTypeApproval') ||
                                    Yii::app()->user->checkAccess('masterWarehouseCreate') ||
                                    Yii::app()->user->checkAccess('masterWarehouseEdit') ||
                                    Yii::app()->user->checkAccess('masterWarehouseApproval') ||
                                    Yii::app()->user->checkAccess('masterServiceList') ||
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
                                    Yii::app()->user->checkAccess('masterInspectionModuleApproval') ||
                                    Yii::app()->user->checkAccess('masterVehicleInventory') ||
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
                                ),
                                array('label' => 'Profile (' . Yii::app()->user->name . ')', 'url' => Yii::app()->createUrl("user/admin/profile", array("id" => Yii::app()->user->id)), 'template' => '/ {menu}', 'visible' => !Yii::app()->user->isGuest),
                                array('url' => Yii::app()->getModule('user')->loginUrl, 'label' => Yii::app()->getModule('user')->t("Login"), 'template' => '/ {menu}', 'visible' => Yii::app()->user->isGuest),
                                array('url' => Yii::app()->getModule('user')->logoutUrl, 'label' => Yii::app()->getModule('user')->t("Logout"), 'template' => '/ {menu}', 'visible' => !Yii::app()->user->isGuest),
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div id="header">
            <div class="row">
                <div class="small-12 medium-3 columns">
                    <div class="logo">
                        <a href="index.php"><img src="/app/images/rims-logo.png"></a>
                        <a href="<?php echo Yii::app()->baseUrl . '/site/index'; ?>" style="color:white; font-size:14px"><strong style="font-size:20px">RAPERIND</strong> MOTOR</a>
                    </div>
                </div>
                <?php if (!$is_login) : ?>
                    <div class="small-12 medium-9 columns">
                        <nav class="clearfix" id="mainmenu">
                            <?php include 'menu.php'; ?>
                        </nav>
                    </div>
                <?php endif; ?>
            </div>
        </div>
        
        <br />	
        
        <?php if (isset($this->breadcrumbs)): ?>
            <div id="site_breadcrumb">
                <div class="row">
                    <div class="small-12 columns">
                        <?php
                        $this->widget('zii.widgets.CBreadcrumbs', array(
                            'links' => $this->breadcrumbs,
                            'separator' => '',
                        ));
                        ?><!-- breadcrumbs -->
                    </div>
                </div>
            </div>
        <?php endif; ?>

        <?php echo $content; ?>

        <!-- end content -->
        <?php include 'footer.php'; ?>

    </body>
</html>
