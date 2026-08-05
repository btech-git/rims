<div class="form">
    <div class="row">
        <?php echo CHtml::beginForm(array(''), 'post', array('enctype' => 'multipart/form-data')); ?>

        <div class="field">
            <div class="row collapse">
                <div class="small-4 columns">
                    <?php echo CHtml::label('Upload File CSV', ''); ?>
                </div>
                <div class="small-8 columns">
                    <?php $this->widget('CMultiFileUpload', array(
                        'name' => 'TaxImportData',
                        'accept' => 'csv',
                        'denied' => 'Only csv are allowed',
                        'max' => 1,
                        'remove' => '[x]',
                        'duplicate' => 'Already Selected',
                        'options' => array(
                            'afterFileSelect' => 'function(e ,v ,m){
                                var fileSize = e.files[0].size;
                                if (fileSize > 2*1024*1024) {
                                    alert("Exceeds file upload limit 2MB");
                                    $(".MultiFile-remove").click();
                                }                      
                                return true;
                            }',
                        ),
                    )); ?>
                </div>
            </div>
        </div>
        
        <div><?php echo CHtml::encode($errorMessage); ?></div>

        <div class="field buttons text-center">
            <?php echo CHtml::submitButton('Upload', array('class' => 'button cbutton', 'confirm' => 'Are you sure you want to import this file?')); ?>
        </div>

        <?php echo CHtml::endForm(); ?>
    </div>
</div>