<?php
Yii::app()->clientScript->registerScript('report', '
	$("#StartDate").val("' . $startDate . '");
	$("#EndDate").val("' . $endDate . '");
');

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').slideToggle(600);
        $('.bulk-action').toggle();
        $(this).toggleClass('active');
        if ($(this).hasClass('active')) {
            $(this).text('');
        } else {
            $(this).text('Advanced Search');
        }
        return false;
    });
");
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/report.css');
?>

<div class="clear"></div>

<div class="tab reportTab">
    <div class="tabHead"></div>
    
    <div class="tabBody">
        <div id="detail_div">
            <div class="myForm">
                <div class="search-bar">
                    <div class="clearfix button-bar">
                        <?php echo CHtml::link('Advanced Search', '#', array('class' => 'search-button right button cbutton secondary')); ?>					
                        <div class="clearfix"></div>
                        <div class="search-form" style="display:none">
                            <?php $this->renderPartial('_search', array(
                                'startDate' => $startDate,
                                'endDate' => $endDate,
                                'branchId' => $branchId,
                            )); ?>
                        </div><!-- search-form -->
                    </div>
                </div>
            </div>

            <hr />

            <div class="relative">
                <div style="font-weight: bold; text-align: center">
                    <?php $branch = Branch::model()->findByPk($branchId); ?>
                    <div style="font-size: larger"><?php echo CHtml::encode(($branch === null) ? '' : $branch->name); ?></div>
                    <div style="font-size: larger">Rekap Jurnal Umum <?php echo $transactionTypeLiteral; ?></div>
                    <div><?php echo ' YTD: &nbsp;&nbsp; ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($startDate))) . ' - ' . CHtml::encode(Yii::app()->dateFormatter->format('d MMMM yyyy', strtotime($endDate))); ?></div>
                </div>

                <br />

                <table style="margin: 0 auto; border-spacing: 0pt">
                    <thead style="position: sticky; top: 0">
                        <tr>
                            <th style="text-align: center">COA</th>
                            <th style="text-align: center">Debit</th>
                            <th style="text-align: center">Credit</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $totalDebit = '0.00'; ?>
                        <?php $totalCredit = '0.00'; ?>
                        <?php foreach ($transactionJournalData as $transactionJournalItem): ?>
                            <tr>
                                <td>
                                    <?php echo CHtml::encode($transactionJournalItem['coa_code']); ?> - 
                                    <?php echo CHtml::link($transactionJournalItem['coa_name'], Yii::app()->createUrl("report/transactionJournalSummary/journalAsset", array(
                                        "CoaId" => $transactionJournalItem['coa_id'], 
                                        "StartDate" => $startDate, 
                                        "EndDate" => $endDate, 
                                        "BranchId" => $branchId,
                                    )), array('target' => '_blank')); ?>
                                </td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $transactionJournalItem['debit'])); ?>
                                </td>
                                <td style="text-align: right">
                                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $transactionJournalItem['credit'])); ?>
                                </td>
                            </tr>
                            <?php $totalDebit += $transactionJournalItem['debit']; ?>
                            <?php $totalCredit += $transactionJournalItem['credit']; ?>
                        <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="text-align: right; font-weight: bold; border-top: 2px solid; text-transform: uppercase">
                                TOTAL 
                            </td>

                            <td style="text-align: right; font-weight: bold; border-top: 2px solid">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalDebit)); ?>
                            </td>

                            <td style="text-align: right; font-weight: bold; border-top: 2px solid">
                                <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalCredit)); ?>
                            </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>
</div>
