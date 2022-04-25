<?php

/**
 * This is the model class for table "{{asset}}".
 *
 * The followings are the available columns in table '{{asset}}':
 * @property integer $id
 * @property string $code
 * @property string $description
 * @property string $memo
 * @property string $status
 * @property integer $is_taxable
 * @property integer $is_zero_book_value
 * @property integer $asset_category_id
 *
 * The followings are the available model relations:
 * @property AssetCategory $assetCategory
 * @property AssetDepreciation[] $assetDepreciations
 * @property AssetPurchase[] $assetPurchases
 * @property AssetSale[] $assetSales
 */
class Asset extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{asset}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('code, description, status, asset_category_id', 'required'),
			array('is_taxable, is_zero_book_value, asset_category_id', 'numerical', 'integerOnly'=>true),
			array('code', 'length', 'max'=>50),
			array('description', 'length', 'max'=>100),
			array('status', 'length', 'max'=>20),
			array('memo', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, code, description, memo, status, is_taxable, is_zero_book_value, asset_category_id', 'safe', 'on'=>'search'),
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
			'assetCategory' => array(self::BELONGS_TO, 'AssetCategory', 'asset_category_id'),
			'assetDepreciations' => array(self::HAS_MANY, 'AssetDepreciation', 'asset_id'),
			'assetPurchases' => array(self::HAS_MANY, 'AssetPurchase', 'asset_id'),
			'assetSales' => array(self::HAS_MANY, 'AssetSale', 'asset_id'),
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
			'memo' => 'Memo',
			'status' => 'Status',
			'is_taxable' => 'Is Taxable',
			'is_zero_book_value' => 'Is Zero Book Value',
			'asset_category_id' => 'Asset Category',
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
		$criteria->compare('memo',$this->memo,true);
		$criteria->compare('status',$this->status,true);
		$criteria->compare('is_taxable',$this->is_taxable);
		$criteria->compare('is_zero_book_value',$this->is_zero_book_value);
		$criteria->compare('asset_category_id',$this->asset_category_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Asset the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
