<?php

class Findproduct extends Product
{
    public $findkeyword;

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            // @todo Please remove those attributes that should not be searched.
            array('code, manufacturer_code, barcode, name, description, extension, findkeyword, product_master_category_code, product_master_category_name, product_sub_master_category_code, product_sub_master_category_name, product_sub_category_code, product_sub_category_name', 'safe', 'on'=>'search'),
        );
    }

    public function relations()
    {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'productMasterCategory' => array(self::BELONGS_TO, 'ProductMasterCategory', 'product_master_category_id'),
            'productSubMasterCategory' => array(self::BELONGS_TO, 'ProductSubMasterCategory', 'product_sub_master_category_id'),
            'productSubCategory' => array(self::BELONGS_TO, 'ProductSubCategory', 'product_sub_category_id'),
            'brand' => array(self::BELONGS_TO, 'Brand', 'brand_id'),
        );
    }
    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
        return array(
            'code' => 'Code',
            'manufacturer_code' => 'Manufacturer Code',
            'barcode' => 'Barcode',
            'name' => 'Name',
            'description' => 'Description',
            'extension' => 'Extension',
            'findkeyword'=>'Find By Keyword', 
        );
    }

    public function searchKeyword()
    {
        // @todo Please modify the following code to remove attributes that should not be searched.
        $criteria=new CDbCriteria;
 
        $explodeKeyword = explode(" ", $this->findkeyword);

        foreach ($explodeKeyword as $key) {
            $criteria->compare('t.code',$key,true,'OR');
            $criteria->compare('manufacturer_code',$key,true,'OR');
            $criteria->compare('barcode',$key,true,'OR');
            $criteria->compare('t.name',$key,true,'OR');
            $criteria->compare('t.description',$key,true,'OR');
            $criteria->compare('extension',$key, true, 'OR');

            $criteria->together=true;
            $criteria->with = array('productSubMasterCategory','productMasterCategory','productSubCategory');
            $criteria->compare('productMasterCategory.code',$key,true,'OR');
            $criteria->compare('productMasterCategory.name',$key,true,'OR');
            $criteria->compare('productSubMasterCategory.code',$key,true,'OR');
            $criteria->compare('productSubMasterCategory.name',$key,true,'OR');
            // $criteria->compare('productSubCategory.code',$key,true,'OR');
            // $criteria->compare('productSubCategory.name',$key,true,'OR');
        }
        // $criteria->with = array('productSubMasterCategory','productMasterCategory');
        // $criteria->compare('t.code',$this->findkeyword,true,'OR');
        // $criteria->compare('manufacturer_code',$this->findkeyword,true,'OR');
        // $criteria->compare('barcode',$this->findkeyword,true,'OR');
        // $criteria->compare('t.name',$this->findkeyword,true,'OR');
        // $criteria->compare('t.description',$this->findkeyword,true,'OR');
        // $criteria->compare('extension',$this->findkeyword, true, 'OR');


        return new CActiveDataProvider($this, array(
            'criteria'=>$criteria,
        ));
    }
}
