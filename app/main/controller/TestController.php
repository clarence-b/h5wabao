<?php

/**
 * 服务器压力测试接口
 */
namespace app\main\controller;

class TestController extends \app\base\controller\BaseController {

    public function __construct() {
        parent::__construct();
    }

    //index.php?r=main/test/run
    public function run(){
        $guid = obj('User')->cteateNewUser();
        $url = 'http://localhost:8080'.ROOT_URL.'index.php?r=main/api/apiGetSeckill&guid='.$guid;
        file_get_contents($url);
        echo "This is GET Request Success!";
    }
}