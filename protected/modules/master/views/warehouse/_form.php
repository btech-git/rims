<?php
/* @var $this WarehouseController */
/* @var $warehouse->header Warehouse */
/* @var $form CActiveForm */
?>
<div class="clearfix page-action">
    <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/warehouse/admin'; ?>"><span class="fa fa-th-list"></span>Manage Warehouse</a>
    <h1>
        <?php if ($warehouse->header->isNewRecord) {
            echo "New Warehouse";
        } else {
            echo "Update Warehouse";
        } ?>
    </h1>
    <!-- begin FORM -->
    <?php $form = $this->beginWidget('CActiveForm', array(
        'id' => 'warehouse-form',
        'htmlOptions' => array('class' => 'form'),
        // Please note: When you enable ajax validation, make sure the corresponding
        // controller action is handling ajax validation correctly.
        // There is a call to performAjaxValidation() commented in generated controller code.
        // See class documentation of CActiveForm for details on this.
        'enableAjaxValidation' => false,
    )); ?>
    
    <hr />
    
    <p class="note">Fields with <span class="required">*</span> are required.</p>
    <?php Yii::app()->clientScript->registerCoreScript('jquery'); ?>
    <?php Yii::app()->clientScript->registerCoreScript('jquery.ui'); ?>
    <div class="row">
        <div class="small-12 medium-6 columns"> 
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($warehouse->header, 'code'); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($warehouse->header, 'code', array('size' => 20, 'maxlength' => 20)); ?>
                        <?php echo $form->error($warehouse->header, 'code'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($warehouse->header, 'name'); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($warehouse->header, 'name', array('size' => 50, 'maxlength' => 50)); ?>
                        <?php echo $form->error($warehouse->header, 'name'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($warehouse->header, 'description'); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textArea($warehouse->header, 'description', array('rows' => 4, 'cols' => 50, 'maxlength' => 100)); ?>
                        <?php echo $form->error($warehouse->header, 'description'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($warehouse->header, 'status'); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($warehouse->header, 'status', array(
                            'Active' => 'Active',
                            'Inactive' => 'Inactive',
                        )); ?>
                        <?php echo $form->error($warehouse->header, 'status'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($warehouse->header, 'column'); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($warehouse->header, 'column'); ?>
                        <?php echo $form->error($warehouse->header, 'column'); ?>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($warehouse->header, 'row'); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($warehouse->header, 'row'); ?>
                        <?php echo $form->error($warehouse->header, 'row'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($warehouse->header, 'branch_id'); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($warehouse->header, 'branch_id', CHtml::listData(Branch::model()->findAll(), 'id', 'name'), array(
                            'prompt' => '[--Select Branch--]',
                        )); ?>

                        <?php echo $form->error($warehouse->header, 'branch_id'); ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="small-12 columns">
                    <?php echo CHtml::button('Add Division', array(
                        'id' => 'detail-division-button',
                        'name' => 'Detail',
                        'class' => 'button extra right',
                    )); ?>

                    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                        'id' => 'division-dialog',
                        // additional javascript options for the dialog plugin
                        'options' => array(
                            'title' => 'Division',
                            'autoOpen' => false,
                            'width' => 'auto',
                            'modal' => true,
                        ),
                    )); ?>

                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                        'id' => 'division-grid',
                        'dataProvider' => $divisionDataProvider,
                        'filter' => $division,
                        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                        'pager' => array(
                            'cssFile' => false,
                            'header' => '',
                        ),
                        'selectionChanged' => 'js:function(id){
                            $("#division-dialog").dialog("close");
                            $.ajax({
                                type: "POST",
                                //dataType: "JSON",
                                url: "' . CController::createUrl('ajaxHtmlAddDivisionDetail', array('id' => $warehouse->header->id, 'divisionId' => '')) . '"+$.fn.yiiGridView.getSelection(id),
                                data: $("form").serialize(),
                                success: function(html) {
                                    $("#division").html(html);
                                },
                            });
                            $("#division-grid").find("tr.selected").each(function(){
                                $(this).removeClass( "selected" );
                            });
                        }',
                        'columns' => array(
                            array(
                                'name' => 'check',
                                'id' => 'selectedIds',
                                'value' => '$data->id',
                                'class' => 'CCheckBoxColumn',
                                'selectableRows' => '100',
                                'checkBoxHtmlOptions' => array(
                                    'onclick' => 'js: if($(this).is(":checked")==true){
                                        var checked_val= $(this).val();

                                        var selected_division = $(this).parent("td").siblings("td").html();
                                        var myArray = [];

                                        jQuery("#division tr").each(function(){													
                                            var savedDivision = $(this).find("input[type=text]").val();																						
                                            myArray.push(savedDivision); 
                                        });
                                        
                                        if (jQuery.inArray(selected_division, myArray)!= -1) {
                                            alert("Please select other division, this is already added");
                                            return false;
                                        } else {
                                            $.ajax({
                                                type: "POST",
                                                //dataType: "JSON",
                                                url: "' . CController::createUrl('ajaxHtmlAddDivisionDetail', array()) . '/id/' . $warehouse->header->id . '/divisionId/"+$(this).val(),
                                                data: $("form").serialize(),
                                                success: function(html) {
                                                    $("#division").html(html);	
                                                    //$.fn.yiiGridView.update("#division-grid");
                                                },
                                            });
                                            $(this).parent("td").parent("tr").addClass("checked");
                                            $(this).parent("td").parent("tr").removeClass("unchecked");
                                        }
                                    } else {
                                        var unselected_division = $(this).parent("td").siblings("td").html();
                                        var myArray = [];
                                        var count = 0;
                                        jQuery("#division tr").each(function(){													
                                            var savedDivision = $(this).find("input[type=text]").val();																						
                                            myArray.push(savedDivision);																						
                                            if (unselected_division==savedDivision){
                                                index_id = count-1;																		
                                            }
                                            count++;
                                        });
                                        
                                        if (jQuery.inArray(unselected_division, myArray)!= -1) {
                                            $.ajax({
                                                type: "POST",
                                                //dataType: "JSON",
                                                url: "' . CController::createUrl('ajaxHtmlRemoveDivisionDetail', array()) . '/id/' . $warehouse->header->id . '/index/"+index_id,
                                                data: $("form").serialize(),
                                                success: function(html) {
                                                    $("#division").html(html);																							
                                                },
                                                update:"#division",
                                            });
                                        } 

                                        $(this).parent("td").parent("tr").removeClass("checked");
                                        $(this).parent("td").parent("tr").addClass("unchecked");
                                    }'
                                ),
                            ),
                            'name'
                        ),
                    )); ?>
                    <?php $this->endWidget(); ?>
                    <h2>Division</h2>
                    <div class="grid-view" id="division" >
                        <?php $this->renderPartial('_detailDivision', array('warehouse' => $warehouse)); ?>
                        <div class="clearfix"></div><div style="display:none" class="keys"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="small-12 medium-6 columns">
            <div class="field buttons text-center">
                <?php echo CHtml::button('Generate Section', array(
                    'class' => 'button cbutton',
                    'onclick' => '
                        column = jQuery("#Warehouse_column").val();
                        row = jQuery("#Warehouse_row").val();
                        $.ajax({
                                type: "POST",
                                //dataType: "JSON",
                                url: "' . CController::createUrl('ajaxHtmlAddSectionDetail', array('id' => $warehouse->header->id)) . '&column="+column+"&row="+row,
                                data: $("form").serialize(),
                                success: function(data){
                                        $("#section").html(data);
                                },
                        });
                    '
                )); ?>
            </div>

            <h2>Section</h2>
            <div class="grid-view" id="section" >
                <?php $this->renderPartial('_detailSection', array(
                    'warehouse' => $warehouse, 
                    'product' => $product, 
                    'productDataProvider' => $productDataProvider
                )); ?>
                <div class="clearfix"></div><div style="display:none" class="keys"></div>
            </div>
        </div>
    </div>

    <hr />
    
    <div class="field buttons text-center">
        <?php echo CHtml::submitButton($warehouse->header->isNewRecord ? 'Create' : 'Save', array('class' => 'button cbutton')); ?>
    </div>
<?php $this->endWidget(); ?>

</div>