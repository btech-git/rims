<div class="row collapse">
<div class="small-4 columns"></div>
<div class="small-8 columns">
<table class="detail">
	
			<?php foreach ($branch->faxDetails as $i => $faxDetail): ?>
			<tr>
		
				<td>
					<?php echo CHtml::activeTextField($faxDetail,"[$i]fax_no",
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
					       	'url' => CController::createUrl('ajaxHtmlRemoveFaxDetail', array('id' => $branch->header->id, 'index' => $i)),
					       	'update' => '#fax',
			      		)),
			     	));
		     	?>
		    </td> 
			</tr>
			
		<?php endforeach; ?>

	

</table>
</div>		
</div>

						
						
					
	
	

