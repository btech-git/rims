<table class="items">
	<thead>
		<tr>
			<th colspan="2">Position</th>
				<!-- <th><a href="#" class="sort-link">Level</a></th>
				<th><a href="#" class="sort-link"></a></th> -->
			</tr>
		</thead>
		<tbody >
			
			<?php foreach ($position->levelDetails as $i => $levelDetail): ?>
				<tr>
					<td>
						<?php echo CHtml::activeHiddenField($levelDetail,"[$i]level_id"); ?>
						<?php $levelName = Level::model()->findByPK($levelDetail->level_id); ?>
						<?php echo CHtml::activeTextField($levelDetail,"[$i]level_name",array('value'=>$levelDetail->level_id!= '' ? $levelName->name : '','readonly'=>true )); ?>
					</td>
					<td>
                        <?php echo CHtml::button('X', array(
                            'onclick' => CHtml::ajax(array(
                                'type' => 'POST',
                                'url' => CController::createUrl('ajaxHtmlRemoveLevelDetail', array('id' => $position->header->id, 'index' => $i)),
                                'update' => '#level',
                            )),
                        )); ?>
				     </td>
				 </tr>
				<?php endforeach ?>
			</tbody>
		</table>