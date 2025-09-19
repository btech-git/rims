<?php

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
    });
");
?>

<div>
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
            'month' => $month,
            'product'=>$product,
            'currentPage' => $currentPage,
        )); ?>
    </div><!-- search-form -->
    <?php echo CHtml::endForm(); ?>
</div>

<div id="product_stock_table">
    <?php $this->renderPartial('_summary', array(
        'productDataProvider' => $productDataProvider,
        'branches' => $branches,
        'year' => $year,
        'month' => $month,
    )); ?>
</div>

<div class="right">
    <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
        'itemCount' => $productDataProvider->pagination->itemCount,
        'pageSize' => $productDataProvider->pagination->pageSize,
        'currentPage' => $productDataProvider->pagination->getCurrentPage(false),
    )); ?>
</div>