<h2>Switch User Login</h2>
<?php echo CHtml::beginForm(); ?>
    <?php echo CHtml::dropDownList('UserId', $userId, CHtml::listData($userList, 'id', 'username'), array('empty' => '-- Select Username --')); ?>
    <?php if ($userIsError): ?>
        <div style="color: red">Please select a username</div>
    <?php endif; ?>

    <hr />
    
    <div class="field buttons text-center">
        <?php echo CHtml::submitButton('Switch', array('name' => 'Submit', 'class' => 'button cbutton')); ?>
    </div>

<?php echo CHtml::endForm(); ?>