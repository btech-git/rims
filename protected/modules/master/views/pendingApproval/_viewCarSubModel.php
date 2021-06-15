<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id'=>'sent-grid',
    'dataProvider'=>$carSubModelDataProvider,
    'filter'=>$carSubModel,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    'columns'=>array(
        'carMake.name',
        'carModel.name',
        array(
            'name'=>'name', 
            'value'=>'CHTml::link($data->name, array("/master/vehicleCarSubModel/view", "id"=>$data->id))', 
            'type'=>'raw'
        ),
    ),
)); ?>