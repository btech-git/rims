<div class="myForm">
    <?php echo CHtml::beginForm(array(''), 'get'); ?>
    <div class="row">
        <div class="medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Supplier</span>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::textField('SupplierName', $supplierName); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="medium-6 columns">
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <span class="prefix">Tanggal </span>
                    </div>
                    <div class="small-4 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'StartDate',
                            'value' => $startDate,
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth'=>true,
                                'changeYear'=>true,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'placeholder' => 'Mulai',
                            ),
                        )); ?>
                    </div>

                    <div class="small-4 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'name' => 'EndDate',
                            'value' => $endDate,
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth'=>true,
                                'changeYear'=>true,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'placeholder' => 'Sampai',
                            ),
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="clear"></div>
    
    <div class="row buttons">
        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
        <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
        <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
    </div>

    <?php echo CHtml::endForm(); ?>
    <div class="clear"></div>
</div>

<h3>Data Hutang Jatuh Tempo</h3>

<fieldset>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Invoice #</th>
                <th>Tanggal</th>
                <th>Jatuh Tempo</th>
                <th>Supplier</th>
                <th>Total</th>
                <th>Payment</th>
                <th>Remaining</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($payableIncomingDueDate as $i => $dataItem): ?>
                <tr>
                    <td><?php echo CHtml::encode($i + 1); ?></td>
                    <td>
                        <?php echo CHtml::link(CHtml::encode($dataItem['invoice_number']), array(
                            "/transaction/transactionReceiveItem/show", 
                            "id" => $dataItem['id']
                        ), array('target' => '_blank')); ?>
                    </td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($dataItem['invoice_date']))); ?></td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format('d MMM yyyy', strtotime($dataItem['invoice_due_date']))); ?></td>
                    <td><?php echo CHtml::encode($dataItem['supplier']); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['invoice_grand_total'])); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['payment'])); ?></td>
                    <td style="text-align: right"><?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0.00', $dataItem['remaining'])); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</fieldset>