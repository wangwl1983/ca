<?php

/**
 * This is the model class for table "{{unit}}".
 *
 * The followings are the available columns in table '{{unit}}':
 * @property integer $unit_id
 * @property string $unit_name
 * @property string $unit_paper_no
 * @property string $unit_tax_no
 * @property string $unit_region
 * @property string $unit_contact_id
 */
class Unit extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return '{{unit}}';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        // NOTE: you should only define rules for those attributes that
        // will receive user inputs.
        return array(
            array('unit_name, unit_paper_no, unit_region', 'required'),
            array('unit_name', 'length', 'max' => 128),
            array('unit_paper_no', 'length', 'max' => 10),
            array('unit_tax_no', 'length', 'max' => 25),
            array('unit_region', 'length', 'max' => 24),
            array('unit_contact_id', 'length', 'max' => 45),
            // The following rule is used by search().
            // @todo Please remove those attributes that should not be searched.
            array('unit_id, unit_name, unit_paper_no, unit_tax_no, unit_region, unit_contact_id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array relational rules.
     */
    public function relations() {
        // NOTE: you may need to adjust the relation name and the related
        // class name for the relations automatically generated below.
        return array(
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'unit_id' => 'Unit',
            'unit_name' => 'Unit Name',
            'unit_paper_no' => 'Unit Paper No',
            'unit_tax_no' => 'Unit Tax No',
            'unit_region' => 'Unit Region',
            'unit_contact_id' => 'Unit Contact',
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
    public function search() {
        // @todo Please modify the following code to remove attributes that should not be searched.

        $criteria = new CDbCriteria;

        $criteria->compare('unit_id', $this->unit_id);
        $criteria->compare('unit_name', $this->unit_name, true);
        $criteria->compare('unit_paper_no', $this->unit_paper_no, true);
        $criteria->compare('unit_tax_no', $this->unit_tax_no, true);
        $criteria->compare('unit_region', $this->unit_region, true);
        $criteria->compare('unit_contact_id', $this->unit_contact_id, true);

        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return Unit the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
