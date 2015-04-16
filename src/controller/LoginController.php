<?php

namespace Sigec\controller;

use Core\controller\Controller;

class LoginController extends Controller
{
	public function index()
	{
		print "index login";
	}
	public function logout($message = null)
	{
		print $message;
	}
}
