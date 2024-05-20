<?php
    $this->pageTitle=Yii::app()->name;
?>
<div id="maincontent">
    <?php echo CHtml::beginForm(); ?>
	<div class="clearfix page-action">
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
                    'Vehicle' => array(
                        'content' => $this->renderPartial('_viewVehicle', array(
                            'vehicleDataProvider' => $vehicleDataProvider, 
                            'vehicle' => $vehicle, 
                        ), true),
                    ),
                    'Customer' => array(
                        'content' => $this->renderPartial('_viewCustomer', array(
                            'customer' => $customer,
                            'customerDataProvider' => $customerDataProvider,
                        ), true),
                    ),
                    'Product' => array(
                        'content' => $this->renderPartial('_viewProduct', array(
                            'productDataProvider' => $productDataProvider, 
                            'product' => $product, 
                            'branches' => $branches,
                            'endDate' => $endDate,
                        ), true),
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
    <?php echo CHtml::endForm(); ?>
</div>