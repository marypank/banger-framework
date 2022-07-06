<?php

namespace app\core;

use app\core\Request;

abstract class Model // abstract to prevent creation of instance
{
	public function loadData($data)
	{
		foreach ($data as $key => $value) {
			if (property_exists($this, $key)) {
				$this->{$key} = $value;
			}
		}
	}

	public function validate()
	{
		//
	}

}