<div class="row collapse">
<div class="small-4 columns"></div>
<div class="small-8 columns">
<table class="detail">
	
	<?php foreach ($customer->phoneDetails as $i => $phoneDetail): ?>
			<tr>
		
				<td>
				
					<?php echo CHtml::activeTextField($phoneDetail,"[$i]phone_no",
						array(
							//'size'=>15,
							//'maxlength'=>10,
			        //'value' => $phoneDetail->id == "" ? '': $phoneDetail->phone_no,
						)); 

					?>
					<?php //echo CHtml::error($phoneDetail, 'phone_no'); ?>
				
				</td>
				<td>
				
				<?php
				    echo CHtml::button('X', array(
				     	'onclick' => CHtml::ajax(array(
					       	'type' => 'POST',
					       	'url' => CController::createUrl('ajaxHtmlRemoveDetail', array('id' => $customer->header->id, 'index' => $i)),
					       	'update' => '#phone',
			      		)),
			     	));
		     	?>
		    </td>
		  </tr>
	
			
	<?php endforeach; ?>

	

</table>
</div>		
</div>
