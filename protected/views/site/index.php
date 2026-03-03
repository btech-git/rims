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
    
    <div id="answer-box"></div>
</div>
