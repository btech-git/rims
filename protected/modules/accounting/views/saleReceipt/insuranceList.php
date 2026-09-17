<h1>List Customer</h1>
   
<div id="link">
    <?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage', Yii::app()->baseUrl.'/accounting/saleReceipt/admin' , array(
        'class'=>'button cbutton',
    )); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'customer-grid',
    'dataProvider' => $insuranceCompanyDataProvider,
    'filter' => $insuranceCompany,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'columns' => array(
        'id',
        array(
            'name' => 'name',
            'value' => '$data->name',
        ),
        'email',
        'phone',
        array(
            'header' => 'COA',
            'name' => 'coa_id',
            'value' => '$data->coa->name',
        ),
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("create", array("create", "customerId" => "", "insuranceId" => $data->id))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
)); ?>