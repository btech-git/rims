<?php $this->widget('ext.groupgridview.GroupGridView', array(
    'id'=>'registration-transaction-grid',
    'dataProvider'=>$modelDataProvider,
    'filter'=>$model,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager'=>array(
        'cssFile'=>false,
        'header'=>'',
    ),
    'columns'=>array(
        array('name'=>'start_mechanic_id', 'value'=>empty($startMechanic) ? "" : $startMechanic->name),
        array('name'=>'service_id', 'value'=>'$data->service->name'),
        'start',
        'end',
        'total_time',
        array(
            'header'=>'WO #', 
            'filter' => false,
            'value'=>'$data->registrationTransaction->work_order_number',
        ),
        array(
            'header'=>'Service Type',
            'filter' => false,
            'value'=>'$data->registrationTransaction->repair_type',
        ),
        array(
            'header'=>'Branch', 
//            'filter' => CHtml::activeDropDownlist($model, 'branch_id', CHtml::listData(Branch::model()->findAll(),'id','code'), array('empty' => '--All--')),
            'value'=>'!empty($data->registrationTransaction->branch_id) ? $data->registrationTransaction->branch->name : "" '
        ),
        array(
            'class'=>'CButtonColumn',
            'template'=>'{vw}',
            'buttons'=>array
            (
                'vw' => array
                (
                    'label'=>'detail',
                    'url'=>'Yii::app()->createUrl("frontDesk/idleManagement/viewDetailService", array("registrationServiceId"=>$data->id))',
                    //'options'=>array('class'=>'registration-service-view','id'=>''),
                    'click'=>"js:function(){
                        var url = $(this).attr('href');
                        /*
                        //  do your post request here
                        console.log(url);
                        $.post(url,function(html){
                            $('#registration-service-dialog').dialog('open');
                            $('#registration_service_div').html(html);
                         });
                        return false;*/
                        newwindow=window.open(url,'name','height=600,width=1200,left=100');
                        if (window.focus) {newwindow.focus()}
                        newwindow.onbeforeunload = function(){  $.fn.yiiGridView.update('registration-transaction-grid')}
                        newwindow.onunload = function(){  $.fn.yiiGridView.update('registration-transaction-grid')}
                        return false;
                    }"
                ),
//								'edit' => array
//								(
//									'label'=>'update',
//									'url'=>'Yii::app()->createUrl("frontDesk/registrationTransaction/idleManagementUpdate", array("id"=>$data->id))',
//									'click'=>"js:function(){
//										var url = $(this).attr('href');
//								        //  do your post request here
//								        console.log(url);
//								        $.post(url,function(html){
//								            $('#update-status-dialog').dialog('open');
//											$('#update_status_div').html(html);
//								         });
//								        return false;
//									}"
//								),
            ),
        ),
    ),
)); ?>