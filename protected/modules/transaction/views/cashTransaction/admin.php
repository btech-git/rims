<?php
/* @var $this CashTransactionController */
/* @var $model CashTransaction */

$this->breadcrumbs = array(
    'Cash Transactions' => array('index'),
    'Manage',
);

/* $this->menu=array(
  array('label'=>'List CashTransaction', 'url'=>array('index')),
  array('label'=>'Create CashTransaction', 'url'=>array('create')),
  ); */

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
	$('#cash-transaction-in-grid').yiiGridView('update', {
            data: $(this).serialize()
	});
	$('#cash-transaction-out-grid').yiiGridView('update', {
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
                <?php echo CHtml::link('<span class="fa fa-plus"></span>New Cash Transaction', Yii::app()->baseUrl . '/transaction/cashTransaction/create', array('class' => 'button success right', 'visible' => Yii::app()->user->checkAccess("cashTransactionCreate"))) ?>
                <h2>Manage Cash Transactions</h2>
            </div>

            <div class="search-bar">
                <div class="clearfix button-bar">
                    <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button right button cbutton secondary')); ?>					
                    <div class="clearfix"></div>
                    <div class="search-form" style="display:none">
                        <?php $this->renderPartial('_search', array(
                            'model' => $model,
                            'user' => $user,
                            'startDate' => $startDate,
                            'endDate' => $endDate,
                        )); ?>
                    </div><!-- search-form -->
                </div>
            </div>

            <div class="grid-view">
                <h2>TRANSACTION IN</h2>
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'cash-transaction-in-grid',
                    'dataProvider' => $cashInTransactionDataProvider,
                    'filter' => null,
                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        array( 
                            'name' => 'transaction_number', 
                            'value' => 'CHTml::link($data->transaction_number, array("view", "id"=>$data->id))', 
                            'type' => 'raw'
                        ),
                        'transaction_date',
                        'transaction_time',
                        array(
                            'header' => 'COA Credit',
                            'name' => 'coa_name', 
                            'value' => '$data->coa != "" ? $data->coa->name : "" '
                        ),
                        array(
                            'name' => 'credit_amount',
                            'value' => 'number_format($data->credit_amount, 2)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right',
                            ),
                        ),
                        array(
                            'header' => 'COA Debit',
                            'value' => 'empty($data->cashTransactionDetails) ? "" : $data->cashTransactionDetails[0]->coa->name'
                        ),
                        array(
                            'header' => 'Debit Amount',
                            'value' => 'empty($data->cashTransactionDetails) ? "0.00" : number_format($data->totalDetails, 2)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right',
                            ),
                        ),
                        'status',
                        array(
                            'header' => 'Approved By',
                            'value' => '$data->status == "Approved" ? $data->cashTransactionApprovals[0]->supervisor->username : "" ',
                        ),
                        array(
                            'header' => 'Input',
                            'name' => 'created_datetime',
                            'filter' => false,
                            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
                        ),
                        array(
                            'class' => 'CButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
//                                'update' => array(
//                                    'label' => 'update',
//                                    'url' => 'Yii::app()->createUrl("transaction/cashTransaction/update", array("id"=>$data->id))',
//                                    'visible' => 'Yii::app()->user->checkAccess("cashTransactionEdit")', //$data->status_document != "Approved" && $data->status_document != "Rejected" && ',
//                                ),
                                'view' => array(
                                    'label' => 'view',
                                    'url' => 'Yii::app()->createUrl("transaction/cashTransaction/view", array("id"=>$data->id))',
                                ),
                            ),
                        ),
                    ),
                )); ?>
            </div>

            <div class="grid-view">
                <h2>TRANSACTION OUT</h2>
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'cash-transaction-out-grid',
                    'dataProvider' => $cashOutTransactionDataProvider,
                    'filter' => NULL,
                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        array( 
                            'name' => 'transaction_number', 
                            'value' => 'CHTml::link($data->transaction_number, array("view", "id"=>$data->id))', 
                            'type' => 'raw'
                        ),
                        'transaction_date',
                        array(
                            'header' => 'COA Debit',
                            'name' => 'coa_name', 
                            'value' => '$data->coa != "" ? $data->coa->name : "" '
                        ),
                        array(
                            'name' => 'debit_amount',
                            'value' => 'number_format($data->debit_amount, 2)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right',
                            ),
                        ),
                        array(
                            'header' => 'COA Credit',
                            'value' => 'empty($data->cashTransactionDetails) ? "" : $data->cashTransactionDetails[0]->coa->name'
                        ),
                        array(
                            'header' => 'Credit Amount',
                            'value' => 'empty($data->cashTransactionDetails) ? "0.00" : number_format($data->totalDetails, 2)',
                            'htmlOptions' => array(
                                'style' => 'text-align: right',
                            ),
                        ),
                        'status',
                        array(
                            'header' => 'Approved By',
                            'value' => '$data->status == "Approved" ? $data->cashTransactionApprovals[0]->supervisor->username : "" ',
                        ),
                        array(
                            'header' => 'Input',
                            'name' => 'created_datetime',
                            'filter' => false,
                            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
                        ),
                        array(
                            'class' => 'CButtonColumn',
                            'template' => '{view}',
                            'buttons' => array(
//                                'update' => array(
//                                    'label' => 'update',
//                                    'url' => 'Yii::app()->createUrl("transaction/cashTransaction/update", array("id"=>$data->id))',
//                                    'visible' => 'Yii::app()->user->checkAccess("cashTransactionEdit")', //$data->status_document != "Approved" && $data->status_document != "Rejected" && ',
//                                ),
                                'view' => array(
                                    'label' => 'view',
                                    'url' => 'Yii::app()->createUrl("transaction/cashTransaction/view", array("id"=>$data->id))',
                                ),
                            ),
                        ),
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