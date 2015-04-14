<?php

namespace Sigec\controller;

use Core\controller\Controller;
use Sigec\view\Login;

class LoginController extends Controller
{
	public function index()
	{
		$view = new Login();
		$view->generateHTML();
	}

	public function logout($message = null)
	{
		return is_null($message) ? "Invalid action<br />" : $message;
	}
}


