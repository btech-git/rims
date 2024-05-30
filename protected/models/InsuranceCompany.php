<?php

/**
 * This is the model class for table "{{insurance_company}}".
 *
 * The followings are the available columns in table '{{insurance_company}}':
 * @property integer $id
 * @property string $name
 * @property string $address
 * @property integer $province_id
 * @property integer $city_id
 * @property string $email
 * @property string $phone
 * @property string $fax
 * @property string $npwp
 * @property integer $coa_id
 *
 * The followings are the available model relations:
 * @property Province $province
 * @property City $city
 * @property Coa $coa
 * @property InsuranceCompanyPricelist[] $insuranceCompanyPricelists
 */
class InsuranceCompany extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return InsuranceCompany the static model class
     */
    public $province_name;
    public $city_name;
    public $coa_name;
    public $coa_code;

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{insurance_company}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('name, address, province_id, city_id, email, phone, fax, npwp', 'required'),
            array('province_id, city_id, coa_id', 'numerical', 'integerOnly' => true),
            array('name', 'length', 'max' => 30),
            array('email', 'length', 'max' => 50),
            array('phone, fax, npwp', 'length', 'max' => 20),
            // The following rule is used by search().
            // Please remove those attributes that should not be searched.
            array('id, name, address, province_id, city_id, email, phone, fax, npwp,province_name,city_name,is_deleted, coa_id, coa_name, coa_code', 'safe', 'on' => 'search'),
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
            'province' => array(self::BELONGS_TO, 'Province', 'province_id'),
            'city' => array(self::BELONGS_TO, 'City', 'city_id'),
            'insuranceCompanyPricelists' => array(self::HAS_MANY, 'InsuranceCompanyPricelist', 'insurance_company_id'),
            'coa' => array(self::BELONGS_TO, 'Coa', 'coa_id'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'id' => 'ID',
            'name' => 'Name',
            'address' => 'Address',
            'province_id' => 'Province',
            'city_id' => 'City',
            'email' => 'Email',
            'phone' => 'Phone',
            'fax' => 'Fax',
            'npwp' => 'Npwp',
            'coa_id' => 'Coa',
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

        $criteria->compare('id', $this->id);
        $criteria->compare('t.name', $this->name, true);
        $criteria->compare('t.address', $this->address, true);
        $criteria->compare('province_id', $this->province_id);
        $criteria->compare('city_id', $this->city_id);
        $criteria->compare('email', $this->email, true);
        $criteria->compare('phone', $this->phone, true);
        $criteria->compare('fax', $this->fax, true);
        $criteria->compare('npwp', $this->npwp, true);
        $criteria->compare('coa_id', $this->coa_id);
        $tampilkan = ($this->is_deleted == 1) ? array(0, 1) : array(0);
        $criteria->addInCondition('t.is_deleted', $tampilkan);

        // $criteria->together = 'true';
        // $criteria->with = array('province','city');
        // $criteria->compare('province.name', $this->province_name == NULL ? $this->province_name : $this->province_name.'%', true,'AND', false);
        // $criteria->compare('city.name', $this->city_name == NULL ? $this->city_name : $this->city_name.'%', true,'AND', false);

        $criteria->together = 'true';
        $criteria->with = array('province', 'city', 'coa');
        $criteria->compare('province.name', $this->province_name, true);
        $criteria->compare('city.name', $this->city_name, true);
        $criteria->compare('coa.name', $this->coa_name, true);
        $criteria->compare('coa.code', $this->coa_code, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
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
                'pageSize' => 50,
            ),
        ));
    }

    function getLevel($data, $row) {
        $color = '';
        if ($data->color_id) {
            $colors = Colors::model()->findByPk($data->color_id);
            if ($colors['name'])
                $color = $colors['name'];
        }
        return $color;
    }
    
    public function searchByReceivableReport($endDate, $branchId, $plateNumber) {
        $branchConditionSql = '';
        $plateNumberConditionSql = '';
        
        $criteria = new CDbCriteria;
        $criteria->compare('t.id', $this->id);
        $criteria->params = array(
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.branch_id = :branch_id';
            $criteria->params[':branch_id'] = $branchId;
        }
        
        if (!empty($plateNumber)) {
            $plateNumberConditionSql = ' AND v.plate_number LIKE :plate_number';
            $criteria->params[':plate_number'] = "%{$plateNumber}%";
        }

        $criteria->addCondition("EXISTS (
            SELECT r.insurance_company_id
            FROM " . RegistrationTransaction::model()->tableName() . " r 
            INNER JOIN " . InvoiceHeader::model()->tableName() . " i ON r.id = i.registration_transaction_id
            INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = r.vehicle_id
            WHERE r.insurance_company_id = t.id AND r.insurance_company_id IS NOT NULL AND i.payment_left > 100.00 AND i.invoice_date <= :end_date " . $branchConditionSql . $plateNumberConditionSql . " 
        )");

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    public function getReceivableReport($endDate, $branchId, $plateNumber) {
        $branchConditionSql = '';
        $plateNumberConditionSql = '';
        
        $params = array(
            ':insurance_company_id' => $this->id,
            ':end_date' => $endDate,
        );
        
        if (!empty($branchId)) {
            $branchConditionSql = ' AND i.branch_id = :branch_id';
            $params[':branch_id'] = $branchId;
        }
        
        if (!empty($plateNumber)) {
            $plateNumberConditionSql = ' AND v.plate_number LIKE :plate_number';
            $params[':plate_number'] = "%{$plateNumber}%";
        }
        
        $sql = "
            SELECT i.invoice_number, i.invoice_date, due_date, v.plate_number AS vehicle, COALESCE(i.total_price, 0) AS total_price, COALESCE(i.payment_amount, 0) AS payment_amount, COALESCE(i.payment_left, 0) AS payment_left, c.name as customer_name 
            FROM " . RegistrationTransaction::model()->tableName() . " r
            INNER JOIN " . InvoiceHeader::model()->tableName() . " i ON r.id = i.registration_transaction_id
            INNER JOIN " . Customer::model()->tableName() . " c ON c.id = i.customer_id
            INNER JOIN " . Vehicle::model()->tableName() . " v ON v.id = i.vehicle_id
            WHERE r.insurance_company_id = :insurance_company_id AND r.insurance_company_id IS NOT NULL AND i.payment_left > 100.00 AND i.invoice_date <= :end_date 
        " . $branchConditionSql . $plateNumberConditionSql;

        $resultSet = Yii::app()->db->createCommand($sql)->queryAll(true, $params);

        return $resultSet;
    }
}
