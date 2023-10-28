<?php

/**
 * This is the model class for table "coa_log".
 *
 * The followings are the available columns in table 'coa_log':
 * @property integer $id
 * @property string $name
 * @property string $code
 * @property integer $coa_category_id
 * @property integer $coa_sub_category_id
 * @property string $date_updated
 * @property string $time_updated
 * @property integer $user_updated_id
 * @property integer $coa_id
 *
 * The followings are the available model relations:
 * @property CoaCategory $coaCategory
 * @property CoaSubCategory $coaSubCategory
 * @property Users $userUpdated
 * @property Coa $coa
 */
class CoaLog extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'coa_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, code, coa_category_id, coa_sub_category_id, date_updated, time_updated, user_updated_id, coa_id', 'required'),
			array('coa_category_id, coa_sub_category_id, user_updated_id, coa_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>50),
			array('code', 'length', 'max'=>15),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, code, coa_category_id, coa_sub_category_id, date_updated, time_updated, user_updated_id, coa_id', 'safe', 'on'=>'search'),
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
			'coaCategory' => array(self::BELONGS_TO, 'CoaCategory', 'coa_category_id'),
			'coaSubCategory' => array(self::BELONGS_TO, 'CoaSubCategory', 'coa_sub_category_id'),
			'userUpdated' => array(self::BELONGS_TO, 'Users', 'user_updated_id'),
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
			'name' => 'Name',
			'code' => 'Code',
			'coa_category_id' => 'Coa Category',
			'coa_sub_category_id' => 'Coa Sub Category',
			'date_updated' => 'Date Updated',
			'time_updated' => 'Time Updated',
			'user_updated_id' => 'User Updated',
			'coa_id' => 'Coa',
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
		$criteria->compare('name',$this->name,true);
		$criteria->compare('code',$this->code,true);
		$criteria->compare('coa_category_id',$this->coa_category_id);
		$criteria->compare('coa_sub_category_id',$this->coa_sub_category_id);
		$criteria->compare('date_updated',$this->date_updated,true);
		$criteria->compare('time_updated',$this->time_updated,true);
		$criteria->compare('user_updated_id',$this->user_updated_id);
		$criteria->compare('coa_id',$this->coa_id);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return CoaLog the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
