<?php

namespace app\main\model;

class SeckillModel extends \app\base\model\BaseModel {

    public function updateBySeckillStock($GuID){
        $retPrizes = NULL;
        $where[] = "`prize_stock` > 0 AND `prize_name` != 'not'";
        $priData = $this->table('prizes')->where($where)->find();

        //库存为0
        if (!$priData) {
            return $retPrizes;
            exit;
        }

        $this->beginTransaction();
        try {
            $sqlPrizeResult = "SELECT `prize_id`, `prize_name` FROM {pre}prizes WHERE `prize_stock` > 0 AND `prize_name` != 'not' ORDER BY RAND() LIMIT 1 FOR UPDATE";
            $retPrizes = $this->query($sqlPrizeResult);

            $time = time();
            $sqlLogs = "INSERT {pre}logs (`user_guid`, `prize_name`, `created_at`) VALUES ('{$GuID}','{$retPrizes[0]['prize_name']}',{$time})";
            $this->execute($sqlLogs);

            $sqlStockMinus = "UPDATE {pre}prizes SET `prize_stock`=`prize_stock` - 1 WHERE `prize_id`={$retPrizes[0]['prize_id']}";
            $this->execute($sqlStockMinus);

            $sqlOpporMinus = "UPDATE {pre}users SET `oppor`=`oppor` - 1, `gets`=`gets` + 1 WHERE `user_guid`='{$GuID}'";
            $this->execute($sqlOpporMinus);
            
        } catch (Exception $e) {
            $this->rollBack();
        }
        $this->commit();

        return $retPrizes;
    }

}