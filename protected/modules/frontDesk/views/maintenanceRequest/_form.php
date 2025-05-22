<script type="text/javascript">
    $(document).ready(function () {
        $('.dateClass').live("keyup", function (e) {
            var Length=$(this).attr("maxlength");

            if ($(this).val().length >= parseInt(Length)){
                $(this).next('.dateClass').focus();
            }
        });
    }
</script>

<div class="form">
    <?php echo CHtml::beginForm('', 'post', array('enctype'=>'multipart/form-data')); ?>
    <?php echo CHtml::errorSummary($maintenanceRequest->header); ?>
    <div class="row">
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Request Tanggal', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                            'model' => $maintenanceRequest->header,
                            'attribute' => "transaction_date",
                            'options' => array(
                                'minDate' => '-1W',
                                'maxDate' => '+6M',
                                'dateFormat' => 'yy-mm-dd',
                                'changeMonth' => true,
                                'changeYear' => true,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
//                                'value' => date('Y-m-d'),
                            ),
                        )); ?>
                        <?php //echo CHtml::encode(Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::value($maintenanceRequest->header, 'transaction_date'))); ?>
                        <?php echo CHtml::error($maintenanceRequest->header, 'transaction_date'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Branch', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::encode(CHtml::value($maintenanceRequest->header, 'branch.name')); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Maintenance Description', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeTextArea($maintenanceRequest->header, 'description', array('rows' => 5, 'columns' => '10')); ?>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="small-12 medium-6 columns">
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Maintenance Type', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($maintenanceRequest->header, 'maintenance_type', array(
                            'Rutin' => 'Rutin',
                            'Perbaikan' => 'Perbaikan',
                            'Inspeksi' => 'Inspeksi',
                        ), array('empty' => '-- Pilih Type --')) ?>
                        <?php echo CHtml::error($maintenanceRequest->header, 'maintenance_type'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Priority Level', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($maintenanceRequest->header, 'priority_level', array(
                            1 => 'Low',
                            2 => 'Medium',
                            3 => 'High',
                        ), array('empty' => '-- Pilih Level --')) ?>
                        <?php echo CHtml::error($maintenanceRequest->header, 'priority_level'); ?>
                    </div>
                </div>
            </div>
            
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo CHtml::label('Requestor', ''); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo CHtml::activeDropDownList($maintenanceRequest->header, 'user_id_requestor', CHtml::listData(Users::model()->findAll(), 'id', 'username'), array('empty' => '-- Pilih Requestor --')) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr />

    <div class="row">
        <?php echo CHtml::button('Add Items', array(
            'onclick' => CHtml::ajax(array(
                'type' => 'POST',
                'url' => CController::createUrl('ajaxHtmlAddDetail', array('id' => $maintenanceRequest->header->id)),
                'update' => '#detail_div',
            )),
        )); ?>
    </div>
    
    <br /><br />
    
    <div id="detail_div">
        <?php $this->renderPartial('_detail', array(
            'maintenanceRequest' => $maintenanceRequest,
        )); ?>
    </div>

    <br />
    
    <div class="field">
        <div class="row collapse">
            <div class="small-4 columns">
                <?php /*echo CHtml::label('Attach Images (Upload size max 2MB)', ''); ?>
            </div>
            <div class="small-8 columns">
                <?php $this->widget('CMultiFileUpload', array(
                    'model' => $maintenanceRequest->header,
                    'attribute' => 'images',
                    'accept' => 'jpg|jpeg|png|gif',
                    'denied' => 'Only jpg, jpeg, png and gif are allowed',
                    'max' => 10,
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
                ));*/ ?>
            </div>
        </div>
    </div>

    <div class="row buttons">
        <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?')); ?>
        <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>
    <?php echo IdempotentManager::generate(); ?>
    <?php echo CHtml::endForm(); ?>
</div><!-- form -->