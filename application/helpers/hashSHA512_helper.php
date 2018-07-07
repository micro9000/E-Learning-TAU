<?php if( ! defined('BASEPATH')) exit('No direct script access allowed');
	
	if (! function_exists('hashSHA512')){

		function hashSHA512($text){
			if ($text !== ''){
				return hash('sha512', $text);
			}

			return FALSE;
		}

	}

?>	