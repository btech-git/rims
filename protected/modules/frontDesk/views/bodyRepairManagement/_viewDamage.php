<div style="height: 350px">
    <h1>Damage</h1>
    <div class="grid-view">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id'=>'registration-damage-grid',
            'dataProvider'=>$registrationDamageDataProvider,
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
                'panel',
                'damage_type',
                'description',
                'hour',
                'waiting_time',
            ),
        )); ?>
    </div>
</div>    