<div style="height: 350px">
    <h1>Service</h1>
    <div class="grid-view">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'registration-service-grid',
            'dataProvider'=>$registrationServiceDataProvider,
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
                array('name'=>'service_id', 'value'=>'$data->service->name'),
                array('header'=>'Category', 'value'=>'$data->service->serviceCategory->name'),
                array('header'=>'Type', 'value'=>'$data->service->serviceType->name'),
            ),
        )); ?>
    </div>
</div>    