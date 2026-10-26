<?php
/* @var $this SiteController */
    $this->pageTitle=Yii::app()->name;
    
    Yii::app()->clientScript->registerCss('_report', '
        #answer-box {
            text-align: left;
            background-color: white;
            padding: 16px;
        }
        .ask-section {
            background-color: lightgray;
            font-weight: bold;
            font-size: 18px;
            padding: 8px;
        }
        .answer-section {
            font-size: 16px;
        }
    ');
?>

<div style="font-size: 16px; text-align: center">
    <div style="font-size: 30px">Raperind Information Management System (RIMS) Dashboard</div>
    <br /><br/>

    <div style="font-weight: bold">
        <div>
            <?php $employeeList = Employee::model()->findAll(array('condition' => "MONTH(t.birth_date) = MONTH(CURDATE()) AND DAY(t.birth_date) = DAY(CURDATE()) AND t.status = 'Active'")); ?>
            
            <?php foreach ($employeeList as $employee): ?>
                <?php $birthDate = new DateTime($employee->birth_date); ?>
                <?php $today = new DateTime('today'); ?>
                <?php $age = $birthDate->diff($today); ?>
                <?php $employmentDays = date_diff(date_create($employee->recruitment_date), date_create(date('Y-m-d'))); ?>
                <p><h3>Happy <?php echo CHtml::encode($age->y); ?>th Birthday, <?php echo CHtml::encode(CHtml::value($employee, 'name')); ?> (<?php echo CHtml::encode(CHtml::value($employee, 'level.name')); ?> <?php echo CHtml::encode(CHtml::value($employee, 'position.name')); ?>)!!!</h3></p>
                <p>Raperind Motor want to wish you all the best and thank you for being with us for <?php echo CHtml::encode($employmentDays->format("%a days")); ?></p>
            <?php endforeach; ?>
        </div>
    </div>

    <div>
        <?php /*echo CHtml::beginForm(array('')); ?>
        <?php echo CHtml::textField('SearchAsk', ''); ?>
        <?php echo Chtml::htmlButton('Search', array(
            'name' => 'SearchButton',
            'onclick' => CHtml::ajax(array(
                'type' => 'POST',
                'dataType' => 'JSON',
                'url' => CController::createUrl('ajaxJsonSearchAnswer'),
                'success' => 'function(data) {
                    $("#SearchAsk").val("");
                    if (data.searchAnswer !== "") {
                        var searchAskDiv = $("<span class=\"ask-section\">" + data.searchAsk + "</span>");
                        $("#answer-box").append(searchAskDiv);
                        $("#answer-box").append("<br />");
                        $("#answer-box").append("<br />");
                        var searchAnswerDiv = $("<p class=\"answer-section\">" + data.searchAnswer + "</p>");
                        $("#answer-box").append(searchAnswerDiv);
                        $("#answer-box").append("<br />");
                    }
                }',
            )),
        )); ?>
        <?php echo CHtml::endForm();*/ ?>
    </div>
</div>
