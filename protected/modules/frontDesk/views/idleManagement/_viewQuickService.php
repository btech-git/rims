<div style="height: 350px">
    <h1>Quick Service</h1>
    <div class="grid-view">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'registration-quick-service-grid',
            'dataProvider'=>$registrationQuickServiceDataProvider,
            'filter'=> null,
            'pager'=>array(
                'cssFile'=>false,
                'header'=>'',
            ),
            'columns'=>array(
                array(
                    'header'=>"No",
                    'value'=>'$this->grid->dataProvider->pagination->offset + $row+1',
                ),
                array('name'=>'quick_service_id', 'value'=>'$data->quickService->name'),
                array('name'=>'hour', 'value'=>'$data->hour'),
            ),
        )); ?>
    </div>
</div>    