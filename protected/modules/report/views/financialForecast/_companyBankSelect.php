<?php echo CHtml::dropDownList('CoaId', $coaId, CHtml::listData(CompanyBank::model()->findAllByAttributes(array('company_id' => $companyId)), 'coa_id', 'account_name'), array(
    'empty' => '-- All Bank --',
    'order' => 'name',
)); ?>
<?php echo CHtml::hiddenField('CompanyBank', ''); ?>