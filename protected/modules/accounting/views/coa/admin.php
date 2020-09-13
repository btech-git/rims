<?php
/* @var $this CoaController */
/* @var $model Coa */

$this->breadcrumbs = array(
    'Coas' => array('index'),
    'Manage',
);

/* $this->menu=array(
  array('label'=>'List Coa', 'url'=>array('index')),
  array('label'=>'Create Coa', 'url'=>array('create')),
  ); */

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
	$('#coa-grid').yiiGridView('update', {
		data: $(this).serialize()
	});
	return false;
});
");
?>

<!--<h1>Manage Coas</h1>-->


<div id="maincontent">
    <div class="row">
        <div class="small-12 columns">
            <div class="clearfix page-action">
                <?php echo CHtml::link('<span class="fa fa-plus"></span>Create COA', Yii::app()->baseUrl . '/accounting/coa/create', array('class' => 'button success right', 'visible' => Yii::app()->user->checkAccess("accounting.coa.create"))) ?>
                <?php echo CHtml::link('<span class="fa fa-plus"></span>View COA', Yii::app()->baseUrl . '/accounting/coa/viewCoa', array('class' => 'button success right', 'visible' => Yii::app()->user->checkAccess("accounting.coa.viewCoa"))) ?>
                <?php
                echo CHtml::button('CUT OFF', array(
                    'id' => 'invoice-button',
                    'name' => 'Invoice',
                    'class' => 'button cbutton right',
                    'style' => 'margin-right:10px',
                    'onclick' => ' 
						$.ajax({
						type: "POST",
						//dataType: "JSON",
						url: "' . CController::createUrl('cutOff') . '",
						data: $("form").serialize(),
						success: function(html) {
							
							alert("Cut Off Success");
							location.reload();
						},})
				'
                ));
                ?>
                <h2>Manage Coas</h2>
            </div>

            <div class="search-bar">
                <div class="clearfix button-bar">
                    <!--<div class="left clearfix bulk-action">
                    <span class="checkbox"><span class="fa fa-reply fa-rotate-270"></span></span>
                    <input type="submit" value="Archive" class="button secondary cbutton" name="archive">         
                    <input type="submit" value="Delete" class="button secondary cbutton" name="delete">      
            </div>-->
                        <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button right button cbutton secondary')); ?>					<div class="clearfix"></div>
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
                    'id' => 'coa-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    // 'summaryText'=>'',
                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        'id',
                        array(
                            'name' => 'name', 
                            'value' => 'CHTml::link($data->name, array("view", "id"=>$data->id))', 
                            'type' => 'raw'
                        ),
                        'code',
                        array(
                            'name' => 'coa_category_id',
                            'filter' => CHtml::activeDropDownList($model, 'coa_category_id', CHtml::listData(CoaCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                            'value' => '$data->coaCategory!="" ?$data->coaCategory->name:""',
                        ),
                        array(
                            'name' => 'coa_sub_category_id',
                            'filter' => CHtml::activeDropDownList($model, 'coa_sub_category_id', CHtml::listData(CoaSubCategory::model()->findAll(array('order' => 'name')), 'id', 'name'), array('empty' => '-- All --')),
                            'value' => '$data->coaSubCategory!="" ?$data->coaSubCategory->name:""'
                        ),
                        'normal_balance',
                        'opening_balance',
                        array(
                            'class' => 'CButtonColumn',
                            'template' => '{edit} {update opening balance}',
                            'buttons' => array
                                (
                                'edit' => array(
                                    'label' => 'edit',
                                    // 'visible'=>'($data->is_deleted == 0)? TRUE:FALSE',
                                    'visible' => '(Yii::app()->user->checkAccess("accounting.coa.update"))',
                                    'url' => 'Yii::app()->createUrl("accounting/coa/update",array("id"=>$data->id))',
                                ),
                                'update opening balance' => array(
                                    'label' => 'update opening balance',
                                    //'visible'=>'$data->opening_balance == ""',
                                    //'visible'=>'(Yii::app()->user->checkAccess("accounting.coa.updateBalance"))',
                                    'url' => 'Yii::app()->createUrl("accounting/coa/ajaxHtmlUpdate",array("id"=>$data->id))', 'options' => array(
                                        'ajax' => array(
                                            'type' => 'POST',
                                            // ajax post will use 'url' specified above 
                                            'url' => 'js: $(this).attr("href")',
                                            'success' => 'function(html) {
                                        $("#coa_div").html(html);
                                        $("#coa-dialog").dialog("open");
                                   }',
                                        ),
                                    ),
                                ),
                            ),
                        ),
                    )
                ));
                ?>
            </div>
        </div>
    </div> <!-- end row -->
</div> <!-- end maintenance -->
<!--Level Dialog -->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'coa-dialog',
    'options' => array(
        'title' => 'Coa',
        'autoOpen' => false,
        'modal' => true,
        'width' => '450',
    ),
));
?>

<div id="coa_div"></div>
<?php $this->endWidget(); ?>
