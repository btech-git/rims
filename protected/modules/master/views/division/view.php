<?php
/* @var $this DivisionController */
/* @var $model Division */

$this->breadcrumbs = array(
    'Company',
    'Divisions' => array('admin'),
    'View Division ' . $model->name,
);

$this->menu = array(
    array('label' => 'List Division', 'url' => array('index')),
    array('label' => 'Create Division', 'url' => array('create')),
    array('label' => 'Update Division', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Division', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Division', 'url' => array('admin')),
);
?>

<div id="maincontent">
    <?php $ccontroller = Yii::app()->controller->id; ?>
    <?php $ccaction = Yii::app()->controller->action->id; ?>
    <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/division/admin'; ?>"><span class="fa fa-th-list"></span>Manage Divisions</a>
    <?php if (Yii::app()->user->checkAccess("masterDivisionEdit")) { ?>
        <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>edit</a>
    <?php } ?>
    <div class="clearfix page-action">
        <h1>View Division <?php echo $model->id; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                //'id',
                'name',
                'status',
            ),
        )); ?>
    </div>
</div>

<div class="row">
    <div class="small-12 columns">
        <h3>Positions</h3>
        <table >
            <thead>
                <tr>
                    <td>Position</td>
                    <td>Level</td>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($divisionPositions as $key => $divisionPosition): ?>
                    <tr>
                        <?php $position = Position::model()->findByPK($divisionPosition->position_id); ?>
                        <td><?php echo $position->name; ?></td>	

                        <td>
                            <?php $positionlevels = PositionLevel::model()->findAllByAttributes(array('position_id' => $divisionPosition->position_id));
                            if ($positionlevels) {
                            ?>
                                <table>
                                    <thead>
                                        <tr>
                                            <td>Name</td>
                                        </tr>
                                    </thead>
                                    <?php foreach ($positionlevels as $i => $positionlevel): ?>
                                        <tr>
                                            <?php $level = Level::model()->findByPK($positionlevel->level_id); ?>
                                            <td><?php echo $level->name; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </table>
                            <?php } else { ?>
                                <table>
                                    <tr>
                                        <td> <?php echo "No Level for this position"; ?></td>
                                    </tr>
                                </table>
                            <?php } ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>

<div class="row">
    <div class="small-12 columns">
        <h3>Branches</h3>
        <table>
            <?php foreach ($divisionBranches as $key => $divisionBranch): ?>
                <tr>
                    <?php $branch = Branch::model()->findByPK($divisionBranch->branch_id); ?>
                    <td><?php echo $branch->name; ?></td>	
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<div class="row">
    <div class="small-12 columns">
        <h3>Warehouses</h3>
        <table>
            <?php foreach ($divisionWarehouses as $key => $divisionWarehouses): ?>
                <tr>
                    <?php $warehouse = Warehouse::model()->findByPK($divisionWarehouses->warehouse_id); ?>
                    <td><?php echo $warehouse->name; ?></td>	
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>
