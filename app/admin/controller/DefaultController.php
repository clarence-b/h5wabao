<?php

//index.php?r=admin
namespace app\admin\controller;

class DefaultController extends \app\base\controller\BaseController {

	public function index() {
        $this->display();
	}

    public function token(){
        if($_POST['token'] == '8888') {
            $_SESSION['token'] = '8888';
            $this->redirect('index.php?r=admin/default/show');
        }else{
            $this->redirect('index.php?r=admin');
        }
    }

    public function show(){
        if($_SESSION['token'] == null) {
            $this->redirect('index.php?r=admin');
            exit;
        }
        $prizes = obj('Prize')->getListPrizes();
        $this->assign('prizes', $prizes);
        $this->display();
    }

    public function log(){
        $tel = trim($_GET['tel']);
        $accept = trim($_GET['ept']);
        $where = NULL;
        switch ($accept) {
            case 0:
                $where = "WHERE g.accept = 0";
                break;
            case 1:
                $where = "WHERE g.accept = 1";
                break;
        }
        !isset($_GET['ept']) && $where = NULL;
        !empty($tel) && $where = "WHERE u.telephone='{$tel}'";
        $logs = obj('Log')->getListUserLogsByWin($where);
        $total = obj('Log')->getCountLogsByAcceptTotal();
        $ept0 = obj('Log')->getCountLogsByAccept0();
        $ept1 = obj('Log')->getCountLogsByAccept1();

        $this->assign('logs', $logs);
        $this->assign('total', $total);
        $this->assign('ept0', $ept0);
        $this->assign('ept1', $ept1);
        $this->display();
    }

    public function update() {
        $id = trim($_POST['pid']);
        $stock = trim($_POST['stock']);
        echo obj('Prize')->updatePrizeStock($id, $stock);
    }
}