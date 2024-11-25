<div class="row collapse">
    <div class="small-12 columns">
        <table class="detail">
            <?php foreach ($company->bankDetails as $i => $bankDetail): ?>
                <tr>
                    <td>
                        <?php echo CHtml::activeHiddenField($bankDetail,"[$i]bank_id"); ?>
                        <?php echo CHtml::activeTextField($bankDetail,"[$i]bank_name",array('size'=>35,'readonly'=>'true','value'=> $bankDetail->bank_id != "" ? $bankDetail->bank->name : '')); ?>
                    </td>		
                    <td>
                        <?php echo CHtml::activeTextField($bankDetail,"[$i]account_name", array(
                            'size'=>25,
                            //'maxlength'=>10,
                            //'value' => $bankDetail->id == "" ? '': $bankDetail->account_name,
                            'placeholder' => 'Account Name',
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($bankDetail,"[$i]account_no", array(
                            'size'=>25,
                            //'size'=>15,
                            //'maxlength'=>10,
                            //'value' => $bankDetail->id == "" ? '': $bankDetail->account_no,
                            'placeholder' => 'Account Number',
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($bankDetail,"[$i]swift_code", array(
                            'size'=>25,
                            //'size'=>15,
                            //'maxlength'=>10,
                            //'value' => $bankDetail->id == "" ? '': $bankDetail->account_no,
                            'placeholder' => 'Swift code',
                        )); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeDropDownList($bankDetail, "[$i]coa_id", CHtml::listData(Coa::model()->findAll(array(
                            'condition' => 't.coa_sub_category_id IN (1, 2, 3) AND t.status = "Approved"', 
                            'order' => 't.name'
                        )), 'id', 'name'), array(
                            'empty' => '-Pilih COA-'
                        )); ?>
                        <?php /*echo CHtml::activeHiddenField($bankDetail,"[$i]coa_id"); ?>
                        <?php echo CHtml::activeTextField($bankDetail,"[$i]coa_name", array(
                            'size'=>25,
                            //'size'=>15,
                            //'maxlength'=>10,
                            'rel'=>$i,
                            'onclick' => '
                                currentDetail=$(this).attr("rel");
                                $("#coa-dialog").dialog("open"); 
                                return false;
                            ',
                            'value' => $bankDetail->coa_id == "" ? '': $bankDetail->coa->name,
                            'placeholder' => 'COA Name',
                        ));*/ ?>
                    </td>
                    <td>
                        <?php echo CHtml::button('X', array(
                            'onclick' => CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajaxHtmlRemoveBankDetail', array('id' => $company->header->id, 'index' => $i)),
                                'update' => '#bank',
                            )),
                        )); ?>
                    </td> 
                </tr>
            <?php endforeach; ?>
        </table>
    </div>		
</div>

						
						
					
	
	

