<?php
/* @var $this EmployeeController */
/* @var $model Employee */

$this->breadcrumbs = array(
    'Company',
    'Employees' => array('admin'),
    'View Employee ' . $model->name,
);

$this->menu = array(
    array('label' => 'List Employee', 'url' => array('index')),
    array('label' => 'Create Employee', 'url' => array('create')),
    array('label' => 'Update Employee', 'url' => array('update', 'id' => $model->id)),
    array('label' => 'Delete Employee', 'url' => '#', 'linkOptions' => array('submit' => array('delete', 'id' => $model->id), 'confirm' => 'Are you sure you want to delete this item?')),
    array('label' => 'Manage Employee', 'url' => array('admin')),
);
?>
<div id="maincontent">
    <div class="clearfix page-action">
        <?php $ccontroller = Yii::app()->controller->id; ?>
        <?php $ccaction = Yii::app()->controller->action->id; ?>
        <a class="button cbutton right" href="<?php echo Yii::app()->baseUrl . '/master/employee/admin'; ?>"><span class="fa fa-list"></span>Manage Employees</a>
        <?php if (Yii::app()->user->checkAccess("masterEmployeeEdit")) { ?>
            <a class="button cbutton right" style="margin-right:10px;" href="<?php echo Yii::app()->createUrl('/master/' . $ccontroller . '/update', array('id' => $model->id)); ?>"><span class="fa fa-edit"></span>edit</a>
        <?php } ?>
        <h1>View Employee <?php echo $model->name; ?></h1>

        <?php $this->widget('zii.widgets.CDetailView', array(
            'data' => $model,
            'attributes' => array(
                'code',
                'name',
                'id_card',
                'local_address',
                array(
                    'label' => 'Tanggal Join',
                    'value' => Yii::app()->dateFormatter->format("d MMMM yyyy", CHtml::encode(CHtml::value($model, 'recruitment_date'))),
                ),
                array('name' => 'province_name', 'value' => $model->province->name),
                array('name' => 'city_name', 'value' => $model->city->name),
                'home_address',
                array('name' => 'home_province_name', 'value' => $model->homeProvince->name),
                array('name' => 'home_city_name', 'value' => $model->homeProvince->name),
                'sex',
                'email',
                'driving_license',
                'status',
            ),
        ));
        ?>
    </div>
</div>

<br /><hr />

<div class="row">
    <div class="small-12 columns">
        <h3>Branch - Division - Position - Level</h3>
        <table >
            <thead>
                <tr>
                    <td>Branch</td>
                    <td>Division</td>
                    <td>Position</td>
                    <td>Level</td>
                </tr>
            </thead>
            <?php foreach ($employeeDivisions as $key => $employeeDivision): ?>
                <tr>
                    <?php $branch = Branch::model()->findByPk($employeeDivision->branch_id); ?>
                    <?php $division = Division::model()->findByPk($employeeDivision->division_id); ?>
                    <?php $position = Position::model()->findByPk($employeeDivision->position_id); ?>
                    <?php $level = Level::model()->findByPk($employeeDivision->level->id); ?>
                    <td><?php echo $branch->name ?></td>
                    <td><?php echo $division->name ?></td>
                    <td><?php echo $position->name ?></td>
                    <td><?php echo $level->name ?></td>

                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</div>

<!--<br /><hr />

<div class="row">
    <div class="small-12 columns">
        <div class="grid-view">
            <?php /*$this->widget('zii.widgets.grid.CGridView', array(
                'id' => 'attendance-grid',
                'dataProvider' => $dataProvider,
                'template' => '<div style="overflow-x:scroll ; overflow-y: hidden; margin-bottom: 1.25rem;">{items}</div><div class="clearfix">{summary}{pager}</div>',
                'pager' => array(
                    'cssFile' => false,
                    'header' => '',
                ),
                'columns' => array(
                    'date',
                    'login_time',
                    'logout_time',
                    'total_hour',
                    [
                        'header' => 'notes',
                        'name' => 'notes',
                        'value' => 'CHtml::dropDownList("EmployeeAttendance[notes]", "$data->notes", array(
                            ""=>"No overtime",
                            "Overtime" => "Overtime",
                            "Izin" => "Izin",
                            "Alpha" => "Alpha",
                        ))',
                        'type' => 'raw'
                    ],
                    [
                        'value' => 'CHtml::button("SAVE", array('
                        . '"id"=>"btnsave",'
                        . '"rel"=>"$data->id", '
                        . '"class"=>"button cbutton secondary", '
                        . '"style"=>"background-color:#767171; color:#fff;"'
                        . '))',
                        'type' => "raw"
                    ],
                ),
            ));*/ ?>
        </div>
    </div>
</div>-->

<?php /*Yii::app()->clientScript->registerScript('myforecastingProduct', '
    $("body").on("click","#btnsave",function(){
        var id = $(this).attr("rel");

        var sibs=$(this).parent().siblings();
        data.model_id=id;
        data.notes=$(sibs[4]).children().val();

        $.ajax({
            "url":"' . CHtml::normalizeUrl(array("employeeAttendance/saveData")) . '",
            "data":data,
            "type":"POST",
            "success":function(data){
                console.log(data);
                $("#attendance-grid").yiiGridView("update",{});
            },
        })

        return false;
    });
', CClientScript::POS_END); ?>