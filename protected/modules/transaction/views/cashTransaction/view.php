<?php
/* @var $this CashTransactionController */
/* @var $model CashTransaction */

$this->breadcrumbs = array(
    'Cash Transactions' => array('index'),
    $model->id,
);

$this->menu = array(
    array('label' => 'List CashTransaction', 'url' => array('index')),
    array('label' => 'Create CashTransaction', 'url' => array('create')),
    array('label' => 'Update CashTransaction', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete CashTransaction', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage CashTransaction', 'url' => array('admin')),
);
?>

<!--<h1>View Cash Transaction #<?php //echo $model->id; ?></h1>-->
<div id="maincontent">
    <div class="clearfix page-action">
        
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>

        <?php echo CHtml::link('<span class="fa fa-th-list"></span>Manage Cash Transaction', Yii::app()->baseUrl . '/transaction/cashTransaction/admin', array('class' => 'button cbutton right', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("transaction.cashTransaction.admin"))) ?>

        <?php if (Yii::app()->user->checkAccess('cashTransactionEdit')): //($model->status != "Approved" && $model->status != 'Rejected') || ): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Edit', Yii::app()->baseUrl . '/transaction/cashTransaction/update?id=' . $model->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px', 'visible' => Yii::app()->user->checkAccess("transaction.cashTransaction.update"))) ?>
        <?php endif; ?>
        <?php if ($model->status == "Draft" && Yii::app()->user->checkAccess("cashTransactionApproval")): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Approval', Yii::app()->baseUrl . '/transaction/cashTransaction/updateApproval?headerId=' . $model->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px')) ?>
        <?php elseif ($model->status != "Draft" && Yii::app()->user->checkAccess("cashTransactionSupervisor")): ?>
            <?php echo CHtml::link('<span class="fa fa-edit"></span>Update Approval', Yii::app()->baseUrl . '/transaction/cashTransaction/updateApproval?headerId=' . $model->id, array('class' => 'button cbutton right', 'style' => 'margin-right:10px')) ?>
        <?php endif; ?>
        
        <?php //if (Yii::app()->user->checkAccess("paymentInSupervisor")): ?>
            <?php echo CHtml::link('<span class="fa fa-minus"></span>Cancel Transaction', array("/transaction/cashTransaction/cancel", "id" => $model->id), array(
                'class' => 'button alert right', 
                'style' => 'margin-right:10px', 
            )); ?>
        <?php //endif; ?>
        
        <h1>View Cash Transaction #<?php echo $model->id; ?></h1>
        <?php $transactions = JurnalUmum::model()->findAllByAttributes(array('kode_transaksi' => $model->transaction_number, 'is_coa_category' => 0)); ?>

        <div class="row">
            <div class="large-12 columns">
                <div class="row">
                    <div class="large-6 columns">

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Transaction Type</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->transaction_type; ?>"> 
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Transaction #</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->transaction_number; ?>"> 
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Transaction Date</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->transaction_date; ?>"> 
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Transaction Time</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->transaction_time; ?>"> 
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Status</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->status; ?>"> 
                                </div>
                            </div>
                        </div>

                    </div>


                    <div class="large-6 columns">

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Debit</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->debit_amount; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Credit</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->credit_amount; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">User</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->user->username; ?>"> 
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Branch</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->branch->name; ?>"> 
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <fieldset>
                    <legend>COA Detail</legend>
                    <div class="large-12 columns">
                        <div class="row">
                            <div class="large-6 columns">

                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">COA Name</span>
                                        </div>
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" value="<?php echo $model->branch->code . '.' . $model->coa->name; ?>"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">COA Code</span>
                                        </div>
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" value="<?php echo $model->branch->coa_prefix . '.' . $model->coa->code; ?>"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">COA Normal Balance</span>
                                        </div>
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" value="<?php echo $model->coa->normal_balance; ?>"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">Catatan</span>
                                        </div>
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" value="<?php echo $model->note; ?>"> 
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="large-6 columns">
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">Opening Balance</span>
                                        </div>
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" value="<?php echo $model->coa->opening_balance; ?>"> 
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">Closing Balance</span>
                                        </div>
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" value="<?php echo $model->coa->closing_balance; ?>"> 
                                        </div>
                                    </div>
                                </div>

                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">Debit</span>
                                        </div>
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" value="<?php echo $model->coa->debit; ?>"> 
                                        </div>
                                    </div>
                                </div>
                                <div class="field">
                                    <div class="row collapse">
                                        <div class="small-4 columns">
                                            <span class="prefix">Credit</span>
                                        </div>
                                        <div class="small-8 columns">
                                            <input type="text" readonly="true" value="<?php echo $model->coa->credit; ?>"> 
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                </fieldset>
                
                <fieldset>
                    <legend>Details</legend>
                    <table>
                        <thead>
                            <tr>
                                <th>Coa</th>
                                <th>Normal Balance</th>
                                <th>Amount</th>
                                <th>Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($details as $key => $detail): ?>
                                <tr>
                                    <td><?php echo $detail->coa != "" ? $model->branch->code . '.' . $detail->coa->name : ''; ?></td>
                                    <td><?php echo $detail->coa != "" ? $detail->coa->normal_balance : '' ?></td>
                                    <td><?php echo Yii::app()->numberFormatter->format('#,##0.00', $detail->amount); ?></td>
                                    <td><?php echo $detail->notes; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </fieldset>
                
                <fieldset>
                    <legend>Approval Status</legend>
                    <table>
                        <thead>
                            <tr>
                                <th>Approval type</th>
                                <th>Revision</th>
                                <th>date</th>
                                <th>note</th>
                                <th>supervisor</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($revisionHistories as $key => $history): ?>
                                <tr>
                                    <td><?php echo $history->approval_type; ?></td>
                                    <td><?php echo $history->revision; ?></td>
                                    <td><?php echo $history->date; ?></td>
                                    <td><?php echo $history->note; ?></td>
                                    <td><?php echo $history->supervisor->username; ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </fieldset>
                
                <br />

                <?php if (Yii::app()->user->checkAccess("generalManager")): ?>
                    <fieldset>
                        <legend>Journal Transactions</legend>
                        <table class="report">
                            <thead>
                                <tr id="header1">
                                    <th style="width: 5%">No</th>
                                    <th style="width: 15%">Kode COA</th>
                                    <th>Nama COA</th>
                                    <th style="width: 15%">Debit</th>
                                    <th style="width: 15%">Kredit</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $totalDebit = 0; $totalCredit = 0; ?>
                                <?php foreach ($transactions as $i => $header): ?>

                                    <?php $amountDebit = $header->debet_kredit == 'D' ? CHtml::value($header, 'total') : 0; ?>
                                    <?php $amountCredit = $header->debet_kredit == 'K' ? CHtml::value($header, 'total') : 0; ?>

                                    <tr>
                                        <td style="text-align: center"><?php echo $i + 1; ?></td>
                                        <td class="width1-4"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountCode')); ?></td>
                                        <td class="width1-5"><?php echo CHtml::encode(CHtml::value($header, 'branchAccountName')); ?></td>
                                        <td class="width1-6" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amountDebit)); ?></td>
                                        <td class="width1-7" style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $amountCredit)); ?></td>
                                    </tr>

                                    <?php $totalDebit += $amountDebit; ?>
                                    <?php $totalCredit += $amountCredit; ?>

                                <?php endforeach; ?>
                            </tbody>

                            <tfoot>
                                <tr>
                                    <td colspan="3" style="text-align: right; font-weight: bold">TOTAL</td>
                                    <td class="width1-6" style="text-align: right; font-weight: bold; border-top: 1px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalDebit)); ?></td>
                                    <td class="width1-7" style="text-align: right; font-weight: bold; border-top: 1px solid"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $totalCredit)); ?></td>
                                </tr>        
                            </tfoot>
                        </table>
                    </fieldset>
                <?php endif; ?>

                <br />

                <fieldset>
                    <legend>Attached Images</legend>

                    <?php foreach ($postImages as $postImage):
                        $dir = dirname(Yii::app()->request->scriptFile) . '/images/uploads/cashTransaction/' . $postImage->filename;
                        $src = Yii::app()->baseUrl . '/images/uploads/cashTransaction/' . $postImage->filename;
                        ?>
                        <div class="row">
                            <div class="small-3 columns">
                                <div style="margin-bottom:.5rem">
                                    <?php echo CHtml::image($src, $model->transaction_type . "Image"); ?>
                                </div>
                            </div>
                            <div class="small-8 columns">
                                <div style="padding:.375rem .5rem; border:1px solid #ccc; background:#fff; font-size:.8125rem; line-height:1.4; margin-bottom:.5rem;">
                                    <?php echo (Yii::app()->baseUrl . '/images/uploads/cashTransaction/' . $postImage->filename); ?>
                                </div>
                            </div>

                        </div>
                    <?php endforeach; ?>
                </fieldset>
            </div>
        </div>
            
        <br />

        <?php //if (Yii::app()->user->checkAccess("cashierHead") && $model->status === 'Approved' && empty($transactions)): ?>
            <div class="field buttons text-center">
                <?php echo CHtml::beginForm(); ?>
                <?php echo CHtml::submitButton('Processing Journal', array('name' => 'Process')); //, 'confirm' => 'Are you sure you want to process into journal transactions?')); ?>
                <?php echo CHtml::endForm(); ?>
            </div>
        <?php //endif; ?>
    </div>
</div>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'cancel-message-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Cancel Message',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => false,
    ),
));?>
<div>
    <?php $hasFlash = Yii::app()->user->hasFlash('message'); ?>
    <?php if ($hasFlash): ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('message'); ?>
        </div>
    <?php endif; ?>
</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
    $(document).ready(function() {
        var hasFlash = <?php echo $hasFlash ? 'true' : 'false' ?>;
        if (hasFlash) {
            $("#cancel-message-dialog").dialog({modal: 'false'});
        }
    });
</script>