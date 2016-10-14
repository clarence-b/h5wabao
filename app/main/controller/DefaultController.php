<?php

namespace app\main\controller;
use \framework\ext\Util;

class DefaultController extends \app\base\controller\BaseController {

    public function __construct() {
        parent::__construct();
    }

	public function index() {
        $this->display();
	}
}