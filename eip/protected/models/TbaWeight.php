<?php

/**
 * This is the model class for table "tba_weight".
 *
 * The followings are the available columns in table 'tba_weight':
 * @property string $id
 * @property string $logitem
 * @property string $logname
 * @property string $nweight
 * @property string $hweight
 * @property string $memo
 * @property string $opt1
 * @property string $opt2
 * @property string $opt3
 * @property string $cemp
 * @property string $uemp
 * @property string $ctime
 * @property string $utime
 * @property string $ip
 */
class TbaWeight extends CActiveRecord
{
    public $logname;
    
    /**
     * @return string the associated database table name
     */
    public function tableName()
    {
            return 'tba_weight';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules()
    {
            // NOTE: you should only define rules for those attributes that
            // will receive user inputs.
            return array(
                    array('nweight, hweight', 'required'),
                    array('logitem', 'length', 'max'=>2),
                    array('nweight, hweight', 'length', 'max'=>3),
                    array('memo', 'length', 'max'=>255),
                    array('opt1, opt2, opt3', 'length', 'max'=>1),
                    array('cemp, uemp', 'length', 'max'=>8),
                    array('ip', 'length', 'max'=>15),
                    array('ctime, utime', 'safe'),
                    // The following rule is used by search().
                    // @todo Please remove those attributes that should not be searched.
                    array('id, logitem, nweight, hweight, memo, opt1, opt2, opt3, cemp, uemp, ctime, utime, ip', 'safe', 'on'=>'search'),
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
                // 取得員工資料
                'log' => array(self::BELONGS_TO, 'TbaLogItem', 'logitem'),
            );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels()
    {
            return array(
                    'id' => 'id',
                    'logitem' => '差勤項目',
                    'logname' => '項目名稱',
                    'nweight' => '平日權重',
                    'hweight' => '假日權重',
                    'memo' => '備註',
                    'opt1' => '是否使用',
                    'opt2' => '遲到',
                    'opt3' => '備用3',
                    'cemp' => '建立人員',
                    'uemp' => '修改人員',
                    'ctime' => '建立時間',
                    'utime' => '修改時間',
                    'ip' => '異動IP',
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

            $criteria->compare('t.id',$this->id,true);
            $criteria->compare('t.logitem',$this->logitem,true);
            $criteria->compare('log.logname',$this->logname,true);
            $criteria->compare('t.nweight',$this->nweight,true);
            $criteria->compare('t.hweight',$this->hweight,true);
            $criteria->compare('t.memo',$this->memo,true);
            $criteria->compare('t.opt1',$this->opt1,true);
            $criteria->compare('t.opt2',$this->opt2,true);
            $criteria->compare('t.opt3',$this->opt3,true);
            $criteria->compare('t.cemp',$this->cemp,true);
            $criteria->compare('t.uemp',$this->uemp,true);
            $criteria->compare('t.ctime',$this->ctime,true);
            $criteria->compare('t.utime',$this->utime,true);
            $criteria->compare('t.ip',$this->ip,true);

            $criteria->with = array('log');
            
            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
            ));
    }

    /**
     * Returns the static model of the specified AR class.
     * Please note that you should have this exact method in all your CActiveRecord descendants!
     * @param string $className active record class name.
     * @return TbaWeight the static model class
     */
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
