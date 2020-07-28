<?php

/**
 * This is the model class for table "{{service_material}}".
 *
 * The followings are the available columns in table '{{service_material}}':
 * @property integer $id
 * @property integer $service_id
 * @property integer $product_id
 * @property integer $easy
 * @property integer $medium
 * @property integer $hard
 *
 * The followings are the available model relations:
 * @property Service $service
 * @property Product $product
 */
class ServiceMaterial extends CActiveRecord
{
	public $material_name;

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{service_material}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('service_id, product_id', 'required'),
			array('service_id, product_id, easy, medium, hard', 'numerical', 'integerOnly'=>true),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, service_id, product_id, easy, medium, hard', 'safe', 'on'=>'search'),
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
			'service' => array(self::BELONGS_TO, 'Service', 'service_id'),
			'product' => array(self::BELONGS_TO, 'Product', 'product_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'service_id' => 'Service',
			'product_id' => 'Product',
			'easy' => 'Easy',
			'medium' => 'Medium',
			'hard' => 'Hard',
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
		$criteria->compare('service_id',$this->service_id);
		$criteria->compare('product_id',$this->product_id);
		$criteria->compare('easy',$this->easy);
		$criteria->compare('medium',$this->medium);
		$criteria->compare('hard',$this->hard);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return ServiceMaterial the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
