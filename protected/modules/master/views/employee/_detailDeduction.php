<div class="row collapse">
<div class="small-4 columns"></div>
<div class="small-8 columns">
<table class="detail">
			
			<?php foreach ($employee->deductionDetails as $i => $deductionDetail): ?>
			<tr>
				<td><?php echo CHtml::activeTextField($deductionDetail,"[$i]deduction_id"); ?></td>
				<td><?php echo CHtml::activeTextField($deductionDetail,"[$i]deduction_name",array('size'=>60,
					'value'=> $deductionDetail->deduction_id != "" ? $deductionDetail->deduction->name : ''
				)); ?>
				</td>		
				
				<td>
					<?php echo CHtml::activeTextField($deductionDetail,"[$i]amount",
						array(
							//'size'=>15,
							//'maxlength'=>10,
			        //'value' => $deductionDetail->id == "" ? '': $deductionDetail->amount,
			        'placeholder' => 'Amount',
						)); 

					?>
		
				
				</td>
				<td>
				<?php
				    echo CHtml::button('Remove', array(
				     	'onclick' => CHtml::ajax(array(
					       	'type' => 'POST',
					       	'url' => CController::createUrl('ajaxHtmlRemoveDeductionDetail', array('id' => $employee->header->id, 'index' => $i)),
					       	'update' => '#deduction',
			      		)),
			     	));
		     	?>
		    </td> 
			</tr>
			
		<?php endforeach; ?>

	

</table>
</div>		
</div>		
</div>		
</div>		
</div>		
</div>