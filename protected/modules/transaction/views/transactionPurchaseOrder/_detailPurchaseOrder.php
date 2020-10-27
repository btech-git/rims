<?php foreach ($purchaseOrder->details as $i => $detail): ?>
    <table>
        <tr>
            <td colspan="3">
                <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                    'tabs' => array(
                        'Detail Item' => array(
                            'id' => 'test1',
                            'content' => $this->renderPartial('_detailPo', array(
                                'i' => $i, 
                                'detail' => $detail, 
                                'purchaseOrder' => $purchaseOrder
                            ), true),
                        ),
                    ),

                    // additional javascript options for the tabs plugin
                    'options' => array(
                        'collapsible' => true,
                    ),
                    // set id for this widgets
                    'id' => 'Request' . $i . 'tab',
                )); ?>
            </td>
        </tr>
    </table>
    <?php Yii::app()->clientScript->registerScript('myjquery' . $i, '
	var adanilai' . $i . ' = $("#TransactionPurchaseOrderDetail_' . $i . '_discount_step option:selected").text();
	var stepbtn' . $i . ' = 0;
	// console.log(adanilai' . $i . ');
	if (adanilai' . $i . ' == 1) {
            $("#step1_' . $i . '").show();
            $("#step2_' . $i . '").hide();
            $("#step3_' . $i . '").hide();
            $("#step4_' . $i . '").hide();
            $("#step5_' . $i . '").hide();
	} else if (adanilai' . $i . ' == 2) {
            $("#step1_' . $i . '").show();
            $("#step2_' . $i . '").show();
            $("#step3_' . $i . '").hide();
            $("#step4_' . $i . '").hide();
            $("#step5_' . $i . '").hide();
	} else if (adanilai' . $i . ' == 3) {
            $("#step1_' . $i . '").show();
            $("#step2_' . $i . '").show();
            $("#step3_' . $i . '").show();
            $("#step4_' . $i . '").hide();
            $("#step5_' . $i . '").hide();
	} else if (adanilai' . $i . ' == 4) {
            $("#step1_' . $i . '").show();
            $("#step2_' . $i . '").show();
            $("#step3_' . $i . '").show();
            $("#step4_' . $i . '").show();
            $("#step5_' . $i . '").hide();
	} else if (adanilai' . $i . ' == 5) {
            $("#step1_' . $i . '").show();
            $("#step2_' . $i . '").show();
            $("#step3_' . $i . '").show();
            $("#step4_' . $i . '").show();
            $("#step5_' . $i . '").show();
	} else {
            $("#step1_' . $i . '").hide();
            $("#step2_' . $i . '").hide();
            $("#step3_' . $i . '").hide();
            $("#step4_' . $i . '").hide();
            $("#step5_' . $i . '").hide();
	}
    '); ?>

<?php endforeach; ?>