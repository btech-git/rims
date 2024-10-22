<?php
    $this->pageTitle=Yii::app()->name;
?>
<div id="maincontent">
    <?php echo CHtml::beginForm(); ?>
	<div class="clearfix page-action">
            <h3>Welcome to RAPERIND</h3>
            <hr />
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
                    'Kendaraan' => array(
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
                    'Produk' => array(
                        'content' => $this->renderPartial('_viewProduct', array(
                            'productDataProvider' => $productDataProvider, 
                            'product' => $product, 
                            'branches' => $branches,
                            'endDate' => $endDate,
                        ), true),
                    ),
                    'Jasa' => array(
                        'content' => $this->renderPartial('_viewService', array(
                            'service' => $service, 
                            'serviceDataProvider' => $serviceDataProvider, 
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