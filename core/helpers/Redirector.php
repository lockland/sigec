<?php

namespace Core\helpers;

class Redirector
{
    private $url;

    public function __construct($controller, $action, Array $parameters = [])
    {
        $this->url = sprintf(
            'location: %s/index.php/%s/%s/%s',
            URL_BASE,
            $controller,
            $action,
            implode('/', $parameters)
        );
    }

    public function redirect()
    {
        header($this->url);
    }
}
