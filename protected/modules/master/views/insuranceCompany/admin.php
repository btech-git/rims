<?php
/* @var $this InsuranceCompanyController */
/* @var $model InsuranceCompany */

$this->breadcrumbs = array(
    'Company',
    'Insurance Companies' => array('admin'),
    'Manage',
);

$this->menu = array(
    array('label' => 'List InsuranceCompany', 'url' => array('index')),
    array('label' => 'Create InsuranceCompany', 'url' => array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').slideToggle(600);
    $('.bulk-action').toggle();
    $(this).toggleClass('active');
    if ($(this).hasClass('active')) {
        $(this).text('');
    } else {
        $(this).text('Advanced Search');
    }
    return false;
});

$('.search-form form').submit(function(){
    $('#insurance-company-grid').yiiGridView('update', {
        data: $(this).serialize()
    });
    return false;
});
");
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php if (Yii::app()->user->checkAccess("masterInsuranceCreate")) { ?>
            <a class="button success right" href="<?php echo Yii::app()->baseUrl . '/master/insuranceCompany/create'; ?>"><span class="fa fa-plus"></span>New  Insurance Company</a>
        <?php } ?>
        <h1>Manage Insurance Company</h1>
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

            <?php $this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'insurance-company-grid',
                'dataProvider' => $model->search(),
                'filter' => $model,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                'rowCssClassExpression' => '($data->is_deleted == 1)?"undelete":""',
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
                    array('name' => 'name', 'value' => 'CHTml::link($data->name, array("view", "id"=>$data->id))', 'type' => 'raw'),
                    'address',
                    array(
                        'header' => 'Province Name',
                        'name' => 'province_name',
                        'value' => '$data->province->name'),
                    array(
                        'header' => 'City Name',
                        'name' => 'city_name',
                        'value' => '$data->city->name'
                    ),
                    'email',
                    array('name' => 'coa_name', 'value' => '$data->coa!="" ? $data->coa->name : ""'),
                    array('name' => 'coa_code', 'value' => '$data->coa!="" ? $data->coa->code : ""'),
                    array(
                        'class' => 'CButtonColumn',
                        'template' => '{price} {edit} {hapus} {restore}',
                        'buttons' => array(
                            'price' => array(
                                'label' => 'price',
                                'url' => 'Yii::app()->createUrl("master/insuranceCompany/ajaxHtmlPrice", array("id"=>$data->id))',
                                'options' => array(
                                    'ajax' => array(
                                        'type' => 'POST',
                                        // ajax post will use 'url' specified above 
                                        'url' => 'js: $(this).attr("href")',
                                        'success' => 'function(html) {
                                                $("#price_div").html(html);
                                                $("#price-dialog").dialog("open");
                                        }',
                                    ),
                                ),
                            ),
                            'edit' => array(
                                'label' => 'edit',
                                'visible' => '(Yii::app()->user->checkAccess("masterInsuranceEdit"))',
                                'url' => 'Yii::app()->createUrl("master/insuranceCompany/update",array("id"=>$data->id))',
                            ),
                            'hapus' => array(
                                'label' => 'delete',
                                'visible' => '($data->is_deleted == 0)? TRUE:FALSE',
                                'url' => 'Yii::app()->createUrl("master/insuranceCompany/delete", array("id" => $data->id))',
                                'options' => array(
                                    // 'class'=>'btn red delete',
                                    'onclick' => 'return confirm("Are you sure want to delete this Insurance Company?");',
                                )
                            ),
                            'restore' => array(
                                'label' => 'UNDELETE',
                                'visible' => '($data->is_deleted == 1)? TRUE:FALSE',
                                'url' => 'Yii::app()->createUrl("master/insuranceCompany/restore", array("id" => $data->id))',
                                'options' => array(
                                    // 'class'=>'btn red delete',
                                    'onclick' => 'return confirm("Are you sure want to undelete this Insurance Company?");',
                                )
                            ),
                        ),
                    ),
                ),
            )); ?>
        </div>
    </div>
</div>

<!--Price Dialog -->
<?php$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'price-dialog',
    'options' => array(
        'title' => 'Price List',
        'autoOpen' => false,
        'modal' => true,
        'width' => '480',
    ),
)); ?>

<div id="price_div"></div>

<?php $this->endWidget(); ?>