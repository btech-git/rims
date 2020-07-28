<?php
/* @var $this PaymentInController */
/* @var $model PaymentIn */

$this->breadcrumbs = array(
    'Payment Ins' => array('index'),
    'Manage',
);

/*$this->menu=array(
	array('label'=>'List PaymentIn', 'url'=>array('index')),
	array('label'=>'Create PaymentIn', 'url'=>array('create')),
);*/

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
	if($(this).hasClass('active')){
		$(this).text('');
	}else {
		$(this).text('Advanced Search');
	}
	return false;
});
$('.search-form form').submit(function(){
	$('#payment-in-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--<h1>Manage Payment Ins</h1>-->


<div id="maincontent">
    <div class="row">
        <div class="small-12 columns">
            <div class="clearfix page-action">
                <?php echo CHtml::link('<span class="fa fa-list" ></span>Unpaid Invoice List',
                    Yii::app()->baseUrl . '/transaction/paymentIn/index', array(
                        'class' => 'button cbutton right',
                        'style' => 'margin-left:10px',
                        'visible' => Yii::app()->user->checkAccess("transaction.paymentIn.index")
                    )) ?>
                <?php echo CHtml::link('<span class="fa fa-plus"></span>New Payment In',
                    Yii::app()->baseUrl . '/transaction/paymentIn/invoiceList', array(
                        'class' => 'button success right',
                        'visible' => Yii::app()->user->checkAccess("transaction.paymentIn.create")
                    )) ?>
                <h2>Manage Payment In</h2>
            </div>

            <div class="search-bar">
                <div class="clearfix button-bar">
                    <!--<div class="left clearfix bulk-action">
                       <span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
                       <input type="submit" value="Archive" class="button secondary cbutton" name="archive">
                       <input type="submit" value="Delete" class="button secondary cbutton" name="delete">
                   </div>-->
                    <?php echo CHtml::link('Advanced Search', '#',
                        array('class' => 'search-button right button cbutton secondary')); ?>
                    <div class="clearfix"></div>
                    <div class="search-form" style="display:none">
                        <?php $this->renderPartial('_search', array(
                            'model' => $model,
                        )); ?>
                    </div><!-- search-form -->
                </div>
            </div>

            <div class="grid-view">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'payment-in-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    // 'summaryText'=>'',
                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        //'id',
                        //'invoice_id',
                        array('name' => 'invoice_id', 'value' => '$data->invoice->invoice_number'),
                        array('name' => 'customer_name', 'value' => '$data->customer->name'),
                        array(
                            'name' => 'payment_number',
                            'value' => 'CHTml::link($data->payment_number, array("view", "id"=>$data->id))',
                            'type' => 'raw'
                        ),
                        'payment_date',
                        array('name' => 'payment_amount', 'value' => 'AppHelper::formatMoney($data->payment_amount)'),
                        'notes',
                        array(
                            'header' => 'Invoice Status',
                            'name' => 'invoice_status',
                            'value' => '$data->invoice->status',
                        ),
                        // array(
                        // 	'class'=>'CButtonColumn',
                        // 	'template'=>'{edit}',
                        // 	'buttons'=>array
                        // 	(
                        // 		'edit' => array
                        // 		(
                        // 			'label'=>'edit',
                        // 			'url'=>'Yii::app()->createUrl("transaction/paymentIn/update", array("id"=>$data->id))',
                        // 			'visible'=> '$data->status != "Approved" && Yii::app()->user->checkAccess("transaction.paymentIn.update")',
                        // 		),

                        // 	),
                        // 	),
                    ),
                )); ?>
            </div>
            <fieldset>
                <legend>Pending Invoice</legend>
                <div class="grid-view">
                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'invoice-grid',
                            // 'dataProvider'=>$vehicleDataProvider,
                            'dataProvider' => $invoiceDataProvider,
                            'filter' => $invoice,
                            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                            'pager' => array(
                                'cssFile' => false,
                                'header' => '',
                            ),

                            'columns' => array(
                                array(
                                    'name' => 'invoice_number',
                                    'value' => 'CHTml::link($data->invoice_number, array("invoiceHeader/view", "id"=>$data->id))',
                                    'type' => 'raw'
                                ),
                                //'invoice_number',
                                'invoice_date',
                                'due_date',
                                'status',
                                array(
                                    'name' => 'reference_type',
                                    'value' => '$data->reference_type == 1 ? "Sales Order" : "Retail Sales"'
                                ),
                                array('name' => 'customer_name', 'value' => '$data->customer->name'),
                                array('name' => 'total_price', 'value' => 'AppHelper::formatMoney($data->total_price)'),
                            ),
                        )
                    );
                    ?>
                </div>
            </fieldset>
        </div>
    </div> <!-- end row -->
</div> <!-- end maintenance -->
