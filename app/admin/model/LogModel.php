<?php

namespace app\admin\model;

class LogModel extends \app\base\model\BaseModel {

    public function getListUserLogsByWin($where=NULL){
        $sql = "SELECT g.prize_name,g.created_at,g.accept,u.username,u.telephone FROM {pre}logs AS g LEFT JOIN {pre}users AS u ON u.user_guid=g.user_guid ".$where." ORDER BY g.created_at DESC";
        $data = $this->query($sql);
        return $data;
    }

    public function getCountLogsByAcceptTotal(){
        return $this->table('logs')->count();
    }

    public function getCountLogsByAccept0(){
        return $this->table('logs')->where(array('accept'=>0))->count();
    }

    public function getCountLogsByAccept1(){
        return $this->table('logs')->where(array('accept'=>1))->count();
    }

}