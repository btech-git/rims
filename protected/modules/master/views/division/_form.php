<?php
/* @var $this DivisionController */
/* @var $division->header Division */
/* @var $form CActiveForm */
?>

<div class="clearfix page-action">
<a class="button cbutton right" href="<?php echo Yii::app()->baseUrl.'/master/division/admin';?>"><span class="fa fa-th-list"></span>Manage Divisions</a>
<h1><?php if($division->header->isNewRecord){ echo "New Division"; }else{ echo "Update Division";}?></h1>
<!-- begin FORM -->

<div class="form">

   <?php $form=$this->beginWidget('CActiveForm', array(
	'id'=>'division-form',
	// Please note: When you enable ajax validation, make sure the corresponding
	// controller action is handling ajax validation correctly.
	// There is a call to performAjaxValidation() commented in generated controller code.
	// See class documentation of CActiveForm for details on this.
	'enableAjaxValidation'=>false,
	)); ?>
	 <hr />
   <p class="note">Fields with <span class="required">*</span> are required.</p>

   
    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($division->header,'code'); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($division->header,'code',array('size'=>20,'maxlength'=>20)); ?>
                        <?php echo $form->error($division->header,'code	'); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($division->header,'name'); ?></label>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->textField($division->header,'name',array('size'=>60,'maxlength'=>100)); ?>
                        <?php echo $form->error($division->header,'name'); ?>
                    </div>
                </div>
            </div>
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <label class="prefix"><?php echo $form->labelEx($division->header,'status'); ?>
                        </div>
                        <div class="small-8 columns">
                            <?php echo  $form->dropDownList($division->header, 'status', array('Active' => 'Active',
                            'Inactive' => 'Inactive', )); ?>
                            <?php echo $form->error($division->header,'status'); ?>
                        </div>
                    </div>
                </div>
            </div>

        <!-- begin RIGHT -->
            <div class="small-12 medium-6 columns">
                <div class="row">
                    <div class="small-12 columns">
                    <?php echo CHtml::button('Add Detail', array(
                                        'id' => 'detail-button',
                                        'name' => 'Detail',
                                        'class'=>'button extra right',
                                        'onclick' => '								
                                            jQuery("#position-dialog").dialog("open");
                                            return false;',
                                        )
                                    ); ?>
                                    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                        'id' => 'position-dialog',
                                        // additional javascript options for the dialog plugin
                                        'options' => array(
                                            'title' => 'Position',
                                            'autoOpen' => false,
                                            'width' => 'auto',
                                            'modal' => true,
                                        ),));
                                    ?>

                                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                                        'id'=>'position-grid',
                                        'dataProvider'=>$positionDataProvider,
                                        'filter'=>$position,
                                        // 'summaryText'=>'',
                                        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                                        'pager'=>array(
                                           'cssFile'=>false,
                                           'header'=>'',
                                        ),
                                        'selectionChanged'=>'js:function(id){

                                                var selectedPosition = $(".selected").find("td").html();
                                                var positionArray = [];

                                                jQuery("#position tr").each(function(){													
                                                    var savedPosition = $(this).find("input[type=text]").val();																						
                                                    positionArray.push(savedPosition); 
                                                });
                                                if(jQuery.inArray(selectedPosition, positionArray)!= -1) {
                                                    alert("Please select other Position , this is already added");
                                                    return false;
                                                } else {


                                                    $.ajax({
                                                        type: "POST",
                                                        //dataType: "JSON",
                                                        url: "' . CController::createUrl('ajaxHtmlAddPositionDetail', array()) . '/id/'.$division->header->id.'/positionId/"+$.fn.yiiGridView.getSelection(id),
                                                        data: $("form").serialize(),
                                                        success: function(html) {

                                                            $("#position").html(html);

                                                        },
                                                    });
                                                    $(this).removeClass( "selected" );
                                                    $(this).addClass( "added" );
                                                }
                                        }',
                                        'columns'=>array(
                                            array(
                                                    'name' => 'check',
                                                    'id' => 'selectedIds',
                                                    'value' => '$data->id',
                                                    'class' => 'CCheckBoxColumn',
                                                    'checked' => function($data) use($positionArray) {
                                        return in_array($data->id, $positionArray); 
                                },
                                                    'selectableRows' => '100',	
                                                    'checkBoxHtmlOptions' => array(
                                                                                 'onclick' => 'js: if($(this).is(":checked")==true){
                                                                                            var checked_val= $(this).val();

                                                                                            var selected_position = $(this).parent("td").siblings("td").html();
                                                                                            var myArray = [];

                                                                                            jQuery("#position tr").each(function(){													
                                                                                                var savedPositions = $(this).find("input[type=hidden]").val();																						
                                                                                                myArray.push(savedPositions); 
                                                                                            });
                                                                                            if(jQuery.inArray(selected_position, myArray)!= -1) {
                                                                                                alert("Please select other position, this is already added");
                                                                                                return false;
                                                                                            } else {

                                                                                                    $.ajax({
                                                                                                    type: "POST",
                                                                                                    //dataType: "JSON",
                                                                                                    url: "' . CController::createUrl('ajaxHtmlAddPositionDetail', array()) . '/id/'.$division->header->id.'/positionId/"+$(this).val(),
                                                                                                    data: $("form").serialize(),
                                                                                                    success: function(html) {
                                                                                                        $("#position").html(html);	
                                                                                                        //$.fn.yiiGridView.update("#position-grid");
                                                                                                    },
                                                                                                });
                                                                                                $(this).parent("td").parent("tr").addClass("checked");
                                                                                                $(this).parent("td").parent("tr").removeClass("unchecked");
                                                                                            }


                                                                                    }else{
                                                                                            var unselected_position_val = $(this).val();
                                                                                            var unselected_position = $(this).parent("td").siblings("td").html();
                                                                                            var myArray = [];
                                                                                            var count = 0;
                                                                                            jQuery("#position tr").each(function(){													
                                                                                                var removedPosition = $(this).find("input[type=hidden]").val();																						
                                                                                                myArray.push(removedPosition);																						
                                                                                                if(unselected_position_val==removedPosition){
                                                                                                    index_id = count-1;																		
                                                                                                }
                                                                                                count++;
                                                                                            });
                                                                                            if(jQuery.inArray(unselected_position_val, myArray)!= -1) {

                                                                                                $.ajax({
                                                                                                    type: "POST",
                                                                                                    //dataType: "JSON",
                                                                                                    url: "' . CController::createUrl('ajaxHtmlRemovePositionDetail', array()) . '/id/'.$division->header->id.'/position_name/"+unselected_position_val+"/index/"+index_id,
                                                                                                    data: $("form").serialize(),
                                                                                                    success: function(html) {
                                                                                                        $("#position").html(html);																							
                                                                                                    },
                                                                                                    update:"#position",
                                                                                                });
                                                                                            } 


                                                                                            $(this).parent("td").parent("tr").removeClass("checked");
                                                                                            $(this).parent("td").parent("tr").addClass("unchecked");
                                                                                    }'
                                                                                ),											
                                                ),
                                            //'code',
                                            'name'

                                        ),
                                    ));?>
                                    <?php $this->endWidget(); ?>
                    <h2>Position</h2>
                    <div class="grid-view" id="position" >
                            <?php $this->renderPartial('_detail', array('division'=>$division
                                    )); ?>
                            <div class="clearfix"></div><div style="display:none" class="keys"></div>
                    </div>
                    </div>
                </div>

                <div class="row">
                    <div class="small-12 columns">
                    <?php echo CHtml::button('Add Branch', array(
                                        'id' => 'detail-branch-button',
                                        'name' => 'Detail',
                                        'class'=>'button extra right',
                                        'onclick' => '

                                            jQuery("#branch-dialog").dialog("open"); return false;',

                                        )
                                    ); ?>
                                    <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                                        'id' => 'branch-dialog',
                                        // additional javascript options for the dialog plugin
                                        'options' => array(
                                            'title' => 'Branch',
                                            'autoOpen' => false,
                                            'width' => 'auto',
                                            'modal' => true,
                                        ),));
                                    ?>

                                    <?php $this->widget('zii.widgets.grid.CGridView', array(
                                        'id'=>'branch-grid',
                                        'dataProvider'=>$branchDataProvider,
                                        'filter'=>$branch,
                                        // 'summaryText'=>'',
                                        'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                                        'pager'=>array(
                                           'cssFile'=>false,
                                           'header'=>'',
                                        ),

                                        'columns'=>array(
                                             array(
                                                    'name' => 'check',
                                                    'id' => 'selectedIds',
                                                    'value' => '$data->id',
                                                    'class' => 'CCheckBoxColumn',
                                                    'checked' => function($data) use($branchArray) {
                                        return in_array($data->id, $branchArray); 
                                },
                                                    'selectableRows' => '100',	
                                                    'checkBoxHtmlOptions' => array(
                                                                                 'onclick' => 'js: if($(this).is(":checked")==true){
                                                                                            var checked_val= $(this).val();

                                                                                            var selected_branch = $(this).parent("td").siblings("td").html();
                                                                                            var myArray = [];

                                                                                            jQuery("#branch tr").each(function(){													
                                                                                                var savedBranches = $(this).find("input[type=hidden]").val();																						
                                                                                                myArray.push(savedBranches); 
                                                                                            });
                                                                                            if(jQuery.inArray(selected_branch, myArray)!= -1) {
                                                                                                alert("Please select other branch, this is already added");
                                                                                                return false;
                                                                                            } else {

                                                                                                    $.ajax({
                                                                                                    type: "POST",
                                                                                                    //dataType: "JSON",
                                                                                                    url: "' . CController::createUrl('ajaxHtmlAddBranchDetail', array()) . '/id/'.$division->header->id.'/branchId/"+$(this).val(),
                                                                                                    data: $("form").serialize(),
                                                                                                    success: function(html) {
                                                                                                        $("#branch").html(html);	
                                                                                                        //$.fn.yiiGridView.update("#branch-grid");
                                                                                                    },
                                                                                                });
                                                                                                $(this).parent("td").parent("tr").addClass("checked");
                                                                                                $(this).parent("td").parent("tr").removeClass("unchecked");
                                                                                            }


                                                                                    }else{
                                                                                            var unselected_branch_var = $(this).val();
                                                                                            var unselected_branch = $(this).parent("td").siblings("td").html();
                                                                                            var myArray = [];
                                                                                            var count = 0;
                                                                                            jQuery("#branch tr").each(function(){													
                                                                                                var savedBranch = $(this).find("input[type=hidden]").val();																						
                                                                                                myArray.push(savedBranch);																						
                                                                                                if(unselected_branch_var==savedBranch){
                                                                                                    index_id = count-1;																		
                                                                                                }
                                                                                                count++;
                                                                                            });
                                                                                            if(jQuery.inArray(unselected_branch_var, myArray)!= -1) {

                                                                                                $.ajax({
                                                                                                    type: "POST",
                                                                                                    //dataType: "JSON",
                                                                                                    url: "' . CController::createUrl('ajaxHtmlRemoveBranchDetail', array()) . '/id/'.$division->header->id.'/branch_name/"+unselected_branch_var+"/index/"+index_id,
                                                                                                    data: $("form").serialize(),
                                                                                                    success: function(html) {
                                                                                                        $("#branch").html(html);																							
                                                                                                    },
                                                                                                    update:"#branch",
                                                                                                });
                                                                                            } 


                                                                                            $(this).parent("td").parent("tr").removeClass("checked");
                                                                                            $(this).parent("td").parent("tr").addClass("unchecked");
                                                                                    }'
                                                                                ),											
                                                ),
                                            //'code',
                                            'name'

                                        ),
                                    ));?>
                                    <?php $this->endWidget(); ?>
                    <h2>Branch</h2>
                    <div class="grid-view" id="branch" >
                            <?php $this->renderPartial('_detailBranch', array('division'=>$division
                                    )); ?>
                            <div class="clearfix"></div><div style="display:none" class="keys"></div>
                    </div>
                    </div>
                </div>

                <div class="row">
                    <div class="small-12 columns">
                        <?php echo CHtml::button('Add Warehouse', array(
                            'id' => 'detail-warehouse-button',
                            'name' => 'Detail',
                            'class'=>'button extra right',
                            'onclick' => 'jQuery("#warehouse-dialog").dialog("open"); return false;',
                        )); ?>
                        
                        <?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                            'id' => 'warehouse-dialog',
                            // additional javascript options for the dialog plugin
                            'options' => array(
                                'title' => 'Warehouse',
                                'autoOpen' => false,
                                'width' => 'auto',
                                'modal' => true,
                            ),
                        )); ?>

                        <?php $this->widget('zii.widgets.grid.CGridView', array(
                            'id'=>'warehouse-grid',
                            'dataProvider'=>$warehouseDataProvider,
                            'filter'=>$warehouse,
                            'summaryText'=>'',								
                            'template' => '{items}<div class="clearfix">{summary}{pager}</div>',
                            'pager'=>array(
                               'cssFile'=>false,
                               'header'=>'',
                            ),
                            'columns'=>array(
                                 array(
                                        'name' => 'check',
                                        'id' => 'selectedIds',
                                        'value' => '$data->id',
                                        'class' => 'CCheckBoxColumn',
                                        'checked' => function($data) use($warehouseArray) {
                                            return in_array($data->id, $warehouseArray); 
                                        },
                                        'selectableRows' => '100',	
                                        'checkBoxHtmlOptions' => array(
                                            'onclick' => '
                                                js: if ($(this).is(":checked")==true) {
                                                    var checked_val= $(this).val();

                                                    var selected_warehouse = $(this).parent("td").siblings("td").html();
                                                    var myArray = [];

                                                    jQuery("#warehouse tr").each(function(){													
                                                        var savedWar = $(this).find("input[type=hidden]").val();																						
                                                        myArray.push(savedWar); 
                                                    });
                                                    
                                                    if (jQuery.inArray(selected_warehouse, myArray)!= -1) {
                                                        alert("Please select other Warehouse, this is already added");
                                                        return false;
                                                    } else {
                                                        $.ajax({
                                                        type: "POST",
                                                        //dataType: "JSON",
                                                        url: "' . CController::createUrl('ajaxHtmlAddWarehouseDetail', array()) . '/id/'.$division->header->id.'/warehouseId/"+$(this).val(),
                                                        data: $("form").serialize(),
                                                        success: function(html) {
                                                            $("#warehouse").html(html);	
                                                            //$.fn.yiiGridView.update("#warehouse-grid");
                                                        },
                                                    });
                                                    $(this).parent("td").parent("tr").addClass("checked");
                                                    $(this).parent("td").parent("tr").removeClass("unchecked");
                                                }
                                            } else {
                                                var unchecked_val= $(this).val();

                                                var unselected_warehouse = $(this).parent("td").siblings("td").html();
                                                var myArray = [];
                                                var count = 0;
                                                jQuery("#warehouse tr").each(function(){													
                                                    var savedWar = $(this).find("input[type=hidden]").val();																						
                                                    myArray.push(savedWar);																						
                                                    if(unchecked_val==savedWar){
                                                        index_id = count-1;																		
                                                    }
                                                    count++;
                                                });
                                                if(jQuery.inArray(unchecked_val, myArray)!= -1) {

                                                    $.ajax({
                                                        type: "POST",
                                                        //dataType: "JSON",
                                                        url: "' . CController::createUrl('ajaxHtmlRemoveWarehouseDetail', array()) . '/id/'.$division->header->id.'/war_name/"+unchecked_val+"/index/"+index_id,
                                                        data: $("form").serialize(),
                                                        success: function(html) {
                                                            $("#warehouse").html(html);																							
                                                        },
                                                        update:"#warehouse",
                                                    });
                                                } 


                                                $(this).parent("td").parent("tr").removeClass("checked");
                                                $(this).parent("td").parent("tr").addClass("unchecked");
                                            }'
                                        ),											
                                    ),
                                //'code',
                                'name'

                                ),
                            ));?>
                            <?php $this->endWidget(); ?>
                    <h2>Warehouse</h2>
                    <div class="grid-view" id="warehouse" >
                        <?php $this->renderPartial('_detailWarehouse', array('division'=>$division)); ?>
                        <div class="clearfix"></div><div style="display:none" class="keys"></div>
                    </div>
                </div>
            </div>
            <!-- end RIGHT -->		
        </div>
        
        <hr />
        
        <div class="field buttons text-center">
          <?php echo CHtml::submitButton($division->header->isNewRecord ? 'Create' : 'Save', array('class'=>'button cbutton')); ?>
        </div>
        <?php $this->endWidget(); ?>

    </div>
</div>