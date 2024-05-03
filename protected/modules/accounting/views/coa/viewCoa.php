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

<!--<h1>View Coa #<?php //echo $model->id;  ?></h1>-->
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>

        <h1>View Coa</h1>
        <?php $coas = Coa::model()->findAll(array('order' => 'code ASC')); ?>
        <?php
        for ($i = 0; $i < 10; $i++) {
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
            if ($i != 9) {
                foreach ($coas as $key => $coa) {
                    if (substr($coa->code, 0, 2) == "0" . $i) {
                        $tableContent .= '
								<tr>
									<td>' . $coa->code . '</td>
									<td>' . $coa->name . '</td>
									<td>' . $coa->coaCategory->name . '</td>
									<td>' . $coa->coaSubCategory->name . '</td>
									<td>' . $coa->opening_balance . '</td>
								</tr>';
                    }
                }

                $tableContent .= '</table>';
            } else {
                foreach ($coas as $key => $coa) {
                    if (substr($coa->code, 0, 1) != 0) {
                        $tableContent .= '
								<tr>
									<td>' . $coa->code . '</td>
									<td>' . $coa->name . '</td>
									<td>' . $coa->coaCategory->name . '</td>
									<td>' . $coa->coaSubCategory->name . '</td>
									<td>' . $coa->opening_balance . '</td>
								</tr>';
                    }
                }
                $tableContent .= '</table>';
            }


            if ($i == 0) {
                $tabarray["HO"] = $tableContent;
            } elseif ($i == 9) {
                $tabarray["COA"] = $tableContent;
            } else {
                $tabarray["R" . $i] = $tableContent;
            }
        }

        $this->widget('zii.widgets.jui.CJuiTabs', array(
            'tabs' => $tabarray,
            // additional javascript options for the accordion plugin
            'options' => array(
                'collapsible' => true,
            ),
            'id' => 'MyTab-Menu1'
        ));
        ?>

    </div>
</div>
<br>

