<?php
$this->breadcrumbs=array(
	'Outstanding Order'=>array('index'),
);

//Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>


	
<div id="maincontent">
<div class="clearfix page-action">
     <div class="grid-view"></div>
        <fieldset>
            <legend>Pending Journal</legend>

            <br />
            
            <div>
                <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                    'tabs' => array(
                        'Purchase Order' => array(
                            'content' => $this->renderPartial('_viewPurchase', array(
                                'purchaseOrderDataProvider' => $purchaseOrderDataProvider, 
                            ), true),
                        ),
                        'Receive Item' => array(
                            'content' => $this->renderPartial('_viewReceive', array(
                                'receiveItemDataProvider' => $receiveItemDataProvider,
                            ), true)
                        ),
                        'Retail Sales' => array(
                            'content' => $this->renderPartial('_viewRegistration', array(
                                'registrationTransactionDataProvider' => $registrationTransactionDataProvider,
                            ), true)
                        ),
//                        'Payment In' => array(
//                            'content' => $this->renderPartial('_viewPaymentIn', array(
//                                'paymentInDataProvider' => $paymentInDataProvider,
//                            ), true)
//                        ),
//                        'Payment Out' => array(
//                            'content' => $this->renderPartial('_viewPaymentOut', array(
//                                'paymentOutDataProvider' => $paymentOutDataProvider,
//                            ), true)
//                        ),
//                        'Movement In' => array(
//                            'content' => $this->renderPartial('_viewMovementIn', array(
//                                'movementInDataProvider' => $movementInDataProvider,
//                            ), true)
//                        ),
//                        'Movement Out' => array(
//                            'content' => $this->renderPartial('_viewMovementOut', array(
//                                'movementOutDataProvider' => $movementOutDataProvider,
//                            ), true)
//                        ),
//                        'Delivery Order' => array(
//                            'content' => $this->renderPartial('_viewDelivery', array(
//                                'deliveryOrderDataProvider' => $deliveryOrderDataProvider,
//                            ), true)
//                        ),
//                        'Cash Transaction' => array(
//                            'content' => $this->renderPartial('_viewCash', array(
//                                'cashTransactionDataProvider' => $cashTransactionDataProvider,
//                            ), true)
//                        ),
//                        'Sales Order' => array(
//                            'content' => $this->renderPartial('_viewSale', array(
//                                'saleOrderDataProvider' => $saleOrderDataProvider, 
//                            ), true)
//                        ),
//                        'Sub Pekerjaan Luar' => array(
//                            'content' => $this->renderPartial(
//                                '_viewSale',
//                                array(
//                                    'saleOrderDataProvider' => $saleOrderDataProvider, 
//                                    'saleOrder' => $saleOrder
//                                ), true
//                            )
//                        ),
//                        'Jurnal Umum' => array(
//                            'content' => $this->renderPartial(
//                                '_viewSale',
//                                array(
//                                    'saleOrderDataProvider' => $saleOrderDataProvider, 
//                                    'saleOrder' => $saleOrder
//                                ), true
//                            )
//                        ),
//                        'Transfer Request' => array(
//                            'content' => $this->renderPartial(
//                                '_viewTransfer',
//                                array(
//                                    'transferRequest' => $transferRequest,
//                                    'transferRequestDataProvider' => $transferRequestDataProvider,
//                                ), true
//                            )
//                        ),
//                        'Sent Request' => array(
//                            'content' => $this->renderPartial(
//                                '_viewTransfer',
//                                array(
//                                    'transferRequest' => $transferRequest,
//                                    'transferRequestDataProvider' => $transferRequestDataProvider,
//                                ), true
//                            )
//                        ),
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