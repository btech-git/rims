<?php
    $this->pageTitle=Yii::app()->name;
?>

<style> 
 .table_wrapper{
    display: block;
    overflow-x: auto;
    white-space: nowrap;
}
</style>

<div id="maincontent">
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
	<div class="clearfix page-action">
            <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                'tabs' => array(
                    'Vehicle' => array(
                        'content' => $this->renderPartial('_viewVehicle', array(
                            'vehicleDataProvider' => $vehicleDataProvider, 
                            'vehicle' => $vehicle, 
                            'tabIndex' => 1,
                        ), true),
                    ),
                    'Customer' => array(
                        'content' => $this->renderPartial('_viewCustomer', array(
                            'customer' => $customer,
                            'customerDataProvider' => $customerDataProvider,
                            'tabIndex' => 2,
                        ), true),
                    ),
                    'Parts' => array(
                        'content' => $this->renderPartial('_viewProduct', array(
                            'productDataProvider' => $productDataProvider, 
                            'product' => $product, 
                            'branches' => $branches,
                            'endDate' => $endDate,
                            'tabIndex' => 3,
                        ), true),
                    ),
//                    'Ban' => array(
//                        'content' => $this->renderPartial('_viewTire', array(
//                            'tireDataProvider' => $tireDataProvider,
//                            'tire' => $tire, 
//                            'branches' => $branches,
//                            'sectionWidth' => $sectionWidth,
//                            'aspectRatio' => $aspectRatio,
//                            'constructionType' => $constructionType,
//                            'rimDiameter' => $rimDiameter,
//                            'loadRating' => $loadRating,
//                            'speedRating' => $speedRating,
//                            'endDate' => $endDate,
//                            'yearList' => $yearList,
//                            'productionYear' => $productionYear,
//                        ), true),
//                    ),
//                    'Oli' => array(
//                        'content' => $this->renderPartial('_viewOil', array(
//                            'productDataProvider' => $productDataProvider, 
//                            'product' => $product, 
//                            'branches' => $branches,
//                            'endDate' => $endDate,
//                        ), true),
//                    ),
                    'Jasa' => array(
                        'content' => $this->renderPartial('_viewService', array(
                            'service' => $service, 
                            'serviceDataProvider' => $serviceDataProvider, 
                            'tabIndex' => 4,
                        ), true),
                    ),
                    'Follow Up' => array(
                        'content' => $this->renderPartial('_viewFollowUp', array(
                            'plateNumber' => $plateNumber,
                            'customerName' => $customerName,
                            'followUpDataProvider' => $followUpDataProvider, 
                            'tabIndex' => 5,
                        ), true),
                    ),
                    'Katalog Opsi Ban' => array(
                        'content' => $this->renderPartial('_viewTireOption', array(
                            'tireSize' => $tireSize,
                            'tireSizeDataProvider' => $tireSizeDataProvider,
                            'tabIndex' => 6,
                        ), true),
                    ),
                ),
                // additional javascript options for the tabs plugin
                'options' => array(
                    'collapsible' => true,
                    'active' => $tabIndex,
                ),
                // set id for this widgets
                'id' => 'view_tab',
            )); ?>
	</div>
    <?php echo CHtml::endForm(); ?>
</div>

<script>
    $('.yiiPager').click(function(e) {
        e.preventDefault();
        window.location.href = e.target.href + '&TabIndex=' + $(this).next().text();
    });
</script>