<?php
date_default_timezone_set('Asia/Jakarta');

function tanggal($date) {
    $bulan = array('Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember');
    $tahun = substr($date, 0, 4);
    $bulan2 = substr($date, 5, 2);
    $tanggal = substr($date, 8, 2);

    return $tanggal . ' ' . $bulan[(int) $bulan2 - 1] . ' ' . $tahun;
}
?>
<style>
    .page {
        background-repeat: no-repeat;
        background-position: center;
        background-size: contain;
    }
    
    .container {
        background-color: rgba(255, 255, 255, 0.8);
    }
    
    table {
        border-collapse: collapse; /* Merges double borders into single lines */
        width: 100%;
      }

      table, th, td {
        border: 1px solid black; /* Adds borders to the outer table and all cells */
      }

      th, td {
        padding: 8px; /* Adds breathing room inside each cell */
        text-align: center;
      }
</style>

<div class="container">
    <div class="header">
        <div style="float: left; width: 20%; text-align: center">
            <img src="<?php echo Yii::app()->baseUrl; ?>/images/vinfast-logo.jpeg" style="width: 75px; height: 64px" />
        </div>
        <div style="float: right; width: 30%">
            <div>
                Doc ID: <?php echo CHtml::encode(CHtml::value($technicalReportHeader, 'document_number')); ?><br />
                Version / Status: <?php echo CHtml::encode(CHtml::value($technicalReportHeader, 'report_version')); ?><br />
                Effective Date: <?php echo Yii::app()->dateFormatter->format("d MMMM yyyy", strtotime($technicalReportHeader->date_effective)); ?>
            </div>
        </div>
        <div style="float: right; text-align: center; width: 50%">
            <div><h1>TECHNICAL REPORT</h1></div>
        </div>
    </div>

    <div class="body-memo">
        <table>
            <tr style="background-color: lightgrey">
                <td colspan="2">Dealer / TPW</td>
                <td>BU</td>
                <td>City/Province</td>
                <td>Warranty Claim Number</td>
            </tr>
            <tr>
                <td colspan="2"><?php echo CHtml::encode(CHtml::value($technicalReportHeader, 'dealer_name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($technicalReportHeader, 'dealer_code')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($technicalReportHeader, 'province.name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($technicalReportHeader, 'warranty_claim_number')); ?></td>
            </tr>
            <tr style="background-color: lightgrey">
                <td>Model</td>
                <td>VIN</td>
                <td>Mileage (KM)</td>
                <td>Warranty Start Date</td>
                <td>Repair Date</td>
            </tr>
            <tr>
                <td>
                    <?php echo CHtml::encode(CHtml::value($technicalReportHeader, 'registrationProduct.registrationTransaction.vehicle.carMake.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($technicalReportHeader, 'registrationProduct.registrationTransaction.vehicle.carModel.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($technicalReportHeader, 'registrationProduct.registrationTransaction.vehicle.carSubModel.name')); ?>
                </td>
                <td><?php echo CHtml::encode(CHtml::value($technicalReportHeader, 'registrationProduct.registrationTransaction.vehicle.frame_number')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($technicalReportHeader, 'registrationProduct.registrationTransaction.vehicle_mileage')); ?></td>
                <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", strtotime($technicalReportHeader->warranty_start_date)); ?></td>
                <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", strtotime($technicalReportHeader->repair_date)); ?></td>
            </tr>
            <tr style="background-color: lightgrey">
                <td colspan="2">Main Part Name</td>
                <td>Main Part Number</td>
                <td colspan="2">Issue</td>
            </tr>
            <tr>
                <td colspan="2"><?php echo CHtml::encode(CHtml::value($technicalReportHeader, 'main_part_name')); ?></td>
                <td><?php echo CHtml::encode(CHtml::value($technicalReportHeader, 'main_part_number')); ?></td>
                <td colspan="2"><?php echo CHtml::encode(CHtml::value($technicalReportHeader, 'report_issue')); ?></td>
            </tr>
        </table>
    </div>

    <br /><br />
    <div class="body-memo">
        <table>
            <tr style="background-color: lightgrey">
                <td colspan="2">1. Failure Phenomenon</td>
            </tr>
            <tr>
                <td colspan="2"><?php echo nl2br(CHtml::encode(CHtml::value($technicalReportHeader, 'failure_phenomenon'))); ?></td>
            </tr>
            <tr style="background-color: lightgrey">
                <td colspan="2">2. Pre-repair vehicle photos/videos</td>
            </tr>
            <tr>
                <td>
                    <table>
                        <?php if (!empty($postOdometerImages)): ?>
                            <?php foreach ($postOdometerImages as $postImage): ?>
                                <tr>
                                    <?php $src = Yii::app()->baseUrl . '/images/uploads/odometer/' . $postImage->fullFilename; ?>
                                    <?php if ($postImage->extension == 'pdf'): ?>
                                        <td><?php echo CHtml::link($postImage->filename, $src, array('target' => '_blank')); ?></td>
                                    <?php else: ?>
                                        <td style="margin: 10px; padding: 5px; padding: 5px; vertical-align: middle; text-align: center ">
                                            <?php echo CHtml::image($src, "Files # " . $postImage->id, array('width' => 300, 'display'=> 'inline-block')); ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </table>
                </td>
                <td><?php echo CHtml::link($technicalReportHeader->failure_symptom_video, $technicalReportHeader->failure_symptom_video, array('target' => '_blank')); ?></td>
            </tr>
            <tr>
                <td>VIN/Odometer Photos</td>
                <td>Video Showing Failure Symptom</td>
            </tr>
            <tr>
                <td>
                    <table>
                        <?php if (!empty($postFailedPartImages)): ?>
                            <?php foreach ($postFailedPartImages as $postImage): ?>
                                <tr>
                                    <?php $src = Yii::app()->baseUrl . '/images/uploads/failedPart/' . $postImage->fullFilename; ?>
                                    <?php if ($postImage->extension == 'pdf'): ?>
                                        <td><?php echo CHtml::link($postImage->filename, $src, array('target' => '_blank')); ?></td>
                                    <?php else: ?>
                                        <td style="margin: 10px; padding: 5px; padding: 5px; vertical-align: middle; text-align: center ">
                                            <?php echo CHtml::image($src, "Files # " . $postImage->id, array('width' => 300, 'display'=> 'inline-block')); ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </table>
                </td>
                <td>
                    <table>
                        <?php if (!empty($postFailedPartSerialNumberImages)): ?>
                            <?php foreach ($postFailedPartSerialNumberImages as $postImage): ?>
                                <tr>
                                    <?php $src = Yii::app()->baseUrl . '/images/uploads/failedPartSerialNumber/' . $postImage->fullFilename; ?>
                                    <?php if ($postImage->extension == 'pdf'): ?>
                                        <td><?php echo CHtml::link($postImage->filename, $src, array('target' => '_blank')); ?></td>
                                    <?php else: ?>
                                        <td style="margin: 10px; padding: 5px; padding: 5px; vertical-align: middle; text-align: center ">
                                            <?php echo CHtml::image($src, "Files # " . $postImage->id, array('width' => 300, 'display'=> 'inline-block')); ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </table>
                </td>
            </tr>
            <tr>
                <td>Original Failed Parts Photos</td>
                <td>Original Failed Parts Serial Number Photos</td>
            </tr>
            <tr style="background-color: lightgrey">
                <td colspan="2">3. Post-repair vehicle photos/videos</td>
            </tr>
            <tr>
                <td>
                    <table>
                        <?php if (!empty($postNewPartImages)): ?>
                            <?php foreach ($postNewPartImages as $postImage): ?>
                                <tr>
                                    <?php $src = Yii::app()->baseUrl . '/images/uploads/newPart/' . $postImage->fullFilename; ?>
                                    <?php if ($postImage->extension == 'pdf'): ?>
                                        <td><?php echo CHtml::link($postImage->filename, $src, array('target' => '_blank')); ?></td>
                                    <?php else: ?>
                                        <td style="margin: 10px; padding: 5px; padding: 5px; vertical-align: middle; text-align: center">
                                            <?php echo CHtml::image($src, "Files # " . $postImage->id, array('width' => 300, 'display'=> 'inline-block')); ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </table>
                </td>
                <td><?php echo CHtml::link($technicalReportHeader->after_repair_video, $technicalReportHeader->after_repair_video, array('target' => '_blank')); ?></td>
            </tr>
            <tr>
                <td>New Parts Photo (Showing Serial Number)</td>
                <td>Video After Repair</td>
            </tr>
        </table>
    </div>
    
    <div style="text-align:right; font-size: 10px;">
        <h4>Dealer/TPW</h4>
        Prepared by,
        <p class="authorized" style="width: 190px">
            <span style="text-align: left">Full name: Raperind Motor Pondok Kelapa</span> <br />
            <span style="text-align: left">Date: <?php echo Yii::app()->dateFormatter->format("d MMM yyyy", strtotime($technicalReportHeader->date_effective)); ?></span>
        </p>
    </div>

</div>