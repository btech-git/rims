<h1>Kelola Data Kas Harian</h1>

<div id="link">
    <?php echo CHtml::link('<span class="fa fa-plus"></span>Kas Harian Approval', Yii::app()->baseUrl . '/accounting/cashDailySummary/summary', array(
        'class' => 'button success right',
        'visible' => Yii::app()->user->checkAccess("accounting.cashDaily.report")
    )); ?>
</div>

<br /><br /><br />

<?php if (Yii::app()->user->hasFlash('message')): ?>
    <div class="flash-success">
        <?php echo Yii::app()->user->getFlash('message'); ?>
    </div>
<?php endif; ?>

<?php echo CHtml::beginForm(array(''), 'get'); ?>

<div class="row">
    <div class="medium-12 columns">
        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <span class="prefix">Periode </span>
                </div>
                
                <div class="small-4 columns">
                    <?php echo CHtml::dropDownList('Month', $month, array(
                        '1' => 'Jan',
                        '2' => 'Feb',
                        '3' => 'Mar',
                        '4' => 'Apr',
                        '5' => 'May',
                        '6' => 'Jun',
                        '7' => 'Jul',
                        '8' => 'Aug',
                        '9' => 'Sep',
                        '10' => 'Oct',
                        '11' => 'Nov',
                        '12' => 'Dec',
                    )); ?>
                </div>
                
                <div class="small-4 columns">
                    <?php echo CHtml::dropDownList('Year', $year, $yearList); ?>

                </div>
            </div>
        </div>
    </div>
</div>

<div style="text-align: center">
    <?php echo CHtml::submitButton('Submit'); ?>
</div>

<br /><br />

<div>
    <table>
        <thead>
            <tr>
                <th>Tanggal Transaksi</th>
                <th>Hari Transaksi</th>
                <th>Amount</th>
                <th>Approved By</th>
                <th>Tanggal Approval</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($approvals as $approval): ?>
                <tr>
                    <td><?php echo CHtml::encode(CHtml::value($approval, 'transaction_date')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($approval, 'transaction_day_of_week')); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', CHtml::value($approval, 'amount'))); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($approval, 'username')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($approval, 'approval_date')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php echo CHtml::endForm(); ?>