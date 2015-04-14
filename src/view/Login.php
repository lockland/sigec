<?php

namespace Sigec\view;

use Core\view\View;

class Login extends View 
{
	public function generateHTML() {
		include('templates/header.html');
		include('templates/aside.html');
		include('templates/footer.html');
	}
}
