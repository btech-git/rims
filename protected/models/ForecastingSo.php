<?php

/**
 * This is the model class for table "{{forecasting}}".
 *
 * The followings are the available columns in table '{{forecasting}}':
 * @property integer $id
 * @property integer $transaction_id
 * @property string $type_forecasting
 * @property string $due_date
 * @property string $payment_date
 * @property string $realization_date
 * @property integer $bank_id
 * @property string $amount
 * @property string $balance
 * @property string $realization_balance
 * @property string $status
 * @property string $notes
 */
class ForecastingSo extends Forecasting
{
	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('transaction_id',$this->transaction_id);
		$criteria->compare('type_forecasting','so',true);
		$criteria->compare('due_date',$this->due_date,true);
		$criteria->compare('payment_date',$this->payment_date,true);
		$criteria->compare('realization_date',$this->realization_date,true);
		$criteria->compare('bank_id',$this->bank_id);
		$criteria->compare('amount',$this->amount,true);
		$criteria->compare('balance',$this->balance,true);
		$criteria->compare('realization_balance',$this->realization_balance,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('notes',$this->notes,true);

		if ($this->customer_name != NULL) {
			$criteria->with = array('transaction_so'=>array('together'=>true, 'with'=>array('customer')));
			$criteria->compare('customer.name', $this->customer_name, true);
		}

		if ($this->bank_name != NULL) {
			$criteria->with = array('bank'=>array('together'=>true, 'with'=>array('coa')));
			$criteria->compare('coa.name', $this->bank_name, true);
		}

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Forecasting the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
