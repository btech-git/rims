<h2>Parts Supply</h2>
<div class="wide form" id="advSearch">
    <div class="row">
        <div class="small-12 medium-6 columns">
            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::activeLabel($receivePartsHeader, 'Tanggal'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'model' => $receivePartsHeader,
                            'attribute' => "transaction_date",
                            'options'=>array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth'=>true,
                                'changeYear'=>true,
                            ),
                            'htmlOptions'=>array(
                                'readonly' => true,
                            ),
                        )); ?>
                    </div>
                </div>
            </div>
            
            <div class="field buttons text-right">
                <?php echo CHtml::button('Search', array('class'=>'button cbutton',
                    'onclick' => '$.fn.yiiGridView.update("receive-parts-grid", {data: {
                        ReceivePartsHeader: {
                            transaction_date: $("#' . CHtml::activeId($receivePartsHeader, 'transaction_date') . '").val(),
                            transaction_type: $("#' . CHtml::activeId($receivePartsHeader, 'transaction_type') . '").val()
                        }
                    } });',
                )); ?>
            </div>
        </div>
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php //echo CHtml::activeLabel($receivePartsHeader, 'Type'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php //echo CHtml::activeTextField($receivePartsHeader, 'transaction_type'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>	
</div>	
            
<hr />
<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'receive-parts-grid',
        'dataProvider'=>$receivePartsDataProvider,
        'filter'=>$receivePartsHeader,
        // 'summaryText'=>'',
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
           'cssFile'=>false,
           'header'=>'',
        ),
        'columns'=>array(
            array(
                'name'=>'transaction_number', 
                'header'=>'Transaction #',
                'value'=>'CHtml::link($data->transaction_number, array("/frontDesk/receiveParts/show", "id"=>$data->id))', 
                'type'=>'raw'
            ),
            array(
                'name'=>'transaction_date',
                'header'=>'Tanggal',
                'filter' => false,
                'value'=>'Yii::app()->dateFormatter->format("d MMM yyyy", $data->transaction_date)'
            ),
            array(
                'header' => 'Umur (hari)', 
                'value' => '$data->outstandingDays',
                'htmlOptions' => array('style' => 'text-align: center'),
            ),
            array(
                'name'=>'supplier_delivery_number',
                'header'=>'SJ #',
                'filter' => false,
                'value'=>'$data->supplier_delivery_number'
            ),
            array(
                'name'=>'insurance_company_id',
                'header'=>'Asuransi',
                'filter' => false,
                'value'=>'CHtml::value($data, "insuranceCompany.name")',
            ),
            array(
                'name' => 'transaction_type',
                'header'=>'Tipe',
                'filter' => CHtml::activeDropDownList($receivePartsHeader, 'transaction_type', array(
                    'Asuransi' => 'Asuransi',
                    'Internal' => 'Internal', 
                ), array('empty' => '-- All --')),
                'value' => '$data->transaction_type',
            ),
            array(
                'name'=>'registration_transaction_id', 
                'header'=>'Registration #',
                'filter' => false,
                'value'=>'empty($data->registration_transaction_id) ? "" : $data->registrationTransaction->transaction_number', 
                'type'=>'raw'
            ),
            array(
                'header'=>'Movements',
                'value'=> function($data){
                    foreach ($data->movementInHeaders as $key => $movementHeader) {
                        echo CHtml::link($movementHeader->movement_in_number, array("/transaction/movementInHeader/show", "id"=>$movementHeader->id)). "<br />";
                    }
                }
            ),
            array(
                'header' => '',
                'type' => 'raw',
                'value' => 'CHtml::link("Create", array("create", "transactionId"=>$data->id, "movementType"=>"3"))',
                'htmlOptions' => array(
                    'style' => 'text-align: center;'
                ),
            ),
        ),
    )); ?>
</div>