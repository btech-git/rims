
<?php
date_default_timezone_set('Asia/Jakarta');

function tanggal($date) {
    $bulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'July', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $tahun = substr($date, 0, 4);
    $bulan2 = substr($date, 5, 2);
    $tanggal = substr($date, 8, 2);

    return $tanggal . ' ' . $bulan[(int) $bulan2 - 1] . ' ' . $tahun;
}
?>
<style>
    .dot {
    box-sizing: border-box;
    width: 2rem;
    height: 2rem;
    border-radius: 50%;
    border: .125rem solid;
    display: inline-block;
}

.dot--empty { background-color: transparent; }
.dot--full { background-color: currentColor; }

.dot--fill-right { border-right-width: 1rem; }
.dot--fill-left { border-left-width: 1rem; }

.red { color: orangered; }
.yellow { color: gold; }
.green { color: limegreen; }

.dot--small {
    width: 1rem;
    height: 1rem;
    border-width: .0625rem;
}

.dot--small.dot--fill-right { border-right-width: .5rem; }
.dot--small.dot--fill-left { border-left-width: .5rem; }

.dot--large {
    width: 4rem;
    height: 4rem;
    border-width: .25rem;
}

.dot--large.dot--fill-right { border-right-width: 2rem; }
.dot--large.dot--fill-left { border-left-width: 2rem; }
</style>

