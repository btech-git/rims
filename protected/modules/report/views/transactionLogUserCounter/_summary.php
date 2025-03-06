<?php Yii::app()->clientScript->registerCss('_report', '
    .width1-1 { width: 5% }
    .width1-2 { width: 5% }
'); ?>

<div style="font-weight: bold; text-align: center">
    <div style="font-size: larger">User Performance Report</div>
    <div><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' &nbsp;&ndash;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
</div>

<br />

<table class="report">
    <thead style="position: sticky; top: 0">
        <tr id="header1">
            <th class="width1-1"></th>
            <?php foreach ($controllerClasses as $controllerClass): ?>
                <?php $formattedControllerClassPart1 = preg_replace('/^.+\//', '', $controllerClass); ?>
                <?php $formattedControllerClassPart2 = preg_replace('/^transaction/', '', $formattedControllerClassPart1); ?>
                <?php $formattedControllerClassPart3 = preg_replace('/Header$/', '', $formattedControllerClassPart2); ?>
                <?php $formattedControllerClass = ucfirst(preg_replace('/[A-Z]/', ' $0', $formattedControllerClassPart3)); ?>
                <th class="width1-2"><?php echo CHtml::encode($formattedControllerClass); ?></th>
            <?php endforeach; ?>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($userCounterData as $userCounterDataItem): ?>
            <tr class="items1">
                <td class="width1-1"><?php echo CHtml::encode($userCounterDataItem['username']); ?></td>
                <?php foreach ($controllerClasses as $controllerClass): ?>
                    <td class="width1-2">
                        <?php if (isset($userCounterDataItem[$controllerClass])): ?>
                            <?php foreach ($userCounterDataItem[$controllerClass] as $actionType => $userCounter): ?>
                                <?php echo $actionType; ?>: <?php echo $userCounter; ?><br />
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </td>
                <?php endforeach; ?>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>
