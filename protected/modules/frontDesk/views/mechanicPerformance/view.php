<?php
/* @var $this RegistrationTransactionController */
/* @var $model RegistrationTransaction */

$this->breadcrumbs = array(
    'Mechanic Performance' => array('index'),
    'Manage',
);

?>

<div id="maincontent">
    <div class="clearfix page-action">
        <h1>Mechanic History</h1>
        <div>
            <span style="text-align: center"><h3>Employee Information</h3></span>
            
            <table>
                <tr>
                    <td>Name: <?php echo CHtml::encode(CHtml::value($employee, 'name')); ?></td>
                    <td>Skills: <?php echo CHtml::encode(CHtml::value($employee, 'skills')); ?></td>
                </tr>
                <tr>
                    <td>Email: <?php echo CHtml::encode(CHtml::value($employee, 'email')); ?></td>
                    <td>Position: <?php echo CHtml::encode(CHtml::value($employeeBranchDivisionPositionLevel, 'position.name')); ?></td>
                </tr>
                <tr>
                    <td>Address : <?php echo CHtml::encode(CHtml::value($employee, 'local_address')); ?></td>
                    <td>Division: <?php echo CHtml::encode(CHtml::value($employeeBranchDivisionPositionLevel, 'division.name')); ?></td>
                </tr>
                <tr>
                    <td>Branch: <?php echo CHtml::encode(CHtml::value($employeeBranchDivisionPositionLevel, 'branch.name')); ?></td>
                    <td>Level: <?php echo CHtml::encode(CHtml::value($employeeBranchDivisionPositionLevel, 'level.name')); ?></td>
                </tr>
            </table>
        </div>
        
        <br />
        
        <div>
            <span style="text-align: center"><h3>Service History</h3></span>
            <table>
                <thead>
                    <th>WO #</th>
                    <th>Date</th>
                    <th>Repair Type</th>
                    <th>Problem</th>
                    <th>Customer</th>
                    <th>Vehicle</th>
                    <th>Service</th>
                    <th>Service Type</th>
                    <th>Time</th>
                </thead>

                <tgeneral>
                    <?php $counter = 1; ?>
                    <?php foreach (array_reverse($registrationServices) as $i => $registrationService): ?>
                        <?php if ($counter < 50): ?>
                            <tr>
                                <?php $registrationTransaction = $registrationService->registrationTransaction; ?>
                                <?php $totalTime = CHtml::value($registrationService, 'total_time'); ?>
                                <?php $formattedTime = sprintf('%02d:%02d:%02d', ($totalTime/ 3600),($totalTime/ 60 % 60), $totalTime% 60); ?>
                                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'work_order_number')); ?></td>
                                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($registrationTransaction, 'work_order_date'))); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'repair_type')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'problem')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'customer.name')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'vehicle.plate_number')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($registrationService, 'service.name')); ?></td>
                                <td><?php echo CHtml::encode(CHtml::value($registrationService, 'serviceType.name')); ?></td>
                                <td><?php echo CHtml::encode($formattedTime); ?></td>
                            </tr>
                            <?php $counter++; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </tgeneral>
            </table>
        </div>
    </div>
</div>