<?php

/**
 * This is the model class for table "tba_board".
 *
 * The followings are the available columns in table 'tba_board':
 * @property string $id
 * @property string $title
 * @property string $content
 * @property string $imagename
 * @property string $imageurl
 * @property string $imagetype
 * @property string $boarddepart
 * @property string $type
 * @property string $priority
 * @property string $depart
 * @property string $area
 * @property string $store
 * @property string $dates
 * @property string $datee
 * @property string $opt1
 * @property string $opt2
 * @property string $opt3
 * @property string $cemp
 * @property string $ctime
 * @property string $uemp
 * @property string $utime
 * @property string $ip
 */
class TbaBoard extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'tba_board';
	}
        
        public $image;

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('title, content', 'required'),
			array('title, content, imagename, imageurl, imagetype', 'length', 'max'=>255),
			array('boarddepart, type, priority, depart, area', 'length', 'max'=>2),
			array('store', 'length', 'max'=>6),
			array('opt1, opt2, opt3', 'length', 'max'=>1),
			array('cemp, uemp', 'length', 'max'=>8),
			array('ip', 'length', 'max'=>15),
                        array('image', 'file', 'types'=>'jpg, gif, png','maxSize'=>1024 * 1024,'allowEmpty' => true,'on'=>'update'),//upload rules
                     
                        /*array('image', 'file','on'=>'upload',
                            'allowEmpty' => true,
                                        'types'=>'jpg, gif, png',
                                        'maxSize' => 1024 * 1024 * 10, // 10MB                
                                        'tooLarge' => 'The file was larger than 10MB. Please upload a smaller file.',                
                                    ),*/
			array('dates, datee, ctime, utime', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, title, content,imagename, imageurl, imagetype , boarddepart, type, priority, depart, area, store, dates, datee, opt1, opt2, opt3, cemp, ctime, uemp, utime, ip', 'safe', 'on'=>'search'),
                        
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
			'title' => '標題',
			'content' => '內容',
                        'imagename'=>'圖片名稱',
                        'imageurl'=>'圖片網址',
                        'imagetype'=>'圖片類型',
                        'boarddepart'=>  '公告部門',
			'type' => '公告類別',
			'priority' => '優先權',
			'depart' => '部門',
			'area' => '區位',
			'store' => '門市',
			'dates' => '日期開始',
			'datee' => '日期結束',
			'opt1' => '是否使用',
			'opt2' => '公告送入跑馬燈',
			'opt3' => '首頁圖片',
			'cemp' => '建立人員',
			'ctime' => '建立時間',
			'uemp' => '修改人員',
			'utime' => '修改時間',
			'ip' => '異動IP',
                        'image'=>'上傳檔案',
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
		$criteria->compare('title',$this->title,true);
		$criteria->compare('content',$this->content,true);
                $criteria->compare('imagename',$this->imagename,true);
                $criteria->compare('imageurl',$this->imageurl,true);
                $criteria->compare('imagetype',$this->imagetype,true);
		$criteria->compare('boarddepart',$this->boarddepart,true);
		$criteria->compare('type',$this->type,true);
		$criteria->compare('priority',$this->priority,true);
		$criteria->compare('depart',$this->depart,true);
		$criteria->compare('area',$this->area,true);
		$criteria->compare('store',$this->store,true);
		$criteria->compare('dates',$this->dates,true);
		$criteria->compare('datee',$this->datee,true);
		$criteria->compare('opt1',$this->opt1,true);
		$criteria->compare('opt2',$this->opt2,true);
		$criteria->compare('opt3',$this->opt3,true);
		$criteria->compare('cemp',$this->cemp,true);
		$criteria->compare('ctime',$this->ctime,true);
		$criteria->compare('uemp',$this->uemp,true);
		$criteria->compare('utime',$this->utime,true);
		$criteria->compare('ip',$this->ip,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return TbaBoard the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
        
        
}
