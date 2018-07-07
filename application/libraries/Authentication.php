<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Authentication{

		protected $CI;

        public function __construct() {
            $this->CI =& get_instance();
            
        }

		public function is_student_logged_in(){
			return ($this->CI->session->has_userdata('std_session_id') === TRUE && 
					$this->CI->session->has_userdata('logged_in') === TRUE && 
						$this->CI->session->userdata('logged_in') === TRUE) ? TRUE : FALSE;
		}
}

?>