<?php
/* @var $this SiteController */
    $this->pageTitle=Yii::app()->name;
    
    Yii::app()->clientScript->registerScriptFile('https://www.gstatic.com/charts/loader.js');
    Yii::app()->clientScript->registerScript('chart', "
        google.charts.load('current', {'packages':['corechart']});
        google.charts.setOnLoadCallback(drawChart);

        function drawChart() {
            var saledata = google.visualization.arrayToDataTable(" . CJSON::encode($dataSale) . ");
            var sale_options = {
                fontSize: 11,
                legend: {position:'none'},
                chartArea: {width: 800, height: 225},
                title: 'Monthly Sales',
                hAxis: {title: 'Month', titleTextStyle: {color: '#333'}},
                vAxis: {title: 'Sales', minValue: 0, count: 12, gridlines: { count: 10 }}
            };
            var salechart = new google.visualization.ColumnChart(document.getElementById('sale_chart_div'));
            salechart.draw(saledata, sale_options);
            
            var saledataperbranch = google.visualization.arrayToDataTable(" . CJSON::encode($dataSalePerBranch) . ");
            var sale_per_branch_options = {
                title: 'Sales Per Branch',
                backgroundColor: 'transparent',
                chartArea: {width: 300, height: 170},
            };
            var saleperbranchchart = new google.visualization.PieChart(document.getElementById('sale_per_branch_chart_div'));
            saleperbranchchart.draw(saledataperbranch, sale_per_branch_options);
            
            var incomeexpensedata = google.visualization.arrayToDataTable(" . CJSON::encode($dataIncomeExpense) . ");
            var income_expense_options = {
                fontSize: 11,
                backgroundColor: 'transparent',
                legend: {position:'right'},
                chartArea: {width: 590, height: 225},
                title: 'Income vs Expense',
                  curveType: 'function',
                  legend: { position: 'bottom' }
            };
            var incomeexpensechart = new google.visualization.LineChart(document.getElementById('income_expense_chart_div'));
            incomeexpensechart.draw(incomeexpensedata, income_expense_options);
            
            
        }
    ", 2);
?>

<div style="font-size:16px; text-align:center">
    <div style="font-size:30px">Raperind Information Management System (RIMS) Dashboard</div>
    <br /><br/>
    
    <table>
        <thead>
            <tr>
                <th colspan="9" style="text-align: center; font-weight: bold; font-size: 14px">New Transactions</th>
            </tr>
        </thead>
        
        <tbody>
            <tr>
                <td style="text-align: center; font-weight: bold; font-size: 12px">
                    <?php echo CHtml::link('Request', array('/transaction/transactionRequestOrder/admin'), array('target' => '_blank')); ?>
                </td>
                <td style="text-align: center; font-weight: bold; font-size: 12px">
                    <?php echo CHtml::link('Purchase', array('/transaction/transactionPurchaseOrder/admin'), array('target' => '_blank')); ?>
                </td>
                <td style="text-align: center; font-weight: bold; font-size: 12px">
                    <?php echo CHtml::link('Sales', array('/transaction/transactionSalesOrder/admin'), array('target' => '_blank')); ?>
                </td>
                <td style="text-align: center; font-weight: bold; font-size: 12px">
                    <?php echo CHtml::link('Transfer', array('/transaction/transferRequest/admin'), array('target' => '_blank')); ?>
                </td>
                <td style="text-align: center; font-weight: bold; font-size: 12px">
                    <?php echo CHtml::link('Sent', array('/transaction/transactionSentRequest/admin'), array('target' => '_blank')); ?>
                </td>
                <td style="text-align: center; font-weight: bold; font-size: 12px">
                    <?php echo CHtml::link('Consignment In', array('/transaction/consignmentInHeader/admin'), array('target' => '_blank')); ?>
                </td>
                <td style="text-align: center; font-weight: bold; font-size: 12px">
                    <?php echo CHtml::link('Consignment Out', array('/transaction/consignmentOutHeader/admin'), array('target' => '_blank')); ?>
                </td>
                <td style="text-align: center; font-weight: bold; font-size: 12px">
                    <?php echo CHtml::link('Movement In', array('/transaction/movementInHeader/admin'), array('target' => '_blank')); ?>
                </td>
                <td style="text-align: center; font-weight: bold; font-size: 12px">
                    <?php echo CHtml::link('Movement Out', array('/transaction/movementOutHeader/admin'), array('target' => '_blank')); ?>
                </td>
            </tr>
            
            <tr>
                <td style="text-align: center; font-weight: bold; font-size: 10px">
                    <?php echo count($requestOrder); ?>
                </td>
                <td style="text-align: center; font-weight: bold; font-size: 10px">
                    <?php echo count($purchase); ?>
                </td>
                <td style="text-align: center; font-weight: bold; font-size: 10px">
                    <?php echo count($sales); ?>
                </td>
                <td style="text-align: center; font-weight: bold; font-size: 10px">
                    <?php echo count($transfer); ?>
                </td>
                <td style="text-align: center; font-weight: bold; font-size: 10px">
                    <?php echo count($sent); ?>
                </td>
                <td style="text-align: center; font-weight: bold; font-size: 10px">
                    <?php echo count($consignmentIn); ?>
                </td>
                <td style="text-align: center; font-weight: bold; font-size: 10px">
                    <?php echo count($consignment); ?>
                </td>
                <td style="text-align: center; font-weight: bold; font-size: 10px">
                    <?php echo count($movementIn); ?>
                </td>
                <td style="text-align: center; font-weight: bold; font-size: 10px">
                    <?php echo count($movement); ?>
                </td>
            </tr>
        </tbody>
    </table>
    
    <br/>
        
    <div>
        <table>
            <tr>
                <td style="font-weight: bold; text-align: center">Total Hutang</td>
                <td style="font-weight: bold; text-align: center">Total Piutang</td>
            </tr>
            <tr>
                <td style="font-weight: bold; text-align: center">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalReceivables)); ?>
                </td>
                
                <td style="font-weight: bold; text-align: center">
                    <?php echo CHtml::encode(Yii::app()->numberFormatter->format('#,##0', $totalPayables)); ?>
                </td>
            </tr>
        </table>
    </div>
    
    <br/>
  
    <div class="completed-center" id="sale_chart_div" style="width: 100%; height: 300px;"></div>
    
    <br/>
    
    <table>
        <tr>
            <td style="width: 35%;">
                <div class="completed-left" id="sale_per_branch_chart_div" ></div>
            </td>
            <td style="width: 65%">
                <div class="completed-right" id="income_expense_chart_div" style="width: 100%; height: 300px;"></div>
            </td>
        </tr>
    </table>
    
</div>