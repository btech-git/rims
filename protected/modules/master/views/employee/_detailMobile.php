<div class="row collapse">
<div class="small-4 columns"></div>
<div class="small-8 columns">
<table class="detail">
	
			<?php foreach ($employee->mobileDetails as $i => $mobileDetail): ?>
			<tr>
		
				<td>
					<?php echo CHtml::activeTextField($mobileDetail,"[$i]mobile_no",
						array(
							//'size'=>15,
							//'maxlength'=>10,
			        //'value' => $mobileDetail->id == "" ? '': $mobileDetail->mobile_no,
						)); 

					?>
		
				
				</td>
				<td>
				<?php
				    echo CHtml::button('X', array(
				     	'onclick' => CHtml::ajax(array(
					       	'type' => 'POST',
					       	'url' => CController::createUrl('ajaxHtmlRemoveMobileDetail', array('id' => $employee->header->id, 'index' => $i)),
					       	'update' => '#mobile',
			      		)),
			     	));
		     	?>
		    </td> 
			</tr>
			
		<?php endforeach; ?>

	

</table>
</div>		
</div>

						
						
					
	
	

