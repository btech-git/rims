<?php

?>
<div class="tab reportTab">
    <div class="tabBody">
        <div id="detail_div">
            <?php echo CHtml::beginForm(array('summaryPayload'), 'get', array('target' => '_blank')); ?>
            
            <div class="myForm tabForm customer">
                
                <div class="clear"></div>
                
                <div class="row buttons">
                    <?php echo CHtml::submitButton('Compare', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                </div>

                <div class="clear"></div>

            </div>

            <hr />

            <div class="relative">
                <?php $this->renderPartial('_summary', array(
                    'transactionLogs' => $transactionLogs,
                    'transactionNumber' => $transactionNumber,
                )); ?>
            </div>
            
            <?php echo CHtml::endForm(); ?>
        </div>
    </div>
</div>