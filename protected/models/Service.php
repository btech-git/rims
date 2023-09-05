<?php

/**
 * This is the model class for table "{{service}}".
 *
 * The followings are the available columns in table '{{service}}':
 * @property integer $id
 * @property string $code
 * @property string $name
 * @property string $description
 * @property integer $service_category_id
 * @property integer $service_type_id
 * @property string $status
 * @property integer $difficulty_level
 * @property string $difficulty
 * @property string $difficulty_value
 * @property string $regular
 * @property string $luxury
 * @property string $luxury_value
 * @property string $luxury_calc
 * @property string $standard_rate_per_hour
 * @property string $flat_rate_hour
 * @property string $price
 * @property string $common_price
 * @property integer $is_deleted
 * @property string $deleted_at
 * @property integer $deleted_by
 * @property string $bongkar
 * @property string $sparepart
 * @property string $ketok_las
 * @property string $dempul
 * @property string $epoxy
 * @property string $cat
 * @property string $pasang
 * @property string $poles
 * @property string $cuci
 * @property string $finishing
 * @property string $price_easy
 * @property string $price_medium
 * @property string $price_hard
 * @property string $price_luxury
 * @property integer $is_approved
 * @property string $date_approval
 * @property integer $user_id
 * @property string $created_datetime
 *
 * The followings are the available model relations:
 * @property CustomerServiceRate[] $customerServiceRates
 * @property InsuranceCompanyPricelist[] $insuranceCompanyPricelists
 * @property ServiceCategory $serviceCategory
 * @property ServiceType $serviceType
 * @property ServiceComplement[] $serviceComplements
 * @property ServiceComplement[] $serviceComplements1
 * @property ServiceEquipment[] $serviceEquipments
 * @property ServiceMaterial[] $serviceMaterials
 * @property ServiceProduct[] $serviceProducts
 * @property ServicePricelist[] $servicePricelists
 * @property ServiceStandardPricelist[] $serviceStandardPricelists
 * @property RegistrationService[] $registrationServices
 * @property User $user
 */
