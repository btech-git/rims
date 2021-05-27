<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'sent-grid',
    'dataProvider'=>$supplierDataProvider,
    'filter'=>$supplier,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    //'summaryText'=>'',
    'columns'=>array(
        array('name' => 'name', 'value' => 'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type' => 'raw'),
        'date',
        'code',
        'company',
        'person_in_charge',
        'phone',
        'position',
        array('name' => 'coa_name', 'value' => '$data->coa!=""?$data->coa->name : ""'),
        array('name' => 'coa_code', 'value' => '$data->coa!=""?$data->coa->code : ""'),
        array('name' => 'coa_outstanding_name', 'value' => '$data->coaOutstandingOrder!=""?$data->coaOutstandingOrder->name : ""'),
        array('name' => 'coa_outstanding_code', 'value' => '$data->coaOutstandingOrder!=""?$data->coaOutstandingOrder->code : ""'),
    ),
)); ?>