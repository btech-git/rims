<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'consignment-grid',
    'dataProvider'=>$consignmentDataProvider,
    'filter'=>$consignment,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    'columns'=>array(
        array(
            'name'=>'consignment_out_no', 
            'value'=>'CHTml::link($data->consignment_out_no, array("/transaction/consignmentOutHeader/view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
        array(
            'header' => 'Tanggal',
            'name' => 'date_posting',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy HH:mm:ss", $data->date_posting)'
        ),
        'status',
        array('name'=>'sender_id','value'=> '$data->user->employee->name'),
        array('name'=>'branch_id','value'=>'$data->branch->name'),
        array(
            'header' => 'Status',
            'value' => '$data->totalRemainingQuantityDelivered',
        ),
    ),
)); ?>
