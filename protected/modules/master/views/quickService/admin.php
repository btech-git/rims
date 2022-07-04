<?php
/* @var $this QuickServiceController */
/* @var $model QuickService */

$this->breadcrumbs = array(
    'Quick Services' => array('admin'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List QuickService', 'url' => array('index')),
    array('label' => 'Create QuickService', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
	$('.search-button').click(function(){
		$('.search-form').slideToggle(600);
		$('.bulk-action').toggle();
		$(this).toggleClass('active');
		if($(this).hasClass('active')){
			$(this).text('');
		}else {
			$(this).text('Advanced Search');
		}
		return false;
	});

	$('form').submit(function(){
		$('#quick-service-grid').yiiGridView('update', {
			data: $(this).serialize()
		});
		return false;
	});
	");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php if (Yii::app()->user->checkAccess("masterQuickServiceCreate")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/quickService/create'; ?>"><span class="fa fa-plus"></span>New Quick Service</a>
        <?php } ?>
        <h2>Manage Quick Service</h2>
    </div>

    <div class="search-bar">
        <div class="clearfix button-bar">
            <div class="row">
                <div class="medium-12 columns">
                    <?php
                    $form = $this->beginWidget('CActiveForm', array(
                        'action' => Yii::app()->createUrl($this->route),
                        'method' => 'get',
                    ));
                    ?>
                    <div class="row">
                        <div class="medium-3 columns">
                            <?php echo $form->textField($model, 'findkeyword', array('placeholder' => 'Find By Keyword', "style" => "margin-bottom:0px;")); ?>
                        </div>
                        <div class="medium-3 columns">
                            <?php
                            echo $form->dropDownList($model, 'service_id', CHtml::listData(Service::model()->findAll(), 'id', 'name'), array(
                                'prompt' => '[--Select Service--]', "style" => "margin-bottom:0px;"
                                    )
                            );
                            ?>
                        </div>
                        <div class="medium-3 columns">
                            <?php
                            echo $form->dropDownList($model, 'service_type_code', CHtml::listData(ServiceType::model()->findAll(), 'name', 'name'), array(
                                'prompt' => '[--Select Service Type--]', "style" => "margin-bottom:0px;"
                                    )
                            );
                            ?>
                        </div>
                        <div class="medium-3 columns">
                            <?php
                            echo $form->dropDownList($model, 'service_category_code', CHtml::listData(ServiceCategory::model()->findAll(), 'name', 'name'), array(
                                'prompt' => '[--Select Service Category--]', "style" => "margin-bottom:0px;"
                                    )
                            );
                            ?>
                        </div>

                    </div>
            <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
    <div class="grid-view">
        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'quick-service-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'columns' => array(
                //'id',
                array('name' => 'service_type_code', 'value' => '$data->service->serviceType->name'),
                array('name' => 'service_category_code', 'value' => '$data->service->serviceCategory->name'),
                array('name' => 'service_name', 'value' => 'CHTml::link($data->service->name, array("view", "id"=>$data->service->id))', 'type' => 'raw'),
                array('name' => 'service_code', 'value' => '$data->service->code'),
                array('name' => 'qs_code', 'value' => 'CHTml::link($data->quickService->code, array("view", "id"=>$data->quick_service_id))', 'type' => 'raw'),
                //'code',
                array(
                    'name' => 'qs_name',
                    'value' => '$data->quickService->name',
                ),
                array(
                    'name' => 'qs_status',
                    'value' => '$data->quickService->status',
                ),
                array(
                    'name' => 'qs_rate',
                    'value' => '$data->quickService->rate',
                ),
                // array(
                // 	'class'=>'CButtonColumn',
                // ),
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{views} {edit} {hapus}',
                    'buttons' => array
                        (
                        'views' => array
                            (
                            'label' => 'view',
                            'url' => 'Yii::app()->createUrl("master/quickService/view", array("id"=>$data->quick_service_id))'
                        ),
                        'edit' => array
                            (
                            'label' => 'edit',
                            'visible' => '(Yii::app()->user->checkAccess("masterQuickServiceEdit"))',
                            'url' => 'Yii::app()->createUrl("master/quickService/update", array("id"=>$data->quick_service_id))'
                        ),
                        'hapus' => array
                            (
                            'label' => 'delete',
                            'url' => 'Yii::app()->createUrl("master/quickService/delete", array("id"=>$data->quick_service_id))'
                        ),
                    ),
                ),
            ),
        ));
        ?>
    </div>
</div>
<!-- end maincontent -->



<?php
Yii::app()->clientScript->registerScript('search', "

    	$('#QuickServiceDetail_findkeyword').keypress(function(e) {
		    if(e.which == 13) {
				$.fn.yiiGridView.update('quick-service-grid', {
					data: $(this).serialize()
				});
		        return false;
		    }
		});

        $('#QuickServiceDetail_service_id, #QuickServiceDetail_service_type_code, #QuickServiceDetail_service_category_code').change(function(){
            $.fn.yiiGridView.update('quick-service-grid', {
                data: $(this).serialize()
            });
            return false;
        });

		
    ");
?>