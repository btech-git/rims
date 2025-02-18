<h1>List Asuransi</h1>
   
<div id="link">
    <?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage Payment In', Yii::app()->baseUrl.'/transaction/paymentIn/admin' , array(
        'class'=>'button cbutton',
    )); ?>
</div>

<?php $this->widget('zii.widgets.grid.CGridView', array(
    'id' => 'insurance-company-grid',
    'dataProvider' => $insuranceCompanyDataProvider,
    'filter' => $insuranceCompany,
    'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
    'pager' => array(
        'cssFile' => false,
        'header' => '',
    ),
    'columns' => array(
        array(
            'name' => 'name',
            'value' => '$data->name',
        ),
        array(
            'name' => 'coa_id',
            'header' => 'COA Piutang',
            'value' => 'empty($data->coa_id) ? "" : $data->coa->name',
        ),
        'email',
        array(
            'header' => '',
            'type' => 'raw',
            'value' => 'CHtml::link("create", array("createMultiple", "customerId" => "", "insuranceId" => $data->id))',
            'htmlOptions' => array(
                'style' => 'text-align: center;'
            ),
        ),
    ),
)); ?>