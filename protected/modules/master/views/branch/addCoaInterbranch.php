<?php $this->breadcrumbs=array(
    'Branch'=>array('admin'),
    'Add Coa Interbranch',
); ?>

<div class="form">
    <?php echo CHtml::beginForm(); ?>
	<div class="row">
        <?php //echo $form->errorSummary($model); ?>
        <div id="maincontent">
            <h2>Branch Asal</h2>
            <div id="branch">
                <table>
                    <thead>
                        <tr>
                            <th>Code</th>
                            <th>Name</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Province</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?php echo CHtml::encode(CHtml::value($branchFrom, 'code')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($branchFrom, 'name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($branchFrom, 'address')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($branchFrom, 'city.name')); ?></td>
                            <td><?php echo CHtml::encode(CHtml::value($branchFrom, 'province.name')); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
            
            <h2>Branch Tujuan</h2>
            
            <br /><br />
            
            <div id="detail_div">
                <?php $this->renderPartial('_detailBranchTo', array(
                    'branchFrom' => $branchFrom,
                    'branchTos' => $branchTos,
                    'branchIdTo' => $branchIdTo,
                    'coaId' => $coaId,
                )); ?>
            </div>
        </div>
    </div>
    
    <hr />
    
    <div class="field buttons text-center">
        <?php echo CHtml::submitButton('Cancel', array('name' => 'Cancel', 'class'=>'button alert', 'confirm' => 'Are you sure you want to cancel?')); ?>
        <?php echo CHtml::submitButton('Save', array('name' => 'Submit', 'class'=>'button primary', 'confirm' => 'Are you sure you want to save?')); ?>
    </div>

    <?php echo CHtml::endForm(); ?>
</div>