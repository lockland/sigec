<?php

namespace Sigec\view;

abstract class ViewBase
{
    protected $template;
    protected $data = array();

    public function generateHTML()
    {
        extract($this->data);
        include $this->template;
    }

    public function assign($key, $value)
    {
        $this->data[$key] = $value;
    }
}
