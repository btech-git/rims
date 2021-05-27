<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'sent-grid',
    'dataProvider'=>$warehouseDataProvider,
    'filter'=>$warehouse,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    //'summaryText'=>'',
    'columns'=>array(
        'code',
        array(
            'name'=>'name', 
            'value'=>'CHTml::link($data->name, array("view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
        'description',
        array(
            'header'=>'Status', 
            'name'=>'status',
            'value'=>'$data->status',
            'type'=>'raw',
            'filter'=>CHtml::dropDownList('Warehouse[status]', 'warehouse_status', array(
                ''=>'Select',
                'Active' => 'Active',
                'Inactive' => 'Inactive',
            )),
        ),
    ),
)); ?>