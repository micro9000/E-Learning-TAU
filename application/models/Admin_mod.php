<?php 
	
	class Admin_mod extends CI_Model{

		##
		## LOGIN FUNCTIONS
		##

		public function login($facNum, $pass){
			$data = array(
				'facultyIDNum' => $facNum,
				'pswd' => $pass,
				'isDeleted' => 0
			);

			$this->db->select('id, facultyIDNum, firstName, lastName, email, dateRegistered, addedByAdminFacultyNum, isAdmin, isDean');
			$this->db->where($data);
			$results = $this->db->get("Faculties");
			return $results->row_array();
		}

		// public function is_faculty_admin_can_login($facNum, $pass){
		// 	$data = array(
		// 		'F.facultyIDNum' => $facNum,
		// 		'A.pswd' => $pass,
		// 		'F.isDeleted' => 0,
		// 		'A.isDeleted' => 0
		// 	);

		// 	$this->db->select('A.id As adminID, F.id as facultyID, F.facultyIDNum, F.firstName, F.lastName, F.email, F.dateRegistered, F.addedByAdminFacultyNum');
		// 	$this->db->from("Admins As A");
		// 	$this->db->join("Faculties As F", "A.facultyID = F.id");
		// 	$this->db->where($data);
		// 	$results = $this->db->get();
		// 	// $sql = $this->db->get_compiled_select();
		// 	// return $sql;
		// 	return $results->row_array();
		// }

		##
		## FACULTY
		##

		public function insert_new_faculty($info, $pswd){

			$data = array(
				'facultyIDNum' => $info['faculty_id_num'],
				'firstName' => $info['firstname'],
				'lastName' => $info['lastname'],
				'email' => $info['email'],
				'pswd' => $pswd,
				'addedByAdminFacultyNum' => $info['facultyIDNum']
			);

			$result = $this->db->insert('Faculties', $data);
			return $result;
		}

		public function mark_faculty_data_as_deleted($facultyID){
			$this->db->set('isDeleted', 1);
			$this->db->where('id', $facultyID);
			$result = $this->db->update('Faculties');
			return $result;
		}

		public function restore_deleted_faculty_data($facultyID){
			$this->db->set('isDeleted', 0);
			$this->db->where('id', $facultyID);
			$result = $this->db->update('Faculties');
			return $result;
		}

		public function update_faculty_without_pass($info){

			$data = array(
				'facultyIDNum' => $info['faculty_id_num'],
				'firstName' => $info['firstname'],
				'lastName' => $info['lastname'],
				'email' => $info['email']
			);

			$this->db->set($data);
			$this->db->where('id', $info['facultyID']);

			$result = $this->db->update('Faculties');
			return $result;
		}

		public function update_faculty_with_pass($info){

			$data = array(
				'facultyIDNum' => $info['faculty_id_num'],
				'firstName' => $info['firstname'],
				'lastName' => $info['lastname'],
				'email' => $info['email'],
				'pswd' => $info['password']
			);

			$this->db->set($data);
			$this->db->where('id', $info['facultyID']);
			$result = $this->db->update('Faculties');
			return $result;
		}

		public function mark_faculty_as_admin_or_dean($facultyID, $status, $mark_as){

			$data = array();
			if ($mark_as == "admin"){
				$data = array(
					'isAdmin' => $status
				);
			}else if ($mark_as == "dean"){
				$data = array(
					'isDean' => $status
				);
			}

			$this->db->set($data);
			$this->db->where('id', $facultyID);
			$result = $this->db->update('Faculties');
			return $result;
		}

		public function select_faculty_password_by_id($id){

			$this->db->select("pswd");
			$this->db->from("Faculties");
			$this->db->where(array(
					"isDeleted" => 0,
					"id" => $id
			));

			// $sql = $this->db->get_compiled_select();
			// echo $sql;
			$results = $this->db->get();
			return $results->row_array();
		}

		public function select_faculty_by_id_num($idNum){

			$this->db->select("id, isAdmin, isDean, facultyIDNum, firstName, lastName, email, DATE_FORMAT(dateRegistered, '%M %d, %Y %r') As dateRegisteredFormated, addedByAdminFacultyNum");
			$this->db->from("Faculties");
			$this->db->where(array(
					"isDeleted" => 0,
					"facultyIDNum" => $idNum
			));

			$results = $this->db->get();
			return $results->row_array();
		}

		public function select_deleted_faculty_by_id_num($idNum){

			$this->db->select("id, isAdmin, isDean, facultyIDNum, firstName, lastName, email, DATE_FORMAT(dateRegistered, '%M %d, %Y %r') As dateRegisteredFormated, addedByAdminFacultyNum");
			$this->db->from("Faculties");
			$this->db->where("facultyIDNum", $idNum);

			$results = $this->db->get();
			return $results->row_array();
		}

		public function select_faculty_by_id($id){

			$this->db->select("id, isAdmin, isDean,  facultyIDNum, firstName, lastName, email, DATE_FORMAT(dateRegistered, '%M %d, %Y %r') As dateRegisteredFormated, addedByAdminFacultyNum");
			$this->db->from("Faculties");
			$this->db->where(array(
					"isDeleted" => 0,
					"id" => $id
			));

			$results = $this->db->get();
			return $results->row_array();
		}

		public function select_deleted_faculty_by_id($id){

			$this->db->select("id, isAdmin, isDean,  facultyIDNum, firstName, lastName, email, DATE_FORMAT(dateRegistered, '%M %d, %Y %r') As dateRegisteredFormated, addedByAdminFacultyNum");
			$this->db->from("Faculties");
			$this->db->where(array(
					"isDeleted" => 1,
					"id" => $id
			));

			$results = $this->db->get();
			return $results->row_array();
		}

		public function select_faculty_by_id_and_id_number($id, $facultyIDNum){

			$this->db->select("id, isAdmin, isDean,  facultyIDNum, firstName, lastName, email, DATE_FORMAT(dateRegistered, '%M %d, %Y %r') As dateRegisteredFormated, addedByAdminFacultyNum");
			$this->db->from("Faculties");
			$this->db->where(array(
					"isDeleted" => 0,
					"id !=" => $id,
					"facultyIDNum" => $facultyIDNum
			));

			$results = $this->db->get();
			return $results->row_array();
		}

		public function select_faculty_by_id_and_email($id, $email){

			$this->db->select("id, isAdmin, isDean,  facultyIDNum, firstName, lastName, email, DATE_FORMAT(dateRegistered, '%M %d, %Y %r') As dateRegisteredFormated, addedByAdminFacultyNum");
			$this->db->from("Faculties");
			$this->db->where(array(
					"isDeleted" => 0,
					"id !=" => $id,
					"email" => $email
			));

			$results = $this->db->get();
			return $results->row_array();
		}


		public function select_all_faculties(){

			$this->db->select("id, isAdmin, isDean,  facultyIDNum, firstName, lastName, email, DATE_FORMAT(dateRegistered, '%M %d, %Y %r') As dateRegisteredFormated, addedByAdminFacultyNum");
			$this->db->order_by('id');
			$this->db->from("Faculties");
			$this->db->where("isDeleted=0");

			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_all_deleted_faculties(){

			$this->db->select("id, isAdmin, isDean,  facultyIDNum, firstName, lastName, email, DATE_FORMAT(dateRegistered, '%M %d, %Y %r') As dateRegisteredFormated, addedByAdminFacultyNum");
			$this->db->order_by('id');
			$this->db->from("Faculties");
			$this->db->where("isDeleted=1");

			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_faculties($searchStr){

			$this->db->select("id, isAdmin, isDean,  facultyIDNum, firstName, lastName, email, DATE_FORMAT(dateRegistered, '%M %d, %Y %r') As dateRegisteredFormated, addedByAdminFacultyNum");
			$this->db->order_by('id');
			$this->db->from("Faculties");
			$this->db->where("isDeleted=0");
			$this->db->group_start();
			$this->db->like("facultyIDNum", $searchStr);
			$this->db->or_like("CONCAT(firstName,' ', lastName)", $searchStr);
			$this->db->or_like("email", $searchStr);
			$this->db->group_end();
			
			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_deleted_faculties($searchStr){

			$this->db->select("id, isAdmin, isDean,  facultyIDNum, firstName, lastName, email, DATE_FORMAT(dateRegistered, '%M %d, %Y %r') As dateRegisteredFormated, addedByAdminFacultyNum");
			$this->db->order_by('id');
			$this->db->from("Faculties");
			$this->db->where("isDeleted=1");
			$this->db->group_start();
			$this->db->like("facultyIDNum", $searchStr);
			$this->db->or_like("CONCAT(firstName,' ', lastName)", $searchStr);
			$this->db->or_like("email", $searchStr);
			$this->db->group_end();
			
			$results = $this->db->get();
			return $results->result_array();
		}

		##
		## Students
		##

		public function insert_new_student($info, $pswd){

			$data = array(
				'stdNum' => $info['student_id_num'],
				'firstName' => $info['firstname'],
				'lastName' => $info['lastname'],
				'email' => $info['email'],
				'pswd' => $pswd,
			);

			$result = $this->db->insert('Students', $data);
			return $result;
		}

		public function update_student_without_pass($info){

			$data = array(
				'stdNum' => $info['student_id_num'],
				'firstName' => $info['firstname'],
				'lastName' => $info['lastname'],
				'email' => $info['email']
			);

			$this->db->set($data);
			$this->db->where("id", $info['studentID']);
			$result = $this->db->update('Students');
			return $result;
		}

		public function update_student_with_pass($info){

			$data = array(
				'stdNum' => $info['student_id_num'],
				'firstName' => $info['firstname'],
				'lastName' => $info['lastname'],
				'email' => $info['email'],
				'pswd' => $info['pswd'],
			);

			$this->db->set($data);
			$this->db->where("id", $info['studentID']);
			$result = $this->db->update('Students');
			return $result;
		}

		public function mark_student_data_as_deleted($studentID){
			$this->db->set('isDeleted', 1);
			$this->db->where('id', $studentID);
			$result = $this->db->update('Students');
			return $result;
		}

		public function restore_deleted_student_data($studentID){
			$this->db->set('isDeleted', 0);
			$this->db->where('id', $studentID);
			$result = $this->db->update('Students');
			return $result;
		}

		public function select_std_num($stdNum){

			$this->db->select("id, stdNum");
			$this->db->from("ValidStudentNumbers");
			$this->db->where(array("stdNum" => $stdNum));

			$results = $this->db->get();
			return $results->row_array();
		}

		public function select_std_by_id_and_id_number($id, $stdNum){

			$this->db->select("id, stdNum, firstName, lastName, email, DATE_FORMAT(dateRegistered, '%M %d, %Y %r') As dateRegisteredFormated");
			$this->db->from("Students");
			$this->db->where(array(
					"isDeleted" => 0,
					"id !=" => $id,
					"stdNum" => $stdNum
			));

			$results = $this->db->get();
			return $results->row_array();
		}

		public function select_std_by_std_num($stdNum){

			$this->db->select("id, stdNum, firstName, lastName, email, DATE_FORMAT(dateRegistered, '%M %d, %Y %r') As dateRegisteredFormated");
			$this->db->from("Students");
			$this->db->where(array(
					"isDeleted" => 0,
					"stdNum" => $stdNum
			));

			$results = $this->db->get();
			return $results->row_array();
		}

		public function select_std_by_id_and_email($id, $email){

			$this->db->select("id, stdNum, firstName, lastName, email, DATE_FORMAT(dateRegistered, '%M %d, %Y %r') As dateRegisteredFormated");
			$this->db->from("Students");
			$this->db->where(array(
					"isDeleted" => 0,
					"id !=" => $id,
					"email" => $email
			));

			$results = $this->db->get();
			return $results->row_array();
		}

		public function select_all_students(){

			$this->db->select("id, stdNum, firstName, lastName, email, DATE_FORMAT(dateRegistered, '%M %d, %Y %r') As dateRegisteredFormated");
			$this->db->order_by('id');
			$this->db->from("Students");
			$this->db->where("isDeleted=0");

			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_all_deleted_students(){

			$this->db->select("id, stdNum, firstName, lastName, email, DATE_FORMAT(dateRegistered, '%M %d, %Y %r') As dateRegisteredFormated");
			$this->db->order_by('id');
			$this->db->from("Students");
			$this->db->where("isDeleted=1");

			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_students($searchStr){
			
			$this->db->select("id, stdNum, firstName, lastName, email, DATE_FORMAT(dateRegistered, '%M %d, %Y %r') As dateRegisteredFormated");
			$this->db->order_by('id');
			$this->db->from("Students");
			$this->db->where("isDeleted=0");
			$this->db->group_start();
			$this->db->like("stdNum", $searchStr);
			$this->db->or_like("firstName", $searchStr);
			$this->db->or_like("lastName", $searchStr);
			$this->db->or_like("email", $searchStr);
			$this->db->or_like("CONCAT(firstName,' ', lastName)", $searchStr);
			$this->db->or_like("CONCAT(lastName,' ', firstName)", $searchStr);
			$this->db->group_end();

			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_deleted_students($searchStr){
			
			$this->db->select("id, stdNum, firstName, lastName, email, DATE_FORMAT(dateRegistered, '%M %d, %Y %r') As dateRegisteredFormated");
			$this->db->order_by('id');
			$this->db->from("Students");
			$this->db->where("isDeleted=1");
			$this->db->group_start();
			$this->db->like("stdNum", $searchStr);
			$this->db->or_like("firstName", $searchStr);
			$this->db->or_like("lastName", $searchStr);
			$this->db->or_like("email", $searchStr);
			$this->db->or_like("CONCAT(firstName,' ', lastName)", $searchStr);
			$this->db->or_like("CONCAT(lastName,' ', firstName)", $searchStr);
			$this->db->group_end();

			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_std_pswd_by_id($id){

			$this->db->select("pswd");
			$this->db->from("Students");
			$this->db->where(array(
					"isDeleted" => 0,
					"id =" => $id
			));

			$results = $this->db->get();
			return $results->row_array();
		}

		public function select_std_by_id($id){

			$this->db->select("id, stdNum, firstName, lastName, email, DATE_FORMAT(dateRegistered, '%M %d, %Y %r') As dateRegisteredFormated");
			$this->db->from("Students");
			$this->db->where(array(
					"isDeleted" => 0,
					"id" => $id
			));

			$results = $this->db->get();
			return $results->row_array();
		}

		public function select_deleted_std_by_id($id){

			$this->db->select("id, stdNum, firstName, lastName, email, DATE_FORMAT(dateRegistered, '%M %d, %Y %r') As dateRegisteredFormated");
			$this->db->from("Students");
			$this->db->where(array(
					"isDeleted" => 1,
					"id" => $id
			));

			$results = $this->db->get();
			return $results->row_array();
		}

		##
		## Principles
		##

		public function insert_new_principle($principle, $facultyIDNum){
			$data = array(
				'principle' => $principle,
				'addedByFacultyNum' => $facultyIDNum
			);

			$result = $this->db->insert('AgriPrinciples', $data);
			return $result;
		}

		public function search_principle($search){

			$this->db->select("AP.*, DATE_FORMAT(AP.dateAdded, '%M %d, %Y %r') As dateAddedFormated, DATE_FORMAT(AP.dateModify, '%M %d, %Y %r') As dateModifyFormated, CONCAT(F.firstName, ' ', F.lastName) As facultyName");
			$this->db->order_by('AP.id');
			$this->db->from('AgriPrinciples As AP');
			$this->db->join('Faculties As F', 'AP.addedByFacultyNum = F.facultyIDNum');
			$this->db->where('AP.isDeleted', 0);
			$this->db->like('AP.principle', $search);

			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_principle_by_id($principleID){

			$this->db->select("AP.*, DATE_FORMAT(AP.dateAdded, '%M %d %Y %r') As dateAddedFormated, DATE_FORMAT(AP.dateModify, '%M %d %Y %r') As dateModifyFormated, CONCAT(F.firstName, ' ', F.lastName) As facultyName");
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

		public function select_deleted_principle_by_id($principleID){

			$this->db->select("AP.*, DATE_FORMAT(AP.dateAdded, '%M %d %Y %r') As dateAddedFormated, DATE_FORMAT(AP.dateModify, '%M %d %Y %r') As dateModifyFormated, CONCAT(F.firstName, ' ', F.lastName) As facultyName");
			$this->db->order_by('AP.id');
			$this->db->from('AgriPrinciples As AP');
			$this->db->join('Faculties As F', 'AP.addedByFacultyNum = F.facultyIDNum');
			$this->db->where(array(
								'AP.isDeleted' => 1,
								'AP.id' => $principleID
							));

			$results = $this->db->get();
			return $results->row_array();
		}

		public function select_all_principles(){

			$this->db->select("AP.*, DATE_FORMAT(AP.dateAdded, '%M %d, %Y %r') As dateAddedFormated, DATE_FORMAT(AP.dateModify, '%M %d, %Y %r') As dateModifyFormated, CONCAT(F.firstName, ' ', F.lastName) As facultyName");
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


		public function mark_principle_as_undeleted($principleID){
			$this->db->set('isDeleted', 0);
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

		public function select_all_deleted_principles(){

			$this->db->select("AP.*, DATE_FORMAT(AP.dateAdded, '%M %d, %Y %r') As dateAddedFormated, DATE_FORMAT(AP.dateModify, '%M %d, %Y %r') As dateModifyFormated, CONCAT(F.firstName, ' ', F.lastName) As facultyName");
			$this->db->order_by('AP.id', 'DESC');
			$this->db->from('AgriPrinciples As AP');
			$this->db->join('Faculties As F', 'AP.addedByFacultyNum = F.facultyIDNum');
			$this->db->where('AP.isDeleted' , 1);

			$results = $this->db->get();
			return $results->result_array();
		}

		public function search_deleted_principle($search){

			$this->db->select("AP.*, DATE_FORMAT(AP.dateAdded, '%M %d, %Y %r') As dateAddedFormated, DATE_FORMAT(AP.dateModify, '%M %d, %Y %r') As dateModifyFormated, CONCAT(F.firstName, ' ', F.lastName) As facultyName");
			$this->db->order_by('AP.id');
			$this->db->from('AgriPrinciples As AP');
			$this->db->join('Faculties As F', 'AP.addedByFacultyNum = F.facultyIDNum');
			$this->db->where('AP.isDeleted', 1);
			$this->db->like('AP.principle', $search);

			$results = $this->db->get();
			return $results->result_array();
		}

		//
		// Sub topics
		//
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

			$this->db->select("ST.*, DATE_FORMAT(ST.dateAdded, '%M %d, %Y %r') As dateAddedFormated, DATE_FORMAT(ST.dateModify, '%M %d, %Y %r') As dateModifyFormated, AP.principle, CONCAT(F.firstName, ' ', F.lastName) As facultyName");
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


		public function select_all_deleted_principles_sub_topics(){

			$this->db->select("ST.*, DATE_FORMAT(ST.dateAdded, '%M %d, %Y %r') As dateAddedFormated, DATE_FORMAT(ST.dateModify, '%M %d, %Y %r') As dateModifyFormated, AP.principle, CONCAT(F.firstName, ' ', F.lastName) As facultyName");
			$this->db->order_by('ST.id', 'DESC');
			$this->db->from('PrinciplesSubTopic As ST');
			$this->db->join('AgriPrinciples As AP', 'ST.principleID=AP.id');
			$this->db->join('Faculties As F', 'ST.addedByFacultyNum=F.facultyIDNum');
			$this->db->where(array(
							'ST.isDeleted' => 1
						));

			$results = $this->db->get();
			return $results->result_array();
		}


		public function search_principle_sub_topics($search){

			$this->db->select("ST.*, DATE_FORMAT(ST.dateAdded, '%M %d, %Y %r') As dateAddedFormated, DATE_FORMAT(ST.dateModify, '%M %d, %Y %r') As dateModifyFormated, AP.principle, CONCAT(F.firstName, ' ', F.lastName) As facultyName");
			$this->db->order_by('ST.id', 'DESC');
			$this->db->from('PrinciplesSubTopic As ST');
			$this->db->join('AgriPrinciples As AP', 'ST.principleID=AP.id');
			$this->db->join('Faculties As F', 'ST.addedByFacultyNum=F.facultyIDNum');
			$this->db->where(array(
							'AP.isDeleted' => 0,
							'ST.isDeleted' => 0
						));

			$this->db->like('ST.topic', $search);
			$this->db->or_like('AP.principle', $search);

			$results = $this->db->get();
			return $results->result_array();
		}

		public function search_deleted_principle_sub_topics($search){

			$this->db->select("ST.*, DATE_FORMAT(ST.dateAdded, '%M %d, %Y %r') As dateAddedFormated, DATE_FORMAT(ST.dateModify, '%M %d, %Y %r') As dateModifyFormated, AP.principle, CONCAT(F.firstName, ' ', F.lastName) As facultyName");
			$this->db->order_by('ST.id', 'DESC');
			$this->db->from('PrinciplesSubTopic As ST');
			$this->db->join('AgriPrinciples As AP', 'ST.principleID=AP.id');
			$this->db->join('Faculties As F', 'ST.addedByFacultyNum=F.facultyIDNum');
			$this->db->where(array(
							'ST.isDeleted' => 1
						));

			$this->db->like('ST.topic', $search);
			$this->db->or_like('AP.principle', $search);

			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_principles_sub_topic_by_topic_id($topicID){

			$this->db->select("ST.*, DATE_FORMAT(ST.dateAdded, '%M %d, %Y %r') As dateAddedFormated, DATE_FORMAT(ST.dateModify, '%M %d, %Y %r') As dateModifyFormated, AP.principle, CONCAT(F.firstName, ' ', F.lastName) As facultyName");
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

		public function select_deleted_principles_sub_topic_by_id($topicID){

			$this->db->select("ST.*, DATE_FORMAT(ST.dateAdded, '%M %d, %Y %r') As dateAddedFormated, DATE_FORMAT(ST.dateModify, '%M %d, %Y %r') As dateModifyFormated, AP.principle, CONCAT(F.firstName, ' ', F.lastName) As facultyName");
			$this->db->order_by('ST.id', 'DESC');
			$this->db->from('PrinciplesSubTopic As ST');
			$this->db->join('AgriPrinciples As AP', 'ST.principleID=AP.id');
			$this->db->join('Faculties As F', 'ST.addedByFacultyNum=F.facultyIDNum');
			$this->db->where(array(
							'ST.isDeleted' => 1,
							'ST.id' => $topicID
						));

			$results = $this->db->get();
			return $results->row_array();
		}

		public function select_principles_sub_topic_by_principle_id($principleID){

			$this->db->select("ST.*, DATE_FORMAT(ST.dateAdded, '%M %d, %Y %r') As dateAddedFormated, DATE_FORMAT(ST.dateModify, '%M %d, %Y %r') As dateModifyFormated, AP.principle, CONCAT(F.firstName, ' ', F.lastName) As facultyName");
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

		public function restore_deleted_principle_sub_topic($topicID){
			$this->db->set('isDeleted', 0);
			$this->db->where('id', $topicID);
			$result = $this->db->update('PrinciplesSubTopic');
			return $result;
		}

		public function update_principle_sub_topic($topicID, $principleID, $topic, $facultyIDNum){
			$data = array(
				'principleID' => $principleID,
				'topic' => $topic,
				'modifyByFacultyNum' => $facultyIDNum
			);

			$this->db->set($data);
			$this->db->where('id', $topicID);
			$result = $this->db->update('PrinciplesSubTopic');
			return $result;
		}


		public function insert_new_topic_chapter($principleID, $topicID, $chapterTitle, $facultyIDNum){
			$data = array(
				'principleID' => $principleID,
				'topicID' => $topicID,
				'chapterTitle' => $chapterTitle,
				'addedByFacultyNum' => $facultyIDNum
			);

			$result = $this->db->insert('TopicChapters', $data);
			return $result;
		}

		public function select_all_topics_chapters(){

			$this->db->select("TC.*, DATE_FORMAT(TC.dateAdded, '%M %d, %Y %r') As dateAddedFormated, DATE_FORMAT(TC.dateModify, '%M %d, %Y %r') As dateModifyFormated, AP.principle, PT.topic, CONCAT(FT.firstName,' ', FT.lastName) As facultyName");
			$this->db->order_by('TC.id', 'DESC');
			$this->db->from('TopicChapters As TC');
			$this->db->join('AgriPrinciples As AP', 'TC.principleID = AP.id');
			$this->db->join('PrinciplesSubTopic As PT', 'TC.topicID = PT.id');
			$this->db->join('Faculties As FT', 'TC.addedByFacultyNum=FT.facultyIDNum');
			$this->db->where('PT.principleID=AP.id');
			$this->db->where(array(
							'TC.isDeleted' => 0,
							'AP.isDeleted' => 0,
							'PT.isDeleted' => 0
						));

			// $sql = $this->db->get_compiled_select();
			// echo $sql;
			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_all_deleted_topics_chapters(){

			$this->db->select("TC.*, DATE_FORMAT(TC.dateAdded, '%M %d, %Y %r') As dateAddedFormated, DATE_FORMAT(TC.dateModify, '%M %d, %Y %r') As dateModifyFormated, AP.principle, PT.topic, CONCAT(FT.firstName,' ', FT.lastName) As facultyName");
			$this->db->order_by('TC.id', 'DESC');
			$this->db->from('TopicChapters As TC');
			$this->db->join('AgriPrinciples As AP', 'TC.principleID = AP.id');
			$this->db->join('PrinciplesSubTopic As PT', 'TC.topicID = PT.id');
			$this->db->join('Faculties As FT', 'TC.addedByFacultyNum=FT.facultyIDNum');
			$this->db->where('PT.principleID=AP.id');
			$this->db->where(array(
							'TC.isDeleted' => 1
						));

			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_all_topics_chapters_topic_id($topicID){

			$this->db->select("TC.*, DATE_FORMAT(TC.dateAdded, '%M %d, %Y %r') As dateAddedFormated, DATE_FORMAT(TC.dateModify, '%M %d, %Y %r') As dateModifyFormated, AP.principle, PT.topic, CONCAT(FT.firstName,' ', FT.lastName) As facultyName");
			$this->db->order_by('TC.id', 'DESC');
			$this->db->from('TopicChapters As TC');
			$this->db->join('AgriPrinciples As AP', 'TC.principleID = AP.id');
			$this->db->join('PrinciplesSubTopic As PT', 'TC.topicID = PT.id');
			$this->db->join('Faculties As FT', 'TC.addedByFacultyNum=FT.facultyIDNum');
			$this->db->where('PT.principleID=AP.id');
			$this->db->where(array(
							'TC.isDeleted' => 0,
							'AP.isDeleted' => 0,
							'PT.isDeleted' => 0,
							'PT.id' => $topicID
						));

			$results = $this->db->get();
			return $results->result_array();
		}


		public function select_chapter_by_id($chapterID){

			$this->db->select("TC.*, DATE_FORMAT(TC.dateAdded, '%M %d, %Y %r') As dateAddedFormated, DATE_FORMAT(TC.dateModify, '%M %d, %Y %r') As dateModifyFormated, AP.principle, PT.topic, CONCAT(FT.firstName,' ', FT.lastName) As facultyName");
			$this->db->order_by('TC.id', 'DESC');
			$this->db->from('TopicChapters As TC');
			$this->db->join('AgriPrinciples As AP', 'TC.principleID = AP.id');
			$this->db->join('PrinciplesSubTopic As PT', 'TC.topicID = PT.id');
			$this->db->join('Faculties As FT', 'TC.addedByFacultyNum=FT.facultyIDNum');
			$this->db->where('PT.principleID=AP.id');
			$this->db->where(array(
							'TC.isDeleted' => 0,
							'AP.isDeleted' => 0,
							'PT.isDeleted' => 0,
							'TC.id' => $chapterID
						));

			$results = $this->db->get();
			return $results->row_array();
		}


		public function select_deleted_chapter_by_id($chapterID){

			$this->db->select("TC.*, DATE_FORMAT(TC.dateAdded, '%M %d, %Y %r') As dateAddedFormated, DATE_FORMAT(TC.dateModify, '%M %d, %Y %r') As dateModifyFormated, AP.principle, PT.topic, CONCAT(FT.firstName,' ', FT.lastName) As facultyName");
			$this->db->order_by('TC.id', 'DESC');
			$this->db->from('TopicChapters As TC');
			$this->db->join('AgriPrinciples As AP', 'TC.principleID = AP.id');
			$this->db->join('PrinciplesSubTopic As PT', 'TC.topicID = PT.id');
			$this->db->join('Faculties As FT', 'TC.addedByFacultyNum=FT.facultyIDNum');
			$this->db->where('PT.principleID=AP.id');
			$this->db->where(array(
							'TC.isDeleted' => 1,
							'TC.id' => $chapterID
						));

			$results = $this->db->get();
			return $results->row_array();
		}


		public function select_chapter_by_topic_id($topicID){

			$this->db->select("TC.*, DATE_FORMAT(TC.dateAdded, '%M %d, %Y %r') As dateAddedFormated, DATE_FORMAT(TC.dateModify, '%M %d, %Y %r') As dateModifyFormated, AP.principle, PT.topic, CONCAT(FT.firstName,' ', FT.lastName) As facultyName");
			$this->db->order_by('TC.id', 'DESC');
			$this->db->from('TopicChapters As TC');
			$this->db->join('AgriPrinciples As AP', 'TC.principleID = AP.id');
			$this->db->join('PrinciplesSubTopic As PT', 'TC.topicID = PT.id');
			$this->db->join('Faculties As FT', 'TC.addedByFacultyNum=FT.facultyIDNum');
			$this->db->where('PT.principleID=AP.id');
			$this->db->where(array(
							'TC.isDeleted' => 0,
							'AP.isDeleted' => 0,
							'PT.isDeleted' => 0,
							'PT.id' => $topicID
						));

			$results = $this->db->get();
			return $results->result_array();
		}

		public function search_chapter($search_str){

			$this->db->select("TC.*, DATE_FORMAT(TC.dateAdded, '%M %d, %Y %r') As dateAddedFormated, DATE_FORMAT(TC.dateModify, '%M %d, %Y %r') As dateModifyFormated, AP.principle, PT.topic, CONCAT(FT.firstName,' ', FT.lastName) As facultyName");
			
			$this->db->from('TopicChapters As TC');
			$this->db->join('AgriPrinciples As AP', 'TC.principleID = AP.id');
			$this->db->join('PrinciplesSubTopic As PT', 'TC.topicID = PT.id');
			$this->db->join('Faculties As FT', 'TC.addedByFacultyNum=FT.facultyIDNum');

			$this->db->group_start();

			$this->db->like('TC.chapterTitle', $search_str);
			$this->db->or_like('AP.principle', $search_str);
			$this->db->or_like('PT.topic', $search_str);

			$this->db->group_end();

			$this->db->group_start();
			$this->db->where(array(
							'TC.isDeleted' => 0,
							'AP.isDeleted' => 0,
							'PT.isDeleted' => 0
						));
			$this->db->group_end();

			$this->db->where('PT.principleID=AP.id');

			$this->db->order_by('TC.id', 'DESC');

			$results = $this->db->get();
			return $results->result_array();
		}

		public function search_deleted_chapter($search_str){

			$this->db->select("TC.*, DATE_FORMAT(TC.dateAdded, '%M %d, %Y %r') As dateAddedFormated, DATE_FORMAT(TC.dateModify, '%M %d, %Y %r') As dateModifyFormated, AP.principle, PT.topic, CONCAT(FT.firstName,' ', FT.lastName) As facultyName");
			
			$this->db->from('TopicChapters As TC');
			$this->db->join('AgriPrinciples As AP', 'TC.principleID = AP.id');
			$this->db->join('PrinciplesSubTopic As PT', 'TC.topicID = PT.id');
			$this->db->join('Faculties As FT', 'TC.addedByFacultyNum=FT.facultyIDNum');

			$this->db->group_start();

			$this->db->like('TC.chapterTitle', $search_str);
			$this->db->or_like('AP.principle', $search_str);
			$this->db->or_like('PT.topic', $search_str);

			$this->db->group_end();

			$this->db->group_start();
			$this->db->where("TC.isDeleted", 1);
			$this->db->group_end();

			$this->db->where('PT.principleID=AP.id');

			$this->db->order_by('TC.id', 'DESC');

			$results = $this->db->get();
			return $results->result_array();
		}


		public function update_topic_chapter($chapterID, $principleID, $topicID, $chapterTitle, $facultyIDNum){
			$data = array(
				'principleID' => $principleID,
				'topicID' => $topicID,
				'chapterTitle' => $chapterTitle,
				'addedByFacultyNum' => $facultyIDNum
			);

			$this->db->set($data);
			$this->db->where('id', $chapterID);
			$result = $this->db->update('TopicChapters');
			return $result;
		}

		public function mark_topic_chapter_as_deleted($chapterID){			
			$this->db->set('isDeleted', 1);
			$this->db->where('id', $chapterID);
			$result = $this->db->update('TopicChapters');
			return $result;
		}

		public function restore_deleted_topic_chapter($chapterID){			
			$this->db->set('isDeleted', 0);
			$this->db->where('id', $chapterID);
			$result = $this->db->update('TopicChapters');
			return $result;
		}

		public function insert_new_lesson_without_cover($chapterID, $title, $slug, $content, $facultyIDNum){
			$data = array(
				'chapterID' => $chapterID,
				'title' => $title,
				'slug' => $slug,
				'content' => $content,
				'addedByFacultyNum' => $facultyIDNum
			);

			$result = $this->db->insert('Lessons', $data);
			return $result;
		}

		public function insert_new_lesson_with_cover($chapterID, $title, $slug, $content, $cover_photo_file_name, $cover_orientation , $facultyIDNum){
			$data = array(
				'chapterID' => $chapterID,
				'title' => $title,
				'slug' => $slug,
				'content' => $content,
				'isWithCoverPhoto' => "1",
				'coverPhoto' => $cover_photo_file_name,
				'coverOrientation' => $cover_orientation,
				'addedByFacultyNum' => $facultyIDNum,
			);

			$result = $this->db->insert('Lessons', $data);
			return $result;
		}


		public function update_lesson_without_cover($lessonID, $chapterID, $title, $slug, $content, $facultyIDNum){
			$data = array(
				'chapterID' => $chapterID,
				'title' => $title,
				'slug' => $slug,
				'content' => $content,
				'modifyByFacultyNum' => $facultyIDNum
			);

			$this->db->set($data);
			$this->db->where("id", $lessonID);
			// $sql = $this->db->get_compiled_update("Lessons");
			// echo $sql;
			$result = $this->db->update('Lessons');
			return $result;
		}

		public function update_lesson_with_cover($lessonID, $chapterID, $title, $slug, $content, $cover_photo_file_name, $cover_orientation , $facultyIDNum){
			$data = array(
				'chapterID' => $chapterID,
				'title' => $title,
				'slug' => $slug,
				'content' => $content,
				'isWithCoverPhoto' => "1",
				'coverPhoto' => $cover_photo_file_name,
				'coverOrientation' => $cover_orientation,
				'modifyByFacultyNum' => $facultyIDNum,
			);

			$this->db->set($data);
			$this->db->where("id", $lessonID);
			// $sql = $this->db->get_compiled_update("Lessons");
			// echo $sql;
			$result = $this->db->update('Lessons');
			return $result;
		}


		public function insert_lesson_update_summary($lessonID, $updateSummary, $facultyIDNum){
			
			$data = array(
				'lessonID' => $lessonID,
				'updateSummary' => $updateSummary,
				'updatedByFacultyNum' => $facultyIDNum,
			);

			$result = $this->db->insert('Lesson_update_summary', $data);
			return $result;
		}

		public function mark_lesson_as_deleted($lessonID){
			$this->db->set('isDeleted', 1);
			$this->db->where('id', $lessonID);
			$result = $this->db->update('Lessons');
			return $result;
		}

		public function mark_lesson_as_deleted_by_user($lessonID, $currentUserIDNum){
			$this->db->set('isDeleted', 1);
			$this->db->where(array(
							"id" => $lessonID,
							"addedByFacultyNum" => $currentUserIDNum
					));
			$result = $this->db->update('Lessons');
			return $result;
		}

		public function restore_deleted_lesson($lessonID){
			$this->db->set('isDeleted', 0);
			$this->db->where('id', $lessonID);
			$result = $this->db->update('Lessons');
			return $result;
		}

		public function select_all_lessons($facultyIDNum = ""){

			$this->db->select("Les.*, DATE_FORMAT(Les.dateAdded, '%M %d, %Y') As dateAddedFormated, 
								DATE_FORMAT(Les.dateModify, '%M %d, %Y') As dateModifyFormated, Chap.chapterTitle, Top.topic, Prin.principle,
								CONCAT(Fac.firstName, ' ', Fac.lastName) As AddedByUser");
			$this->db->order_by('Les.id', 'DESC');
			$this->db->from('Lessons As Les');
			$this->db->join('TopicChapters As Chap', 'Les.chapterID = Chap.id');
			$this->db->join('PrinciplesSubTopic As Top', 'Chap.topicID = Top.id');
			$this->db->join('AgriPrinciples As Prin', 'Top.principleID = Prin.id');
			$this->db->join('Faculties As Fac', 'Fac.facultyIDNum=Les.addedByFacultyNum');
			$this->db->where(array(
							'Les.isDeleted' => 0,
							'Chap.isDeleted' => 0,
							'Top.isDeleted' => 0,
							'Prin.isDeleted' => 0
						));

			if ($facultyIDNum !== ""){
				$this->db->where(array("Les.addedByFacultyNum" => $facultyIDNum));
			}

			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_all_deleted_lessons($facultyIDNum = ""){

			$this->db->select("Les.*, DATE_FORMAT(Les.dateAdded, '%M %d, %Y') As dateAddedFormated, 
								DATE_FORMAT(Les.dateModify, '%M %d, %Y') As dateModifyFormated, Chap.chapterTitle, Top.topic, Prin.principle,
								CONCAT(Fac.firstName, ' ', Fac.lastName) As AddedByUser");
			$this->db->order_by('Les.id', 'DESC');
			$this->db->from('Lessons As Les');
			$this->db->join('TopicChapters As Chap', 'Les.chapterID = Chap.id');
			$this->db->join('PrinciplesSubTopic As Top', 'Chap.topicID = Top.id');
			$this->db->join('AgriPrinciples As Prin', 'Top.principleID = Prin.id');
			$this->db->join('Faculties As Fac', 'Fac.facultyIDNum=Les.addedByFacultyNum');
			$this->db->where("Les.isDeleted", 1);

			if ($facultyIDNum !== ""){
				$this->db->where(array("Les.addedByFacultyNum" => $facultyIDNum));
			}

			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_lessons($search_str){

			$this->db->select("Les.*, DATE_FORMAT(Les.dateAdded, '%M %d, %Y') As dateAddedFormated, 
								DATE_FORMAT(Les.dateModify, '%M %d, %Y') As dateModifyFormated, Chap.chapterTitle, Top.topic, Prin.principle,
								CONCAT(Fac.firstName, ' ', Fac.lastName) As AddedByUser");

			$this->db->order_by('Les.id', 'DESC');
			$this->db->from('Lessons As Les');
			$this->db->join('TopicChapters As Chap', 'Les.chapterID = Chap.id');
			$this->db->join('PrinciplesSubTopic As Top', 'Chap.topicID = Top.id');
			$this->db->join('AgriPrinciples As Prin', 'Top.principleID = Prin.id');
			$this->db->join('Faculties As Fac', 'Fac.facultyIDNum=Les.addedByFacultyNum');
			$this->db->where(array(
							'Les.isDeleted' => 0,
							'Chap.isDeleted' => 0,
							'Top.isDeleted' => 0,
							'Prin.isDeleted' => 0
						));
			$this->db->group_start();
			$this->db->like("Les.title", $search_str);
			$this->db->or_like("Les.content", $search_str);
			$this->db->group_end();

			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_deleted_lessons($search_str){

			$this->db->select("Les.*, DATE_FORMAT(Les.dateAdded, '%M %d, %Y') As dateAddedFormated, 
								DATE_FORMAT(Les.dateModify, '%M %d, %Y') As dateModifyFormated, Chap.chapterTitle, Top.topic, Prin.principle,
								CONCAT(Fac.firstName, ' ', Fac.lastName) As AddedByUser");

			$this->db->order_by('Les.id', 'DESC');
			$this->db->from('Lessons As Les');
			$this->db->join('TopicChapters As Chap', 'Les.chapterID = Chap.id');
			$this->db->join('PrinciplesSubTopic As Top', 'Chap.topicID = Top.id');
			$this->db->join('AgriPrinciples As Prin', 'Top.principleID = Prin.id');
			$this->db->join('Faculties As Fac', 'Fac.facultyIDNum=Les.addedByFacultyNum');
			$this->db->where("Les.isDeleted", 1);
			$this->db->group_start();
			$this->db->like("Les.title", $search_str);
			// $this->db->or_like("Les.content", $search_str);
			$this->db->group_end();

			$results = $this->db->get();
			return $results->result_array();
		}

		public function advance_select_lessons($principleID=0, $topicID=0, $chapterID=0, $lesson_title="", $faculty_id_number="", $startDate="", $endDate=""){

			// echo "principleID " . $principleID . " -- ";
			// echo "topicID " . $topicID . " -- ";
			// echo "chapterID " . $chapterID . " -- ";
			// echo "lesson_title " . $lesson_title . " -- ";
			// echo "faculty_id_number " . $faculty_id_number . " -- ";
			// echo "startDate " . $startDate . " -- ";
			// echo "endDate " . $endDate . " -- ";

			$this->db->select("Les.*, DATE_FORMAT(Les.dateAdded, '%M %d, %Y') As dateAddedFormated, 
								DATE_FORMAT(Les.dateModify, '%M %d, %Y') As dateModifyFormated, Chap.chapterTitle, Top.topic, Prin.principle,
								CONCAT(Fac.firstName, ' ', Fac.lastName) As AddedByUser");

			$this->db->order_by('Les.id', 'DESC');
			$this->db->from('Lessons As Les');
			$this->db->join('TopicChapters As Chap', 'Les.chapterID = Chap.id');
			$this->db->join('PrinciplesSubTopic As Top', 'Chap.topicID = Top.id');
			$this->db->join('AgriPrinciples As Prin', 'Top.principleID = Prin.id');
			$this->db->join('Faculties As Fac', 'Fac.facultyIDNum=Les.addedByFacultyNum');
			$this->db->where(array(
							'Les.isDeleted' => 0,
							'Chap.isDeleted' => 0,
							'Top.isDeleted' => 0,
							'Prin.isDeleted' => 0
						));
			$this->db->group_start();

			if ($principleID > 0){
				$this->db->where("Prin.id", $principleID);
			}

			if ($topicID > 0){
				$this->db->where("Top.id", $topicID);
			}

			if ($chapterID > 0){
				$this->db->where("Chap.id", $chapterID);
			}

			if ($faculty_id_number != ""){
				$this->db->where("Les.addedByFacultyNum", $faculty_id_number);
			}

			if ($startDate != "" && $endDate != ""){
				$this->db->where("Les.dateAdded BETWEEN '". $startDate ."' AND '". $endDate ."'");
			}

				
			if ($lesson_title != ""){
				$this->db->group_start();
				$this->db->like("Les.title", $lesson_title);
				$this->db->group_end();
			}
			
			$this->db->group_end();

			// $sql = $this->db->get_compiled_select();
			// echo $sql;
			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_lesson_actual_data_by_id($lessonID){

			$this->db->select("Les.*, Chap.id As ChapID, Top.id As TopID, Prin.id As PrinID");
			$this->db->from('Lessons As Les');
			$this->db->join('TopicChapters As Chap', 'Les.chapterID = Chap.id');
			$this->db->join('PrinciplesSubTopic As Top', 'Chap.topicID = Top.id');
			$this->db->join('AgriPrinciples As Prin', 'Top.principleID = Prin.id');
			$this->db->where(array(
						'Les.isDeleted' => 0,
						'Chap.isDeleted' => 0,
						'Top.isDeleted' => 0,
						'Prin.isDeleted' => 0,
						'Les.id' => $lessonID
					));

			// $sql = $this->db->get_compiled_select();
			// echo $sql;
			$results = $this->db->get();
			return $results->result_array();
		}


		public function select_deleted_lesson_actual_data_by_id($lessonID){

			$this->db->select("Les.*, Chap.id As ChapID, Top.id As TopID, Prin.id As PrinID");
			$this->db->from('Lessons As Les');
			$this->db->join('TopicChapters As Chap', 'Les.chapterID = Chap.id');
			$this->db->join('PrinciplesSubTopic As Top', 'Chap.topicID = Top.id');
			$this->db->join('AgriPrinciples As Prin', 'Top.principleID = Prin.id');
			$this->db->where(array(
						'Les.isDeleted' => 1,
						'Les.id' => $lessonID
					));

			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_lesson_by_id($lessonID){

			$this->db->select("Les.*, DATE_FORMAT(Les.dateAdded, '%M %d, %Y') As dateAddedFormated, 
								DATE_FORMAT(Les.dateModify, '%M %d, %Y') As dateModifyFormated, Chap.chapterTitle, Top.topic, Prin.principle,
								CONCAT(Fac.firstName, ' ', Fac.lastName) As AddedByUser");

			$this->db->order_by('Les.id', 'DESC');
			$this->db->from('Lessons As Les');
			$this->db->join('TopicChapters As Chap', 'Les.chapterID = Chap.id');
			$this->db->join('PrinciplesSubTopic As Top', 'Chap.topicID = Top.id');
			$this->db->join('AgriPrinciples As Prin', 'Top.principleID = Prin.id');
			$this->db->join('Faculties As Fac', 'Fac.facultyIDNum=Les.addedByFacultyNum');
			$this->db->where(array(
							'Les.isDeleted' => 0,
							'Chap.isDeleted' => 0,
							'Top.isDeleted' => 0,
							'Prin.isDeleted' => 0,
							'Les.id' => $lessonID
						));

			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_lesson_by_chapter_id($chapterID){

			$this->db->select("Les.*, DATE_FORMAT(Les.dateAdded, '%M %d, %Y') As dateAddedFormated, 
								DATE_FORMAT(Les.dateModify, '%M %d, %Y') As dateModifyFormated, Chap.chapterTitle, Top.topic, Prin.principle,
								CONCAT(Fac.firstName, ' ', Fac.lastName) As AddedByUser");

			$this->db->order_by('Les.id', 'DESC');
			$this->db->from('Lessons As Les');
			$this->db->join('TopicChapters As Chap', 'Les.chapterID = Chap.id');
			$this->db->join('PrinciplesSubTopic As Top', 'Chap.topicID = Top.id');
			$this->db->join('AgriPrinciples As Prin', 'Top.principleID = Prin.id');
			$this->db->join('Faculties As Fac', 'Fac.facultyIDNum=Les.addedByFacultyNum');
			$this->db->where(array(
							'Les.isDeleted' => 0,
							'Chap.isDeleted' => 0,
							'Top.isDeleted' => 0,
							'Prin.isDeleted' => 0,
							'Chap.id' => $chapterID
						));

			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_lesson_update_summary($lessonID){

			$this->db->select("LUS.id, LUS.lessonID, LUS.updateSummary, LUS.updatedByFacultyNum, DATE_FORMAT(LUS.dateUpdated, '%M %d, %Y %r') As dateUpdatedFormatted, 
								CONCAT(FAC.firstName,' ', FAC.lastName) As UpdatedBy");
			$this->db->from("Lesson_update_summary As LUS");
			$this->db->join("Faculties As FAC", "FAC.facultyIDNum=LUS.updatedByFacultyNum");
			$this->db->where("LUS.lessonID", $lessonID);

			$results = $this->db->get();
			return $results->result_array();
		}

		public function insert_audit_trail_new_entry($actionDone, $affectedModule, $responsibleFacultyNum){

			$data = array(
				'actionDone' => $actionDone,
				'affectedModule' => $affectedModule,
				'responsibleFacultyNum' => $responsibleFacultyNum
			);

			$result = $this->db->insert('AuditTrail', $data);
			return $result;
		}


		public function select_all_audit_trail(){

			$this->db->select("Audit.id, Audit.actionDone, Audit.affectedModule, CONCAT(Facu.firstName, ' ', Facu.lastName) As DoneBy, DATE_FORMAT(Audit.actionDate, '%M %d, %Y %r') As dateTrans");
			$this->db->from("AuditTrail As Audit, Faculties As Facu");
			$this->db->where("Audit.responsibleFacultyNum=Facu.facultyIDNum");
			$this->db->order_by("Audit.id", "DESC");
			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_audit_trail($affectedModule="", $startDate="", $endDate=""){

			$this->db->select("Audit.id, Audit.actionDone, Audit.affectedModule, CONCAT(Facu.firstName, ' ', Facu.lastName) As DoneBy, DATE_FORMAT(Audit.actionDate, '%M %d, %Y %r') As dateTrans");
			$this->db->from("AuditTrail As Audit, Faculties As Facu");
			$this->db->where("Audit.responsibleFacultyNum=Facu.facultyIDNum");

			if ($affectedModule != "" && $startDate != "" && $endDate != ""){

				$this->db->where("Audit.affectedModule",$affectedModule);
				$this->db->where("Audit.actionDate BETWEEN '". $startDate ."' AND '". $endDate ."'");

			}else if ($affectedModule != "" && $startDate == "" && $endDate == ""){

				$this->db->where("Audit.affectedModule",$affectedModule);

			}else if ($affectedModule == "" && $startDate != "" && $endDate != ""){

				$this->db->where("Audit.actionDate BETWEEN '". $startDate ."' AND '". $endDate ."'");
				
			}

			$this->db->order_by("Audit.id", "DESC");
			$results = $this->db->get();
			return $results->result_array();
		}
	}

?>