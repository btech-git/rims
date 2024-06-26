<?php
/* @var $this CoaController */
/* @var $model Coa */

$this->breadcrumbs = array(
    'Coas' => array('index'),
        //$model->name,
);

/* $this->menu=array(
  array('label'=>'List Coa', 'url'=>array('index')),
  array('label'=>'Create Coa', 'url'=>array('create')),
  array('label'=>'Update Coa', 'url'=>array('update', 'id'=>$model->id)),
  array('label'=>'Delete Coa', 'url'=>'#', 'linkOptions'=>array('submit'=>array('delete','id'=>$model->id),'confirm'=>'Are you sure you want to delete this item?')),
  array('label'=>'Manage Coa', 'url'=>array('admin')),
  ); */
?>

<!--<h1>View Coa #<?php //echo $model->id;    ?></h1>-->
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>

        <h1>View Coa</h1>
        <?php
        for ($i = 0; $i < 2; $i++) {
            $tableContent = '';
            $tableContent .= '
            <table>
                <tr>
                    <th>Code</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Sub Category</th>
                    <th>Opening Balance</th>
                </tr>';
            if ($i == 1) {
                foreach ($coaInactives as $key => $coaInactive) {
                    $tableContent .= '
                    <tr>
                        <td>' . $coaInactive->code . '</td>
                        <td>' . $coaInactive->name . '</td>
                        <td>' . CHtml::encode(CHtml::value($coaInactive, 'coaCategory.name')) . '</td>
                        <td>' . CHtml::encode(CHtml::value($coaInactive, 'coaSubCategory.name')) . '</td>
                        <td>' . $coaInactive->opening_balance . '</td>
                    </tr>';
                }

                $tableContent .= '</table>';
            } else {
                foreach ($coas as $key => $coa) {
                    if (substr($coa->code, 0, 1) != 0) {
                        $tableContent .= '
                        <tr>
                            <td>' . $coa->code . '</td>
                            <td>' . $coa->name . '</td>
                            <td>' . CHtml::encode(CHtml::value($coa, 'coaCategory.name')) . '</td>
                            <td>' . CHtml::encode(CHtml::value($coa, 'coaSubCategory.name')) . '</td>
                            <td>' . $coa->opening_balance . '</td>
                        </tr>';
                    }
                }
                $tableContent .= '</table>';
            }

            if ($i == 0) {
                $tabarray["COA Active"] = $tableContent;
            } else {
                $tabarray["COA Inactive"] = $tableContent;
            }
        }

        $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => $tabarray,
            // additional javascript options for the accordion plugin
            'options' => array(
                'collapsible' => true,
            ),
            'id' => 'MyTab-Menu1'
        )); ?>

    </div>
</div>
<br>

