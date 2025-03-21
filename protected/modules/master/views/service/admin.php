<?php
/* @var $this ServiceController */
/* @var $model Service */

$this->breadcrumbs = array(
    'Service' => Yii::app()->baseUrl . '/master/service/admin',
    'Service' => array('admin'),
    'Manage Service',
);

$this->menu = array(
    array('label' => 'List Service', 'url' => array('index')),
    array('label' => 'Create Service', 'url' => array('create')),
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
    $('.search-form form').submit(function(){
            $('#service-grid').yiiGridView('update', {
                    data: $(this).serialize()
            });
            return false;
    });
"); ?>


<div id="maincontent">
    <div class="clearfix page-action">
        <?php if (Yii::app()->user->checkAccess("masterServiceCreate")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/service/create'; ?>" data-reveal-id="color"><span class="fa fa-plus"></span>New Service</a>
        <?php } ?>
        <h1>Manage Services</h1>

        <div class="search-bar">
            <div class="clearfix button-bar">
                <!--<div class="left clearfix bulk-action">
                        <span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
                        <input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
                        <input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
                </div>-->
                <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
                <div class="clearfix"></div>
                <div class="search-form" style="display:none">
                    <?php
                    $this->renderPartial('_search', array(
                        'model' => $model,
                    ));
                    ?>
                </div><!-- search-form -->				
            </div>
        </div>

        <div class="grid-view">

            <?php
            $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'service-grid',
                'dataProvider' => $model->search(),
                'filter' => null,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom:1.25rem">{items}</div><div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'rowCssClassExpression' => '($data->is_deleted == 1)?"undelete":""',
                'columns' => array(
                    //'id',
                    array(
                        'class' => 'CCheckBoxColumn',
                        'selectableRows' => '2',
                        'header' => 'Selected',
                        'value' => '$data->id',
                    ),
                    array('name' => 'service_type_code', 'value' => '$data->serviceType->code'),
                    array(
                        'name' => 'service_type_name',
//                        'filter' => CHtml::activeDropDownList($model, 'service_type_id', CHtml::listData(ServiceType::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                        'value' => '$data->serviceType->name'
                    ),
                    array('name' => 'service_category_code', 'value' => '$data->serviceCategory->code'),
                    array(
                        'name' => 'service_category_name',
//                        'filter' => CHtml::activeDropDownList($model, 'service_category_id', CHtml::listData(ServiceCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                        'value' => '$data->serviceCategory->name'
                    ),
                    'code',
                    array(
                        'name' => 'name', 
                        'value' => 'CHTml::link($data->name, array("view", "id"=>$data->id))', 
                        'type' => 'raw'
                    ),
                    'description',
                    array(
                        'header' => 'Status',
                        'name' => 'status',
                        'value' => '$data->status',
                        'type' => 'raw',
//                        'filter' => CHtml::dropDownList('Service[status]', $model->status, array(
//                            '' => 'All',
//                            'Active' => 'Active',
//                            'Inactive' => 'Inactive',
//                        )),
                    ),
                    array('name'=>'user_id', 'value'=>'$data->user->username'),
                    array(
                        'header' => 'Input', 
                        'value' => '$data->created_datetime', 
                    ),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{edit} {hapus} {restore}',
                        'buttons' => array
                            (
                            'edit' => array(
                                'label' => 'edit',
                                // 'visible'=>'($data->is_deleted == 0)? TRUE:FALSE',
                                'visible' => '(Yii::app()->user->checkAccess("masterServiceEdit"))',
                                'url' => 'Yii::app()->createUrl("master/service/update",array("id"=>$data->id))',
                            ),
                            'hapus' => array(
                                'label' => 'delete',
                                'visible' => '($data->is_deleted == 0)? TRUE:FALSE',
                                'url' => 'Yii::app()->createUrl("master/service/delete", array("id" => $data->id))',
                                'options' => array(
                                    // 'class'=>'btn red delete',
                                    'onclick' => 'return confirm("Are you sure want to delete this equipments?");',
                                )
                            ),
                            'restore' => array(
                                'label' => 'UNDELETE',
                                'visible' => '($data->is_deleted == 1)? TRUE:FALSE',
                                'url' => 'Yii::app()->createUrl("master/service/restore", array("id" => $data->id))',
                                'options' => array(
                                    // 'class'=>'btn red delete',
                                    'onclick' => 'return confirm("Are you sure want to undelete this Service?");',
                                )
                            ),
                        ),
                    ),
                ),
            ));
            ?>
        </div>
    </div>
</div>