<div class="container">
    <div class="header">
        <table>
            <tr>
                <td><img src="<?php echo Yii::app()->baseUrl.'/images/logo.jpg';?>" alt="Logo" height="30"></td>
                <td style="font-size: 9px">
                    <ul>
                        <li>Jl. Raya Kalimalang Q/2D-E, Jaktim 13450, T: +6221.8643594/95, +6221.8642456, F: +6221.8645008</li>
                        <li>Jl. Radin Inten II no. 9, Jaktim 13440, T: +6221.8629545/46, F: +6221.8627313</li>
                        <li>Jl. Raya Jatiasih/Jatikramat no. 9, Pdk. Gede Bekasi, T: +6221.84993984/77, F: +6221.84993989</li>
                        <li>Jl. Raya Kalimalang no. 8 Kp. Dua, Jakasampurna Bekasi, T: +6221.8843656, F: +6221.88966753</li>
                        <li>Jl. Ruko Pulogadung Trade Center Blok 8C no. 27, Jaktim, T: +6221.46836035/36</li>
                        <li>Jl. Celebration Boulevard Blok AA-9/35, Grand Wisata Bekasi, T: +6221.82615945, F: +6221.82615944</li>
                        <li>Email: raperind@cbn.net.id</li>
                    </ul>
                </td>
            </tr>
        </table>
    </div>
    
    <div class="row">
        <table style="width: 100%; font-size: 11px">
            <tr>
                <td style="width: 20%; font-weight: bold">Work Order #</td>
                <td><?php echo CHtml::encode(CHtml::value($vehicleInspection, 'work_order_number')); ?></td>
                <td style="width: 20%; font-weight: bold">Date</td>
                <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy", CHtml::value($vehicleInspection, 'inspection_date'))); ?></td>
            </tr>
            <tr>
                <td style="width: 20%; font-weight: bold">Customer</td>
                <td><?php echo CHtml::encode(CHtml::value($registrationTransaction, 'customer.name')); ?></td>
                <td style="width: 20%; font-weight: bold">Car Make</td>
                <td><?php echo CHtml::encode(CHtml::value($vehicle, 'carMake.name')); ?></td>
            </tr>
            <tr>
                <td style="width: 20%; font-weight: bold">Plate #</td>
                <td><?php echo CHtml::encode(CHtml::value($vehicle, 'plate_number')); ?></td>
                <td style="width: 20%; font-weight: bold">Car Model</td>
                <td><?php echo CHtml::encode(CHtml::value($vehicle, 'carModel.name')); ?></td>
            </tr>
            <tr>
                <td style="width: 20%; font-weight: bold">Chasis #</td>
                <td><?php echo CHtml::encode(CHtml::value($vehicle, 'frame_number')); ?></td>
                <td style="width: 20%; font-weight: bold">Color</td>
                <td><?php echo CHtml::encode(CHtml::value($vehicle, 'color.name')); ?></td>
            </tr>
            <tr>
                <td style="width: 20%; font-weight: bold">Kilometer</td>
                <td><?php echo number_format(CHtml::encode(CHtml::value($registrationTransaction, 'vehicle_mileage')), 0); ?></td>
                <td style="width: 20%; font-weight: bold">Year</td>
                <td><?php echo CHtml::encode(CHtml::value($vehicle, 'year')); ?></td>
            </tr>
        </table>
    </div>
    
    <div style="margin-top: 2%; width: 100%; background-color: blue;">
        <div style="width: 80%; max-width: 24em; margin: -15 auto; padding: 0.25em 0.625em">
            <p style="text-align: center; color: white; font-weight: bold; font-size: 11px">Vehicle Report</p>
        </div>
    </div>
    
    <!--<div style="margin-top: 1%; width: 100%; background-color: black;">&nbsp;</div>-->
    
    <div class="row">
        <table>
            <thead>
                <tr>
                    <th>Module</th>
                    <?php foreach($modules as $module): ?>
                        <th style="width: 25%; font-weight: bold">
                            <span style="color: <?php echo CHtml::encode(CHtml::value($module, 'color_indicator')); ?>"><?php echo CHtml::encode(CHtml::value($module, 'name')); ?></span>
                        </th>
                    <?php endforeach; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach($vehicleInspection->vehicleInspectionDetails as $detail): ?>
                    <?php $sectionId = CHtml::value($detail, 'section_id'); ?>
                    <?php if ($lastId !== $sectionId): ?>
                <tr>
                    <td colspan="5" style="font-size: 14px; font-weight: bold"><?php echo CHtml::encode(CHtml::value($detail, 'section.name')); ?></td>
                </tr>
                    <?php endif; ?>
                    <?php $lastId = $sectionId; ?>
                    <tr>
                        <td><?php echo CHtml::encode(CHtml::value($detail, 'module.name')); ?></td>
                        <?php if ($detail->checklistModule->type == 'Text'): ?>
                            <td colspan="4"><?php echo CHtml::encode(CHtml::value($detail, 'value')); ?></td>
                        <?php else: ?>
                            <td style="text-align: center"><?php echo ($detail->checklistModule->color_indicator == 'Green') ? CHtml::image(Yii::app()->baseUrl."/images/icons/check_green.png", '', array('height' => '20px')) : ''; ?></td>
                            <td style="text-align: center"><?php echo ($detail->checklistModule->color_indicator == 'Yellow') ? CHtml::image(Yii::app()->baseUrl."/images/icons/check_yellow.jpeg", '', array('height' => '20px')) : ''; ?></td>
                            <td style="text-align: center"><?php echo ($detail->checklistModule->color_indicator == 'Red') ? CHtml::image(Yii::app()->baseUrl."/images/icons/check_red.png", '', array('height' => '20px')) : ''; ?></td>
                            <td style="text-align: center"><?php echo ($detail->checklistModule->color_indicator == 'Gray') ? CHtml::image(Yii::app()->baseUrl."/images/icons/check_black.png", '', array('height' => '20px')) : ''; ?></td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
                
            </tbody>
        </table>
    </div>
    
    <div class="footerrow">
        <div style="margin-top: 2%; width: 100%; background-color: blue;">
            <div style="width: 80%; max-width: 24em; margin: -15 auto; padding: 0.25em 0.625em">
                <p style="text-align: center; color: white; font-weight: bold; font-size: 11px">Signature</p>
            </div>
        </div>
        
        <table style="width: 100%">
            <tr>
                <td style="text-align: center; width: 50%; padding-top: 9%">(Customer)</td>
                <td style="text-align: center; width: 50%; padding-top: 9%">(Service Advisor)</td>
            </tr>
        </table>
        
<!--        <div style="margin-top: 2%; width: 100%; background-color: blue;">
            <div style="width: 80%; max-width: 24em; margin: -15 auto; padding: 0.25em 0.625em">
                <p style="text-align: center; color: white; font-weight: bold; font-size: 11px">&nbsp;</p>
            </div>
        </div>-->
    </div>
</div>

<style>
table, th, td {
  border: 1px solid black;
  border-collapse: collapse;
  font-size:  10px;
}
</style>