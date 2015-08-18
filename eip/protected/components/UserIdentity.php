<?php

/**
 * UserIdentity represents the data needed to identity a user.
 * It contains the authentication method that checks if the provided
 * data can identity the user.
 */
class UserIdentity extends CUserIdentity
{
    /**
     * 員工編號
     * @var type 
     */
    private $_id;
    
    /**
     * 暱稱
     * @var type 
     */
    private $_username;    
    
    /**
     * Authenticates a user.
     * The example implementation makes sure if the username and password
     * are both 'demo'.
     * In practical applications, this should be changed to authenticate
     * against some persistent user identity storage (e.g. database).
     * @return boolean whether authentication succeeds.
     */
    public function authenticate()
    {
        // 查詢此員工資料
        $user = User::model()->findByAttributes(array(
            'empno' => $this->username,
        ));            
        
        // 若員工不存在
        if($user===null)
            $this->errorCode=self::ERROR_USERNAME_INVALID;
        // 若此帳號已停用
        else if($user->opt1=='0'){
            // 判斷是否是因為密碼錯太多
            if($user->opt3 >= 6)
                $this->errorCode=self::ERROR_PASSWORD_ERROR_TO_MUCH;
            else
                $this->errorCode=  self::ERROR_USER_UNAVAILABLE;
        }
        // 判斷是否為第一次登入, 並做密碼比對
        else if ( $user->check($this->password) ) 
        {
            $this->_id = $user->empno;
            $this->_username = $user->username;
            $this->errorCode=self::ERROR_NONE;
            $user->opt3 = 0; // 登入成功後, 密碼錯誤次數歸0
            $user->saveAttributes(array('opt3'));
        }
        else{
            // 密碼最多只能錯6次! 超過6次, 此帳號即停用!
            $user->opt3 = $user->opt3 + 1;
            if($user->opt3 >= 6){
                $user->opt1 = '0';
                $user->memo = '此帳號因輸入密碼錯誤超過6次已停用!';
            }
            $user->saveAttributes(array('opt1','opt3')); // 用以紀錄錯誤次數
            
            $this->errorCode=self::ERROR_PASSWORD_INVALID;
        }
        return !$this->errorCode;        
    }
    
//    /**
//     * 檢查是否第一次登入, 如果是的話, 則判斷密碼是否為員編, 若不是第一次登入則以HASH過的密碼作判斷
//     * @param type $user
//     * @return type boolean
//     */
//    private function checkFirstTime($user)
//    {
//        $check = TRUE;
//        
//        if($user->opt2 == NULL){
//            if( $user->pwd_hash != $this->password ) $check = FALSE;
//        }
//        else
//            $check = $user->check($this->password);
//        
//        return $check;
//    }
    
    /**
     * 用以回傳名稱
     * @return type
     */
    public function getName()
    {
        return $this->_username;
    }

    /**
     * 用以回傳員工編號
     * @return type
     */
    public function getId()
    {
        return $this->_id;
    }    
}