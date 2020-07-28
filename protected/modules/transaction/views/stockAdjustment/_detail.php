<table border="0" cellspacing="0" cellpadding="0" id="tblDetail" style="<?php echo ($model->id == NULL)? "display: none":""; ?>">
    <thead>
    <tr class="modelDetailHeader">
       <th style="min-width: 200px;">Product</th>
       <?php foreach ($warehouse as $key) {
            echo "<th>".$key->name."</th>";
       }?>
       <th>Adjust Qty</th>
    </tr>
    <?php 
        if ($model->id != NULL) { 

            // var_dump($modelDetail);
            // $modelsProduct=StockAdjustmentDetail::model()->findAll(array(
            //     'select'=>'t.product_id',
            //     'group'=>'t.product_id',
            //     'where'=>'stock_adjustment_header_id = '.$model->id,
            //     'distinct'=>true,
            // ));

        $criteria = new CDbCriteria;
        $criteria->select = 'product_id';
        $criteria->condition = 'stock_adjustment_header_id = '.$model->id;
        $criteria->distinct = true;
        $criteria->group = 'product_id';
        $modelsProduct = StockAdjustmentDetail::model()->findAll($criteria);


        // var_dump($modelsProduct); 

        foreach ($modelsProduct as $key => $value) {
            // echo $value->product_id;
            echo "<tr id=\"trid_{$value->product_id}\" rel=\"{$value->product_id}\"><td width=\"200px\">";
            echo "<input type=\"hidden\" value=\"{$value->product_id}\" name=\"StockAdjustmentDetail[id][]\"/> {$value->product->name}</td>";
            $total =0;
            foreach ($warehouse as $wh) {
                $tok = Inventory::getTotalStock($value->product_id,$wh->id);
                $stock_in = StockAdjustmentDetail::getCurrentStock($model->id,$value->product_id,$wh->id,'stockin');
                $stock_out = StockAdjustmentDetail::getCurrentStock($model->id,$value->product_id,$wh->id,'stockout');

                $stock = ($stock_in + $stock_out);

                $total = ($total + $stock); 
                // echo $wh->id.$value->product_id."=====>".$stock_in ." < >".$stock_out." = ".$stock."<br >";

                // if ($stockout <=0)
                // if ($stock_in != 0) {
                //     $stock = $stock_in;
                // }elseif ($stock_out != 0) {
                //     $stock = $stock_out;
                // }else{
                //     $stock = 0;
                // }

                /*foreach ($modelDetail as $key => $modelDetailvalue) {
                    if ($wh->id == $modelDetailvalue->warehouse_id) {
                        $stock_in = $modelDetailvalue->stock_in; 
                        $stock_out = $modelDetailvalue->stock_out; 
                        if ($stock_in != 0) {
                            $stock = $stock_in;
                        }elseif ($stock_out != 0) {
                            $stock = $stock_out;
                        }else{
                            $stock = 0;
                        }
                        //$stock = ($stock_in == 0) ? ($stock_out == 0) ? 0 : $stock_in : $stoc;
                        // echo '<td><input placeholder="Stock" class="stock_wh" type="number" value="'.$stock.'" name="warehouse_id['.$modelDetailvalue->warehouse_id.'][]" id="warehouse_id_'.$modelDetailvalue->warehouse_id.'"><label class="sufix">(stock)</label></td>';
                        // continue;
                    }
                }*/
                echo '<td><input placeholder="Stock" class="stock_wh" type="number" value="'.$stock.'" name="warehouse_id['.$wh->id.'][]" id="warehouse_id_'.$wh->id.'" readonly><label class="sufix">('.$tok.')</label></td>';
            }
            echo "<hr />";

            echo '<td><input type="text" id="sum_count_'.$value->product_id.'" readonly="readonly" value="'.$total.'"></td></tr>';
        }

            ?>
    <?php
        }
    ?>
    </thead>
    <tbody>
    </tbody>
</table>