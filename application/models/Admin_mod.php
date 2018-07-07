<?php 
	
	class Admin_mod extends CI_Model{

		##
		## LOGIN FUNCTIONS
		##

		public function is_faculty_admin_can_login($facNum, $pass){
			$data = array(
				'F.facultyIDNum' => $facNum,
				'A.pswd' => $pass,
				'F.isDeleted' => 0,
				'A.isDeleted' => 0
			);

			$this->db->select('A.id As adminID, F.id as facultyID, F.facultyIDNum, F.firstName, F.lastName, F.email, F.dateRegistered, F.addedByAdminFacultyNum');
			$this->db->from("Admins As A");
			$this->db->join("Faculties As F", "A.facultyID = F.id");
			$this->db->where($data);
			$results = $this->db->get();
			// $sql = $this->db->get_compiled_select();
			// return $sql;
			return $results->row_array();
		}

		public function insert_new_principle($principle, $facultyIDNum){
			$data = array(
				'principle' => $principle,
				'addedByFacultyNum' => $facultyIDNum
			);

			$result = $this->db->insert('AgriPrinciples', $data);
			return $result;
		}

		public function select_principle_by_id($principleID){
			$this->db->select("AP.*, CONCAT(F.firstName, ' ', F.lastName) As facultyName");
			$this->db->order_by('AP.id');
			$this->db->from('AgriPrinciples As AP');
			$this->db->join('Faculties As F', 'AP.addedByFacultyNum = F.facultyIDNum');
			$this->db->where(array(
								'AP.isDeleted' => 0,
								'AP.id' => $principleID
							));

			$results = $this->db->get();
			return $results->row_array();
		}

		public function select_all_principles(){

			$this->db->select("AP.*, CONCAT(F.firstName, ' ', F.lastName) As facultyName");
			$this->db->order_by('AP.id', 'DESC');
			$this->db->from('AgriPrinciples As AP');
			$this->db->join('Faculties As F', 'AP.addedByFacultyNum = F.facultyIDNum');
			$this->db->where('AP.isDeleted' , 0);

			$results = $this->db->get();
			return $results->result_array();
		}

		public function mark_principle_as_deleted($principleID){
			$this->db->set('isDeleted', 1);
			$this->db->where('id', $principleID);
			$result = $this->db->update('AgriPrinciples');
			return $result;
		}

		public function update_principle($principleID, $principle, $facultyIDNum){

			$data = array(
				'principle' => $principle,
				'modifyByFacultyNum' => $facultyIDNum
			);

			$this->db->set($data);
			$this->db->where('id', $principleID);
			$result = $this->db->update('AgriPrinciples');
			return $result;
		}


		public function insert_new_principle_sub_topic($principleID, $topic, $facultyIDNum){
			$data = array(
				'principleID' => $principleID,
				'topic' => $topic,
				'addedByFacultyNum' => $facultyIDNum
			);

			$result = $this->db->insert('PrinciplesSubTopic', $data);
			return $result;
		}

		public function select_all_principles_sub_topics(){

			$this->db->select("ST.*, AP.principle, CONCAT(F.firstName, ' ', F.lastName) As facultyName");
			$this->db->order_by('ST.id', 'DESC');
			$this->db->from('PrinciplesSubTopic As ST');
			$this->db->join('AgriPrinciples As AP', 'ST.principleID=AP.id');
			$this->db->join('Faculties As F', 'ST.addedByFacultyNum=F.facultyIDNum');
			$this->db->where(array(
							'AP.isDeleted' => 0,
							'ST.isDeleted' => 0
						));

			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_principles_sub_topic_by_topic_id($topicID){

			$this->db->select("ST.*, AP.principle, CONCAT(F.firstName, ' ', F.lastName) As facultyName");
			$this->db->order_by('ST.id', 'DESC');
			$this->db->from('PrinciplesSubTopic As ST');
			$this->db->join('AgriPrinciples As AP', 'ST.principleID=AP.id');
			$this->db->join('Faculties As F', 'ST.addedByFacultyNum=F.facultyIDNum');
			$this->db->where(array(
							'AP.isDeleted' => 0,
							'ST.isDeleted' => 0,
							'ST.id' => $topicID
						));

			$results = $this->db->get();
			return $results->row_array();
		}

		public function select_principles_sub_topic_by_principle_id($principleID){

			$this->db->select("ST.*, AP.principle, CONCAT(F.firstName, ' ', F.lastName) As facultyName");
			$this->db->order_by('ST.id', 'DESC');
			$this->db->from('PrinciplesSubTopic As ST');
			$this->db->join('AgriPrinciples As AP', 'ST.principleID=AP.id');
			$this->db->join('Faculties As F', 'ST.addedByFacultyNum=F.facultyIDNum');
			$this->db->where(array(
							'AP.isDeleted' => 0,
							'ST.isDeleted' => 0,
							'AP.id' => $principleID
						));

			$results = $this->db->get();
			return $results->result_array();
		}

		public function mark_principle_sub_topic_as_deleted($topicID){
			$this->db->set('isDeleted', 1);
			$this->db->where('id', $topicID);
			$result = $this->db->update('PrinciplesSubTopic');
			return $result;
		}

	}

?>