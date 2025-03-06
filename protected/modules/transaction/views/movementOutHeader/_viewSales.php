<h2>Retail Sales</h2>
<div class="wide form" id="advSearch">

    <div class="row">
        <div class="small-12 medium-6 columns">
            <!-- BEGIN FIELDS -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::activeLabel($registrationTransaction, 'transaction_date'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker',array(
                            'model' => $registrationTransaction,
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
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::activeLabel($registrationTransaction, 'customer_name'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextField($registrationTransaction, 'customer_name'); ?>
                    </div>
                </div>
            </div>

            <div class="field buttons text-right">
                <?php echo CHtml::button('Search', array('class'=>'button cbutton',
                    'onclick' => '$.fn.yiiGridView.update("retail-sale-grid", {data: {
                            RegistrationTransaction: {
                                transaction_date: $("#' . CHtml::activeId($registrationTransaction, 'transaction_date') . '").val(),
                                customer_name: $("#' . CHtml::activeId($registrationTransaction, 'customer_name') . '").val()
                            }
                        } });',
                    )); ?>
            </div>
        </div>
    </div>	
</div>	
            
<hr />
<div class="grid-view">
    <?php $this->widget('zii.widgets.grid.CGridView', array(
        'id'=>'retail-sale-grid',
        'dataProvider'=>$registrationTransactionDataProvider,
        'filter'=>$registrationTransaction,
        // 'summaryText'=>'',
        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
        'pager'=>array(
           'cssFile'=>false,
           'header'=>'',
        ),
        'columns'=>array(
            array(
                'name'=>'transaction_number', 
                'value'=>'CHtml::link($data->transaction_number, array("/frontDesk/registrationTransaction/show", "id"=>$data->id))', 
                'type'=>'raw'
            ),
            array(
                'name'=>'transaction_date',
                'filter' => false,
                'value'=>'$data->transaction_date'
            ),
            array(
                'name' => 'repair_type',
                'filter' => CHtml::activeDropDownList($registrationTransaction, 'repair_type', array(
                    'BR' => 'Body Repair',
                    'GR' => 'General Repair', 
                ), array('empty' => '-- All --')),
                'value' => '$data->repair_type',
            ),
            array(
                'name'=>'customer_id', 
                'filter' => false,
                'value'=>'empty($data->customer_id) ? "" : $data->customer->name', 
                'type'=>'raw'
            ),
            array(
                'header'=>'Movements',
                'value'=> function($data){
                    foreach ($data->movementOutHeaders as $key => $movementDetail) {
                        echo CHtml::link($movementDetail->movement_out_no, array("/transaction/movementOutHeader/show", "id"=>$movementDetail->id)). "<br />";
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