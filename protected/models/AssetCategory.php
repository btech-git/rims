<?php

/**
 * This is the model class for table "{{asset_category}}".
 *
 * The followings are the available columns in table '{{asset_category}}':
 * @property integer $id
 * @property string $code
 * @property string $description
 * @property integer $status
 * @property string $type
 * @property integer $number_of_years
 *
 * The followings are the available model relations:
 * @property AssetPurchase[] $assetPurchases
 * @property AssetTransaction[] $assetTransactions
 */
class AssetCategory extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{asset_category}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, description', 'required'),
			array('status, number_of_years', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>20),
			array('description', 'length', 'max'=>100),
			array('type', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, description, status, type, number_of_years', 'safe', 'on'=>'search'),
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
			'assetPurchases' => array(self::HAS_MANY, 'AssetPurchase', 'asset_category_id'),
			'assetTransactions' => array(self::HAS_MANY, 'AssetTransaction', 'asset_category_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'code' => 'Code',
			'description' => 'Description',
			'status' => 'Status',
			'type' => 'Type',
			'number_of_years' => 'Number Of Years',
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
		$criteria->compare('code',$this->code,true);
		$criteria->compare('description',$this->description,true);
		$criteria->compare('status',$this->status);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('number_of_years',$this->number_of_years);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return AssetCategory the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
