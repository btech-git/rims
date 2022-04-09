<div class="row">
    <div class="large-12 columns">
        <h3>Mechanics</h3>
        <hr/>
        <?php 
        $criteria = new CDbCriteria();
        $criteria->addCondition("t.branch_id IN (SELECT branch_id FROM " . UserBranch::model()->tableName() . " WHERE users_id = :userId)");
        $criteria->params = array(':userId' => Yii::app()->user->id);
        ?>
        <?php $employees = Employee::model()->findAll($criteria); ?>

        <div class="row">
            <div class="large-12 columns">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Availability</th>
                            <th>Skill</th>
                            <th>Work Order Number</th>
                            <th>Plate Number</th>
                            <th>Branch</th>
                        </tr>
                    </thead>
                    
                    <tbody>
                        <?php foreach ($employees as $key => $employee): ?>
                            <tr>
                                <td><?php echo $employee->name; ?></td>
                                <td><?php echo $employee->availability; ?></td>
                                <td><?php echo $employee->skills; ?></td>
                                <td>
                                    <ul style="margin-bottom: 0 !important; list-style: none;">
                                        <?php
                                        foreach (RegistrationServiceEmployee::model()->findAllByAttributes(array('employee_id' => $employee->id)) as $key => $value) {
                                            echo "<li>" . $value->registrationService->registrationTransaction->work_order_number . "</li>";
                                        }
                                        ?>
                                    </ul>
                                </td>
                                <td>
                                    <ul style="margin-bottom: 0 !important; list-style: none;">
                                        <?php
                                        foreach (RegistrationServiceEmployee::model()->findAllByAttributes(array('employee_id' => $employee->id)) as $key => $value) {
                                            echo "<li>" . $value->registrationService->registrationTransaction->vehicle->plate_number . "</li>";
                                        }
                                        ?>
                                    </ul>
                                </td>
                                <td><?php echo empty($employee->branch->name) ? 'Branch Inactive' : $employee->branch->name; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>