class Service extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Service the static model class
     */
    public $service_category_name;
    public $service_category_code;
    public $service_type_name;
    public $service_type_code;
    public $service_price;
    public $findkeyword;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{service}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('code, name, service_category_id, service_type_id, status, difficulty_level, user_id', 'required'),
            array('service_category_id, service_type_id, difficulty_level, is_approved, user_id', 'numerical', 'integerOnly' => true),
            array('code', 'unique'),
            array('code', 'length', 'max' => 20),
            array('name', 'length', 'max' => 100),
            array('description', 'length', 'max' => 60),
            array('date_approval', 'safe'),
            array('status, difficulty, difficulty_value, regular, luxury, luxury_value, luxury_calc, standard_rate_per_hour, flat_rate_hour, price, common_price, bongkar, sparepart, ketok_las, dempul, epoxy, cat, pasang, poles, cuci, finishing, price_easy, price_medium, price_hard, price_luxury', 'length', 'max' => 10),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, code, name, price, description, created_datetime, service_category_id, service_type_id, status, difficulty_level, service_category_name,service_type_name,service_category_code, service_type_code, difficulty, difficulty_value, regular, luxury, luxury_value, luxury_calc, standard_rate_per_hour, flat_rate_hour, price, common_price, is_deleted, findkeyword, bongkar, sparepart, ketok_las, dempul, epoxy, cat, pasang, poles, cuci, finishing, price_easy, price_medium, price_hard, price_luxury, is_approved, date_approval, user_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array
     */
    public function behaviors() {
        return array(
            'SoftDelete' => array('class' => 'application.components.behaviors.SoftDeleteBehavior'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'registrationServices' => array(self::HAS_MANY, 'RegistrationService', 'service_id'),
            'customerServiceRates' => array(self::HAS_MANY, 'CustomerServiceRate', 'service_id'),
            'insuranceCompanyPricelists' => array(self::HAS_MANY, 'InsuranceCompanyPricelist', 'service_id'),
            'serviceCategory' => array(self::BELONGS_TO, 'ServiceCategory', 'service_category_id'),
            'serviceType' => array(self::BELONGS_TO, 'ServiceType', 'service_type_id'),
            'serviceComplements' => array(self::HAS_MANY, 'ServiceComplement', 'service_id'),
            'serviceComplements1' => array(self::HAS_MANY, 'ServiceComplement', 'complement_id'),
            'serviceEquipments' => array(self::HAS_MANY, 'ServiceEquipment', 'service_id'),
            'serviceMaterials' => array(self::HAS_MANY, 'ServiceMaterial', 'service_id'),
            'serviceProducts' => array(self::HAS_MANY, 'ServiceProduct', 'service_id'),
            'servicePricelists' => array(self::HAS_MANY, 'ServicePricelist', 'service_id'),
            'serviceStandardPricelists' => array(self::HAS_MANY, 'ServiceStandardPricelist', 'service_id'),
            'user' => array(self::BELONGS_TO, 'Users', 'user_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'code' => 'Code',
            'name' => 'Name',
            'description' => 'Description',
            'service_category_id' => 'Service Category',
            'service_type_id' => 'Service Type',
            'status' => 'Status',
            'difficulty_level' => 'Difficulty Level',
            'service_category_name' => 'Service Category',
            'service_type_name' => 'Service Type',
            'service_category_code' => 'Service Category Code',
            'service_type_code' => 'Service Type Code',
            'difficulty' => 'Difficulty',
            'difficulty_value' => 'Difficulty Value',
            'regular' => 'Regular',
            'luxury' => 'Luxury',
            'luxury_value' => 'Luxury Value',
            'luxury_calc' => 'Luxury Calc',
            'standard_rate_per_hour' => 'Standard Rate Per Hour',
            'flat_rate_hour' => 'Flat Rate Hour',
            'price' => 'Price',
            'common_price' => 'Common Price',
            'is_deleted' => 'Is Deleted',
            'deleted_at' => 'Deleted At',
            'deleted_by' => 'Deleted By',
            'bongkar' => 'Bongkar',
            'sparepart' => 'Sparepart',
            'ketok_las' => 'Ketok Las',
            'dempul' => 'Dempul',
            'epoxy' => 'Epoxy',
            'cat' => 'Cat',
            'pasang' => 'Pasang',
            'poles' => 'Poles',
            'cuci' => 'Cuci',
            'finishing' => 'Finishing',
            'price_easy' => 'Price Rate (Easy)',
            'price_medium' => 'Price Rate (Medium)',
            'price_hard' => 'Price Rate (Hard)',
            'price_luxury' => 'Price Rate (Luxury)',
            'is_approved' => 'Approval',
            'date_approval' => 'Tanggal Approval',
            'user_id' => 'User Input',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        // Warning: Please modify the following code to remove attributes that
        // should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('t.id', $this->id);
        $criteria->compare('t.code', $this->code, true);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('description', $this->description, true);
        $criteria->compare('t.service_category_id', $this->service_category_id);
        $criteria->compare('t.service_type_id', $this->service_type_id);
        $criteria->compare('t.status', $this->status, FALSE);
        $criteria->compare('difficulty_level', $this->difficulty_level);
        $criteria->compare('difficulty', $this->difficulty, true);
        $criteria->compare('difficulty_value', $this->difficulty_value, true);
        $criteria->compare('regular', $this->regular, true);
        $criteria->compare('luxury', $this->luxury, true);
        $criteria->compare('luxury_value', $this->luxury_value, true);
        $criteria->compare('luxury_calc', $this->luxury_calc, true);
        $criteria->compare('standard_rate_per_hour', $this->standard_rate_per_hour, true);
        $criteria->compare('flat_rate_hour', $this->flat_rate_hour, true);
        $criteria->compare('price', $this->price, true);
        $criteria->compare('common_price', $this->common_price, true);
        $criteria->compare('deleted_at', $this->deleted_at, true);
        $criteria->compare('deleted_by', $this->deleted_by);
        $criteria->compare('bongkar', $this->bongkar, true);
        $criteria->compare('sparepart', $this->sparepart, true);
        $criteria->compare('ketok_las', $this->ketok_las, true);
        $criteria->compare('dempul', $this->dempul, true);
        $criteria->compare('epoxy', $this->epoxy, true);
        $criteria->compare('cat', $this->cat, true);
        $criteria->compare('pasang', $this->pasang, true);
        $criteria->compare('poles', $this->poles, true);
        $criteria->compare('cuci', $this->cuci, true);
        $criteria->compare('finishing', $this->finishing, true);
        $criteria->compare('price_easy', $this->price_easy, true);
        $criteria->compare('price_medium', $this->price_medium, true);
        $criteria->compare('price_hard', $this->price_hard, true);
        $criteria->compare('price_luxury', $this->price_luxury, true);
        $criteria->compare('t.is_approved', $this->is_approved);
        $criteria->compare('t.date_approval', $this->date_approval);
        $criteria->compare('t.user_id', $this->user_id);

        $tampilkan = ($this->is_deleted == 1) ? array(0, 1) : array(0);
        $criteria->addInCondition('t.is_deleted', $tampilkan);

        $criteria->together = 'true';
        $criteria->with = array('serviceCategory', 'serviceType');
        $criteria->compare('serviceCategory.name', $this->service_category_name, true);
        $criteria->compare('serviceCategory.code', $this->service_category_code, true);
        $criteria->compare('serviceType.name', $this->service_type_name, true);
        $criteria->compare('serviceType.code', $this->service_type_code, true);

        $explodeKeyword = explode(" ", $this->findkeyword);
        foreach ($explodeKeyword as $key) {
            $criteria->compare('t.code', $key, true, 'OR');
            $criteria->compare('t.name', $key, true, 'OR');
            $criteria->compare('description', $key, true, 'OR');
            $criteria->compare('serviceCategory.name', $key, true, 'OR');
            $criteria->compare('serviceCategory.code', $key, true, 'OR');
            $criteria->compare('serviceType.name', $key, true, 'OR');
            $criteria->compare('serviceType.code', $key, true, 'OR');
        }

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'sort' => array(
                'defaultOrder' => 't.status ASC, t.name',
                'attributes' => array(
                    'service_category_name' => array(
                        'asc' => 'serviceCategory.name ASC',
                        'desc' => 'serviceCategory.name DESC',
                    ),
                    'service_category_code' => array(
                        'asc' => 'serviceCategory.code ASC',
                        'desc' => 'serviceCategory.code DESC',
                    ),
                    'service_type_name' => array(
                        'asc' => 'serviceType.name ASC',
                        'desc' => 'serviceType.name DESC',
                    ),
                    'service_type_code' => array(
                        'asc' => 'serviceType.code ASC',
                        'desc' => 'serviceType.code DESC',
                    ),
                    '*',
                ),
            ),
            'pagination' => array(
                'pageSize' => 10,
            ),
        ));
    }

    function getLevel($data) {
        $level = "";
        if ($data->difficulty_level == 0) {
            $level = "Easy";
        } elseif ($data->difficulty_level == 1) {
            $level = "Medium";
        } else {
            $level = "Hard";
        }
        return $level;
    }

    public function getTotalSales($startDate, $endDate) {
        $sql = "
            SELECT COALESCE(SUM(p.total_price), 0) AS total 
            FROM " . RegistrationService::model()->tableName() . " p 
            INNER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = p.registration_transaction_id
            WHERE p.service_id = :service_id AND substr(r.transaction_date, 1, 10) BETWEEN :start_date AND :end_date
            GROUP BY service_id
            HAVING total > 0.00
        ";

        $value = Yii::app()->db->createCommand($sql)->queryScalar(array(
            ':service_id' => $this->id,
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        ));

        return ($value === false) ? 0 : $value;
    }
    
    public function getSaleRetailReport($startDate, $endDate, $serviceId) {
        
        $sql = "SELECT r.transaction_number, r.transaction_date, r.repair_type, c.name as customer, v.plate_number as vehicle, t.name as type, p.total_price
                FROM " . RegistrationService::model()->tableName() . " p 
                LEFT OUTER JOIN " . RegistrationTransaction::model()->tableName() . " r ON r.id = p.registration_transaction_id
                LEFT OUTER JOIN " . Customer::model()->tableName() . " c ON c.id = r.customer_id
                LEFT OUTER JOIN " . Vehicle::model()->tableName() . " v ON v.id = r.vehicle_id
                LEFT OUTER JOIN " . ServiceType::model()->tableName() . " t ON t.id = p.service_type_id
                WHERE substr(r.transaction_date, 1, 10) BETWEEN :start_date AND :end_date AND service_id = :service_id AND p.total_price > 0
                ORDER BY r.transaction_date ASC";
        
        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
            ':service_id' => $serviceId,
        ));
        
        return $resultSet;
    }
    
    public function getSaleRetailServiceReport($startDate, $endDate) {
        
        $params = array(
            ':start_date' => $startDate,
            ':end_date' => $endDate,
        );
        
        $sql = "
            SELECT s.id, s.code, s.name, c.name as category, t.name as type, po.sale_total as total
            FROM " . Service::model()->tableName() . " s
            INNER JOIN " . ServiceCategory::model()->tableName() . " c ON c.id = s.service_category_id
            INNER JOIN " . ServiceType::model()->tableName() . " t ON t.id = s.service_type_id
            INNER JOIN (
                SELECT p.service_id, SUM(p.total_price) AS sale_total
                FROM " . RegistrationService::model()->tableName() . " p
                INNER JOIN " . RegistrationTransaction::model()->tableName() . " h ON h.id = p.registration_transaction_id
                WHERE substr(h.transaction_date, 1, 10) BETWEEN :start_date AND :end_date
                GROUP BY p.service_id
            ) po ON s.id = po.service_id
            ORDER BY c.name ASC, s.name ASC
        ";

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
}
