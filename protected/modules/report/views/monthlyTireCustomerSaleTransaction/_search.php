<div>
    <table>
        <thead>
            <tr>
                <td>Master Kategori</td>
                <td>Sub Master Kategori</td>
                <td>Sub Kategori</td>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    <?php $productMasterCategory = ProductMasterCategory::model()->findByPk(4); ?>
                    <?php echo CHtml::encode(CHtml::value($productMasterCategory, 'name')); ?>
                </td>

                <td>
                    <?php $productSubMasterCategory = ProductSubMasterCategory::model()->findByPk(26); ?>
                    <?php echo CHtml::encode(CHtml::value($productSubMasterCategory, 'name')); ?>
                </td>

                <td>
                    <div id="product_sub_category">
                        <?php echo CHtml::dropDownList('ProductSubCategoryId', $productSubCategoryId, CHtml::listData(ProductSubCategory::model()->findAll(array(
                            'condition' => 'id IN (442, 443, 444)',
                            'order' => 'name ASC'
                        )), 'id', 'name'), array(
                            'empty' => '-- All --',
                            'order' => 'name',
                        )); ?>
                    </div>
                </td>
            </tr>
        </tbody>
    </table>

    <table>
        <thead>
            <tr>
                <td>Name</td>
                <td>Bulan</td>
                <td>Tahun</td>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td><?php echo CHtml::textField('CustomerName', $customerName); ?></td>
                <td>
                    <?php echo CHtml::dropDownList('Month', $month, array(
                        '01' => 'Jan',
                        '02' => 'Feb',
                        '03' => 'Mar',
                        '04' => 'Apr',
                        '05' => 'May',
                        '06' => 'Jun',
                        '07' => 'Jul',
                        '08' => 'Aug',
                        '09' => 'Sep',
                        '10' => 'Oct',
                        '11' => 'Nov',
                        '12' => 'Dec',
                    )); ?>
                </td>
                <td><?php echo CHtml::dropDownList('Year', $year, $yearList); ?></td>
            </tr>
        </tbody>
    </table>

    <div>
        <?php echo CHtml::submitButton('Tampilkan', array('onclick' => '$("#CurrentSort").val(""); return true;')); ?>
        <?php echo CHtml::submitButton('Hapus', array('name' => 'ResetFilter'));  ?>
        <?php //echo CHtml::submitButton('Simpan ke Excel', array('name' => 'SaveExcel')); ?>
    </div>
</div>