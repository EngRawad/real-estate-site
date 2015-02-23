<?php

//////////////////////////////////////
// PHP Newsletter v3.5.6            //
// (C) 2006-2013 Alexander Yanitsky //
// Website: http://janicky.com      //
// E-mail: janickiy@mail.ru         //
// Skype: janickiy                  //
//////////////////////////////////////

class ExceptionMember extends Exception
{
	protected $key;

	public function __construct($key, $message)
	{
		$this->key = $key;

		parent::__construct($message);
	}

	public function getKey()
	{
		return $this->key;
	}
}

?>
