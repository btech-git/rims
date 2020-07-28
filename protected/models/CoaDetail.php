<?php

/**
 * This is the model class for table "{{coa_detail}}".
 *
 * The followings are the available columns in table '{{coa_detail}}':
 * @property integer $id
 * @property integer $coa_id
 * @property integer $periode
 * @property string $opening_balance
 * @property string $closing_balance
 * @property string $debit
 * @property string $credit
 *
 * The followings are the available model relations:
 * @property Coa $coa
 */
class CoaDetail extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{coa_detail}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('coa_id, periode, opening_balance, closing_balance, debit, credit', 'required'),
			array('coa_id, periode', 'numerical', 'integerOnly'=>true),
			array('opening_balance, closing_balance, debit, credit', 'length', 'max'=>18),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, coa_id, periode, opening_balance, closing_balance, debit, credit', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'coa' => array(self::BELONGS_TO, 'Coa', 'coa_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'coa_id' => 'Coa',
			'periode' => 'Periode',
			'opening_balance' => 'Opening Balance',
			'closing_balance' => 'Closing Balance',
			'debit' => 'Debit',
			'credit' => 'Credit',
		);
	}

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
		$criteria->compare('coa_id',$this->coa_id);
		$criteria->compare('periode',$this->periode);
		$criteria->compare('opening_balance',$this->opening_balance,true);
		$criteria->compare('closing_balance',$this->closing_balance,true);
		$criteria->compare('debit',$this->debit,true);
		$criteria->compare('credit',$this->credit,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CoaDetail the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
