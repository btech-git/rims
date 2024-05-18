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
                                'transactionType' => $transactionType,
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
                <?php $this->renderPartial('_summary', array(
                    'transactionTypeLiteral' => $transactionTypeLiteral,
                    'transactionType' => $transactionType,
                    'startDate' => $startDate,
                    'endDate' => $endDate,
                    'branchId' => $branchId,
                    'transactionJournalData' => $transactionJournalData,
                )); ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
</div>
