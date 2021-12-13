<div style="height: 550px">
    <h1>Work in Progress</h1>
    <div class="grid-view">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'mechanic-assignment-grid',
            'dataProvider'=>$registrationProgressDataProvider,
            'filter'=> null, //$registrationService,
            'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
            'pager'=>array(
                'cssFile'=>false,
                'header'=>'',
            ),
            'columns'=>array(
                array(
                    'header'=>"No",
                    'value'=>'$this->grid->dataProvider->pagination->offset + $row+1',
                ),
                array(
                    'header' => 'Plate #',
                    'value' => '$data->registrationTransaction->vehicle->plate_number'
                ),
                array(
                    'header' => 'Car Make',
                    'value' => '$data->registrationTransaction->vehicle->carMake->name'
                ),
                array(
                    'header' => 'Car Model',
                    'value' => '$data->registrationTransaction->vehicle->carModel->name'
                ),
                array(
                    'header' => 'WO #',
                    'value' => '$data->registrationTransaction->work_order_number'
                ),
                array(
                    'header' => 'WO Date',
                    'value' => '$data->registrationTransaction->work_order_date'
                ),
                array(
                    'header' => 'Branch',
                    'value' => '$data->registrationTransaction->branch->name'
                ),
                'service_name',
                'start_date_time',
                'finish_date_time',
                'total_time',
                array(
                    'class'=>'CButtonColumn',
                    'template'=>'{vw}',
                    'buttons'=>array(
                        'vw' => array(
                            'label'=>'Finish',
                            'url'=>'Yii::app()->createUrl("frontDesk/bodyRepairMechanic/proceedToQualityControlMechanic", array("id"=>$data->id))',
                        ),
                    ),
                ),
            ),
        )); ?>
    </div>
</div>    