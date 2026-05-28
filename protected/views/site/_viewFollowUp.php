<div class="row">
    <div class="small-12 columns" style="padding-left: 0px; padding-right: 0px;">
        <table style="border: 0px solid">
            <tr>
                <td style="border: 0px solid" colspan="2"><h1>List Vehicle</h1></td>
            </tr>
            <tr>
                <td>No Polisi</td>
                <td>
                    <?php echo CHtml::textField('PlateNumber', $plateNumber, array(
                        'onchange' => 
                        CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateFollowUpTable'),
                            'update' => '#follow_up_table',
                        )),
                    )); ?>
                </td>
                <td>Customer</td>
                <td>
                    <?php echo CHtml::textField('CustomerName', $customerName, array(
                        'onchange' => 
                        CHtml::ajax(array(
                            'type' => 'GET',
                            'url' => CController::createUrl('ajaxHtmlUpdateFollowUpTable'),
                            'update' => '#follow_up_table',
                        )),
                    )); ?>
                </td>
            </tr>
        </table>

        <div class="clear"></div>

        <div class="row buttons" style="text-align: center">
            <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
        </div>

        <hr />

        <div id="follow_up_table">
            <?php $this->renderPartial('_followUpTable', array(
                'followUpDataProvider' => $followUpDataProvider,
            )); ?>
        </div>
    </div>
</div>