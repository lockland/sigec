<?php

namespace Sigec\view;

abstract class ViewBase
{
	protected $data = Array();

	public function generateHTML($template = null) 
	{
		extract($this->data);
		require($template);
	}

	public function assign($key, $value)
	{
		$this->data[$key] = $value;
	}
}
