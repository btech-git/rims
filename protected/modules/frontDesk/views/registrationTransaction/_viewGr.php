<?php $this->renderPartial('_search_wl'); ?>

<?php $this->widget('ext.groupgridview.GroupGridView', array(
    'id' => 'grDatas-transaction-grid',
    'dataProvider' => $grDatas,
    // 'filter'=>$model,
    'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'mergeColumns' => array('platnumber'),
    'columns' => array(
        array(
            'header' => '#',
            'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1',
            //  row is zero based
        ),
        array(
            'header' => 'Plate Number',
            'name' => 'platnumber',
            'value' => '$data->registrationTransaction->vehicle->plate_number',
        ),
        array(
            'header' => 'WO Number',
            'value' => '$data->registrationTransaction->work_order_number',
        ),
        array(
            'header' => 'Transaction Number',
            'value' => '$data->registrationTransaction->transaction_number',
        ),
        array(
            'header' => 'Transaction Date',
            'value' => '$data->registrationTransaction->transaction_date',
        ),
        'start',
        'end',
        array(
            'name' => 'Duration',
            'value' => '$data->hour',
        ),
        'status',
        array(
            'name' => 'Working By',
            'value' => '$data->getEmployee()',
        ),

        array(
            'class' => 'CButtonColumn',
            'template' => '{views}',
            'buttons' => array
            (

                'views' => array
                (
                    'label' => 'view',
                    'url' => 'Yii::app()->createUrl("frontDesk/registrationTransaction/view", array("id"=>$data->registrationTransaction->id))',
                    'options' => array('id' => 'agr'),
                    'visible' => 'Yii::app()->user->checkAccess("frontDesk.registrationTransaction.view")'
                ),

            ),
        ),

    ),
)); ?>
<?php

Yii::app()->clientScript->registerScript('search', "

$('a#agr').click(function(e) {
    var url=this.href;
	newwindow=window.open(url,'name','height=500,width=800,left=100,top=100');
	if (window.focus) {newwindow.focus()}
	newwindow.onbeforeunload = function(){  $.fn.yiiGridView.update('registration-transaction-grid')}
	newwindow.onunload = function(){  $.fn.yiiGridView.update('registration-transaction-grid')}
	e.preventDefault();
    return false;
});

$('form').submit(function(){
	$('#grDatas-transaction-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

