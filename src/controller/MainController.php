<?php

namespace Sigec\controller;

use Core\controller\Controller;
use Sigec\view\Main;

class MainController extends Controller
{
	public function index()
	{
		$view = new Main();
		$view->assign('username', 'Francielle Vareira');
		$view->generateHTML('Main.phtml');
	}

	public function logout($message = null)
	{
		return is_null($message) ? "Invalid action<br />" : $message;
	}
}
