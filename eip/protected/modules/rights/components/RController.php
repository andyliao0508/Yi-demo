<?php
/**
* Rights base controller class file.
*
* @author Christoffer Niska <cniska@live.com>
* @copyright Copyright &copy; 2010 Christoffer Niska
* @since 0.6
*/
class RController extends CController
{
    /**
    * @property string the default layout for the controller view. Defaults to '//layouts/column1',
    * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
    */
    public $layout='//layouts/column1';
    /**
    * @property array context menu items. This property will be assigned to {@link CMenu::items}.
    */
    public $menu=array();
    /**
    * @property array the breadcrumbs of the current page. The value of this property will
    * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
    * for more details on how to specify this property.
    */
    public $breadcrumbs=array();
    
    /**
     * 門市IP
     * @var type 
     */
    public $myip = '';
    
    /**
    * The filter method for 'rights' access filter.
    * This filter is a wrapper of {@link CAccessControlFilter}.
    * @param CFilterChain $filterChain the filter chain that the filter is on.
    */
    public function filterRights($filterChain)
    {
        $filter = new RightsFilter;
        $filter->allowedActions = $this->allowedActions();
        $filter->filter($filterChain);
    }

    /**
    * @return string the actions that are always allowed separated by commas.
    */
    public function allowedActions()
    {
        return '';
    }

    /**
    * Denies the access of the user.
    * @param string $message the message to display to the user.
    * This method may be invoked when access check fails.
    * @throws CHttpException when called unless login is required.
    */
    public function accessDenied($message=null)
    {
        if( $message===null )
                $message = Rights::t('core', 'You are not authorized to perform this action.');

        $user = Yii::app()->getUser();
        if( $user->isGuest===true )
                $user->loginRequired();
        else
                throw new CHttpException(403, $message);
    }

    /**
     * 用以設定建立資料的人員及時間
     * @param type $model
     */
    protected function createData($model){

        $model->ctime =  date("Y-m-d H:i:s", time());
        $model->cemp = Yii::app()->user->getId();                        
        $model->ip = $this->getMyip();
    }

    /**
     * 用以設定修改資料的人員及時間
     * @param type $model
     */
    protected function updateData($model){

        $model->utime =  date("Y-m-d H:i:s", time());
        $model->uemp = Yii::app()->user->getId();                        
        $model->ip = $this->getMyip();
    }
    
    /**
     * 取得IP
     * @return type
     */
    protected function getMyip(){
        
        $myip = '';
        if (empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {  
            $myip = $_SERVER['REMOTE_ADDR'];  
        } else {  
            $myip = explode(',', $_SERVER['HTTP_X_FORWARDED_FOR']);  
            $myip = $myip[0];  
        }
        return $myip;
    }
    
    /**
     * 取得目前時間
     * @param type $model
     */
    protected function getCurrentTime(){

        return  date("Y-m-d H:i:s", time());
    }
 
}
