<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'employee-dayoff-grid',
    'dataProvider'=>$employeeDayoffDataProvider,
    'filter'=>$employeeDayoff,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    'columns'=>array(
        array(
            'header'=>'Employee', 
            'value' => '$data->employee->name', 
        ),
        array(
            'header' => 'Tanggal Mulai',
            'name' => 'date_from',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->date_from)'
        ),
        array(
            'header' => 'Tanggal Akhir',
            'name' => 'date_to',
            'filter' => false,
            'value' => 'Yii::app()->dateFormatter->format("d MMM yyyy", $data->date_to)'
        ),
        'day',
        'off_type',
        'notes',
        'status',
        array(
            'class'=>'CButtonColumn',
            'template'=>'{views}',
            'buttons'=>array(
                'views' => array(
                    'label'=>'approval',
                    'url'=>'Yii::app()->createUrl("master/employeeDayoff/updateApproval", array("headerId"=>$data->id))',
                ),
            ),
        ),
    ),
)); ?>