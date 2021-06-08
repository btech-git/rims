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
<!--            <div class="myForm" id="myForm">

                <?php /*echo CHtml::beginForm(array(''), 'get'); ?>
                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-2 columns">
                                    <span class="prefix">Tanggal </span>
                                </div>
                                <div class="small-5 columns">
                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'name' => 'tanggal_mulai',
                                        'options' => array(
                                            'dateFormat' => 'yy-mm-dd',
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => true,
                                            'placeholder' => 'Mulai',
                                        ),
                                    )); ?>
                                </div>

                                <div class="small-5 columns">
                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'name' => 'tanggal_sampai',
                                        'options' => array(
                                            'dateFormat' => 'yy-mm-dd',
                                        ),
                                        'htmlOptions' => array(
                                            'readonly' => true,
                                            'placeholder' => 'Sampai',
                                        ),
                                    )); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                <?php echo CHtml::endForm();*/ ?>
            </div>-->
            
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
                        'Product' => array(
                            'content' => $this->renderPartial('_viewProduct', array(
                                'product' => $product,
                                'productDataProvider' => $productDataProvider,
                            ), true)
                        ),
                        'Service' => array(
                            'content' => $this->renderPartial('_viewService', array(
                                'service' => $service,
                                'serviceDataProvider' => $serviceDataProvider,
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
                    'id' => 'view_tab',
                )); ?>
            </div>
        </fieldset>
    </div>
</div>