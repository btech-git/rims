<?php
/* @var $this TransactionDeliveryOrderController */

$this->breadcrumbs = array(
    'Pending Approval' => array('index'),
);

$this->menu = array(
    array('label' => 'List Pending Approval', 'url' => array('index')),
);

Yii::app()->clientScript->registerScript('report', '
     $("#tanggal_mulai").val("' . $tanggal_mulai . '");
     $("#tanggal_sampai").val("' . $tanggal_sampai . '");
    
');
//Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>



<div id="maincontent">
    <div class="clearfix page-action">
        <h1>Pending Approval</h1>
        <div class="grid-view"></div>
        
        <fieldset>
            <legend>List Data Master</legend>
            
            <br />

            <div>
                <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                    'tabs' => array(
                        'COA' => array(
                            'content' => $this->renderPartial('_viewCoa', array(
                                'coa' => $coa,
                                'coaDataProvider' => $coaDataProvider,
                            ), true)
                        ),
                        'Service' => array(
                            'content' => $this->renderPartial('_viewService', array(
                                'service' => $service,
                                'serviceDataProvider' => $serviceDataProvider,
                            ), true)
                        ),
                        'Service Category' => array(
                            'content' => $this->renderPartial('_viewServiceCategory', array(
                                'serviceCategory' => $serviceCategory,
                                'serviceCategoryDataProvider' => $serviceCategoryDataProvider,
                            ), true)
                        ),
                        'Service Type' => array(
                            'content' => $this->renderPartial('_viewServiceType', array(
                                'serviceType' => $serviceType,
                                'serviceTypeDataProvider' => $serviceTypeDataProvider,
                            ), true)
                        ),
                        'Customer' => array(
                            'content' => $this->renderPartial('_viewCustomer', array(
                                'customer' => $customer,
                                'customerDataProvider' => $customerDataProvider,
                            ), true)
                        ),
                        'Supplier' => array(
                            'content' => $this->renderPartial('_viewSupplier', array(
                                'supplier' => $supplier,
                                'supplierDataProvider' => $supplierDataProvider,
                            ), true)
                        ),
                        'Warehouse' => array(
                            'content' => $this->renderPartial('_viewWarehouse', array(
                                'warehouse' => $warehouse,
                                'warehouseDataProvider' => $warehouseDataProvider,
                            ), true)
                        ),
                        'Car Make' => array(
                            'content' => $this->renderPartial('_viewCarMake', array(
                                'carMake' => $carMake,
                                'carMakeDataProvider' => $carMakeDataProvider,
                            ), true)
                        ),
                        'Car Model' => array(
                            'content' => $this->renderPartial('_viewCarModel', array(
                                'carModel' => $carModel,
                                'carModelDataProvider' => $carModelDataProvider,
                            ), true)
                        ),
                        'Car Sub Model' => array(
                            'content' => $this->renderPartial('_viewCarSubModel', array(
                                'carSubModel' => $carSubModel,
                                'carSubModelDataProvider' => $carSubModelDataProvider,
                            ), true)
                        ),
                    ),
                    // additional javascript options for the tabs plugin
                    'options' => array(
                        'collapsible' => true,
                    ),
                    // set id for this widgets
                    'id' => 'view_master',
                )); ?>
            </div>
            
            <br />

            <div>
                <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                    'tabs' => array(
                        'Product' => array(
                            'content' => $this->renderPartial('_viewProduct', array(
                                'product' => $product,
                                'productDataProvider' => $productDataProvider,
                            ), true)
                        ),
                        'Product Master Category' => array(
                            'content' => $this->renderPartial('_viewProductMasterCategory', array(
                                'productMasterCategory' => $productMasterCategory,
                                'productMasterCategoryDataProvider' => $productMasterCategoryDataProvider,
                            ), true)
                        ),
                        'Product Sub Master Category' => array(
                            'content' => $this->renderPartial('_viewProductSubMasterCategory', array(
                                'productSubMasterCategory' => $productSubMasterCategory,
                                'productSubMasterCategoryDataProvider' => $productSubMasterCategoryDataProvider,
                            ), true)
                        ),
                        'Product Sub Category' => array(
                            'content' => $this->renderPartial('_viewProductSubCategory', array(
                                'productSubCategory' => $productSubCategory,
                                'productSubCategoryDataProvider' => $productSubCategoryDataProvider,
                            ), true)
                        ),
                    ),
                    // additional javascript options for the tabs plugin
                    'options' => array(
                        'collapsible' => true,
                    ),
                    // set id for this widgets
                    'id' => 'view_master_category',
                )); ?>
            </div>
        </fieldset>
    </div>
</div>