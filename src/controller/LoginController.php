<?php

namespace Sigec\controller;

class LoginController 
{
	public function logout($message = null)
	{
		return is_null($message) ? "Invalid action<br />" : $message;
	}
}
