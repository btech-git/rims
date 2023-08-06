<div id="maincontent">
    <div class="form">
        <?php echo CHtml::beginForm(array(), 'POST', array('enctype' => 'multipart/form-data')); ?>

        <div class="row">
            <?php echo CHtml::fileField('TimesheetImportFile') ;?>
        </div>
        
        <div class="row buttons">
            <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to upload this file?')); ?>
        </div>
        
        <?php echo CHtml::endForm(); ?>
    </div>
</div>
