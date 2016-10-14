<?php

// index.php?r=main/api/***
namespace app\main\controller;

class ApiController extends \app\base\controller\BaseController {

    public function __construct() {
        parent::__construct();
    }

    /**
     * 创建新用户GUID
     * @return [type] [description]
     */
    public function apiCteateNewUser(){
        echo obj('User')->cteateNewUser();
    }

    /**
     * 查找数据库GUID是否存在,判断用户是否注册
     * @return [type] [description]
     */
    public function apiGetUserByGuID(){
        $GuID = trim($this->arg('guid'));
        $data = obj('User')->findByUserGuID($GuID);
        echo $data ? $this->msgApi(1, 'GUID', $data) : $this->msgApi(-1, 'NOT FIND GUID', $data);
    }


    /**
     * 提交用户信息
     * @return [type] [description]
     */
    public function apiOnSubmit() {
        $_guid = trim($this->arg('guid'));
        $_username = trim($this->arg('username'));
        $_telephone = trim($this->arg('telephone'));
        echo obj('User')->submitSuccessSeckillByUserInfo($_guid, $_username, $_telephone);
    }

    /**
     * 提取奖品
     * @return [type] [description]
     */
    public function apiGetSeckill() {

        //1、判断用户是否已有中奖日志 （已中过奖，后面都默认未中奖）
        //2、判断用户抽奖机会 是否为0 （为0，不用查询数据库，直接返回机会已用完）
        $GuID = trim($this->arg('guid'));
        $oppor = obj('User')->findByUserGuID( $GuID )['oppor'];
        $logs = obj('User')->verifySeckillByUserLog( $GuID );

        //没有次数
        if($oppor == 0) {echo $this->msgApi(-1, '您没有抽奖机会了!');exit;}

        //剩余次数
        $opporBlack = $oppor - 1;
        //已中奖过，将不会再中奖
        if ($logs > 0) {
            $this->opporMsg($opporBlack);
            obj('User')->updateSorryUserOpporMinus( $GuID );
            exit;
        }
        //概率
        $gl = $this->GaiLv();
        if($gl >= 10 && $gl <= 50) {
            $data = obj('Seckill')->updateBySeckillStock( $GuID );
            echo $data ? $this->msgApi(1, "恭喜您获得{$data[0]['prize_name']}", $data[0]) 
            : $this->opporMsg($opporBlack, 'NOT PRIZE'); //没奖品了

        }else{
            obj('User')->updateSorryUserOpporMinus( $GuID );
            $this->opporMsg($opporBlack, $gl);
        }
    }

    /**
     * 没中奖消息
     * @param  integer $opporBlack [剩余次数]
     * @param  [type]  $gl     [随机数]
     * @return [type]          [description]
     */
    public function opporMsg($opporBlack=0, $gl=NULL){
        echo $opporBlack == 0 ? $this->msgApi(0, "很遗憾，您没有中奖!", $gl)
        : $this->msgApi(0, "很遗憾，您还有{$opporBlack}次挖宝机会!", $gl);
    }

    /**
     * 简单概率算法
     */
    public function GaiLv(){
        return mt_rand(1, 200);
    }

    /**
     * 判断用户是否提交信息
     * @return [type] [description]
     */
    public function apiGetSubmitStatus(){
        $GuID = trim($this->arg('guid'));
        $submitStatus = obj('User')->getSubmitStatusByUser( $GuID );
        echo $submitStatus['submit'];
    }
    /**
     * 更新用户领奖状态
     * @return [type] [description]
     */
    public function apiUpdateUserByAccept(){
        $GuID = trim($this->arg('guid'));
        if($_POST['code'] && $_POST['code'] == '123') {
            echo obj('User')->updateUserByAccept( $GuID ) ? $this->msgApi(1, "验证成功!") 
            : $this->msgApi(0, "验证失败!");
        }else{
            echo $this->msgApi(0, "验证码错误!");
        }
    }

    /**
     * 查询用户中奖信息
     * @return [type] [description]
     */
    public function apiViewUserByPrizes() {
        $GuID = trim($this->arg('guid'));
        $data = obj('User')->viewUserByPrizes($GuID);
        echo $data ? $this->msgApi(1, "success", $data[0]) : $this->msgApi(0, "没有中奖记录");
    }
}