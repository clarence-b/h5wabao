<?php

namespace app\main\model;

class UserModel extends \app\base\model\BaseModel {

    /**
     * 第一次进入游戏绑定注册用户信息
     * @param  [type] $json [description]
     * @return [type]       [description]
     */
    public function cteateNewUser(){
        $GuID = \framework\ext\Util::createGuID();
        $data['user_guid'] = $GuID;
        $data['created_at'] = time();

        $this->beginTransaction();
        try {
            !count($this->findByUserGuID($GuID)) && $this->table('users')->data($data)->insert();
        } catch (Exception $e) {
            $this->rollBack();
        }
        $this->commit();
        $_SESSION['GuID'] = $GuID;
        return $GuID;
    }
    /**
     * 判断用户是否注册
     * @param  [type] $GuID [description]
     * @return [type]         [description]
     */
    public function findByUserGuID($GuID){
        return $this->table('users')->field('oppor')->where(array('user_guid'=>$GuID))->find();
    }

    /**
     * 验证用户是否已有中奖日志
     * @param  [type] $openid [description]
     * @return [type]         [返回: true: 已中奖过，false:没有记录]
     */
    public function verifySeckillByUserLog($GuID){
        return $this->table('logs')->where(array('user_guid'=>$GuID))->count();
    }

    /**
     * 【未中奖】抽奖机会-1,不动奖品库存
     * @return [type] [description]
     */
    public function updateSorryUserOpporMinus($GuID){
        $sql = "UPDATE {pre}users SET `oppor`=`oppor` - 1 , `gets`=`gets` + 1 WHERE `user_guid`='{$GuID}'";
        return $this->execute($sql);
    }

    /**
     * 提交用户信息(中奖后调用)
     * @param  [type] $GuID    [description]
     * @param  [type] $username  [description]
     * @param  [type] $telephone [description]
     * @return [type]            [description]
     */
    public function submitSuccessSeckillByUserInfo($GuID, $username, $telephone){
        $data['username'] = $username;
        $data['telephone'] = $telephone;
        $data['submit'] = 1;
        return $this->table('users')->data($data)->where(array('user_guid'=>$GuID))->update();
    }

    /**
     * 获取用户提交状态
     * @param  [type] $GuID [description]
     * @return [type]       [description]
     */
    public function getSubmitStatusByUser($GuID){
        return $this->table('users')->field('submit')->where(array('user_guid'=>$GuID))->find();
    }
    /**
     * 更新用户领奖状态
     * @param  [type] $GuID [description]
     * @return [type]         [description]
     */
    public function updateUserByAccept($GuID){
        $data['accept'] = 1;
        return $this->table('logs')->data($data)->where(array('user_guid'=>$GuID))->update();
    }

    /**
     * 查询用户中奖信息
     * @param  [type] $GuID [description]
     * @return [type]         [description]
     */
    public function viewUserByPrizes($GuID){
        return $this->table('logs')->where(array('user_guid'=>$GuID))->select();
    }

}