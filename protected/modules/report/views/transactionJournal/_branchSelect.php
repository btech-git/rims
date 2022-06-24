<div class="field">
    <div class="row collapse">
        <div class="small-4 columns">
            <span class="prefix">Branch </span>
        </div>

        <div class="small-8 columns">
            <?php $branchList = empty($companyId) ? Branch::model()->findAllByAttributes(array('status' => 'Active')) : Branch::model()->findAllByAttributes(array('status' => 'Active', 'company_id' => $companyId)); ?>
            <?php echo CHtml::dropDownlist('BranchId', $branchId, CHtml::listData($branchList, 'id', 'name'), array('empty' => '-- All Branch --')); ?>
        </div>
    </div>
</div>