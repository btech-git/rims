<?php
$this->breadcrumbs = array(
    'Sale Receipt' => array('index'),
    'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle(600);
    $('.bulk-action').toggle();
    $(this).toggleClass('active');
    
    if ($(this).hasClass('active')) {
        $(this).text('');
    } else {
        $(this).text('Advanced Search');
    }
    
    return false;
});
$('.search-form form').submit(function(){
    $('#sale-receipt-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    
    return false;
});
");
?>

<div id="maincontent">
    <div class="row">
        <div class="small-12 columns">
            <div class="clearfix page-action">
                <h2>Manage Tanda Terima Penjualan</h2>
                
                <?php echo CHtml::link('<span class="fa fa-plus"></span>New', Yii::app()->baseUrl . '/accounting/saleReceipt/customerList', array(
                    'class' => 'button success right',
                    'style' => 'margin-right:10px',
//                    'visible' => Yii::app()->user->checkAccess("paymentInCreate")
                )); ?>
            </div>

            <div class="search-bar">
                <div class="clearfix button-bar">
                    <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button right button cbutton secondary')); ?>
                    <div class="clearfix"></div>
                    <div class="search-form" style="display:none">
                        <?php /*$this->renderPartial('_search', array(
                            'model' => $model,
                            'startDate' => $startDate,
                            'endDate' => $endDate,
                            'customerName' => $customerName,
                            'customerType' => $customerType,
                        ));*/ ?>
                    </div><!-- search-form -->
                </div>
            </div>

            <div class="grid-view">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'sale-receipt-grid',
                    'dataProvider' => $dataProvider,
                    'filter' => NULL,
                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        array(
                            'name' => 'transaction_number',
                            'value' => 'CHtml::link($data->transaction_number, array("view", "id"=>$data->id))',
                            'type' => 'raw'
                        ),
                        'transaction_date',
                        array(
                            'name' => 'customer_name', 
                            'value' => 'empty($data->customer_id) ? "N/A" : $data->customer->name'
                        ),
                        array(
                            'name' => 'total_invoice_amount', 
                            'value' => 'AppHelper::formatMoney($data->total_invoice_amount)',
                            'htmlOptions' => array('style' => 'text-align: right'),
                        ),
                        'status',
                        'note',
                    ),
                )); ?>
            </div>
        </div>
    </div> <!-- end row -->
</div> <!-- end maintenance -->

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'cancel-message-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Cancel Message',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => false,
    ),
));?>
<div>
    <?php $hasFlash = Yii::app()->user->hasFlash('message'); ?>
    <?php if ($hasFlash): ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('message'); ?>
        </div>
    <?php endif; ?>
</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
    $(document).ready(function() {
        var hasFlash = <?php echo $hasFlash ? 'true' : 'false' ?>;
        if (hasFlash) {
            $("#cancel-message-dialog").dialog({modal: 'false'});
        }
    });
</script>