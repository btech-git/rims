<?php

Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });

    $('.search-form form').submit(function(){
        $('#registration-transaction-grid').yiiGridView('update', {
            data: $(this).serialize()
        });
        return false;
    });
");
?>

<div id="maincontent">
    <div class="clearfix page-action">
        <h1>Kendaraan dalam Bengkel</h1>
    </div>
    <div class="clearfix"></div>
</div>

<br />

<div class="grid-view">
    <table>
        <thead>
            <tr>
                <th>Plat #</th>
                <th>Kendaraan</th>
                <th>Warna</th>
                <th>Tahun</th>
                <th>Customer</th>
                <th>Status</th>
                <th>Tanggal Masuk</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach($vehicles as $vehicle): ?>
                <tr>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'plate_number')); ?></td>
                    <td>
                        <?php echo CHtml::encode(CHtml::value($vehicle, 'carMake.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($vehicle, 'carModel.name')); ?> -
                        <?php echo CHtml::encode(CHtml::value($vehicle, 'carSubModel.name')); ?>
                    </td>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'color.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'year')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'customer.name')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'status_location')); ?></td>
                    <td><?php echo CHtml::encode(CHtml::value($vehicle, 'entry_datetime')); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>