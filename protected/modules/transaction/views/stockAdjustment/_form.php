<?php
/* @var $this StockAdjustmentController */
/* @var $model StockAdjustmentHeader */
/* @var $form CActiveForm */
/* <script type="text/javascript">
  <?php
  $listwarehouse = '';
  foreach ($warehouse as $key) {
  $listwarehouse .="<td>"; //<input type=\"number\" placeholder=\"Stock\" class=\"stock_wh\" name=\"stock_wh_".$key->id."[]\"/>";
  $listwarehouse .= CHtml::numberField('warehouse_id['.$key->id.'][]','', array('placeholder'=>'Stock', 'class'=>'stock_wh'));
  $listwarehouse .= "<label class=\"sufix\">(stock)</label></td>";

  }
  ?>
  var defaultwh = '<?php echo $listwarehouse; ?>';
  </script>
 */
?>
<div class="form">

    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'stock-adjustment-header-form',
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>

    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php echo $form->errorSummary($model); ?>

    <div class="row">
        <div class="small-12 medium-6 columns">

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'stock_adjustment_number', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php
                        if ($model->isNewRecord) {
                            echo $form->hiddenField($model, 'status', array('value' => 'Draft', 'readonly' => true));
                        }
                        ?>
                        <?php echo $form->textField($model, 'stock_adjustment_number', array('size' => 30, 'maxlength' => 30, 'readonly' => true)); ?>

                        <?php echo $form->error($model, 'stock_adjustment_number'); ?>
                    </div>
                </div>
            </div>		

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'date_posting', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php //echo $form->textField($model,'date_posting'); ?>
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $model,
                            'attribute' => "date_posting",
                            'options' => array(
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth' => true,
                                'changeYear' => true,
//                                'yearRange'=>'1900:2020'
                            ),
                            'htmlOptions' => array(
                                'value' => date('Y-m-d'),
                            //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                            ),
                        )); ?>
                        <?php echo $form->error($model, 'date_posting'); ?>
                    </div>
                </div>
            </div>	

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'branch_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownlist($model, 'branch_id', CHtml::listData(Branch::model()->findAllByAttributes(array('status' => 'Active')), 'id', 'name'), array('prompt' => '[--Select Branch--]', /* 'onchange'=>'
                          //$("#receive-item-grid .filters input[name=\"TransactionReceiveItem[branch_name]\"]").prop("readOnly","readOnly");
                          $.updateGridView("receive-item-grid", "TransactionReceiveItem[branch_name]", $("#MovementInHeader_branch_id option:selected").text());
                          $.ajax({
                          type: "POST",
                          //dataType: "JSON",
                          url: "' . CController::createUrl('ajaxHtmlRemoveDetailAll', array('id'=> $model->id)).'",
                          data: $("form").serialize(),
                          success: function(html) {
                          $(".detail").html(html);

                          },
                          });
                          $("#MovementInHeader_receive_item_id").val("");
                          $("#MovementInHeader_receive_item_number").val("");
                          ' */)); ?>
                        <?php echo $form->error($model, 'branch_id'); ?>
                    </div>
                </div>
            </div>		

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'user_id', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($model, 'user_id', array('readonly' => true, 'value' => $model->isNewRecord ? Yii::app()->user->getId() : $model->user_id)); ?>
                        <?php echo $form->error($model, 'user_id'); ?>
                    </div>
                </div>
            </div>		

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->labelEx($model, 'note', array('class' => 'prefix')); ?>
                    </div>
                    
                    <div class="small-8 columns">
                        <?php echo $form->textArea($model, 'note', array('rows' => 6, 'cols' => 50)); ?>
                    </div>
                </div>
            </div>

        </div>
        <div class="small-12 columns">
            <fieldset>
                <legend>Detail</legend>

                <div class="row">
                    <div class="small-3 columns">
                        <?php echo CHtml::button('Add Details', array(
                            'id' => 'detail-button',
                            'name' => 'Detail',
                            'style' => 'min-width: 200px',
                            'onclick' => '$("#tblDetail").show(); $("#product-grid-dialog").dialog("open"); return false;',
                        )); ?>
                        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                            'id' => 'product-grid-dialog',
                            // additional javascript options for the dialog plugin
                            'options' => array(
                                'title' => 'Product List',
                                'autoOpen' => false,
                                'width' => 'auto',
                                'modal' => true,
                            ),
                        )); ?>

                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id' => 'product-grid',
                            'dataProvider' => $product->search(),
                            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                            'pager' => array(
                                'cssFile' => false,
                                'header' => '',
                            ),
                            'filter' => $product,
                            'selectableRows' => 1,
                            'rowHtmlOptionsExpression' => 'array("data-id"=>$data->name)',
                            'selectionChanged' => 'js:function(id){
                                var productID = $.fn.yiiGridView.getSelection(id);
                                var productName = $("tr.selected").attr("data-id");

                                $.ajax({
                                    url: "' . CController::createUrl('getdefaultstock') . '",
                                    type: "post",
                                    data: {
                                        id: productID, 
                                    },
                                    success: function (data) {
                                        var newRowContent = "<tr id=\"trid_"+productID+"\" rel=\""+productID+"\"><td width=\"200px\"><input type=\"hidden\" value=\""+productID+"\" name=\"StockAdjustmentDetail[id][]\"/>"+productName+"</td>"+data+"<td><input type=\"text\" id=\"sum_count_"+ productID + "\" readonly=\"readonly\"></td></tr>";
                                        $("#tblDetail tbody").append(newRowContent);

                                    }
                                });


                                // var newRowContent = "<tr id=\"trid_"+productID+"\" rel=\""+productID+"\"><td width=\"200px\"><input type=\"hidden\" value=\""+productID+"\" name=\"StockAdjustmentDetail[id][]\"/>"+productName+"</td>"+defaultwh1+"<td><input type=\"text\" id=\"sum_count_"+ productID + "\" readonly=\"readonly\"></td></tr>";

                                // $("#tblDetail tbody").append(newRowContent);

                                $("#product-grid-dialog").dialog("close");
                                $("#product-grid").find("tr.selected").each(function(){
                                        $(this).removeClass( "selected" );
                                });
                            }',
                            'columns' => array(
                                //'jenis_persediaan_id',
                                'code',
                                'manufacturer_code',
                                'name',
                                'stock',
                                'minimum_stock',
                            //'order_pembelian_id',
                            ),
                        )); ?>

                        <?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>
                        <!-- Refresh grid with value from kode kelompok persediaan-->
                    </div>
                    <div class="small-9 columns"></div>
                </div>
                
                <div class="row">
                    <div class="small-12 columns">
                        <div style="max-width: 90em; width: 100%;">
                            <div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">
                                <?php $this->renderPartial('_detail', array('model' => $model, 'modelDetail' => $modelDetail, 'warehouse' => $warehouse)); ?>
                            </div>
                        </div>						
                    </div>
                </div>

            </fieldset>


            <?php if ($model->id != NULL) { ?>
                <div class="row">
                    <div class="small-12 columns">
                        <?php $this->renderPartial('_approval', array('listApproval' => $listApproval)); ?>
                    </div>
                </div>

                <hr />
                
                <div class="field">
                    <div class="row collapse">
                        <div class="small-12 columns">
                            <h2>Approval</h2>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="small-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix"><?php echo $form->labelEx($modelApproval, 'approval_type'); ?></label>
                                </div>
                                
                                <div class="small-8 columns">
                                    <?php echo $form->hiddenField($modelApproval, 'stock_adjustment_header_id', array('value' => $model->id)); ?>
                                    <?php echo $form->dropDownList($modelApproval, 'approval_type', array(
                                        'Revised' => 'Revised', 
                                        'Rejected' => 'Rejected', 
                                        'Approved' => 'Approved',
                                    )); ?>
                                    <?php echo $form->error($modelApproval, 'approval_type'); ?>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix"><?php echo $form->labelEx($modelApproval, 'revision'); ?></label>
                                </div>
                                <div class="small-8 columns">
                                    <?php $revisions = StockAdjustmentApproval::model()->findAllByAttributes(array('stock_adjustment_header_id' => $model->id)); ?>
                                    <?php echo $form->textField($modelApproval, 'revision', array('value' => count($revisions) != 0 ? count($revisions) + 1 : 0, 'readonly' => true)); ?>		
                                    <?php echo $form->error($modelApproval, 'revision'); ?>
                                </div>
                            </div>
                        </div>	

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix"><?php echo $form->labelEx($modelApproval, 'date'); ?></label>
                                </div>
                                
                                <div class="small-8 columns">
                                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                                        'model' => $modelApproval,
                                        'attribute' => "date",
                                        // additional javascript options for the date picker plugin
                                        'options' => array(
                                            'dateFormat' => 'yy-mm-dd',
                                            'changeMonth' => true,
                                            'changeYear' => true,
//                                            'yearRange' => '1900:2020'
                                        ),
                                        'htmlOptions' => array(
                                            'value' => date('Y-m-d'),
                                        //'value'=>$customer->header->isNewRecord ? '' : Customer::model()->findByPk($customer->header->id)->birthdate,
                                        ),
                                    )); ?>
                                    <?php echo $form->error($modelApproval, 'date'); ?>
                                </div>
                            </div>
                        </div>	

                    </div>
                    <div class="small-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix"><?php echo $form->labelEx($modelApproval, 'note'); ?></label>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo $form->textArea($modelApproval, 'note', array('rows' => 5, 'cols' => 50)); ?>
                                    <?php echo $form->error($modelApproval, 'note'); ?>
                                </div>
                            </div>
                        </div>
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <label class="prefix"><?php echo $form->labelEx($modelApproval, 'supervisor_id'); ?></label>
                                </div>
                                <div class="small-8 columns">
                                    <?php echo $form->textField($modelApproval, 'supervisor_id', array('readonly' => true, 'value' => Yii::app()->user->getId())); ?>
                                    <?php echo $form->error($modelApproval, 'supervisor_id'); ?>
                                </div>
                            </div>
                        </div>				
                    </div>
                </div>		
            <?php } ?>

            <div class="buttons">
                <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
                <?php echo CHtml::submitButton($model->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to save?')); ?>
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>

</div><!-- form -->

<script type="text/javascript">
    // $('#tblDetail').hide();
    $(document).on("change", ".stock_wh", function () {
        var sum = 0;
        var thisted = $(this).parent().parent('tr').attr('rel');
        $("#trid_" + thisted).find('.stock_wh').each(function () {
            var combat = $(this).val();
            if (!isNaN(combat) && combat.length !== 0) {
                sum += parseFloat(combat);
            }
        });

        $("#sum_count_" + thisted).val(sum);
    });
</script>