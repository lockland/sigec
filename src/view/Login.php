<?php

namespace Sigec\view;

use Core\view\View;

class Main extends View
{
    public function generateHTML($data = null)
    {
        include('templates/header.phtml');
        include('templates/aside.phtml');
        include('templates/footer.phtml');
    }
}
