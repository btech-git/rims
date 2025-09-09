<div class="tab reportTab">
    <div class="tabBody">
        <div id="detail_div">
            <div class="myForm tabForm customer">
                <?php echo CHtml::beginForm(array(''), 'get'); ?>
                <div class="row">
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-6 columns">
                                    <span class="prefix">Tahun </span>
                                </div>

                                <div class="small-6 columns">
                                    <?php echo CHtml::dropDownList('Year', $year, $yearList); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="medium-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-6 columns">
                                    <span class="prefix">Employee</span>
                                </div>

                                <div class="small-6 columns">
                                    <?php echo CHtml::dropDownList('EmployeeId', $employeeId, CHtml::listData(Employee::model()->findAllbyAttributes(array('status' => 'Active'), array('order' => 'name ASC')), 'id', 'name'), array('empty' => '-- Pilih Employee --')); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="clear"></div>
                
                <div class="row buttons">
                    <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
                    <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
                    <?php echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel'));  ?>
                </div>

                <?php echo CHtml::endForm(); ?>
                <div class="clear"></div>

            </div>

            <hr />

            <div style="font-weight: bold; text-align: center">
                <?php $employee = Employee::model()->findByPK($employeeId); ?>
                <div style="font-size: larger">Laporan Attendance Employee <?php echo CHtml::encode(CHtml::value($employee, 'name')); ?></div>
                <div><?php echo CHtml::encode($year); ?></div>
            </div>

            <br />

            <?php $monthList = array(
                1 => 'Jan',
                2 => 'Feb',
                3 => 'Mar',
                4 => 'Apr',
                5 => 'May',
                6 => 'Jun',
                7 => 'Jul',
                8 => 'Aug',
                9 => 'Sep',
                10 => 'Oct',
                11 => 'Nov',
                12 => 'Dec',
            ); ?>

            <?php $dayOfWeekList = array_flip(array('Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu')); ?>

            <div class="relative">
                <?php $this->renderPartial('_summary', array(
                    'employeeYearlyAttendanceData' => $employeeYearlyAttendanceData,
                    'year' => $year,
                    'onleaveCategories' => $onleaveCategories,
                    'monthList' => $monthList,
                    'employee' => $employee,
                    'dayOfWeekList' => $dayOfWeekList,
                    'employeeDaysCountData' => $employeeDaysCountData,
                )); ?>
            </div>

            <div class="clear"></div>
        </div>
    </div>
</div>