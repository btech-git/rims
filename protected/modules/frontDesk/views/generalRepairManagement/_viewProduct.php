<div style="height: 350px">
    <h1>Products</h1>
    <table>
        <thead>
            <th>Product</th>
            <th>Quantity</th>
            <th>Quantity Movement</th>
            <th>Quantity Movement Left</th>
            <th>Quantity Receive</th>
            <th>Quantity Receive Left</th>
            <th>Action</th>
        </thead>
        
        <tbody>
            <?php foreach ($registrationTransaction->registrationProducts as $key => $rp): ?>
                <tr>
                    <td><?php echo $rp->product->name; ?></td>
                    <td><?php echo $rp->quantity; ?></td>
                    <td><?php echo $rp->quantity_movement; ?></td>
                    <td><?php echo $rp->quantity_movement_left; ?></td>
                    <td><?php echo $rp->quantity_receive; ?></td>
                    <td><?php echo $rp->quantity_receive_left; ?></td>
                    <td>
                        <?php echo CHtml::tag('button', array(
                            'type'=>'button',
                            'class' => 'hello button expand',
                            'onclick'=>'$("#detail-'.$key.'").toggle();'
                        ), '<span class="fa fa-caret-down"></span> Detail');?>
                    </td>
                </tr>
                <tr>
                    <td id="detail-<?php echo $key?>" class="hide" colspan=6>
                        <?php 
                        $mcriteria = new CDbCriteria;
                        $mcriteria->together = 'true';
                        $mcriteria->with = array('movementOutHeader');
                        $mcriteria->condition="movementOutHeader.status ='Delivered' AND registration_product_id = ".$rp->id;
                        $getMovementDetails = MovementOutDetail::model()->findAll($mcriteria); 
                        ?>
                        <table>
                            <thead>
                                <tr>
                                    <th>Movement #</th>
                                    <th>Quantity Movement</th>
                                    <th>Quantity Received</th>
                                    <th>Quantity Received Left</th>
                                    <th>Quantity Receive</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <?php foreach ($getMovementDetails as $i => $md): ?>
                                <tr>
                                    <td>
                                        <?php echo $md->movementOutHeader->movement_out_no; ?>
                                        <input type="hidden" id="movementOut-<?php echo $i?>" value="<?php echo $md->movement_out_header_id; ?>">
                                        <input type="hidden" id="movementOutDetail-<?php echo $i?>" value="<?php echo $md->id; ?>">
                                    </td>
                                    <td><input type="text" id="quantityMovement-<?php echo $i?>" value="<?php echo $md->quantity ?>" readonly="true"></td>
                                    <td><input type="text" id="quantityReceived-<?php echo $i?>" value="<?php echo $md->quantity_receive ?>" readonly="true"></td>
                                    <td><input type="text" id="quantityReceivedLeft-<?php echo $i?>" value="<?php echo $md->quantity_receive_left ?>" readonly="true"></td>
                                    <td>
                                        <?php if ($md->quantity_receive_left > 0 || $md->quantity_receive_left == ""): ?>
                                            <input type="text" id="quantity-<?php echo $i?>" onchange ="
                                                var move = +$('#quantityMovement-<?php echo $i?>').val();
                                                var quantity = +$('#quantity-<?php echo $i?>').val();
                                                if (quantity > move)
                                                {
                                                    alert('Quantity Receive could not be greater than Quantity Movement');
                                                    $('#quantity-<?php echo $i?>').val(' ');
                                                };
                                            ">
                                        <?php else: ?>
                                            <input type="text" id="quantity-<?php echo $i?>" readonly="true">
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php echo CHtml::button('Receive', array(
                                            'id' => 'detail-button',
                                            'name' => 'Detail',
                                            'class'=>'button cbutton left',
                                            'disabled'=>$md->quantity_receive_left > 0 || $md->quantity_receive_left == "" ? false : true,
                                            'onclick' => ' 
                                                $.ajax({
                                                    type: "POST",
                                                    //dataType: "JSON",
                                                    url: "' . CController::createUrl('receive', array('movementOutDetailId'=> $md->id,'registrationProductId'=>$rp->id,'quantity'=>'')) .'"+$("#quantity-'.$i.'").val(),
                                                    data: $("form").serialize(),
                                                    success: function(html) {
                                                        alert("Success");
                                                        location.reload();
                                                    },
                                                })
                                            '
                                        )); ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </table>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>