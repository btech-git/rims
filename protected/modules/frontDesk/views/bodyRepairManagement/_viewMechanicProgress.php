<div style="height: 350px">
    <h1>Mechanic Assignments</h1>
    <div class="grid-view">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'mechanic-assignment-grid',
            'dataProvider'=>$registrationProgressDataProvider,
            'filter'=> null, //$registrationService,
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
            ),
        )); ?>
    </div>
</div>    