<?php
$this->breadcrumbs = array(
    UserModule::t('Users') => array('/user'),
    UserModule::t('Manage'),
);

$this->menu = array(
    array('label' => UserModule::t('Create User'), 'url' => array('create')),
    array('label' => UserModule::t('Manage Users'), 'url' => array('admin')),
    array('label' => UserModule::t('Manage Profile Field'), 'url' => array('profileField/admin')),
    array('label' => UserModule::t('List User'), 'url' => array('/user')),
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
    $.fn.yiiGridView.update('user-grid', {
        data: $(this).serialize()
    });
    return false;
});
");
?>

<!-- <h1>Manage Banks</h1> -->
<div id="maincontent">
    <div class="row">
        <div class="small-12 columns">
            <div class="clearfix page-action">
                <div class="button-group right">
<!--                    <a class="button success" href="<?php //echo Yii::app()->baseUrl.'/user/profileField/admin'; ?>"><span class="fa fa-plus"></span>Manage Profile Fields</a>&nbsp;
                    <a class="button success" href="<?php //echo Yii::app()->baseUrl.'/rights'; ?>"><span class="fa fa-plus"></span>Manage Access Control</a>-->
                    <a class="button cbutton alert right" style="margin-right:10px;" href="<?php echo Yii::app()->baseUrl . '/user/admin/adminResigned'; ?>">
                        <span class="fa fa-ban"></span>Inactive Users
                    </a>&nbsp;
                    <a class="button cbutton success right" href="<?php echo Yii::app()->baseUrl . '/user/admin/create'; ?>"><span class="fa fa-plus"></span>New User</a>
                </div>
                <h2>Manage Users</h2>
            </div>

            <div class="search-bar">
                <div class="clearfix button-bar">
                    <a href="#" class="search-button right button cbutton secondary">Advanced Search</a>
                    <div class="clearfix"></div>
                    <div class="search-form" style="display:none">
                        <?php $this->renderPartial('_search', array(
                            'model' => $model,
                        )); ?>
                    </div><!-- search-form -->
                </div>
            </div>

            <div class="grid-view">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
                    'id' => 'user-grid',
                    'dataProvider' => $model->search(),
                    'filter' => $model,
                    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                    'pager' => array(
                        'cssFile' => false,
                        'header' => '',
                    ),
                    'columns' => array(
                        array(
                            'name' => 'id',
                            'type' => 'raw',
                            'value' => 'CHtml::link(CHtml::encode($data->id),array("admin/update","id"=>$data->id))',
                        ),
                        array(
                            'name' => 'username',
                            'type' => 'raw',
                            'value' => 'CHtml::link(UHtml::markSearch($data,"username"),array("admin/view","id"=>$data->id))',
                        ),
                        array(
                            'name' => 'email',
                            'type' => 'raw',
                            'value' => 'CHtml::link(UHtml::markSearch($data,"email"), "mailto:".$data->email)',
                        ),
                        'create_at',
                        'lastvisit_at',
                        'employee.name',
//                        array(
//                            'name' => 'superuser',
//                            'value' => 'User::itemAlias("AdminStatus",$data->superuser)',
//                            'filter' => User::itemAlias("AdminStatus"),
//                        ),
                        array(
                            'name' => 'status',
                            'value' => 'User::itemAlias("UserStatus",$data->status)',
                            'filter' => User::itemAlias("UserStatus"),
                        ),
                        array(
                            'class' => 'CButtonColumn',
                            'template' => '{edit} {delete}',
                            'buttons' => array(
                                'edit' => array(
                                    'label' => 'edit',
                                    'url' => 'Yii::app()->createUrl("user/admin/update",array("id"=>$data->id))',
                                    'visible' => 'Yii::app()->user->checkAccess("masterUserEdit")'
                                ),
                            ),
                        ),
                    ),
                )); ?>
            </div>
        </div>
    </div>
</div>
