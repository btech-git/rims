<fieldset>
    <legend>Customer</legend>
    <div class="row">
        <div class="large-12 columns">

            <div class="large-6 columns">

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Name</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->customer->name; ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Type</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->customer->customer_type; ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Address</span>
                        </div>
                        <div class="small-8 columns">
                            <textarea name="" id="" cols="30" rows="5" readonly="true"><?php echo $model->customer->address . '&#13;&#10;' . $model->customer->province->name . '&#13;&#10;' . $model->customer->city->name . '&#13;&#10;' . $model->customer->zipcode; ?></textarea>
                        </div>
                    </div>
                </div>
            </div> <!-- end div large -->

            <div class="large-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Phone</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->phone; ?>">
                            <?php /*$phones = CustomerPhone::model()->findAllByAttributes(array('customer_id' => $model->customer_id, 'status' => 'Active')); ?>
                            <?php if (count($phones) > 0): ?>
                                <?php foreach ($phones as $key => $phone): ?>
                                    <input type="text" readonly="true" value="<?php echo $phone->phone_no; ?>"> 
                                <?php endforeach; ?>
                            <?php else: ?>
                                <input type="text" readonly="true" value="<?php echo 'No Phone Registered to this Customer'; ?>">
                            <?php endif;*/ ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Mobile</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->mobile_phone; ?>">
                            <?php /*$mobiles = CustomerMobile::model()->findAllByAttributes(array('customer_id' => $model->customer_id, 'status' => 'Active')); ?>
                            <?php if (count($mobiles) > 0): ?>
                                <?php foreach ($mobiles as $key => $mobile): ?>
                                    <input type="text" readonly="true" value="<?php echo $mobile->mobile_no; ?>">
                                <?php endforeach ?>
                            <?php else: ?>
                                <input type="text" readonly="true" value="<?php echo 'No Mobile Phone Registered to this Customer'; ?>">
                            <?php endif*/ ?>
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Email</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->customer->email; ?>"> 
                        </div>
                    </div>
                </div>
            </div><!-- end div large -->
        </div>
    </div>
</fieldset>

<div>
    <?php if ($model->pic != null): ?>
        <fieldset>
            <legend>PIC</legend>
            <div class="row">
                <div class="large-12 columns">
                    <div class="large-6 columns">
                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Name</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->pic->name; ?>"> 
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Address</span>
                                </div>
                                <div class="small-8 columns">
                                    <textarea name="" id="" cols="30" rows="5" readonly="true"><?php echo $model->pic->address . '&#13;&#10;' . $model->pic->province->name . '&#13;&#10;' . $model->pic->city->name . '&#13;&#10;' . $model->pic->zipcode; ?></textarea>
                                </div>
                            </div>
                        </div>

                        <div class="field">
                            <div class="row collapse">
                                <div class="small-4 columns">
                                    <span class="prefix">Email</span>
                                </div>
                                <div class="small-8 columns">
                                    <input type="text" readonly="true" value="<?php echo $model->customer->email; ?>"> 
                                </div>
                            </div>
                        </div>
                    </div> <!-- end div large -->
                </div>
            </div>
        </fieldset>
    <?php endif ?>
</div>