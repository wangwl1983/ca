<?php

/**
 * This is the model class for table "{{price}}".
 *
 * The followings are the available columns in table '{{price}}':
 * @property integer $price_id
 * @property string $price_record_type
 * @property string $price_region_id
 * @property integer $price_value
 */
class Price extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return '{{price}}';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('price_record_type, price_region_id, price_value', 'required'),
			array('price_value', 'numerical', 'integerOnly'=>true),
			array('price_record_type, price_region_id', 'length', 'max'=>45),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('price_id, price_record_type, price_region_id, price_value', 'safe', 'on'=>'search'),
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
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'price_id' => 'Price',
			'price_record_type' => 'Price Record Type',
			'price_region_id' => 'Price Region',
			'price_value' => 'Price Value',
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

		$criteria->compare('price_id',$this->price_id);
		$criteria->compare('price_record_type',$this->price_record_type,true);
		$criteria->compare('price_region_id',$this->price_region_id,true);
		$criteria->compare('price_value',$this->price_value);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Price the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
