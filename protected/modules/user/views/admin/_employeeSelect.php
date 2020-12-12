<div id="employee_list">
    <?php echo CHtml::activeDropDownList($model, 'employee_id', CHtml::listData($employees, 'id', 'name'), array('empty' => '-- Pilih Employee --')); ?>
</div>