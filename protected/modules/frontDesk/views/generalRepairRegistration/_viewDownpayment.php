<fieldset>
    <legend>Downpayment</legend>
    <div class="row">
        <div class="large-12 columns">

            <div class="large-6 columns">

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">DP #</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->downpayment_transaction_number; ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Tanggal</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->downpayment_transaction_date; ?>"> 
                        </div>
                    </div>
                </div>

                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Note</span>
                        </div>
                        <div class="small-8 columns">
                            <textarea name="" id="" cols="30" rows="5" readonly="true"><?php echo $model->downpayment_note; ?></textarea>
                        </div>
                    </div>
                </div>
            </div> <!-- end div large -->

            <div class="large-6 columns">
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Jumlah</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo number_format($model->downpayment_amount, 2); ?>"> 
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Status</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->downpayment_status; ?>">
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Created By</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->userIdCreatedDownpayment->username; ?>"> 
                        </div>
                    </div>
                </div>
                <div class="field">
                    <div class="row collapse">
                        <div class="small-4 columns">
                            <span class="prefix">Created Date</span>
                        </div>
                        <div class="small-8 columns">
                            <input type="text" readonly="true" value="<?php echo $model->downpayment_created_datetime; ?>">
                        </div>
                    </div>
                </div>
            </div><!-- end div large -->
        </div>
    </div>
</fieldset>