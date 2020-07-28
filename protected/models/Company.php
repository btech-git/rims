<?php

/**
 * This is the model class for table "{{company}}".
 *
 * The followings are the available columns in table '{{company}}':
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property integer $province_id
 * @property integer $city_id
 * @property integer $branch_id
 * @property string $phone
 * @property string $npwp
 * @property string $tax_status
 *
 * The followings are the available model relations:
 * @property Province $province
 * @property City $city
 * @property CompanyBank[] $companyBanks
 * @property CompanyBranch[] $companyBranches
 */
class Company extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public $city_name;
	public $province_name;


	public function tableName()
	{
		return '{{company}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('name, address, province_id, city_id, phone, npwp, tax_status', 'required'),
			array('province_id, city_id, branch_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>30),
			array('phone, npwp, tax_status', 'length', 'max'=>20),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, name, address, province_id, city_id, branch_id, phone, npwp, tax_status, is_deleted, city_name, province_name', 'safe', 'on'=>'search'),
		);
	}

	/**
     * @return array
     */
    public function behaviors()
    {
        return array(
            'SoftDelete'=>array('class'=>'application.components.behaviors.SoftDeleteBehavior'),
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
			'province' => array(self::BELONGS_TO, 'Province', 'province_id'),
			'city' => array(self::BELONGS_TO, 'City', 'city_id'),
			'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
			'companyBanks' => array(self::HAS_MANY, 'CompanyBank', 'company_id'),
			'companyBranches' => array(self::HAS_MANY, 'CompanyBranch', 'company_id'),
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
			'address' => 'Address',
			'province_id' => 'Province',
			'city_id' => 'City',
			'branch_id' => 'Branch',
			'phone' => 'Phone',
			'npwp' => 'Npwp',
			'tax_status' => 'Tax Status',
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
		$criteria->compare('address',$this->address,true);
		$criteria->compare('province_id',$this->province_id);
		$criteria->compare('city_id',$this->city_id);
		$criteria->compare('branch_id',$this->branch_id);
		$criteria->compare('phone',$this->phone,true);
		$criteria->compare('npwp',$this->npwp,true);
		$criteria->compare('tax_status',$this->tax_status,true);
		// $criteria->compare('is_deleted',0,true);
		$tampilkan = ($this->is_deleted == 1) ? array(0,1) : array(0);
		$criteria->addInCondition('t.is_deleted', $tampilkan);

		$criteria->together = 'true';
		$criteria->with = array('province', 'city');
		$criteria->compare('province.name', $this->province_name, true);
		$criteria->compare('city.name', $this->city_name, true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
            'defaultOrder' => 't.name',
            'attributes' => array(
	                'province_name' => array(
	                    'asc' => 'province.name ASC',
	                    'desc' => 'province.name DESC',
	                ),
	                'city_name' => array(
	                    'asc' => 'city.name ASC',
	                    'desc' => 'city.name DESC',
	                ),
	                '*',
	            ),
	        ),
	        'pagination' => array(
	            'pageSize' => 10,
	        ),
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Company the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
