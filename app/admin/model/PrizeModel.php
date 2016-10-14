<?php

namespace app\admin\model;

class PrizeModel extends \app\base\model\BaseModel {

	public function getListPrizes(){
		$where[] = 'prize_id != 7';
		return $this->table('prizes')->where($where)->select();
	}

	public function updatePrizeStock($id, $stock){
		$data['prize_stock'] = $stock;
		return $this->table('prizes')->data($data)->where(array('prize_id'=>$id))->update();
	}

}