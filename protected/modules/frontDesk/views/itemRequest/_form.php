<script type="text/javascript">
    $(document).ready(function () {
        $('.dateClass').live("keyup", function (e) {
            var Length=$(this).attr("maxlength");

            if ($(this).val().length >= parseInt(Length)){
                $(this).next('.dateClass').focus();
            }
        });
    }
</script>

<div id="maincontent">
    <div class="clearfix page-action">
        <div class="form">

            <?php echo CHtml::beginForm(); ?>
            <?php echo CHtml::errorSummary($itemRequest->header); ?>
            <div class="row">
                <div class="medium-12 columns">
                    <div class="row">
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::label('Request Tanggal', ''); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                            'model' => $itemRequest->header,
                                            'attribute' => "transaction_date",
                                            'options' => array(
                                                'dateFormat' => 'yy-mm-dd',
                                                'changeMonth' => true,
                                                'changeYear' => true,
                                            ),
                                            'htmlOptions' => array(
                                                'readonly' => true,
//                                                'value' => date('Y-m-d'),
                                            ),
                                        )); ?>
                                        <?php echo CHtml::error($itemRequest->header, 'transaction_date'); ?>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo 'Branch'; ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode(CHtml::value($itemRequest->header, 'branch.name')); ?>
                                        <?php echo CHtml::error($itemRequest->header,'branch_id'); ?>
                                    </div>
                                </div>
                            </div>

                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <label class="prefix"><?php echo CHtml::label('User', ''); ?></label>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::encode($itemRequest->header->user->username); ?>
                                        <?php echo CHtml::error($itemRequest->header,'user_id'); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <div class="medium-6 columns">
                            <div class="field">
                                <div class="row collapse">
                                    <div class="small-4 columns">
                                        <?php echo CHtml::label('Note', ''); ?>
                                    </div>
                                    <div class="small-8 columns">
                                        <?php echo CHtml::activeTextArea($itemRequest->header, 'note', array('rows' => 5, 'columns' => '10')); ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr />

                <div class="row">
                    <?php echo CHtml::button('Tambah Barang', array(
                        'id' => 'btn_product',
                        'onclick' => '$.ajax({
                            type: "POST",
                            data: $("form").serialize(),
                            url: "' . CController::createUrl('ajaxHtmlAddProduct', array('id' => $itemRequest->header->id)) . '",
                            success: function(html){
                                $("#detail_div").html(html);
                            }
                        })'
                    )); ?>
                </div>

                <br /><br />

                <div id="detail_div">
                    <?php $this->renderPartial('_detail', array(
                        'itemRequest' => $itemRequest,
                    )); ?>
                </div>

                <div class="row buttons">
                    <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                    <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
                </div>
                <?php echo IdempotentManager::generate(); ?>
                <?php echo CHtml::endForm(); ?>
            </div>
        </div>
    </div>
</div><!-- form -->