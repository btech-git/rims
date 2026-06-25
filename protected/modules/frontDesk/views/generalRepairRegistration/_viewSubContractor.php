<?php $workOrderExpenseHeaders = WorkOrderExpenseHeader::model()->findAllByAttributes(array('registration_transaction_id'=>$model->id), array(
    'order' => 't.id ASC', 
    'limit' => 50
)); ?>
<div class="detail">
    <?php if (count($workOrderExpenseHeaders) > 0): ?>
        <table>
            <thead>
                <tr>
                    <th>Sub Pekerjaan #</th>
                    <th>Tanggal</th>
                    <th>Supplier</th>
                    <th>Catatan</th>
                    <th>Deskripsi</th>
                    <th>Memo</th>
                    <th>Total</th>
                </tr>
            </thead>

            <tbody>
                <?php foreach ($workOrderExpenseHeaders as $i => $header): ?>
                    <?php foreach ($header->workOrderExpenseDetails as $detail): ?>
                        <tr>
                            <td>
                                <?php echo CHtml::link($header->transaction_number, array(
                                    "/accounting/workOrderExpense/show", 
                                    "id"=>$header->id
                                ), array('target' => '_blank')); ?>
                            </td>
                            <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", $header->transaction_date)); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($header, 'supplier.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($header, 'note')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($detail, 'description')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($detail, 'memo')); ?></td>
                            <td style="text-align: right">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', CHtml::value($detail, 'amount'))); ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <?php echo "NO Sub Pekerjaan Luar"; ?>
    <?php endif; ?>
</div>