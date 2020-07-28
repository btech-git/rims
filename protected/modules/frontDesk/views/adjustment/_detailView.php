<table border="0" cellspacing="0" cellpadding="0">
    <thead>
    <tr class="modelDetailHeader">
       <th style="min-width: 200px;">Product</th>
       <?php foreach ($warehouse as $key) {
            echo "<th>".$key->name."</th>";
       }?>
    </tr>
    <?php 

        $criteria = new CDbCriteria;
        $criteria->select = 'product_id';
        $criteria->condition = 'stock_adjustment_header_id = '.$model->id;
        $criteria->distinct = true;
        $criteria->group = 'product_id';
        $modelsProduct = StockAdjustmentDetail::model()->findAll($criteria);


            // var_dump($modelsProduct); 

        foreach ($modelsProduct as $key => $value) {
            // echo $value->product_id;
            echo "<tr id=\"trid_{$value->product_id}\" rel=\"{$value->product_id}\"><td width=\"200px\">{$value->product->name}</td>";

            foreach ($warehouse as $wh) {
                /* $stock=0;
                foreach ($modelDetail as $key => $modelDetailvalue) {
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
                        continue;
                    }
                }*/
                $tok = Inventory::getTotalStock($value->product_id,$wh->id);
                $stock_in = StockAdjustmentDetail::getCurrentStock($model->id,$value->product_id,$wh->id,'stockin');
                $stock_out = StockAdjustmentDetail::getCurrentStock($model->id,$value->product_id,$wh->id,'stockout');

                $stock = ($stock_in + $stock_out);

                echo '<td>'.$stock.' ('.$tok.')</td>';
            }

            echo '</tr>';
        }

    ?>
    </thead>
    <tbody>
    </tbody>
</table>