<table class="items saved_war" >
    <thead>
        <tr>
            <th colspan="2">Warehouse</th>
            <!-- <th><a href="#" class="sort-link">Level</a></th>
            <th><a href="#" class="sort-link"></a></th> -->
        </tr>
    </thead>
    <tbody >
        <?php foreach ($division->warehouseDetails as $i => $warehouseDetail): ?>
            <tr class="added" >
                <td><?php echo CHtml::activeHiddenField($warehouseDetail,"[$i]warehouse_id"); ?>
                <?php $warehouse = Warehouse::model()->findByPK($warehouseDetail->warehouse_id); ?>
                <?php echo CHtml::activeTextField($warehouseDetail,"[$i]warehouse_name",array('value'=>$warehouseDetail->warehouse_id!= '' ? $warehouse->name : '','readonly'=>true )); ?></td>
                <td>
                    <?php /*echo CHtml::button('X', array(
                        'onclick' => CHtml::ajax(array(
                            'type' => 'POST',
                            'url' => CController::createUrl('ajaxHtmlRemoveWarehouseDetail', array('id' => $division->header->id,'war_name'=>$warehouse->name , 'index' => $i)),
                            'update' => '#warehouse',
                            'success' => 'function(data){
                               var clicked_id = $(this).attr("url");
                               var war_id_split = clicked_id.split("war_name=");
                               var war_id = war_id_split[1].split("&");
                                alert(war_id[0]);
                                alert($("#warehouse-dialog").find("tr").children("td:nth-child(2)").html());
                                if($("#warehouse-dialog").find("tr").children("td:nth-child(2)").html()==war_id[0])
                                {
                                    alert("here")
                                }
                            }',
                        )),
                    ));*/ ?>
                </td>
            </tr>
        <?php endforeach ?>
    </tbody>
</table>