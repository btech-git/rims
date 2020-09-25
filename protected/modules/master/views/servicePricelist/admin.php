<?php
/* @var $this ServicePricelistController */
/* @var $model ServicePricelist */

$this->breadcrumbs = array(
    'Service' => Yii::app()->baseUrl . '/master/servicePricelist/admin',
    'Service Pricelist' => array('admin'),
    'Manage Service',
);

$this->menu = array(
    array('label' => 'List ServicePricelist', 'url' => array('index')),
    array('label' => 'Create ServicePricelist', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function() {
	$('.search-form').slideToggle(600);
	$('.bulk-action').toggle();
	$(this).toggleClass('active');
	if ($(this).hasClass('active')) {
            $(this).text('');
	}else {
            $(this).text('Advanced Search');
	}
        
	return false;
    });
    $('form').submit(function() {
	$('#service-pricelist-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        
        return false;
    });
");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <?php if (Yii::app()->user->checkAccess("master.servicePricelist.create")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/servicePricelist/create'; ?>" data-reveal-id="color"><span class="fa fa-plus"></span>New Service Pricelist</a>
        <?php } ?>
        <h1>Manage Service Price lists</h1>

        <div class="search-bar">
            <div class="clearfix button-bar">
                <div class="row">
                    <div class="medium-12 columns">
                        <?php $form = $this->beginWidget('CActiveForm', array(
                            'action' => Yii::app()->createUrl($this->route),
                            'method' => 'get',
                        )); ?>
                        <div class="row">
                            <div class="medium-3 columns">
                                <?php //echo $form->textField($model, 'findkeyword', array('placeholder' => 'Find By Keyword', "style" => "margin-bottom:0px;")); ?>
                            </div>
                            <div class="medium-3 columns">
                                <?php echo $form->dropDownList($model, 'service_id', CHtml::listData(Service::model()->findAll(), 'id', 'name'), array(
                                    'prompt' => '[--Select Service--]', 
                                    "style" => "margin-bottom:0px;",
                                )); ?>
                            </div>
                            <div class="medium-3 columns">
                                <?php /*echo $form->dropDownList($model, 'service_type_code', CHtml::listData(ServiceType::model()->findAll(), 'name', 'name'), array(
                                    'prompt' => '[--Select Service Type--]', "style" => "margin-bottom:0px;"
                                )); ?>
                            </div>
                            <div class="medium-3 columns">
                                <?php echo $form->dropDownList($model, 'service_category_code', CHtml::listData(ServiceCategory::model()->findAll(), 'name', 'name'), array(
                                    'prompt' => '[--Select Service Category--]', "style" => "margin-bottom:0px;"
                                ));*/ ?>
                            </div>
                        </div>
                        <?php $this->endWidget(); ?>
                    </div>
            <?php /* <div class="medium-2 columns">
              <a href="#" class="search-button right button cbutton secondary" id="advsearch" style="display: none;">Advanced Search</a>
              </div> */ ?>
                </div>      			
            </div>
            <?php /* <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
              <div class="clearfix"></div>
              <div class="search-form" style="display:none">
              <?php $this->renderPartial('_search',array(
              'model'=>$model,
              )); ?>
              </div><!-- search-form --> */
            ?>				
        </div>
    </div>

    <div class="grid-view">
        <?php $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'service-pricelist-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'columns' => array(
                'service.name: Service',
                'service.serviceType.name: Type',
                'service.serviceCategory.name: Category',
                'serviceGroup.name: Group',
                array(
                    'name' => 'standard_flat_rate_per_hour',
                    'header' => 'Flat Rate /hour',
                    'filter' => false,
                    'value' => 'number_format($data->standard_flat_rate_per_hour, 0)',
                ),
                array(
                    'name' => 'flat_rate_hour',
                    'header' => 'Flat Rate Hour',
                    'filter' => false,
                    'value' => 'number_format($data->flat_rate_hour, 0)',
                ),
//                'flat_rate_hour',
                array(
                    'name' => 'price',
                    'filter' => false,
                    'value' => 'number_format($data->price, 0)',
                ),
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{edit}',
                    'buttons' => array(
                        'edit' => array(
                            'label' => 'edit',
                            'visible' => '(Yii::app()->user->checkAccess("master.servicePricelist.update"))',
                            'url' => 'Yii::app()->createUrl("master/servicePricelist/update",array("id"=>$data->id))',
                        ),
                    ),
                ),
            ),
        )); ?>
    </div>
</div>

<?php Yii::app()->clientScript->registerScript('search', "
    $('#ServicePricelist_findkeyword').keypress(function(e) {
        if (e.which == 13) {
            $.fn.yiiGridView.update('service-pricelist-grid', {
                data: $(this).serialize()
            });
            return false;
        }
    });

    $('#ServicePricelist_service_id, #ServicePricelist_service_type_code, #ServicePricelist_service_category_code').change(function(){
        $.fn.yiiGridView.update('service-pricelist-grid', {
            data: $(this).serialize()
        });
        return false;
    });
"); ?>