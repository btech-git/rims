<?php
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
    });
");
?>

<div class="clear"></div>

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <div id="detail_div">
            <div class="myForm">
                <?php echo CHtml::beginForm(array(''), 'get'); ?>

                <div class="search-bar">
                    <div class="clearfix button-bar">
                        <a href="#" class="search-button right button cbutton secondary" id="menushow">Advanced Search</a>
                    </div>
                </div>

                <div class="clearfix"></div>

                <div class="search-form" style="display:none">
                    <?php $this->renderPartial('_search',array(
                        'yearList' => $yearList,
                        'year' => $year,
                        'productId' => $productId,
                        'productCode' => $productCode,
                        'productName' => $productName,
                        'branchId' => $branchId,
                        'brandId' => $brandId,
                        'subBrandId' => $subBrandId,
                        'subBrandSeriesId' => $subBrandSeriesId,
                        'masterCategoryId' => $masterCategoryId,
                        'subCategoryId' => $subCategoryId,
                        'subMasterCategoryId' => $subMasterCategoryId,
                    )); ?>
                </div><!-- search-form -->

                <?php echo CHtml::endForm(); ?>
                <div class="clear"></div>

            </div>

            <hr />

            <?php $monthList = array(
                1 => 'Jan',
                2 => 'Feb',
                3 => 'Mar',
                4 => 'Apr',
                5 => 'May',
                6 => 'Jun',
                7 => 'Jul',
                8 => 'Aug',
                9 => 'Sep',
                10 => 'Oct',
                11 => 'Nov',
                12 => 'Dec',
            ); ?>

            <div class="relative">
                <?php $this->renderPartial('_summary', array(
                    'invoiceTireInfo' => $invoiceTireInfo,
                    'year' => $year,
                    'monthList' => $monthList,
                    'branchId' => $branchId,
                )); ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
