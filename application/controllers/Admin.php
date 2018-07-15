<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Admin extends CI_Controller{

		public function login_page(){

			if ($this->is_admin_still_logged_in() === TRUE){
				redirect('/admin_main_panel');
			}

			$data['page_title'] = "Admin login";
			$data['page_code'] = "login";

			$this->load->view("admin/header", $data);
			$this->load->view("admin/login");
			$this->load->view("admin/footer");
		}

		public function is_admin_still_logged_in(){
			if (
				$this->session->has_userdata('admin_session_email') &&
				$this->session->has_userdata('admin_logged_in') &&
				($this->session->userdata('admin_logged_in') == TRUE)
				){

				return TRUE;
			}
			
			return FALSE;
		}

		public function get_actual_user_type($userType){
			if ($userType == "admin_faculty"){
				return "Admin";
			}else if ($userType == "dean"){
				return "Dean";
			}else if ($userType == "dean_admin_faculty"){
				return "Root user";
			}else if($userType == "faculty"){
				return "Faculty";
			}else{
				return "Faculty";
			}
		}

		public function get_user_type(){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$isAdmin = $this->session->userdata('admin_session_isAdmin');
			$isDean = $this->session->userdata('admin_session_isDean');

			if ($isAdmin == 1 && $isDean == 0){
				return 'admin_faculty';
			}else if ($isAdmin == 0 && $isDean == 1){
				return 'dean';
			}else if ($isAdmin == 1 && $isDean == 1){
				return 'dean_admin_faculty';
			}else if ($isAdmin == 0 && $isDean == 0){
				return 'faculty';
			}else{
				return 'faculty';
			}

		}

		public function destroy_admin_session(){

			$sessions = array(
				'admin_session_faculty_id',
				'admin_session_facultyNum',
				'admin_session_firstName',
				'admin_session_lastName',
				'admin_session_email',
				'admin_session_isAdmin',
				'admin_session_isDean',
				'admin_logged_in'
			);

			$this->session->unset_userdata($sessions);

			redirect('admin_login_page');
		}

		public function login(){

			$is_done = array(
					"done" => "FALSE",
					"msg" => ""
				);

			$facNum = $this->input->post('facNum');
			$password = $this->input->post('password');

			$data = array(
				"facNum" => $facNum,
				"password" => $password
			);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("facNum", "Faculty Number", "trim|required|max_length[8]|min_length[8]");
			$this->form_validation->set_rules("password", "Password", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors()
				);
			}else{
				$hashPass = hashSHA512($password);

				$results = $this->admin_mod->login($data['facNum'], $hashPass);

				if (sizeof($results) > 0){
					if ($results['id'] > 0 && $results['facultyIDNum'] != ""){

						$std_session_data = array(
							'admin_session_faculty_id' => $results['id'],
							'admin_session_facultyNum' => $results['facultyIDNum'],
							'admin_session_firstName' => $results['firstName'],
							'admin_session_lastName' => $results['lastName'],
							'admin_session_email' => $results['email'],
							'admin_session_isAdmin' => $results['isAdmin'],
							'admin_session_isDean' => $results['isDean'],
							'admin_logged_in' => TRUE
						);

						$this->session->set_userdata($std_session_data);

						$is_done = array(
							"done" => "TRUE",
							"msg" => "Successfully Logged in"
						);

					}else{
						$is_done = array(
							"done" => "FALSE",
							"msg" => "Login failed"
						);
					}
				}else{
					$is_done = array(
						"done" => "FALSE",
						"msg" => "Login failed"
					);
				}
			}

			// print_r($is_done);
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}

		##
		##
		## // PAGES:
		##
		##

		
		public function main_panel(){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;

			$data['session_data'] = $this->session->userdata();
			$data['page_title'] = "Admin Main Panel";
			$data['page_code'] = "main_panel";

			// $this->load->library('pagination');

			// $config['base_url'] = base_url("admin_agriculture_principles");
			// $config['total_rows'] = 200;
			// $config['per_page'] = 20;

			// $this->pagination->initialize($config);

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div.php");
			$this->load->view("admin/topbar");
			
			$this->load->view("admin/main_panel");
			$this->load->view("admin/footer");
		}

		public function agriculture_principles($principleID = 0){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}
			
			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;

			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			$data['principleID'] = 0;

			if (is_numeric($principleID) && $principleID > 0 && $principleID != 0){

				$principle_data = $this->admin_mod->select_principle_by_id($principleID);

				if (sizeof($principle_data) == 0){
					show_404();
				}

				$data['principle_to_update_data'] = $principle_data;
				$data['principleID'] = $principleID;
			}
			
			$data['session_data'] = $this->session->userdata();

			$data['page_title'] = "Admin - Principles";
			$data['page_code'] = "principle_panel";

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div.php");
			$this->load->view("admin/topbar");
			$this->load->view("admin/principles");
			$this->load->view("admin/footer");

		}

		public function principles_sub_topics($topicID = 0){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;

			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			if (is_numeric($topicID) && $topicID > 0 && $topicID != 0){

				$topic_data = $this->admin_mod->select_principles_sub_topic_by_topic_id($topicID);

				if (sizeof($topic_data) == 0){
					show_404();
				}

				$data['topic_to_update_data'] = $topic_data;
				$data['topicID'] = $topicID;
				$data['principleID'] = $topic_data['principleID'];
			}

			$data['session_data'] = $this->session->userdata();

			$data['page_title'] = "Admin Principles Sub Topics";
			$data['page_code'] = "principle_sub_topic_panel";

			$data['principles'] = $this->admin_mod->select_all_principles();

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div.php");
			$this->load->view("admin/topbar");
			$this->load->view("admin/sub_topics");
			$this->load->view("admin/footer");
		}

		public function sub_topic_chapters($chapterID = 0){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;
			
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			if (is_numeric($chapterID) && $chapterID > 0 && $chapterID != 0){

				$chapter_data = $this->admin_mod->select_chapter_by_id($chapterID);

				if (sizeof($chapter_data) == 0){
					show_404();
				}

				$data['chapter_to_update_data'] = $chapter_data;
				$data['chapterID'] = $chapterID;
				$data['topicID'] = $chapter_data['topicID'];
				$data['principleID'] = $chapter_data['principleID'];
			}
			
			$data['session_data'] = $this->session->userdata();

			$data['page_title'] = "Admin Sub Topics Chapters";
			$data['page_code'] = "sub_topic_chapters_panel";

			$data['principles'] = $this->admin_mod->select_all_principles();

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div.php");
			$this->load->view("admin/topbar");
			$this->load->view("admin/chapters");
			$this->load->view("admin/footer");
		}


		public function chapters_lessons(){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;
			
			$data['session_data'] = $this->session->userdata();

			$data['page_title'] = "Admin Chapters-Lessons";
			$data['page_code'] = "chapters_lessons_panel";

			$data['principles'] = $this->admin_mod->select_all_principles();

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div.php");
			$this->load->view("admin/topbar");
			$this->load->view("admin/lessons");
			$this->load->view("admin/footer");
		}

		public function faculty_list($facultyID=0){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;
			
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			if (is_numeric($facultyID) && $facultyID > 0 && $facultyID != 0){

				$faculty_data = $this->admin_mod->select_faculty_by_id($facultyID);
				$admin_data = $this->admin_mod->select_faculty_by_id_num($faculty_data['addedByAdminFacultyNum']);

				if (sizeof($faculty_data) == 0){
					show_404();
				}

				$data['faculty_to_update_data'] = $faculty_data;
				$data['admin_data'] = $admin_data;
				$data['facultyID'] = $facultyID;
			}

			$data['session_data'] = $this->session->userdata();

			$data['page_title'] = "Admin Faculies";
			$data['page_code'] = "faculty_list_panel";

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div.php");
			$this->load->view("admin/topbar");
			$this->load->view("admin/faculties");
			$this->load->view("admin/footer");
		}

		public function students_list($studentID=0){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;
			
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			if (is_numeric($studentID) && $studentID > 0 && $studentID != 0){

				$student_data = $this->admin_mod->select_std_by_id($studentID);

				if (sizeof($student_data) == 0){
					show_404();
				}

				$data['student_to_update_data'] = $student_data;
				$data['studentID'] = $studentID;
			}

			$data['session_data'] = $this->session->userdata();

			$data['page_title'] = "Admin Faculies";
			$data['page_code'] = "students_list_panel";

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div.php");
			$this->load->view("admin/topbar");
			$this->load->view("admin/students");
			$this->load->view("admin/footer");
		}


		public function add_lessons(){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			// Needs inside sidebar
			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;

			$data['page_title'] = "Admin Add Lessons";
			$data['page_code'] = "add_lessons";

			$data['principles'] = $this->admin_mod->select_all_principles();

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div.php");
			$this->load->view("admin/topbar");
			$this->load->view("admin/add_lesson");
			$this->load->view("admin/footer");
		}

		##
		##
		## // ACTIONS:
		##
		##

		## Faculty

		public function add_faculty(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}


			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$data = array(
				"faculty_id_num" => $this->input->post('faculty_id_num'),
				"email" => $this->input->post('email'),
				"lastname" => $this->input->post('lastname'),
				"firstname" => $this->input->post('firstname'),
				"password" => $this->input->post('password'),
				"confirm_pass" => $this->input->post('confirm_pass'),
				"facultyIDNum" => $facultyIDNum,
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			//is_unique[Faculties.facultyIDNum]|
			// array('is_unique' => 'This %s already exists.')
			$this->form_validation->set_rules("faculty_id_num", "Faculty ID number", "trim|required|is_natural|callback_check_id_number_already_used_on_insert");
			//|is_unique[Faculties.email]
			// array('is_unique' => 'This %s already exists.')
			$this->form_validation->set_rules("email", "Email", "trim|required|valid_email|callback_check_email_already_used_on_insert");
			$this->form_validation->set_rules("lastname", "Faculty Lastname", "trim|required");
			$this->form_validation->set_rules("firstname", "Faculty Firstname", "trim|required");
			$this->form_validation->set_rules("password", "Password", "trim|required"); 
			$this->form_validation->set_rules("confirm_pass", "Password Confirmation", "trim|required|matches[password]");
			$this->form_validation->set_rules("facultyIDNum", "Admin faculty id number", "trim|required"); 

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{

				$hashPass = hashSHA512($data['password']);
				
				if ($this->admin_mod->insert_new_faculty($data, $hashPass) == 1){
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Inserted Successfully"
					);
				}

			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function update_faculty(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$data = array(
				"facultyID" => $this->input->post('facultyID'),
				"faculty_id_num" => $this->input->post('faculty_id_num'),
				"email" => $this->input->post('email'),
				"lastname" => $this->input->post('lastname'),
				"firstname" => $this->input->post('firstname'),
				"facultyIDNum" => $facultyIDNum,
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);

			$this->form_validation->set_rules("facultyID", "faculty ID", "trim|required"); 
			$this->form_validation->set_rules("faculty_id_num", "Faculty ID number", "trim|required|is_natural|callback_check_id_number_already_used_on_update");
			$this->form_validation->set_rules("email", "email", "trim|required|valid_email|callback_check_email_already_used_on_update");
			$this->form_validation->set_rules("lastname", "Faculty Lastname", "trim|required");
			$this->form_validation->set_rules("firstname", "Faculty Firstname", "trim|required");
			$this->form_validation->set_rules("facultyIDNum", "Admin faculty id number", "trim|required"); 


			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{

				$pswd = $this->input->post('password');
				$pswd_conf = $this->input->post('confirm_pass');

				if ($pswd != ""){

					$pass = array(
						"password" => $pswd,
						"confirm_pass" => $pswd_conf
					);

					$pass = $this->security->xss_clean($pass);
					$this->form_validation->set_data($pass);

					$this->form_validation->set_rules("password", "Password", "trim|required"); 
					$this->form_validation->set_rules("confirm_pass", "Password Confirmation", "trim|required|matches[password]");

					if ($this->form_validation->run() === FALSE){
						$is_done = array(
							"done" => "FALSE",
							"msg" => validation_errors('<span>', '</span>')
						);
					}else{
						$hashPass = hashSHA512($pass['password']);

						if ($this->admin_mod->update_faculty_with_pass($data['facultyID'], $data, $hashPass) == 1){
							$is_done = array(
								"done" => "TRUE",
								"msg" => "Updated Successfully with password"
							);
						}
					}
					
				}else{
					if ($this->admin_mod->update_faculty_without_pass($data['facultyID'], $data) == 1){
						$is_done = array(
							"done" => "TRUE",
							"msg" => "Updated Successfully"
						);
					}
				}
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function delete_faculty_data(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			// $facultyIDNum = $this->session->userdata('admin_session_facultyNum'); // it can be use in audit trail later

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$facultyID = $this->input->post('facultyID');

			$data = array(
				"facultyID" => $facultyID
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("facultyID", "Faculty ID", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{
					
				if ($this->admin_mod->mark_faculty_data_as_deleted($data['facultyID']) == 1){
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Successfully Deleted"
					);
				}
			}
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function mark_faculty_as_admin_or_dean(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			// $facultyIDNum = $this->session->userdata('admin_session_facultyNum'); // it can be use in audit trail later

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$facultyID = $this->input->post('facultyID');
			$status = $this->input->post('status');
			$mark_as = $this->input->post('mark_as');

			$data = array(
				"facultyID" => $facultyID,
				"status" => $status,
				"mark_as" => $mark_as
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("facultyID", "Faculty ID", "trim|required");
			$this->form_validation->set_rules("status", "Status", "trim|required");
			$this->form_validation->set_rules("mark_as", "Mark as", "trim|required");

			if ($this->form_validation->run() === TRUE){

				if ($this->admin_mod->mark_faculty_as_admin_or_dean($data['facultyID'], $data['status'], $data['mark_as']) == 1){
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Successfully changed mark ".$data['mark_as']." status"
					);
				}
			}else{
				$is_done = array(
					"done" => "FALSE",
					"msg" => ""
				);
			}
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}

		public function check_id_number_already_used_on_update($facultyIDNum){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}
			
			$facultyID = $this->input->post('facultyID');
			$faculty_data = $this->admin_mod->select_faculty_by_id_and_id_number($facultyID, $facultyIDNum);

			if (sizeof($faculty_data) > 0){
				$this->form_validation->set_message('check_id_number_already_used_on_update', 'The {field} already used.');
				return FALSE;
			}

			return TRUE;
		}


		public function check_id_number_already_used_on_insert($facultyIDNum){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}
			
			$faculty_data = $this->admin_mod->select_faculty_by_id_and_id_number(0, $facultyIDNum);

			if (sizeof($faculty_data) > 0){
				$this->form_validation->set_message('check_id_number_already_used_on_insert', 'Invalid {field}, the {field} already used.');
				return FALSE;
			}

			return TRUE;
		}

		public function check_email_already_used_on_update($email){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}
			
			$facultyID = $this->input->post('facultyID');
			$faculty_data = $this->admin_mod->select_faculty_by_id_and_email($facultyID, $email);

			if (sizeof($faculty_data) > 0){
				$this->form_validation->set_message('check_email_already_used_on_update', 'The {field} already used.');
				return FALSE;
			}

			return TRUE;
		}


		public function check_email_already_used_on_insert($email){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}
			
			$faculty_data = $this->admin_mod->select_faculty_by_id_and_email(0, $email);

			if (sizeof($faculty_data) > 0){
				$this->form_validation->set_message('check_email_already_used_on_insert', 'Invalid {field}, the {field} already used.');
				return FALSE;
			}

			return TRUE;
		}

		public function get_all_faculties(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			$faculties = $this->admin_mod->select_all_faculties();
			// print_r($faculties);

			$facultyLen = sizeof($faculties);
			for($i=0; $i<$facultyLen; $i++){
				$admin_data = $this->admin_mod->select_faculty_by_id_num($faculties[$i]['addedByAdminFacultyNum']);

				if (sizeof($admin_data) > 0){
					$faculties[$i]['addedBy'] = $admin_data['firstName'] ." ". $admin_data['lastName'];
				}
				
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($faculties));
		}


		public function search_faculty(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			$searchStr = $this->input->post('searchStr');

			$data = array('search_string' => $searchStr);
			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("search_string", "Search string", "trim|required");

			$results = array();

			if ($this->form_validation->run() === TRUE){
				$results = $this->admin_mod->select_faculties($data['search_string']);
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($results));
		}

		public function get_faculty_by_id(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			$facultyID = $this->input->post('facultyID');

			$data = array('facultyID' => $facultyID);
			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("facultyID", "Faculty ID", "trim|required");

			$results = array();

			if ($this->form_validation->run() === TRUE){
				$results = $this->admin_mod->select_faculty_by_id($data['facultyID']);
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($results));
		}

		## Students -------------------------------------------------------------------------------------

		public function add_student(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}


			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			// $facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$data = array(
				"student_id_num" => $this->input->post('student_id_num'),
				"email" => $this->input->post('email'),
				"lastname" => $this->input->post('lastname'),
				"firstname" => $this->input->post('firstname'),
				"password" => $this->input->post('password'),
				"confirm_pass" => $this->input->post('confirm_pass')
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("student_id_num", "Student ID number", "trim|required|is_natural|callback_check_is_student_enrolled|callback_check_std_id_number_already_used_on_insert");
			$this->form_validation->set_rules("email", "Email", "trim|required|valid_email|callback_check_std_email_already_used_on_insert");
			$this->form_validation->set_rules("lastname", "Student Lastname", "trim|required");
			$this->form_validation->set_rules("firstname", "Student Firstname", "trim|required");
			$this->form_validation->set_rules("password", "Password", "trim|required"); 
			$this->form_validation->set_rules("confirm_pass", "Password Confirmation", "trim|required|matches[password]");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{

				$hashPass = hashSHA512($data['password']);
				
				if ($this->admin_mod->insert_new_student($data, $hashPass) == 1){
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Inserted Successfully"
					);
				}

			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function update_student(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}


			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			// $facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$data = array(
				"studentID" => $this->input->post("studentID"), 
				"student_id_num" => $this->input->post('student_id_num'),
				"email" => $this->input->post('email'),
				"lastname" => $this->input->post('lastname'),
				"firstname" => $this->input->post('firstname'),
				"password" => $this->input->post('password'),
				"confirm_pass" => $this->input->post('confirm_pass')
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("studentID", "Student ID", "trim|required");
			$this->form_validation->set_rules("student_id_num", "Student ID number", "trim|required|is_natural|callback_check_is_student_enrolled|callback_check_std_id_number_already_used_on_update");
			$this->form_validation->set_rules("email", "Email", "trim|required|valid_email|callback_check_std_email_already_used_on_update");
			$this->form_validation->set_rules("lastname", "Student Lastname", "trim|required");
			$this->form_validation->set_rules("firstname", "Student Firstname", "trim|required");
			
			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{

				$pswd = $this->input->post('password');
				$pswd_conf = $this->input->post('confirm_pass');

				if ($pswd != ""){

					$pass = array(
						"password" => $pswd,
						"confirm_pass" => $pswd_conf
					);

					$pass = $this->security->xss_clean($pass);
					$this->form_validation->set_data($pass);
					$this->form_validation->set_rules("password", "Password", "trim|required"); 
					$this->form_validation->set_rules("confirm_pass", "Password Confirmation", "trim|required|matches[password]");

					if ($this->form_validation->run() === FALSE){

						$is_done = array(
							"done" => "FALSE",
							"msg" => validation_errors('<span>', '</span>')
						);

					}else{

						$hashPass = hashSHA512($pass['password']);

						if ($this->admin_mod->update_student_with_pass($data['studentID'], $data, $hashPass) == 1){
							$is_done = array(
								"done" => "TRUE",
								"msg" => "Updated Successfully with password"
							);
						}
					}
					
				}else{
					if ($this->admin_mod->update_student_without_pass($data['studentID'], $data) == 1){
						$is_done = array(
							"done" => "TRUE",
							"msg" => "Updated Successfully"
						);
					}
				}

			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}

		public function check_is_student_enrolled($stdIDNum){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}
			
			$std_data = $this->admin_mod->select_std_num($stdIDNum);

			if (sizeof($std_data) == 0){
				$this->form_validation->set_message('check_is_student_enrolled', 'Invalid {field}, student number not exists in the master list.');
				return FALSE;
			}

			return TRUE;
		}

		public function validate_student_number(){

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$data = array("student_id_num" => $this->input->post('student_id_num'));

			$data = $this->security->xss_clean($data);
			$this->form_validation->set_data($data);

			$this->form_validation->set_rules("student_id_num", "Student ID number", "trim|required|is_natural|callback_check_is_student_enrolled");

			if ($this->form_validation->run() === FALSE){

				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);

			}else{

				$is_done = array(
					"done" => "TRUE",
					"msg" => "Student number is enrolled in the master list"
				);

			}
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}

		public function check_std_id_number_already_used_on_insert($stdIDNum){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}
			
			$std_data = $this->admin_mod->select_std_by_id_and_id_number(0, $stdIDNum);

			if (sizeof($std_data) > 0){
				$this->form_validation->set_message('check_std_id_number_already_used_on_insert', 'Invalid {field}, the {field} already used.');
				return FALSE;
			}

			return TRUE;
		}

		public function check_std_id_number_already_used_on_update($stdIDNum){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}
			
			$studentID = $this->input->post("studentID");

			$std_data = $this->admin_mod->select_std_by_id_and_id_number($studentID, $stdIDNum);

			if (sizeof($std_data) > 0){
				$this->form_validation->set_message('check_std_id_number_already_used_on_update', 'Invalid {field}, the {field} already used.');
				return FALSE;
			}

			return TRUE;
		}

		public function check_std_email_already_used_on_insert($email){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}
			
			$std_data = $this->admin_mod->select_std_by_id_and_email(0, $email);

			if (sizeof($std_data) > 0){
				$this->form_validation->set_message('check_std_email_already_used_on_insert', 'Invalid {field}, the {field} already used.');
				return FALSE;
			}

			return TRUE;
		}


		public function check_std_email_already_used_on_update($email){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}
			
			$studentID = $this->input->post("studentID");
			$std_data = $this->admin_mod->select_std_by_id_and_email($studentID, $email);

			if (sizeof($std_data) > 0){
				$this->form_validation->set_message('check_std_email_already_used_on_update', 'Invalid {field}, the {field} already used.');
				return FALSE;
			}

			return TRUE;
		}

		public function get_all_students(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			$students = $this->admin_mod->select_all_students();

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($students));
		}

		public function delete_student_data(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			// $facultyIDNum = $this->session->userdata('admin_session_facultyNum'); // it can be use in audit trail later

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$studentID = $this->input->post('studentID');

			$data = array(
				"studentID" => $studentID
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("studentID", "Student ID", "trim|required");

			if ($this->form_validation->run() === FALSE){

				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);

			}else{
					
				if ($this->admin_mod->mark_student_data_as_deleted($data['studentID']) == 1){
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Successfully Deleted"
					);
				}
			}
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function search_students(){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			$searchStr = $this->input->post('searchStr');

			$data = array('search_string' => $searchStr);
			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("search_string", "Search string", "trim|required");

			$results = array();

			if ($this->form_validation->run() === TRUE){
				$results = $this->admin_mod->select_students($data['search_string']);
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($results));
		}


		## Principles

		public function add_principle(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$principle = $this->input->post('principle');
			$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$data = array(
				"principle" => $principle,
				"facultyIDNum" => $facultyIDNum
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("principle", "Principle", "trim|required");
			$this->form_validation->set_rules("facultyIDNum", "Faculty ID Number", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{
				
				if ($this->admin_mod->insert_new_principle($data['principle'], $data['facultyIDNum']) == 1){
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Inserted Successfully"
					);
				}
			}

			// print_r($is_done);
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));

		}

		public function get_all_principles(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$principles = $this->admin_mod->select_all_principles();
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($principles));
		}

		public function search_principles(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$searchStr = $this->input->post('searchStr');

			$data = array('search_string' => $searchStr);
			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("search_string", "Search string", "trim|required");

			$results = array();

			if ($this->form_validation->run() === TRUE){
				$results = $this->admin_mod->search_principle($data['search_string']);
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($results));
		}

		public function delete_principle(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}


			// $facultyIDNum = $this->session->userdata('admin_session_facultyNum'); // it can be use in audit trail later

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$principleID = $this->input->post('principleID');

			$data = array(
				"principleID" => $principleID
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("principleID", "Principle ID", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{
					
				if ($this->admin_mod->mark_principle_as_deleted($data['principleID']) == 1){
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Successfully Deleted"
					);
				}
			}

			// print_r($is_done);
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function update_principle(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}


			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$principleID = $this->input->post('principleID');
			$principle = $this->input->post('principle');
			$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$data = array(
				"principleID" => $principleID,
				"principle" => $principle,
				"facultyIDNum" => $facultyIDNum
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("principleID", "Principle ID", "trim|required");
			$this->form_validation->set_rules("principle", "Principle", "trim|required");
			$this->form_validation->set_rules("facultyIDNum", "Faculty ID Number", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{
				
				if ($this->admin_mod->update_principle($data['principleID'], $data['principle'], $data['facultyIDNum']) == 1){
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Updated Successfully"
					);
				}
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));

		}


		## Sub topics


		public function add_principle_sub_topic(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}


			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$principleID = $this->input->post('principleID');
			$sub_topic = $this->input->post('sub_topic');
			$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$data = array(
				"principleID" => $principleID,
				"sub_topic" => $sub_topic,
				"facultyIDNum" => $facultyIDNum,
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("principleID", "Principle ID", "trim|required");
			$this->form_validation->set_rules("sub_topic", "Sub topic", "trim|required");
			$this->form_validation->set_rules("facultyIDNum", "Faculty ID Number", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{
				
				if ($this->admin_mod->insert_new_principle_sub_topic($data['principleID'], $data['sub_topic'], $data['facultyIDNum']) == 1){
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Inserted Successfully"
					);
				}
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));

		}


		public function update_principle_sub_topic(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}


			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$topicID = $this->input->post('topicID');
			$principleID = $this->input->post('principleID');
			$sub_topic = $this->input->post('sub_topic');
			$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$data = array(
				"topicID" => $topicID,
				"principleID" => $principleID,
				"sub_topic" => $sub_topic,
				"facultyIDNum" => $facultyIDNum,
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("topicID", "Topic ID", "trim|required");
			$this->form_validation->set_rules("principleID", "Principle ID", "trim|required");
			$this->form_validation->set_rules("sub_topic", "Sub topic", "trim|required");
			$this->form_validation->set_rules("facultyIDNum", "Faculty ID Number", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{
				
				if ($this->admin_mod->update_principle_sub_topic($data['topicID'], $data['principleID'], $data['sub_topic'], $data['facultyIDNum']) == 1){
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Update Successfully"
					);
				}
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));

		}

		public function get_all_principles_sub_topics(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$principles = $this->admin_mod->select_all_principles_sub_topics();
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($principles));
		}

		public function get_principles_sub_topics_by_principle(){
	
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$principleID = $this->input->post('principleID');

			$data = array('principleID' => $principleID);
			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("principleID", "Principle ID", "trim|required");

			$results = array();

			if ($this->form_validation->run() === TRUE){
				$results = $this->admin_mod->select_principles_sub_topic_by_principle_id($data['principleID']);
			}
			// print_r($results);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($results));
		}

		public function search_principles_sub_topics(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$searchStr = $this->input->post('searchStr');

			$data = array('search_string' => $searchStr);
			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("search_string", "Search string", "trim|required");

			$results = array();

			if ($this->form_validation->run() === TRUE){
				$results = $this->admin_mod->search_principle_sub_topics($data['search_string']);
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($results));
		}

		public function delete_principle_sub_topic(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}


			// $facultyIDNum = $this->session->userdata('admin_session_facultyNum'); // it can be use in audit trail later

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$topicID = $this->input->post('topicID');

			$data = array(
				"topicID" => $topicID
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("topicID", "Topic ID", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{
					
				if ($this->admin_mod->mark_principle_sub_topic_as_deleted($data['topicID']) == 1){
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Successfully Deleted"
					);
				}
			}
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function add_topic_new_chapter(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}


			// $facultyIDNum = $this->session->userdata('admin_session_facultyNum'); // it can be use in audit trail later

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$principleID = $this->input->post('principleID');
			$topicID = $this->input->post('topicID');
			$chapterTitle = $this->input->post('chapterTitle');
			$facultyIDNum = $this->session->userdata('admin_session_facultyNum'); 

			$data = array(
				"principleID" => $principleID,
				"topicID" => $topicID,
				"chapterTitle" => $chapterTitle,
				"addedByFacultyNum" => $facultyIDNum
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("principleID", "Principle ID", "trim|required");
			$this->form_validation->set_rules("topicID", "Topic ID", "trim|required");
			$this->form_validation->set_rules("chapterTitle", "Chapter Title", "trim|required");
			$this->form_validation->set_rules("addedByFacultyNum", "Faculty ID number", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{
					
				if ($this->admin_mod->insert_new_topic_chapter($data['principleID'], $data['topicID'], $data['chapterTitle'], $data['addedByFacultyNum']) == 1){
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Successfully Inserted"
					);
				}
			}
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}

		public function get_all_topics_chapters(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$chapters = $this->admin_mod->select_all_topics_chapters();
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($chapters));
		}

		public function search_topics_chapters(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$search_str = $this->input->post('search_str');

			$data = array(
				"search_str" => $search_str
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("search_str", "Search string", "trim|required");

			$chapters = array();

			if ($this->form_validation->run() === TRUE){
				$chapters = $this->admin_mod->search_chapter($data['search_str']);
			}
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($chapters));
		}

		public function get_chapter_by_id(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$chapterID = $this->input->post('chapterID');

			$data = array(
				"chapterID" => $chapterID
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("chapterID", "Chapter ID", "trim|required");

			$chapters = array();

			if ($this->form_validation->run() === TRUE){
				$chapters = $this->admin_mod->select_chapter_by_id($data['chapterID']);
			}
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($chapters));
		}


		public function get_all_chapters_by_topic_id(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$topicID = $this->input->post('topicID');

			$data = array(
				"topicID" => $topicID
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("topicID", "Topic ID", "trim|required");

			$chapters = array();

			if ($this->form_validation->run() === TRUE){
				$chapters = $this->admin_mod->select_all_topics_chapters_topic_id($data['topicID']);
			}
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($chapters));
		}


		public function update_topic_chapter(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}


			// $facultyIDNum = $this->session->userdata('admin_session_facultyNum'); // it can be use in audit trail later

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$chapterID = $this->input->post('chapterID');
			$principleID = $this->input->post('principleID');
			$topicID = $this->input->post('topicID');
			$chapterTitle = $this->input->post('chapterTitle');
			$facultyIDNum = $this->session->userdata('admin_session_facultyNum'); 

			$data = array(
				"chapterID" => $chapterID,
				"principleID" => $principleID,
				"topicID" => $topicID,
				"chapterTitle" => $chapterTitle,
				"addedByFacultyNum" => $facultyIDNum
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("chapterID", "Chapter ID", "trim|required");
			$this->form_validation->set_rules("principleID", "Principle ID", "trim|required");
			$this->form_validation->set_rules("topicID", "Topic ID", "trim|required");
			$this->form_validation->set_rules("chapterTitle", "Chapter Title", "trim|required");
			$this->form_validation->set_rules("addedByFacultyNum", "Faculty ID number", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{
					
				if ($this->admin_mod->update_topic_chapter($data['chapterID'], $data['principleID'], $data['topicID'], $data['chapterTitle'], $data['addedByFacultyNum']) == 1){
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Update Successfully"
					);
				}
			}
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function delete_topic_chapter(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			// $facultyIDNum = $this->session->userdata('admin_session_facultyNum'); // it can be use in audit trail later

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$chapterID = $this->input->post('chapterID');

			$data = array(
				"chapterID" => $chapterID
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("chapterID", "Chapter ID", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{
					
				if ($this->admin_mod->mark_topic_chapter_as_deleted($data['chapterID']) == 1){
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Successfully Deleted"
					);
				}
			}
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}

		public function upload_file($config, $field_name){

			$this->load->library('upload', $config);

			$results = array();

            if ( ! $this->upload->do_upload($field_name))
            {
            	$results['is_upload_done'] = "FALSE";
                $results['results'] = array('error' => $this->upload->display_errors());
            }
            else
            {
            	$results['is_upload_done'] = "TRUE";
                $results['results'] = array('upload_data' => $this->upload->data());
            }

            return $results;
		}

		public function upload_lessons_img(){
			$config['upload_path']          = './uploads/lessons/content';
            $config['allowed_types']        = 'gif|jpg|jpeg|png';
            $config['max_size']             = 20000;
            $config['max_width']            = 1024;
            $config['max_height']           = 768;
            $config['file_ext_tolower']     = TRUE;
            $config['encrypt_name']     	= TRUE;

            $results = $this->upload_file($config, "upload_file");

            $this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($results));
		}


		public function add_new_lesson(){
			// print_r($_POST);
			// print_r($_FILES);			
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}


			$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$chapter_id = $this->input->post("chapter_id");
			$lesson_title = $this->input->post("lesson_title");
			$cover_photo_len = $this->input->post("cover_photo_len");
			$cover_photo_orientation = $this->input->post("cover_photo_orientation");
			$lesson_content = $this->input->post("lesson_content");

			$data = array(
				"chapter_id" => $chapter_id,
				"lesson_title" => $lesson_title,
				"cover_photo_len" => $cover_photo_len,
				"cover_photo_orientation" => $cover_photo_orientation,
				"lesson_content" => $lesson_content,
				"faculty_id_num" => $facultyIDNum
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("chapter_id", "Chapter ID", "trim|required");
			$this->form_validation->set_rules("lesson_title", "Lesson title", "trim|required|min_length[5]");
			$this->form_validation->set_rules("lesson_content", "Lesson Content", "trim|required");
			$this->form_validation->set_rules("cover_photo_len", "Cover photo len", "trim|required");
			$this->form_validation->set_rules("faculty_id_num", "Faculty Id number", "trim|required");

			if ($cover_photo_len > 0){
				$this->form_validation->set_rules("cover_photo_orientation", "Cover photo orientation", "trim|required");
			}

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{
				

				if ($cover_photo_len > 0){

					$config['upload_path']          = './uploads/lessons/cover';
		            $config['allowed_types']        = 'gif|jpg|jpeg|png';
		            $config['max_size']             = 20000;
		            $config['max_width']            = 1024;
		            $config['max_height']           = 768;
		            $config['file_ext_tolower']     = TRUE;
		            $config['encrypt_name']     	= TRUE;

		            $results = $this->upload_file($config, "cover_photo");
	
		            if ($results['is_upload_done'] == "TRUE"){
		            	
		            	$slug = url_title($data['lesson_title'],'underscore', TRUE);
						
						if ($this->admin_mod->insert_new_lesson_with_cover($data['chapter_id'], 
																			$data['lesson_title'], 
																			$slug, 
																			$data['lesson_content'],
																			$results['results']['upload_data']['file_name'], 
																			$data['cover_photo_orientation'] ,
																			$data['faculty_id_num']) == 1){
							$is_done = array(
								"done" => "TRUE",
								"msg" => "Successfully Inserted"
							);
						}
		            }else{
		            	$is_done = array(
							"done" => "FALSE",
							"msg" => $results['results']['error']
						);
		            }

				}else{
					
					$slug = url_title($data['lesson_title'],'underscore', TRUE);

					if ($this->admin_mod->insert_new_lesson_without_cover($data['chapter_id'], $data['lesson_title'], $slug, $data['lesson_content'], $data['faculty_id_num']) == 1){
						$is_done = array(
							"done" => "TRUE",
							"msg" => "Successfully Inserted"
						);
					}else{
						$is_done = array(
							"done" => "FALSE",
							"msg" => "Error inserting lesson"
						);
					}
				}
			}
			// print_r($is_done);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}

		public function delete_lesson(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();

			$facultyIDNum = $this->session->userdata('admin_session_facultyNum'); // it can be use in audit trail later

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$lessonID = $this->input->post('lessonID');

			$data = array(
				"lessonID" => $lessonID
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("lessonID", "Lesson ID", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{

				if ($userType == "admin_faculty" || $userType == "dean_admin_faculty"){
					
					if ($this->admin_mod->mark_lesson_as_deleted($data['lessonID']) == 1){
						$is_done = array(
							"done" => "TRUE",
							"msg" => "Successfully Deleted"
						);
					}
				}else{

					if ($this->admin_mod->mark_lesson_as_deleted_by_user($data['lessonID'], $facultyIDNum) == 1){
						$is_done = array(
							"done" => "TRUE",
							"msg" => "Successfully Deleted"
						);
					}
				}
			}
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}

		public function get_all_lessons_by_current_user(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$lessons = $this->admin_mod->select_all_lessons($facultyIDNum);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($lessons));
		}

		public function search_lessons(){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$search_str = $this->input->post('search_str');

			$data = array(
				"search_str" => $search_str
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("search_str", "Search string", "trim|required");

			$lessons = array();

			if ($this->form_validation->run() === TRUE){
				$lessons = $this->admin_mod->select_lessons($data['search_str']);
			}
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($lessons));
		}

		public function toValidMySQLDate($date){
            $dateTmp = strtotime($date);
            $date = date("Y-m-d", $dateTmp);

            return $date;
        }

		public function advance_search_lessons(){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$principleID = ($this->input->post('principleID') != "") ? $this->input->post('principleID') : 0;
			$topicID = ($this->input->post('topicID') != "") ? $this->input->post('topicID') : 0;
			$chapterID = ($this->input->post('chapterID') != "") ? $this->input->post('chapterID') : 0;
			$lesson_title = ($this->input->post('lesson_title') != "") ? $this->input->post('lesson_title') : "";
			$faculty_id_number = ($this->input->post('faculty_id_number') != "") ? $this->input->post('faculty_id_number') : "";
			$startDate = ($this->input->post('startDate') != "") ? $this->input->post('startDate') : "";
			$endDate = ($this->input->post('endDate') != "") ? $this->input->post('endDate') : "";

			$startDate = $this->toValidMySQLDate($startDate);
			$endDate = $this->toValidMySQLDate($endDate);

			$data = array(
				"principleID" => $principleID,
				"topicID" => $topicID,
				"chapterID" => $chapterID,
				"lesson_title" => $lesson_title,
				"faculty_id_number" => $faculty_id_number,
				"startDate" => ($startDate == "1970-01-01") ? "" : $startDate,
				"endDate" => ($endDate == "1970-01-01") ? "" : $endDate
			);
			

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("principleID", "Principle ID", "trim");
			$this->form_validation->set_rules("topicID", "Topic ID", "trim");
			$this->form_validation->set_rules("chapterID", "Chapter ID", "trim");
			$this->form_validation->set_rules("lesson_title", "Lesson Title", "trim");
			$this->form_validation->set_rules("faculty_id_number", "Faculty ID number", "trim");
			$this->form_validation->set_rules("startDate", "Start Date", "trim");
			$this->form_validation->set_rules("endDate", "End Date", "trim");

			// print_r($data);
			$lessons = array();

			if ($this->form_validation->run() === TRUE){
				$lessons = $this->admin_mod->advance_select_lessons($data['principleID'], 
																	$data['topicID'], 
																	$data['chapterID'], 
																	$data['lesson_title'], 
																	$data['faculty_id_number'], 
																	$data['startDate'], 
																	$data['endDate']
																);
			}else{
				$lessons = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}


			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($lessons));
		}

	}

?>