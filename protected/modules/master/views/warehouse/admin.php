<?php
/* @var $this WarehouseController */
/* @var $model Warehouse */

$this->breadcrumbs = array(
    'Warehouse' => array('admin'),
    'Warehouses' => array('admin'),
    'Manage Warehouses',
);

$this->menu = array(
    array('label' => 'List Warehouse', 'url' => array('index')),
    array('label' => 'Create Warehouse', 'url' => array('create')),
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
	$('#warehouse-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php if (Yii::app()->user->checkAccess("masterWarehouseCreate")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/warehouse/create'; ?>" data-reveal-id="warehouse"><span class="fa fa-plus"></span>New Warehouse</a>
        <?php } ?>
        <h1>Manage Warehouses</h1>
        <!-- begin pop up -->
        <!--<div id="warehouse" class="reveal-modal" data-reveal aria-labelledby="modalTitle" aria-hidden="true" role="dialog">
                <div class="small-12 columns">
                        <div id="maincontent">
                                <div class="clearfix page-action">
                                        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/warehouse/admin'; ?>"><span class="fa fa-th-list"></span>Manage Warehouse</a>
                                        <h1>New Warehouse</h1>
                                                <div class="form">

                                                   <form method="post" action="" id="popup-form">   <hr>
                                                   <p class="note">Fields with <span class="required">*</span> are required.</p>

                                                   
                                                   <div class="row">
                                                      <div class="small-12 medium-6 columns">

                                                         <div class="field">
                                                            <div class="row collapse">
                                                               <div class="small-4 columns">
                                                                  <label class="prefix">Code</label>
                                                                </div>
                                                               <div class="small-8 columns">
                                                                  <input type="text" maxlength="100" size="60" disabled="true">                                 
                                                                </div>
                                                            </div>
                                                         </div>

                                                         <div class="field">
                                                            <div class="row collapse">
                                                               <div class="small-4 columns">
                                                                  <label class="prefix">Name</label>
                                                                </div>
                                                               <div class="small-8 columns">
                                                                  <input type="text" maxlength="100" size="60">                                 
                                                                </div>
                                                            </div>
                                                         </div>

                                                                        <div class="field">
                                                                                <div class="row collapse">
                                                                                        <div class="small-4 columns">
                                                                                                <label class="prefix">Status</label>
                                                                                        </div>
                                                                                        <div class="small-8 columns">
                                                                                                <select>
                                                                                                        <option selected="selected" value="1">Active</option>
                                                                                                        <option value="-1">Inactive</option>
                                                                                                </select>                                 
                                                                                        </div>
                                                                                </div>
                                                                        </div>

                                                      </div>
                                                   </div>

                                                   <hr>

                                                   <div class="field buttons text-center">
                                                      <input type="button" value="Create" name="yt0" class="button cbutton">  
                                                    </div>

                                                   </form>
                                                </div>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>-->
        <!-- end pop up -->

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


        <?php
        $this->widget('zii.widgets.grid.CGridView', array(
            'id' => 'warehouse-grid',
            'dataProvider' => $model->search(),
            'filter' => $model,
            // 'summaryText' => '',
            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
            'pager' => array(
                'cssFile' => false,
                'header' => '',
            ),
            'columns' => array(
                array(
                    'class' => 'CCheckBoxColumn',
                    'selectableRows' => '2',
                    'header' => 'Selected',
                    'value' => '$data->id',
                ),
                //'code',
                array('name' => 'name', 'value' => 'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type' => 'raw'),
                //'description',
                array(
                    'header' => 'Status',
                    'name' => 'status',
                    'value' => '$data->status',
                    'type' => 'raw',
                    'filter' => CHtml::dropDownList('Warehouse[status]', 'warehouse_status', array(
                        '' => 'Select',
                        'Active' => 'Active',
                        'Inactive' => 'Inactive',
                            )
                    ),
                ),
                array(
                    'class' => 'CButtonColumn',
                    'template' => '{edit}',
                    'buttons' => array
                        (
                        'edit' => array
                            (
                            'label' => 'edit',
                            'url' => 'Yii::app()->createUrl("master/warehouse/update", array("id"=>$data->id))',
                            'visible' => '(Yii::app()->user->checkAccess("masterWarehouseEdit"))'
                        ),
                    ),
                ),
            ),
        ));
        ?>
    </div>
</div>
<!-- end maincontent -->