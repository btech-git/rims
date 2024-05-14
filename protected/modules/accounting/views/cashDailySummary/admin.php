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
                <div class="small-2 columns">
                    <span class="prefix">Periode</span>
                </div>
                
                <div class="small-2 columns">
                    <?php echo CHtml::dropDownList('MonthStart', $monthStart, array(
                        '01' => 'Jan',
                        '02' => 'Feb',
                        '03' => 'Mar',
                        '04' => 'Apr',
                        '05' => 'May',
                        '06' => 'Jun',
                        '07' => 'Jul',
                        '08' => 'Aug',
                        '09' => 'Sep',
                        '10' => 'Oct',
                        '11' => 'Nov',
                        '12' => 'Dec',
                    )); ?>
                </div>
                
                <div class="small-2 columns">
                    <?php echo CHtml::dropDownList('YearStart', $yearStart, $yearList); ?>
                </div>
                
                <div class="small-2 columns">
                    <span class="prefix">Sampai</span>
                </div>
                
                <div class="small-2 columns">
                    <?php echo CHtml::dropDownList('MonthEnd', $monthEnd, array(
                        '01' => 'Jan',
                        '02' => 'Feb',
                        '03' => 'Mar',
                        '04' => 'Apr',
                        '05' => 'May',
                        '06' => 'Jun',
                        '07' => 'Jul',
                        '08' => 'Aug',
                        '09' => 'Sep',
                        '10' => 'Oct',
                        '11' => 'Nov',
                        '12' => 'Dec',
                    )); ?>
                </div>
                
                <div class="small-2 columns">
                    <?php echo CHtml::dropDownList('YearEnd', $yearEnd, $yearList); ?>
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
        <thead style="position: sticky; top: 0">
            <tr>
                <th>Tanggal Transaksi</th>
                <th>Hari Transaksi</th>
                <th>Approved By</th>
                <th>Tanggal Approval</th>
                <th>Amount</th>
            </tr>
        </thead>
        
        <tbody>
            <?php $total = 0; ?>
            <?php foreach ($approvals as $approval): ?>
                <?php $amount = CHtml::value($approval, 'amount'); ?>
                <tr>
                    <td><?php echo CHtml::encode(CHtml::value($approval, 'transaction_date')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($approval, 'transaction_day_of_week')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($approval, 'username')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($approval, 'approval_date')); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amount)); ?></td>
                </tr>
                <?php $total += $amount; ?>
            <?php endforeach; ?>
        </tbody>
        
        <tfoot>
            <tr>
                <td colspan="4" style="text-align: right; font-weight: bold">Total</td>
                <td style="text-align: right; font-weight: bold"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $total)); ?></td>
            </tr>
        </tfoot>
    </table>
</div>

<?php echo CHtml::endForm(); ?>