<?php

/**
 * 基础控制器
 */

namespace app\base\controller;

class BaseController extends \framework\base\Controller {

	/**
	 * 初始化
	 */
	public function __construct() {
	   session_start();
	}

    public function display($tpl = '', $return = false, $isTpl = true ){
        if( $isTpl ){
            if( empty($tpl) ){
                $tpl = 'app/'.APP_NAME . '/view/' . strtolower(ACTION_NAME);
            }
            if( $this->layout ){
                $this->__template_file = $tpl;
                $tpl = $this->layout;
            }
        }
        $this->_getView()->assign( get_object_vars($this));
        return $this->_getView()->display($tpl, $return, $isTpl);
    }

    public function msgApi($code, $mssage, $data=NULL){
        $msg = array(
            'code' => $code,
            'message' => $mssage,
            'data' => json_encode($data)
        );
        return json_encode($msg);
    }
}