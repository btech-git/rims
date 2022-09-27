<div>
    <h1>Mechanic Data</h1>
    <table>
        <tr>
            <td>Name: <?php echo CHtml::encode(CHtml::value($employee, 'name')); ?></td>
            <td>Division : <?php echo CHtml::encode(CHtml::value($employeeBranchDivisionPositionLevel, 'division.name')); ?></td>
        </tr>
        <tr>
            <td>ID #: <?php echo CHtml::encode(CHtml::value($employee, 'id_card')); ?></td>
            <td>Position: <?php echo CHtml::encode(CHtml::value($employeeBranchDivisionPositionLevel, 'position.name')); ?></td>
        </tr>
        <tr>
            <td>Branch: <?php echo CHtml::encode(CHtml::value($employeeBranchDivisionPositionLevel, 'branch.name')); ?></td>
            <td>Level: <?php echo CHtml::encode(CHtml::value($employeeBranchDivisionPositionLevel, 'level.name')); ?></td>
        </tr>
    </table>
</div>
<div>
    <h2>Details</h2>
    <div>
        <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => array(
                'History' => array(
                    'content' => $this->renderPartial('_viewEmployeeHistory', array(
                        'registrationBodyRepairHistoryDataProvider' => $registrationBodyRepairHistoryDataProvider,
                    ), true ),
                ),
//                'Assignments' => array(
//                    'content' => $this->renderPartial('_viewEmployeeAssignment', array(
//                        'registrationBodyRepairAssignmentDataProvider' => $registrationBodyRepairAssignmentDataProvider,
//                    ), true),
//                ),
            ),
            // additional javascript options for the tabs plugin
            'options' => array(
                'collapsible' => true,
            ),
            // set id for this widgets
            'id' => 'view_employee_detail',
        )); ?>
    </div>
</div>