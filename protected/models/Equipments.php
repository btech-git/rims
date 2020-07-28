<?php

/**
 * This is the model class for table "{{equipments}}".
 *
 * The followings are the available columns in table '{{equipments}}':
 * @property integer $id
 * @property integer $branch_id
 * @property integer $equipment_type_id
 * @property integer $equipment_sub_type_id
 * @property string $name
 * @property string $status
 *
 * The followings are the available model relations:
 * @property EquipmentDetails[] $equipmentDetails
 * @property EquipmentMaintenance[] $equipmentMaintenances
 * @property EquipmentMaintenances[] $equipmentMaintenances1
 * @property EquipmentTask[] $equipmentTasks
 * @property EquipmentType $equipmentType
 * @property EquipmentSubType $equipmentSubType
 */
class Equipments extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{equipments}}';
	}
	public $branch_name;
	public $equipment_type_name;
	public $equipment_sub_type_name;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('branch_id, equipment_type_id, equipment_sub_type_id, name', 'required'),
			array('branch_id, equipment_type_id, equipment_sub_type_id', 'numerical', 'integerOnly'=>true),
			array('name', 'length', 'max'=>30),
			array('status', 'length', 'max'=>10),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, branch_id, equipment_type_id, equipment_sub_type_id, name, equipment_type_name, equipment_sub_type_name, status', 'safe', 'on'=>'search'),
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
			'branch' => array(self::BELONGS_TO, 'Branch', 'branch_id'),
			'equipmentDetails' => array(self::HAS_MANY, 'EquipmentDetails', 'equipment_id'),
			'equipmentMaintenances' => array(self::HAS_MANY, 'EquipmentMaintenance', 'equipment_id'),
			'equipmentMaintenances1' => array(self::HAS_MANY, 'EquipmentMaintenances', 'equipment_id'),
			'equipmentTasks' => array(self::HAS_MANY, 'EquipmentTask', 'equipment_id'),
			'equipmentType' => array(self::BELONGS_TO, 'EquipmentType', 'equipment_type_id'),
			'equipmentSubType' => array(self::BELONGS_TO, 'EquipmentSubType', 'equipment_sub_type_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'branch_id' => 'Branch',
			'equipment_type_id' => 'Equipment Type',
			'equipment_sub_type_id' => 'Equipment Sub Type',
			'name' => 'Name',
			'status' => 'Status',
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
		$criteria->compare('branch_id',$this->branch_id);
		$criteria->compare('equipment_type_id',$this->equipment_type_id);
		$criteria->compare('equipment_sub_type_id',$this->equipment_sub_type_id);
		$criteria->compare('t.name',$this->name,true);
		$criteria->compare('LOWER(status)', strtolower($this->status),FALSE);

		$criteria->together = 'true';
		$criteria->with = array('branch','equipmentType', 'equipmentSubType');
		$criteria->compare('branch.name', $this->branch_name, true);
		// $criteria->compare('city.name', $this->city_name, true);


		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort' => array(
            'defaultOrder' => 't.name',
            'attributes' => array(
	                'branch_id' => array(
	                    'asc' => 'branch.name ASC',
	                    'desc' => 'branch.name DESC',
	                ),
	                'equipment_type_id' => array(
	                    'asc' => 'equipmentType.name ASC',
	                    'desc' => 'equipmentType.name DESC',
	                ),
	                'equipment_sub_type_id' => array(
	                    'asc' => 'equipmentSubType.name ASC',
	                    'desc' => 'equipmentSubType.name DESC',
	                ),
	                '*',
	            ),
	        ),
	        'pagination' => array(
	            'pageSize' => 10,
	        ),

		));
	}

	public function defaultScope()
	{
	  	$alias = $this->getTableAlias(false, false);
	    return array(
	        'condition'=>"{$alias}.status = 'Active'",
	        // 'order'=>"t.name ASC",
	    );
	}


	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Equipments the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	public static function getLink($data,$row)
	{
		
		if($data->id)
		{
			$equipmentMaintenances = EquipmentMaintenances::model()->findAllByAttributes(array('equipment_id'=>$data->id));
			if(count($equipmentMaintenances)>0)
			{
				return $link = CHtml::link('Update Maintenance Details',Yii::app()->baseUrl."/master/equipments/updateDetails?id=".$data->id);
			}
			else
			{
				return $link = CHtml::link('Add Maintenance Details',Yii::app()->baseUrl."/master/equipments/createMaintenance?id=".$data->id);
			}			
		}
	}
}
