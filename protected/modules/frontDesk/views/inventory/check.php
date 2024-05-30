<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
    });
    $('#EndDate').val('" . $endDate . "');
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
            'endDate' => $endDate,
            'product'=>$product,
            'pageNumber' => $pageNumber,
        )); ?>
    </div><!-- search-form -->
    <?php echo CHtml::endForm(); ?>
</div>

<div id="product_stock_table">
    <?php $this->renderPartial('_productStockTable', array(
        'productDataProvider' => $productDataProvider,
        'branches' => $branches,
        'endDate' => $endDate,
    )); ?>
</div>

<div>
    <div class="right">
        <?php $this->widget('system.web.widgets.pagers.CLinkPager', array(
            'itemCount' => $productDataProvider->pagination->itemCount,
            'pageSize' => $productDataProvider->pagination->pageSize,
            'currentPage' => $productDataProvider->pagination->getCurrentPage(false),
        )); ?>
    </div>
    <div class="clear"></div>
</div>

<script>
    //$('ul.yiiPager > li > a').click(function(e) {
        //e.preventDefault();
        //$.ajax({
        //    type: 'GET',
        //    url: '/raperind/frontDesk/inventory/ajaxHtmlUpdateProductSubBrandSelect',
        //    data: $('form').serialize(),
        //    success: function(html) {
        //        $('#product_stock_table').html(html);
        //    }
        //});
        //var href = $(e.target).attr('href');
        //var pageNumber = href.replace(/.+(?:&|\?)page=(\d+)(?:&|$).*/g, '$1');
        //$('#page').val(pageNumber);
        //console.log(href, pageNumber);
    //});
</script>