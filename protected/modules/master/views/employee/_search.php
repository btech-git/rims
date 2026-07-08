<?php
/* @var $this EmployeeController */
/* @var $model Employee */
/* @var $form CActiveForm */
?>

<div class="wide form" id="advSearch">

    <?php
    $form = $this->beginWidget('CActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
    ));
    ?>

    <div class="row">
        <div class="small-12 medium-6 columns">
            <!-- BEGIN field -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'name', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">	
                        <?php echo $form->textField($model, 'name', array('size' => 60, 'maxlength' => 100)); ?>            
                    </div>
                </div>
            </div>

            <!-- BEGIN field -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'local_address', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">	
                        <?php echo $form->textArea($model, 'local_address', array('rows' => 5, 'cols' => 50)); ?>
                    </div>
                </div>
            </div>		

            <!-- BEGIN field -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'sex', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">	
                        <?php echo $form->textField($model, 'sex', array('size' => 10, 'maxlength' => 10)); ?>
                    </div>
                </div>
            </div>		

            <!-- BEGIN field -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'email', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">	
                        <?php echo $form->textField($model, 'email', array('size' => 60, 'maxlength' => 60)); ?>
                    </div>
                </div>
            </div>

            <!-- BEGIN field -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'working_period_mode', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">	
                        <?php echo $form->dropDownList($model, 'working_period_mode', array(
                            '90' => 'Kurang dari atau sama dengan 3 bulan',
                            '180' => 'Kurang dari atau sama dengan 6 bulan',
                            '360' => 'Kurang dari atau sama dengan 1 tahun',
                            '720' => 'Kurang dari atau sama dengan 2 tahun',
                            '1080' => 'Kurang dari atau sama dengan 3 tahun',
                            '1800' => 'Kurang dari atau sama dengan 5 tahun',
                            '-1' => 'Lebih dari 5 tahun',
                        ), array('empty' => '')); ?>
                    </div>
                </div>
            </div>

        </div>

        <div class="small-12 medium-6 columns">

            <!-- BEGIN field -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'id_card', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">	
                        <?php echo $form->textField($model, 'id_card', array('size' => 30, 'maxlength' => 30)); ?>
                    </div>
                </div>
            </div>	

            <!-- BEGIN field -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'status', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">	
                        <?php echo $form->dropDownList($model, 'status', array(
                            'Active' => 'Active',
                            'Inactive' => 'Inactive'
                        ), array('empty' => '')); ?>
                    </div>
                </div>
            </div>	

            <!-- BEGIN field -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'salary_type', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">	
                        <?php echo $form->dropDownList($model, 'salary_type', array(
                            'Hourly' => 'Hourly',
                            'Daily' => 'Daily', 
                            'Weekly' => 'Weekly', 
                            'Monthly' => 'Monthly', 
                            'One Time Payment' => 'One Time Payment'
                        ), array('empty' => '')); ?>
                    </div>
                </div>
            </div>	

            <!-- BEGIN field -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'basic_salary', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">	
                        <?php echo $form->textField($model, 'basic_salary', array('size' => 10, 'maxlength' => 10)); ?>
                    </div>
                </div>
            </div>			

            <!-- BEGIN field -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'payment_type', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">	
                        <?php echo $form->dropDownList($model, 'payment_type', array(
                            'Cash' => 'Cash',
                            'Transfer' => 'Transfer'
                        ), array('empty' => '')); ?>
                    </div>
                </div>
            </div>

            <!-- BEGIN field -->
            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'code', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">	
                        <?php echo $form->textField($model, 'code', array('size' => 50, 'maxlength' => 50)); ?>
                    </div>
                </div>
            </div>

            <div class="field">
                <div class="row collapse">
                    <div class="small-4 columns">
                        <?php echo $form->label($model, 'is_deleted', array('class' => 'prefix')); ?>
                    </div>
                    <div class="small-8 columns">
                        <?php echo $form->dropDownList($model, 'is_deleted', array(
                            1 => 'Show Deleted',
                            0 => 'Hide Deleted'
                        ), array('empty' => '')); ?>
                    </div>
                </div>
            </div>
        </div>	
    </div>

    <div class="field buttons text-right">
        <?php echo CHtml::submitButton('Search', array('class' => 'button cbutton')); ?>
    </div>
    <?php $this->endWidget(); ?>
</div><!-- search-form -->