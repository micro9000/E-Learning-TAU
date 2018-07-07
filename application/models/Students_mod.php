<?php 
	
	class Students_mod extends CI_Model{

		##
		## LOGIN FUNCTIONS
		##

		public function is_student_can_login($stdNum, $pass){
			$data = array(
				'stdNum' => $stdNum,
				'pswd' => $pass
			);

			$this->db->select('id, stdNum, firstName, lastName, email');
			$this->db->where($data);
			$results = $this->db->get('Students');
			return $results->row_array();
		}

	}

?>