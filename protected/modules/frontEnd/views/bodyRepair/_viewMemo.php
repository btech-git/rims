<table>
    <thead>
        <tr>
            <th>Message</th>
            <th>Date</th>
            <th>Sent By</th>
        </tr>
    </thead>
    <tbody>
        <?php if (count($registrationMemos) > 0): ?>
            <?php foreach ($registrationMemos as $i => $registrationMemo): ?>
                <tr>
                    <td><?php echo $registrationMemo->memo; ?></td>
                    <td><?php echo $registrationMemo->date_time; ?></td>
                    <td><?php echo $registrationMemo->user->username; ?></td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        <tr>
            <td colspan="3">
                Tambah Memo: 
                <?php echo CHtml::textField('Memo', $memo, array('size' => 10, 'maxLength' => 100)); ?> <br />
                <?php //echo CHtml::hiddenField('_FormSubmit_', ''); ?>
                <?php echo CHtml::submitButton('Submit', array('name' => 'SubmitMemo', 'confirm' => 'Are you sure you want to save?', 'class' => 'btn_blue')); ?>
            </td>
        </tr>
    </tbody>
</table>