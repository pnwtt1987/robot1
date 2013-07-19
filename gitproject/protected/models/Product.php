<?php

/**
 * This is the model class for table "product".
 *
 * The followings are the available columns in table 'product':
 * @property integer $product_id
 * @property integer $category_id
 * @property string $product_code
 * @property string $product_name
 * @property integer $product_amount
 * @property double $product_price
 * @property string $product_detail
 * @property string $product_image
 * @property string $product_create
 * @property string $product_update
 */
class Product extends CActiveRecord implements IECartPosition {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Product the static model class
     */
    public $product_old_image;
    public $category_name;

    public static function model($className=__CLASS__) {
        return parent::model($className);
    }

    public  function getId() {
        return $this->product_id;
    }

    public  function getPrice() {
        return $this->product_price;
    }

    public  function getName() {
        return $this->product_name;
    }
    public  function getCode() {
        return $this->product_code;
    }
    /*public  function getQuantity() {
        return $this->product_amount;
    }*/

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'product';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.

        return array(
            array('product_name, product_code,product_amount,product_price', 'required'),
            array('product_amount', 'numerical', 'integerOnly' => true),
            array('product_price', 'numerical'),
            array('category_id,product_detail, product_create, product_update,product_old_image', 'safe'),
            array('product_image', 'required', 'on' => 'insert'),
            array('product_image', 'file', 'types' => 'jpg, gif, png', 'on' => 'insert'),
            array('product_image', 'file', 'types' => 'jpg, gif, png', 'allowEmpty' => true, 'on' => 'update'),
            array('product_code, product_name,category_name', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
            'category' => array(self::BELONGS_TO, 'Category', 'category_id')
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'product_id' => 'Product',
            'category_id' => 'หมวดสินค้า',
            'category_name' => 'ชื่อหมวดสินค้า',
            'product_code' => 'รหัสสินค้า',
            'product_name' => 'ชื่อสินค้า',
            'product_amount' => 'จำนวน',
            'product_price' => 'ราคา',
            'product_detail' => 'รายละเอียด',
            'product_image' => 'รูปสินค้า',
            'product_create' => 'Product Create',
            'product_update' => 'Product Update',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria;
        // $criteria->together = true;
        $criteria->with = array('category');
        $criteria->select = "product_id,product_code,product_name,product_amount,product_price,product_image,t.category_id,category.category_name As category_name";
        $criteria->compare('product_id', $this->product_id);
        $criteria->compare('category_id', $this->category_id);
        $criteria->compare('category_name', $this->category_name);
        $criteria->compare('product_code', $this->product_code, true);
        $criteria->compare('product_name', $this->product_name, true);
        $criteria->compare('product_amount', $this->product_amount);
        $criteria->compare('product_price', $this->product_price);
//$product=Product::model()->find($criteria);
        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

}