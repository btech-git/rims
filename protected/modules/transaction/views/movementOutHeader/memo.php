<?php
Yii::app()->clientScript->registerScript('memo', '
    $("#utilities").addClass("hide");
    $("#header").addClass("hide");
    $("#mainmenu").addClass("hide");
    $(".breadcrumbs").addClass("hide");
    $("#footer").addClass("hide");
');
Yii::app()->clientScript->registerCssFile(Yii::app()->request->baseUrl . '/css/transaction/memo.css');
Yii::app()->clientScript->registerCss('memo', '
    @page {
        size:auto;
        margin: 5px 0px 0px 0px;
    }
    .hcolumn1 { width: 50% }
    .hcolumn2 { width: 50% }

    .hcolumn1header { width: 35% }
    .hcolumn1value { width: 65% }
    .hcolumn2header { width: 35% }
    .hcolumn2value { width: 65% }

    .sig1 { width: 25% }
    .sig2 { width: 50% }
    .sig3 { width: 25% }
    
    .memo-title
    {
        margin-left:35%;
        font-size:9px;
    }
');
?>

<div id="memoheader">
    <div class="memo-logo"><img src="<?php echo Yii::app()->request->baseUrl; ?>/images/rap-logo.png" alt="" width="15%"/></div>
    <div class="memo-title">
        <p style="font-size: 10px">
            Jl. Raya Jati Asih/Jati Kramat - 84993984/77 Fax. 84993989 <br />
            Jl. Raya Kalimalang No. 8, Kp. Dua - 8843656 Fax. 88966753<br />
            Jl. Raya Kalimalang Q/2D - 8643594/95 Fax. 8645008<br />
            Jl. Raya Radin Inten II No. 9 - 8629545/46 Fax. 8627313<br />
            Jl. Celebration Boulevard Blok AA 9/35 - 8261594<br />
            Email info@raperind.com
        </p>
    </div>
</div>

<hr />
<h3>SURAT JALAN</h3>
<br /><br /><br />
  
<div id="memonote">
    <table style="background-color: white;">
        <tr>
            <td style="text-align: left; line-height: 0rem"><?php echo CHtml::encode(CHtml::value($model, 'movement_out_no')); ?></td>
        </tr>
        <tr>
            <td style="text-align: left; line-height: 0rem"><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($model, 'date_posting'))); ?></td>
        </tr>
        <tr>
            <?php
            if ($model->movement_type == 1) {
                $movementType = "Delivery Order";
            } elseif ($model->movement_type == 2) {
                $movementType = "Return Order";
            } elseif ($model->movement_type == 3) {
                $movementType = "GR/BR";
            } elseif ($model->movement_type == 4) {
                $movementType = "Permintaan Bahan";
            } else {
                $movementType = "";
            }
            ?>
            <td style="text-align: left; line-height: 0rem"><?php echo CHtml::encode($movementType); ?></td>
        </tr>
    </table>
</div>
<br /><br /><br /><br />

<div id="memonote">
    <table>
        <tr style="background-color: skyblue">
            <th style="width: 5%; text-align: center">NO</th>
            <th>Code</th>
            <th>Product</th>
            <th>Brand</th>
            <th>Qty Request</th>
            <th>Qty Stock</th>
            <th>Qty Movement</th>
        </tr>
        <?php $no = 1;?>
        <?php if (count($details) > 0): ?>
            <?php foreach ($details as $detail): ?>
                <?php $product = $detail->product; ?>
                <tr class="isi">
                    <td><?php echo $no ?></td>
                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($product, 'manufacturer_code')); ?></td>
                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($product, 'name')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($product, 'brand.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($product, 'subBrand.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($product, 'subBrandSeries.name')); ?>
                    </td>
                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'quantity_transaction')); ?></td>
                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'quantity_stock')); ?></td>
                    <td>&nbsp; <?php echo CHtml::encode(CHtml::value($detail, 'quantity')); ?></td>
                </tr>
                <?php $no++; ?>
            <?php endforeach; ?>
        <?php endif; ?>
    </table>
</div>

<div>
    <h4>Jakarta, <?php echo tanggal(date('Y-m-d')); ?></h4>
    Yang Mengirim,
    <p class="authorized"></p>
</div>