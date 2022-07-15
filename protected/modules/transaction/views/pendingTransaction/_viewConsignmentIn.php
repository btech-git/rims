<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'consignment-in-grid',
    'dataProvider'=>$consignmentInDataProvider,
    'filter'=>$consignmentIn,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    'columns'=>array(
        array(
            'name'=>'consignment_in_number', 
            'value'=>'CHTml::link($data->consignment_in_number, array("/transaction/consignmentInHeader/view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date_posting',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->date_posting)'
        ),
        'status_document',
        array('name'=>'receive_id','value'=> '$data->user->username'),
        array('name'=>'receive_branch','value'=> '$data->receiveBranch->name'),
        array(
            'header' => 'Status',
            'value' => '$data->totalRemainingQuantityReceived',
        ),
        array(
            'header' => 'Input',
            'name' => 'created_datetime',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->created_datetime)'
        ),
    ),
)); ?>