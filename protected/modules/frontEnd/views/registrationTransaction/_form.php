<div id="transaction-form">
    <?php echo CHtml::beginForm(array(), 'POST'); ?>
    
    <div class="form">
        <?php echo CHtml::errorSummary($registrationTransaction->header); ?>

        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">Customer Vehicle Data</legend>
            <div class="row">
                <div class="col">
                    <?php $this->widget('zii.widgets.jui.CJuiTabs', array(
                        'tabs' => array(
                            'Customer Info' => array(
                                'id' => 'info1',
                                'content' => $this->renderPartial('_infoCustomerVehicle', array(
                                    'registrationTransaction' => $registrationTransaction, 
                                    'customer' => $customer,
                                    'vehicle' => $vehicle,
                                ), true)
                            ),
                            'History' => array(
                                'id' => 'info2',
                                'content' => $this->renderPartial('_infoHistory', array(
                                    'registrationTransaction' => $registrationTransaction,
                                    'vehicle' => $vehicle,
                                ), true)
                            ),
                        ),
                        // additional javascript options for the tabs plugin
                        'options' => array(
                            'collapsible' => true,
                        ),
                        // set id for this widgets
                        'id' => 'view_tab',
                    )); ?>  
                </div>
            </div>
        </fieldset>
        
        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">FORM REGISTRASI</legend>
            <div class="row">
                <div class="col">
                    <?php echo CHtml::activeLabelEx($registrationTransaction->header, 'transaction_date', array('class' => 'form-label', 'label' => 'Tanggal')); ?>
                    <?php $this->widget('zii.widgets.jui.CJuiDatePicker', array(
                        'model' => $registrationTransaction->header,
                        'attribute' => "transaction_date",
                        'options' => array(
                            'dateFormat' => 'yy-mm-dd',
                            'changeMonth' => true,
                            'changeYear' => true,
                        ),
                        'htmlOptions' => array(
                            'readonly' => true,
                            'class' => 'form-control readonly-form-input',
                        ),
                    )); ?>
                    <?php echo CHtml::error($registrationTransaction->header,'transaction_date'); ?>
                </div>
                <div class="col">
                    <?php echo CHtml::label('BR/GR', false, array('class' => 'form-label')); ?>
                    <?php echo CHtml::activeDropDownList($registrationTransaction->header, 'repair_type', array(
                        'GR' => 'GR',
                        'BR' => 'BR',
                    ), array('class' => 'form-control')); ?>
                    <?php echo CHtml::error($registrationTransaction->header,'repair_type'); ?>
                </div>
            </div>

            <div class="row">
                <div class="col">
                    <?php echo CHtml::label('Branch', false, array('class' => 'form-label')); ?>
                    <?php $branch = Branch::model()->findByPk($registrationTransaction->header->branch_id); ?>
                    <?php echo CHtml::textField('BranchName', $branch->name, array(
                        'class' => 'form-control', 
                        'readonly'=>true
                    )); ?>
                    <?php echo CHtml::error($registrationTransaction->header,'branch_id'); ?>
                </div>
                <div class="col">
                    <?php echo CHtml::label('Mekanik', false, array('class' => 'form-label')); ?>
                    <?php echo CHtml::activeDropDownlist($registrationTransaction->header, 'employee_id_assign_mechanic', CHtml::listData(Employee::model()->findAllByAttributes(array(
                        "branch_id" => User::model()->findByPk(Yii::app()->user->getId())->branch_id,
                        "position_id" => 1,
                    )), "id", "name"), array(
                        'class' => 'form-control', 
                        "empty" => "--Assign Mechanic--"
                    )); ?>
                    <?php echo CHtml::error($registrationTransaction->header,'employee_id_assign_mechanic'); ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php echo CHtml::label('Salesman', false, array('class' => 'form-label')); ?>
                    <?php echo CHtml::activeDropDownlist($registrationTransaction->header, 'employee_id_sales_person', CHtml::listData(Employee::model()->findAllByAttributes(array(
                        "position_id" => 2,
                    )), "id", "name"), array(
                        'class' => 'form-control', 
                        "empty" => "--Assign Sales--"
                    )); ?>
                    <?php echo CHtml::error($registrationTransaction->header,'employee_id_sales_person'); ?>
                </div>
                <div class="col">
                    <?php echo CHtml::label('Asuransi', false, array('class' => 'form-label')); ?>
                    <?php echo CHtml::activeDropDownlist($registrationTransaction->header,'insurance_company_id',CHtml::listData(InsuranceCompany::model()->findAll(),'id','name'),array(
                        'prompt'=>'-- Tanpa Asuransi --',
                        'class' => 'form-control'
                    )); ?>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <?php echo CHtml::activeLabelEx($registrationTransaction->header, 'problem', array('class' => 'form-label')); ?>
                    <?php echo CHtml::activeTextArea($registrationTransaction->header,'problem',array(
                        'rows' => 3, 
                        'cols' => 30, 
                        'class' => 'form-control'
                    )); ?>
                    <?php echo CHtml::error($registrationTransaction->header,'problem'); ?>
                </div>
                <div class="col">
                    <?php echo CHtml::activeLabelEx($registrationTransaction->header, 'note', array('class' => 'form-label')); ?>
                    <?php echo CHtml::activeTextArea($registrationTransaction->header,'note',array('rows'=>3, 'cols'=>30, 'class' => 'form-control')); ?>
                    <?php echo CHtml::error($registrationTransaction->header,'note'); ?>
                </div>
            </div>
        </fieldset>

        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">SUKU CADANG - SPAREPARTS</legend>
            <div class="detail" id="detail-product">
                <?php $this->renderPartial('_detailProduct', array(
                    'registrationTransaction' => $registrationTransaction,
                )); ?>
            </div>
        </fieldset>

        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">JASA PERBAIKAN - SERVICE</legend>
            <div class="detail" id="detail-service">
                <?php $this->renderPartial('_detailService', array('registrationTransaction' => $registrationTransaction,)); ?>
            </div>
        </fieldset>

        <fieldset class="border border-secondary rounded mb-3 p-3">
            <legend class="float-none w-auto text-dark px-1">TOTAL TRANSAKSI</legend>
            <div class="detail" id="detail-total">
                <?php $this->renderPartial('_detailTotal', array('registrationTransaction' => $registrationTransaction,)); ?>
            </div>
        </fieldset>

        <div class="d-grid">
            <div class="row">
                <div class="col text-center">
                    <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'confirm' => 'Are you sure you want to cancel?', 'class'=>'btn btn-danger')); ?>
                    <?php echo CHtml::submitButton('Submit', array('name' => 'Submit', 'confirm' => 'Are you sure you want to save?', 'class'=>'btn btn-success')); ?>
                </div>
            </div>
            <?php echo IdempotentManager::generate(); ?>
        </div>
    </div>
    
    <?php echo CHtml::endForm(); ?>
</div>