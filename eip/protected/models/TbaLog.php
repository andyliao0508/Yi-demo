<?php

/**
 * This is the model class for table "tba_log".
 *
 * The followings are the available columns in table 'tba_log':
 * @property string $id
 * @property string $logday
 * @property string $storecode
 * @property string $storename
 * @property string $empno
 * @property string $empname
 * @property string $logtype
 * @property string $logitem
 * @property string $logname
 * @property string $num
 * @property string $batchnum
 * @property string $leavecheck
 * @property string $leavefile
 * @property string $provecheck
 * @property string $provefile
 * @property string $classcheck
 * @property string $classfile
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
class TbaLog extends CActiveRecord
{
    public $batchnum ;
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tba_log';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('storecode, empno, logday, logitem,num', 'required'),
                                                         array('storecode', 'length', 'max'=>6),
			array('empno, cemp, uemp', 'length', 'max'=>8),
			array('empname', 'length', 'max'=>64),
			array('logtype, logitem', 'length', 'max'=>2),
			array('storename,logname', 'length', 'max'=>20),
			array('num,batchnum', 'length', 'max'=>4),
			array('leavecheck, provecheck, classcheck, opt1, opt2, opt3', 'length', 'max'=>1),
			array('leavefile, provefile, classfile, memo', 'length', 'max'=>255),
                                                         
			array('ip', 'length', 'max'=>15),
			array('ctime, utime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, logday, storecode, storename, empno, empname, logtype, logitem, logname, num, 
                                                                    batchnum, leavecheck, leavefile, provecheck, provefile, classcheck, classfile, memo, 
                                                                    opt1, opt2, opt3, cemp, uemp, ctime, utime, ip', 'safe', 'on'=>'search'),
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
			'id' => 'id',
			'logday' => '日期',
			'storecode' => '門市編號',
			'storename' => '門市名稱',
			'empno' => '員工編號',
			'empname' => '員工姓名',
			'logtype' => '差勤類別',
			'logitem' => '差勤項目',
			'logname' => '項目名稱',
			'num' => '數量',
                    		'batchnum' => '多天數量',
			'leavecheck' => '請假單',
			'leavefile' => '請假單據',
			'provecheck' => '證明',
			'provefile' => '證明單據',
			'classcheck' => '輪值',
			'classfile' => '輪值單據',
			'memo' => '備註',
			'opt1' => '是否使用',
			'opt2' => '遲到',
			'opt3' => '不換算',
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

            $criteria->compare('id',$this->id,true);
            //$criteria->compare('logday',$this->logday,true);
            // with the new mergeWith line...，為了 admin Advanced Search 而使用
            $criteria->mergeWith($this->dateRangeSearchCriteria('logday', $this->logday));  
            $criteria->compare('storecode',$this->storecode,true);
            $criteria->compare('storename',$this->storename,true);
            $criteria->compare('empno',$this->empno,true);
            $criteria->compare('empname',$this->empname,true);
            $criteria->compare('logtype',$this->logtype,true);
            $criteria->compare('logitem',$this->logitem,true);
            $criteria->compare('logname',$this->logname,true);
            $criteria->compare('num',$this->num,true);
            $criteria->compare('leavecheck',$this->leavecheck,true);
            $criteria->compare('leavefile',$this->leavefile,true);
            $criteria->compare('provecheck',$this->provecheck,true);
            $criteria->compare('provefile',$this->provefile,true);
            $criteria->compare('classcheck',$this->classcheck,true);
            $criteria->compare('classfile',$this->classfile,true);
            $criteria->compare('memo',$this->memo,true);
            $criteria->compare('opt1',$this->opt1,true);
            $criteria->compare('opt2',$this->opt2,true);
            $criteria->compare('opt3',$this->opt3,true);
            $criteria->compare('cemp',$this->cemp,true);
            $criteria->compare('uemp',$this->uemp,true);
            $criteria->compare('ctime',$this->ctime,true);
            $criteria->compare('utime',$this->utime,true);
            $criteria->compare('ip',$this->ip,true);

            return new CActiveDataProvider($this, array(
                    'criteria'=>$criteria,
                    'sort' => array(
                                        'defaultOrder' => 't.logday DESC',
                                    ),                
                    'pagination'=>array('pageSize'=>100),
            ));
    }
        
   /**
    * Model behaviors ， 呼叫目錄components\behaviors\EDateRangeSearchBehavior.php ，為了 admin Advanced Search 日期範圍 而使用
    */
    public function behaviors()
    {
        return array(
            'dateRangeSearch'=>array(
                'class'=>'application.components.behaviors.EDateRangeSearchBehavior',
            ),
        );
    }
        
    public static function model($className=__CLASS__)
    {
            return parent::model($className);
    }
}
