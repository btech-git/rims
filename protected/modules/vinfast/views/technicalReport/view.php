<?php
/* @var $this InvoiceHeaderController */
/* @var $model InvoiceHeader */

$this->breadcrumbs = array(
    'Invoice Headers' => array('admin'),
    $model->id,
);
?>

<?php echo CHtml::beginForm(); ?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>

        <?php echo CHtml::link('<span class="fa fa-list"></span>Manage', array("admin"), array(
            'class' => 'button cbutton left', 
            'style' => 'margin-left:10px', 
        )); ?>
        
        <?php if (Yii::app()->user->checkAccess("salesHead")): ?>
            <?php echo CHtml::link('<span class="fa fa-minus"></span>Cancel Transaction', array("cancel", "id" => $model->id), array(
                'class' => 'button alert right', 
                'style' => 'margin-right:10px', 
            )); ?>
        <?php endif; ?>
        
        <?php if (Yii::app()->user->checkAccess("saleInvoiceEdit")): ?>
            <?php echo CHtml::link('<span class="fa fa-pencil"></span> Edit', array("update", "id" => $model->id), array(
                'class' => 'button warning right', 
                'style' => 'margin-right:10px', 
            )); ?>
        <?php endif; ?>
        
        <br /><hr />
        
        <h1>View Technical Report #<?php echo $model->id; ?></h1>

        <table>
            <tr>
                <td>Doc ID</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'document_number')); ?></td>
                <td>Version/Status</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'report_version')); ?></td>
            </tr>
            
            <tr>
                <td>Dealer/TPW</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'dealer_name')); ?></td>
                <td>BU</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'dealer_code')); ?></td>
            </tr>
            
            <tr>
                <td>Effective Date</td>
                <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", strtotime($model->date_effective)); ?></td>
                <td>City/Province</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'province.name')); ?></td>
            </tr>
            
            <tr>
                <td>Warranty Start Date</td>
                <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", strtotime($model->warranty_start_date)); ?></td>
                <td>Repair Date</td>
                <td><?php echo Yii::app()->dateFormatter->format("d MMM yyyy", strtotime($model->repair_date)); ?></td>
            </tr>
            
            <tr>
                <td>RG #</td>
                <td>
                    <?php echo CHtml::link(CHtml::value($model, 'registrationProduct.registrationTransaction.transaction_number'), array(
                        '/frontDesk/registrationTransaction/view', 
                        'id' => $model->registrationProduct->registration_transaction_id
                    ), array('target' => '_blank')); ?>
                </td>
                <td>Plat #</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'registrationProduct.registrationTransaction.vehicle.plate_number')); ?></td>
            </tr>
            
            <tr>
                <td>Model</td>
                <td>
                    <?php echo CHtml::encode(CHtml::value($model, 'registrationProduct.registrationTransaction.vehicle.carMake.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($model, 'registrationProduct.registrationTransaction.vehicle.carModel.name')); ?> -
                    <?php echo CHtml::encode(CHtml::value($model, 'registrationProduct.registrationTransaction.vehicle.carSubModel.name')); ?>
                </td>
                <td>VIN</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'registrationProduct.registrationTransaction.vehicle.frame_number')); ?></td>
            </tr>
            
            <tr>
                <td>Mileage (KM)</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'vehicle_mileage')); ?></td>
                <td>Main Part Name</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'main_part_name')); ?></td>
            </tr>
            
            <tr>
                <td>Main Part Number</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'main_part_number')); ?></td>
                <td>Issue</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'report_issue')); ?></td>
            </tr>
             
            <tr>
                <td>Video Showing Failure Symptom</td>
                <td><?php echo CHtml::link($model->failure_symptom_video, $model->failure_symptom_video, array('target' => '_blank')); ?></td>
                <td>Video After Repair</td>
                <td><?php echo CHtml::link($model->after_repair_video, $model->after_repair_video, array('target' => '_blank')); ?></td>
            </tr>
               
            <tr>
                <td>Failure Phenomenon</td>
                <td><?php echo CHtml::encode(CHtml::value($model, 'failure_phenomenon')); ?></td>
                <td></td>
                <td><?php //echo CHtml::encode(CHtml::value($model, 'failure_phenomenon')); ?></td>
            </tr>
               
            <?php if (Yii::app()->user->checkAccess("director")): ?>
                <tr>
                    <td>User Created</td>
                    <td><?php echo CHtml::encode(CHtml::value($model, 'user.username')); ?></td>
                    <td>Date Created</td>
                    <td><?php echo CHtml::encode(Yii::app()->dateFormatter->format("d MMM yyyy H:m:s", strtotime(CHtml::value($model, 'created_datetime')))); ?></td>
                </tr>

                <tr>
                    <td>User Edited</td>
                    <td><?php echo CHtml::encode(CHtml::value($model, 'userIdEdited.username')); ?></td>
                    <td>Date Edited</td>
                    <td><?php echo CHtml::encode(CHtml::value($model, 'edited_datetime')); ?></td>
                </tr>
            <?php endif; ?>
        </table>
    </div>
</div>

<br /><hr />

<div class="row">
    <table>
        <tr>
            <td>Original Failed Parts Photos</td>
            <td>Original Failed Parts Serial Number Photos</td>
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
    </table>
</div>

<div class="row">
    <table>
        <tr>
            <td>VIN/Odometer Photos</td>
            <td>New Parts Photo (Showing Serial Number)</td>
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
        </tr>
    </table>
</div>
<?php echo CHtml::endForm(); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'cancel-message-dialog',
    // additional javascript options for the dialog plugin
    'options' => array(
        'title' => 'Cancel Message',
        'autoOpen' => false,
        'width' => 'auto',
        'modal' => false,
    ),
));?>
<div>
    <?php $hasFlash = Yii::app()->user->hasFlash('message'); ?>
    <?php if ($hasFlash): ?>
        <div class="flash-error">
            <?php echo Yii::app()->user->getFlash('message'); ?>
        </div>
    <?php endif; ?>
</div>
<?php $this->endWidget('zii.widgets.jui.CJuiDialog'); ?>

<script>
    $(document).ready(function() {
        var hasFlash = <?php echo $hasFlash ? 'true' : 'false' ?>;
        if (hasFlash) {
            $("#cancel-message-dialog").dialog({modal: 'false'});
        }
    });
    
    var label = $('#status');
    var text = label.text();
    //console.log(label.text());
    if (label.val() === "PAID") {
        label.css("background-color", "green");
    }
</script>