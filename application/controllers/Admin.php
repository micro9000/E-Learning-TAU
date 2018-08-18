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
					"msg" => "Login failed"
				);

			$facNum = $this->input->post('facNum');
			$password = $this->input->post('password');

			$data = array(
				"facNum" => $facNum,
				"password" => $password
			);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("facNum", "Faculty Number", "trim|required"); //|max_length[8]|min_length[8]
			$this->form_validation->set_rules("password", "Password", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors()
				);
			}else{
				$hashPass = hashSHA512($password);

				$results = $this->admin_mod->login($data['facNum'], $hashPass);

				if ($results != null){
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

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div");
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

				if ($principle_data == null){
					show_404();
				} else if (sizeof($principle_data) == 0){
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
			$this->load->view("admin/content_start_div");
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

				if ($topic_data == null){
					show_404();
				}else if (sizeof($topic_data) == 0){
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
			$this->load->view("admin/content_start_div");
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

				if ($chapter_data == null){
					show_404();
				} else if (sizeof($chapter_data) == 0){
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
			$this->load->view("admin/content_start_div");
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
			
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			$data['session_data'] = $this->session->userdata();

			$data['page_title'] = "Admin Chapters-Lessons";
			$data['page_code'] = "chapters_lessons_panel";

			$data['principles'] = $this->admin_mod->select_all_principles();

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div");
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

				if ($faculty_data == null){
					show_404();
				}else if (sizeof($faculty_data) == 0){
					show_404();
				}

				if ($admin_data == null){
					show_404();
				}else if (sizeof($admin_data) == 0){
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
			$this->load->view("admin/content_start_div");
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

				if ($student_data == null){
					show_404();
				}else if (sizeof($student_data) == 0){
					show_404();
				}

				$data['student_to_update_data'] = $student_data;
				$data['studentID'] = $studentID;
			}

			$data['session_data'] = $this->session->userdata();

			$data['page_title'] = "Admin Students";
			$data['page_code'] = "students_list_panel";

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div");
			$this->load->view("admin/topbar");
			$this->load->view("admin/students");
			$this->load->view("admin/footer");
		}


		public function profile(){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$facultyID = $this->session->userdata('admin_session_faculty_id');
			$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;
			
			if (is_numeric($facultyID) && $facultyID > 0 && $facultyID != 0 && $facultyIDNum != ""){

				$faculty_data = $this->admin_mod->select_faculty_by_id($facultyID);
				$admin_data = $this->admin_mod->select_faculty_by_id_num($faculty_data['addedByAdminFacultyNum']);

				if ($faculty_data == null){
					show_404();
				}else if (sizeof($faculty_data) == 0){
					show_404();
				}

				if ($admin_data == null){
					show_404();
				}else if (sizeof($admin_data) == 0){
					show_404();
				}

				$data['faculty_to_update_data'] = $faculty_data;
				$data['admin_data'] = $admin_data;
				$data['facultyID'] = $facultyID;
				$data['session_data'] = $this->session->userdata();

				$data['page_title'] = "Admin Profile";
				$data['page_code'] = "admin_profile_panel";

				$this->load->view("admin/header", $data);
				$this->load->view("admin/sidebar");
				$this->load->view("admin/content_start_div");
				$this->load->view("admin/topbar");
				$this->load->view("admin/profile");
				$this->load->view("admin/footer");
			}else{
				show_404();
			}
		}


		public function add_lessons($lessonID=0){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			// Needs inside sidebar
			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;

			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			$data['page_title'] = "Admin Add Lessons";
			$data['page_code'] = "add_lessons";

			$data['principles'] = $this->admin_mod->select_all_principles();

			$data['lessonID'] = $lessonID;

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div");
			$this->load->view("admin/topbar");
			$this->load->view("admin/add_lesson");
			$this->load->view("admin/footer");
		}


		public function audit_trail(){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			// Needs inside sidebar
			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;

			$data['page_title'] = "Admin Audit Trail";
			$data['page_code'] = "audit_trail";

			// $audit_trail_list = $this->admin_mod->select_all_audit_trail();
			// $data['audit_trail_list'] = $audit_trail_list;
			// $data['audit_trail_list_len'] = sizeof($audit_trail_list);

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div");
			$this->load->view("admin/topbar");
			$this->load->view("admin/audit_trail");
			$this->load->view("admin/footer");
		}

		public function view_lesson_update_summary($lessonID = 0, $slug = ""){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			// Needs inside sidebar
			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;


			$data['page_title'] = "Admin Audit Trail";
			$data['page_code'] = "audit_trail";

			$lessonData = array(
						"id" => $lessonID,
						"slug" => $slug
					);

			$lessonData = $this->security->xss_clean($lessonData);

			$lesson_update_summary = $this->admin_mod->select_lesson_update_summary($lessonData['id']);
			$data['lesson_update_summary'] = $lesson_update_summary;
			$data['lesson_update_summary_len'] = sizeof($lesson_update_summary);

			$lesson_data = $this->admin_mod->select_lesson_by_id($lessonData['id']);
			$data['lesson_data'] = ($lesson_data != null) ? (sizeof($lesson_data) > 0) ? $lesson_data : array() : array();

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div");
			$this->load->view("admin/topbar");
			$this->load->view("admin/view_lesson_update_summary");
			$this->load->view("admin/footer");
		}


		public function recycle_bin_principle(){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			// Needs inside sidebar
			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;

			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			$data['page_title'] = "Admin Recycle Bin";
			$data['page_code'] = "recycle_bin_principle";

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div");
			$this->load->view("admin/topbar");
			$this->load->view("admin/recycle_bin_principle");
			$this->load->view("admin/footer");
		}

		public function recycle_bin_principle_sub_topic(){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			// Needs inside sidebar
			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;

			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			$data['page_title'] = "Admin Recycle Bin";
			$data['page_code'] = "recycle_bin_sub_topics";

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div");
			$this->load->view("admin/topbar");
			$this->load->view("admin/recycle_bin_sub_topics");
			$this->load->view("admin/footer");
		}


		public function recycle_bin_chapters(){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			// Needs inside sidebar
			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;

			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			$data['page_title'] = "Admin Recycle Bin";
			$data['page_code'] = "recycle_bin_chapters";

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div");
			$this->load->view("admin/topbar");
			$this->load->view("admin/recycle_bin_chapters");
			$this->load->view("admin/footer");
		}


		public function recycle_bin_lessons(){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			// Needs inside sidebar
			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;

			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			$data['page_title'] = "Admin Recycle Bin";
			$data['page_code'] = "recycle_bin_lessons";

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div");
			$this->load->view("admin/topbar");
			$this->load->view("admin/recycle_bin_lessons");
			$this->load->view("admin/footer");
		}

		public function recycle_bin_faculties(){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			// Needs inside sidebar
			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;

			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			$data['page_title'] = "Admin Recycle Bin";
			$data['page_code'] = "recycle_bin_faculties";

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div");
			$this->load->view("admin/topbar");
			$this->load->view("admin/recycle_bin_faculties");
			$this->load->view("admin/footer");
		}

		public function recycle_bin_students(){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			// Needs inside sidebar
			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;

			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			$data['page_title'] = "Admin Recycle Bin";
			$data['page_code'] = "recycle_bin_students";

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div");
			$this->load->view("admin/topbar");
			$this->load->view("admin/recycle_bin_students");
			$this->load->view("admin/footer");
		}


		public function view_lesson($lessonID=0, $slug=""){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			// Needs inside sidebar
			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;

			$lessonData = array(
						'id' => $lessonID,
						'slug' => $slug
					);

			$lessonData = $this->security->xss_clean($lessonData);

			$data['page_title'] = "Admin view lesson";
			$data['page_code'] = "view_lesson";
			// $data['agriculture_matrix'] = $this->admin_mod->get_principles_sub_topics_chapters_matrix();

			$lessonData = $this->admin_mod->select_lesson_by_id($lessonData['id']);

			$data['lesson_data'] = ($lessonData != null) ? sizeof($lessonData) > 0 ? $lessonData : array() : array();

			$chapter_lessons = $this->admin_mod->select_lesson_by_chapter_id($lessonData[0]['chapterID']);
			$data['chapter_lessons'] = $chapter_lessons;

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div");
			$this->load->view("admin/topbar");
			$this->load->view("admin/faculty_view_lesson");
			$this->load->view("admin/footer");
		}

		public function add_quiz_questions($quizID, $quiz_slug){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			// Needs inside sidebar
			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;

			$quizData = array(
						'quizID' => $quizID,
						'quiz_slug' => $quiz_slug,
					);

			$quizData = $this->security->xss_clean($quizData);

			$quiz_data = $this->admin_mod->select_chapter_quiz_by_id($quizData['quizID']);

			if ($quiz_data == null){
				show_404();
			} else if (sizeof($quiz_data) == 0){
				show_404();
			}

			
			$data['quiz_data'] = $quiz_data;
			$data['quizID'] = $quizID;

			$data['page_title'] = "Admin quiz questions";
			$data['page_code'] = "quiz_questions";

			// $data['quiz_questions'] = $this->get_quiz_questions_and_choices_matrix($quizData['quizID']);

			$this->load->view("admin/header", $data);
			$this->load->view("admin/sidebar");
			$this->load->view("admin/content_start_div");
			$this->load->view("admin/topbar");
			$this->load->view("admin/add_quiz_questions");
			$this->load->view("admin/footer");

		}


		public function std_quiz_view_results($resultsID, $stdNum){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			// Needs inside sidebar
			$userType = $this->get_user_type();
			$actualUserType = $this->get_actual_user_type($userType);
			$data['userType'] = $userType;
			$data['actualUserType'] = $actualUserType;

			$post_quizData = array(
						'resultsID' => $resultsID,
						"stdNum" => $stdNum
					);

			$post_quizData = $this->security->xss_clean($post_quizData);

			$quiz_results = $this->admin_mod->get_std_last_chapter_quiz($post_quizData['resultsID'], $post_quizData['stdNum']);

			// echo "<pre>";
			// print_r($quiz_results);
			// echo "</pre>";

			if ($quiz_results != NULL){

				$data['quiz_results'] = $quiz_results;

				$quizData = array(
							'chapterID' => $quiz_results['chapterID'],
							'quizID' => $quiz_results['quizID']
						);
				$quizData = $this->security->xss_clean($quizData);

				$data['quiz_answers'] = $this->students_mod->get_std_last_chapter_quiz_answers($quiz_results['id'], $post_quizData['stdNum']);

				$numberOfRightAns = $this->students_mod->get_quiz_number_right_answers($quizData['quizID']);

				if ($numberOfRightAns != NULL){
					$data['numberOfRightAns'] = $numberOfRightAns;
				}else{
					$data['numberOfRightAns'] = 0;
				}

				$quiz_data = $this->admin_mod->select_chapter_quiz_by_id($quizData['quizID']);

				if ($quiz_data == null){
					show_404();
				} else if (sizeof($quiz_data) == 0){
					show_404();
				}

				$data['quiz_data'] = $quiz_data;
				$data['quizID'] = $quizData['quizID'];

				$chapterData = $this->admin_mod->select_chapter_by_id($quiz_data['chapterID']);
				$data['chapterData'] = $chapterData;

				$topicData = $this->admin_mod->select_principles_sub_topic_by_topic_id($chapterData['topicID']);
				$data['topicData'] = $topicData;

				$principleData = $this->admin_mod->select_principle_by_id($chapterData['principleID']);
				$data['principleData'] = $principleData;

				$data['quiz_questions_choices_matrix'] = $this->get_quiz_questions_and_choices_matrix_get($quizData['quizID']);

				$data['page_title'] = "Admin student quiz results";
				$data['page_code'] = "quiz_results";

				$this->load->view("admin/header", $data);
				$this->load->view("admin/sidebar");
				$this->load->view("admin/content_start_div");
				$this->load->view("admin/topbar");
				$this->load->view("admin/std_quiz_results");
				$this->load->view("admin/footer");

			}else{
				show_404();
			}

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

					// Audit Trail
					$actionDone = "Add new faculty - " . $data['lastname'].", ".$data['firstname'];
					$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'FACU', $facultyIDNum);

					$is_done = array(
						"done" => "TRUE",
						"msg" => "Inserted Successfully"
					);
				}

			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		private function faculty_update_audit_trail($facuCurData, $newData, $isWithPass){

			$current_user_ffID = $this->session->userdata('admin_session_facultyNum');
			// $facultyDataID = $newData['facultyID'];

			if (sizeof($facuCurData) > 0 && sizeof($newData) > 0){

				if ($facuCurData['firstName'] != $newData['firstname']){ // firstname

					$actionDone = "Update faculty first name from - " . $facuCurData['firstName']." to ".$newData['firstname'];
					$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'FACU', $current_user_ffID);

				}

				if ($facuCurData['lastName'] != $newData['lastname']){ // lastname

					$actionDone = "Update faculty last name from - " . $facuCurData['lastName']." to ".$newData['lastname'];
					$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'FACU', $current_user_ffID);

				}

				if ($facuCurData['email'] != $newData['email']){ // email

					$actionDone = "Update faculty email from - " . $facuCurData['email']." to ".$newData['email'];
					$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'FACU', $current_user_ffID);

				}

				if ($facuCurData['facultyIDNum'] != $newData['faculty_id_num']){ // facultyIDNum

					$actionDone = "Update faculty id number from - " . $facuCurData['facultyIDNum']." to ".$newData['faculty_id_num'];
					$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'FACU', $current_user_ffID);

				}

				if ($isWithPass == "with_pass"){

					if ($facuCurData['cur_pswd'] != $newData['password']){ // Password

						$actionDone = "Update faculty (". $newData['lastname'] .", ". $newData['firstname'] .") password";
						$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'FACU', $current_user_ffID);

					}

				}

			}
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

				$facuCurData = $this->admin_mod->select_faculty_by_id($data['facultyID']);

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

						$data['password'] = $hashPass;

						if ($facuCurData != null){
							if (sizeof($facuCurData) > 0){

								$facuCurData['cur_pswd'] = $this->admin_mod->select_faculty_password_by_id($data['facultyID']);

								if ($this->admin_mod->update_faculty_with_pass($data) == 1){

									$this->faculty_update_audit_trail($facuCurData, $data, 'with_pass');

									$is_done = array(
										"done" => "TRUE",
										"msg" => "Updated Successfully with password"
									);
								}

							}else{
								$is_done = array(
										"done" => "FALSE",
										"msg" => "Can't update the faculty data"
									);
							}
						}else{
							$is_done = array(
									"done" => "FALSE",
									"msg" => "Can't update the faculty data"
								);
						}
						
								
					}
					
				}else{

					if ($this->admin_mod->update_faculty_without_pass($data) == 1){

						if ($facuCurData != null){
							if (sizeof($facuCurData) > 0){
								$this->faculty_update_audit_trail($facuCurData, $data, 'without_pass');
							}
						}
								

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
				
				$facuCurData = $this->admin_mod->select_faculty_by_id($data['facultyID']);

				if ($this->admin_mod->mark_faculty_data_as_deleted($data['facultyID']) == 1){

					if ($facuCurData != null){
						if (sizeof($facuCurData) > 0){
							// audit trail
							$facultyIDNum = $this->session->userdata('admin_session_facultyNum'); // it can be use in audit trail later
							$actionDone = "Remove faculty " . $facuCurData['lastName'] .", ". $facuCurData['firstName'];
							$this->admin_mod->insert_audit_trail_new_entry($actionDone, "FACU", $facultyIDNum);
						}
					}
						

					$is_done = array(
						"done" => "TRUE",
						"msg" => "Successfully Deleted"
					);
				}
			}
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function restore_deleted_faculty_data(){
			
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
				
				$facuCurData = $this->admin_mod->select_deleted_faculty_by_id($data['facultyID']);

				if ($this->admin_mod->restore_deleted_faculty_data($data['facultyID']) == 1){

					if ($facuCurData != null){

						if (sizeof($facuCurData) > 0){
							// audit trail
							$facultyIDNum = $this->session->userdata('admin_session_facultyNum'); // it can be use in audit trail later
							$actionDone = "Restore faculty " . $facuCurData['lastName'] .", ". $facuCurData['firstName'];
							$this->admin_mod->insert_audit_trail_new_entry($actionDone, "FACU", $facultyIDNum);
						}
					}
						

					$is_done = array(
						"done" => "TRUE",
						"msg" => "Successfully Restore"
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

				$dean_count = $this->admin_mod->select_Dean_count($data['facultyID']);

				if ($dean_count['count'] == "0" && $dean_count['count'] == 0){
					$facuCurData = $this->admin_mod->select_faculty_by_id($data['facultyID']);

					if ($this->admin_mod->mark_faculty_as_admin_or_dean($data['facultyID'], $data['status'], $data['mark_as']) == 1){

						if ($facuCurData != null){
							if (sizeof($facuCurData) > 0){
								// audit trail
								$facultyIDNum = $this->session->userdata('admin_session_facultyNum'); // it can be use in audit trail later
								$actionDone = "Faculty ". $facuCurData['lastName'] .", ". $facuCurData['firstName'] . " mark as " . $data['mark_as'];
								$this->admin_mod->insert_audit_trail_new_entry($actionDone, "FACU", $facultyIDNum);
							}
						}
								

						$is_done = array(
							"done" => "TRUE",
							"msg" => "Successfully changed mark ".$data['mark_as']." status"
						);
					}
				}else{
					$is_done = array(
						"done" => "FALSE",
						"msg" => "Can't mark multiple dean"
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

			if ($faculty_data != NULL){
				if (sizeof($faculty_data) > 0){
					$this->form_validation->set_message('check_id_number_already_used_on_update', 'The {field} already used.');
					return FALSE;
				}
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

			if ($faculty_data != NULL){
				if (sizeof($faculty_data) > 0){
					$this->form_validation->set_message('check_id_number_already_used_on_insert', 'Invalid {field}, the {field} already used.');
					return FALSE;
				}
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

			if ($faculty_data != NULL){
				if (sizeof($faculty_data) > 0){
					$this->form_validation->set_message('check_email_already_used_on_update', 'The {field} already used.');
					return FALSE;
				}
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

			if ($faculty_data != NULL){
				if (sizeof($faculty_data) > 0){
					$this->form_validation->set_message('check_email_already_used_on_insert', 'Invalid {field}, the {field} already used.');
					return FALSE;
				}
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

				if ($admin_data != NULL){
					if (sizeof($admin_data) > 0){
						$faculties[$i]['addedBy'] = $admin_data['firstName'] ." ". $admin_data['lastName'];
					}
				}
					
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($faculties));
		}

		public function get_all_deleted_faculties(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			$faculties = $this->admin_mod->select_all_deleted_faculties();
			// print_r($faculties);

			$facultyLen = sizeof($faculties);
			for($i=0; $i<$facultyLen; $i++){
				$admin_data = $this->admin_mod->select_deleted_faculty_by_id_num($faculties[$i]['addedByAdminFacultyNum']);

				if ($admin_data != NULL){
					if (sizeof($admin_data) > 0){
						$faculties[$i]['addedBy'] = $admin_data['firstName'] ." ". $admin_data['lastName'];
					}
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

				$facultyLen = sizeof($results);
				for($i=0; $i<$facultyLen; $i++){
					$admin_data = $this->admin_mod->select_faculty_by_id_num($results[$i]['addedByAdminFacultyNum']);

					if ($admin_data != NULL){
						if (sizeof($admin_data) > 0){
							$results[$i]['addedBy'] = $admin_data['firstName'] ." ". $admin_data['lastName'];
						}
					}
						
					
				}
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($results));
		}

		public function search_deleted_faculty(){
			
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
				$results = $this->admin_mod->select_deleted_faculties($data['search_string']);

				$facultyLen = sizeof($results);
				for($i=0; $i<$facultyLen; $i++){
					$admin_data = $this->admin_mod->select_deleted_faculty_by_id_num($results[$i]['addedByAdminFacultyNum']);

					if ($admin_data != NULL){
						if (sizeof($admin_data) > 0){
							$results[$i]['addedBy'] = $admin_data['firstName'] ." ". $admin_data['lastName'];
						}
					}
						
					
				}
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

				// print_r($results);
				if ($results != NULL){

					$facultyLen = sizeof($results);
					for($i=0; $i<$facultyLen; $i++){
						$admin_data = $this->admin_mod->select_faculty_by_id_num($results['addedByAdminFacultyNum']);

						if ($admin_data != NULL){
							if (sizeof($admin_data) > 0){
								$results['addedBy'] = $admin_data['firstName'] ." ". $admin_data['lastName'];
							}
						}
					}

				}
					
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($results));
		}

		## Students -------------------------------------------------------------------------------------

		public function get_all_student_numbers(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			$results = $this->admin_mod->select_all_std_nums();

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($results));
		}

		public function search_student_nums(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			$search = $this->input->post('search');

			$data = array('search' => $search);
			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("search", "Search String", "trim|required");

			$results = array();

			if ($this->form_validation->run() === TRUE){
				$results = $this->admin_mod->search_std_nums($data['search']);
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($results));
		}

		public function student_number_mass_upload(){

			$className = "student_numbers";

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);


			$fileName = $_FILES[$className]['name'];
            $ext = explode(".", basename($fileName));
            $fileExtension = strtolower(end($ext));


            if ($fileExtension == "csv"){

				$file = $_FILES[$className]['tmp_name'];

	        	$handle = fopen($file, "r");


	        	if ($file == NULL){
	        		
	        		$is_done = array(
						"done" => "FALSE",
						"msg" => "Can't read file"
					);

	        	}else{

	        		ini_set('max_execution_time', 9600);

	        		$invalidStdNum = array();
	        		$existStdNum = array();

	        		while (($filesop = fgetcsv($handle, 1000, ",")) !== false) {

	   					$stdNum = $filesop[0];

	   					if (is_numeric($stdNum)){

	   						$stdNumExist = $this->admin_mod->select_std_num($stdNum);

	   						if ($stdNumExist != NULL){

	   							array_push($existStdNum, $stdNum);

	   						}else{
	   							$result = $this->admin_mod->insert_student_number($stdNum);

		   						if ($result != 1){
		   							array_push($invalidStdNum, $stdNum);
		   						}
	   						}

	   					}else{
	   						array_push($invalidStdNum, $stdNum);
	   					}

					}

					$invalidStdNumStr = "";
					$invalidStdNumLen = sizeof($invalidStdNum);

					for($i=0; $i<$invalidStdNumLen; $i++){
						$invalidStdNumStr .= $invalidStdNum[$i];

						if ($i == ($invalidStdNumLen - 1)){
	                        $invalidStdNumStr .= "";
	                    }else{
	                        $invalidStdNumStr .= ",";
	                    }
					}

					$existsStdNumStr = "";
					$existsStdNumLen = sizeof($existStdNum);

					for($i=0; $i<$existsStdNumLen; $i++){
						$existsStdNumStr .= $existStdNum[$i];

						if ($i == ($existsStdNumLen - 1)){
	                        $existsStdNumStr .= "";
	                    }else{
	                        $existsStdNumStr .= ",";
	                    }
					}

					$msg = "DONE!";
					$msg .= "<br/> Number of invalid student numbers:". $invalidStdNumLen;

					if ($invalidStdNumLen > 0){
						$msg .= "<br/> Invalid Student Numbers: >" . $invalidStdNumStr;
					}

					if ($existsStdNumLen > 0){
						$msg .= "<br/> Already Added : " . $existsStdNumStr;
					}

					$is_done = array(
						"done" => "TRUE",
						"msg" => $msg
					);

	        	}

            }else{

            	$is_done = array(
					"done" => "FALSE",
					"msg" => "Invalid file extension (required CSV)"
				);

            }

            $this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}

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

			$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

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

					// Audit Trail
					$actionDone = "Add new student - " . $data['lastname'].", ".$data['firstname'];
					$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'STUD', $facultyIDNum);

					$is_done = array(
						"done" => "TRUE",
						"msg" => "Inserted Successfully"
					);
				}

			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}

		private function student_update_audit_trail($stdCurData, $newData, $isWithPass){

			$current_user_ffID = $this->session->userdata('admin_session_facultyNum');

			if (sizeof($stdCurData) > 0 && sizeof($newData) > 0){

				if ($stdCurData['firstName'] != $newData['firstname']){ // firstname

					$actionDone = "Update student firstname from - " . $stdCurData['firstName']." to ".$newData['firstname'];
					$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'STUD', $current_user_ffID);

				}

				if ($stdCurData['lastName'] != $newData['lastname']){ // lastname

					$actionDone = "Update student lastname from - " . $stdCurData['lastName']." to ".$newData['lastname'];
					$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'STUD', $current_user_ffID);

				}

				if ($stdCurData['email'] != $newData['email']){ // email

					$actionDone = "Update student email from - " . $stdCurData['email']." to ".$newData['email'];
					$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'STUD', $current_user_ffID);

				}

				if ($stdCurData['stdNum'] != $newData['student_id_num']){ // student_id_num

					$actionDone = "Update student id number from - " . $stdCurData['stdNum']." to ".$newData['student_id_num'];
					$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'STUD', $current_user_ffID);

				}

				if ($isWithPass == "with_pass"){

					$currentPswd = $stdCurData['password']['pswd'];
					$newPswd = $newData['pswd'];

					if ($currentPswd != $newPswd){ // Password

						$actionDone = "Update student (". $newData['lastname'] .", ". $newData['firstname'] .") password";
						$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'STUD', $current_user_ffID);

					}

				}

			}
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

			// print_r($data);

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

				$stdCurData = $this->admin_mod->select_std_by_id($data['studentID']);

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
						$data['pswd'] = $hashPass;

						if ($stdCurData != NULL){
							if (sizeof($stdCurData) > 0){

								$stdCurData['password'] = $this->admin_mod->select_std_pswd_by_id($data['studentID']);				

								if ($this->admin_mod->update_student_with_pass($data) == 1){

									$this->student_update_audit_trail($stdCurData, $data, "with_pass");

									$is_done = array(
										"done" => "TRUE",
										"msg" => "Updated Successfully with password"
									);
								}

							}else{
								$is_done = array(
										"done" => "FALSE",
										"msg" => "Can't update this student data"
									);
							}
						}else{
							$is_done = array(
									"done" => "FALSE",
									"msg" => "Can't update this student data"
								);
						}

								
					}
					
				}else{
				
					if ($this->admin_mod->update_student_without_pass($data) == 1){

						$this->student_update_audit_trail($stdCurData, $data, "without_pass");

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

			if ($std_data == NULL){
				// if (sizeof($std_data) == 0){
				// 	$this->form_validation->set_message('check_is_student_enrolled', 'Invalid {field}, student number not exists in the master list.');
				// 	return FALSE;
				// }
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

				$std_data = $this->admin_mod->select_std_num($stdIDNum);

				if ($std_data == NULL){
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Student number not exists in the master list"
					);
				}else{
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Student number is enrolled in the master list"
					);
				}

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

			if ($std_data != NULL){
				if (sizeof($std_data) > 0){
					$this->form_validation->set_message('check_std_id_number_already_used_on_insert', 'Invalid {field}, the {field} already used.');
					return FALSE;
				}
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

			if ($std_data != NULL){
				if (sizeof($std_data) > 0){
					$this->form_validation->set_message('check_std_id_number_already_used_on_update', 'Invalid {field}, the {field} already used.');
					return FALSE;
				}
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

			if ($std_data != NULL){
				if (sizeof($std_data) > 0){
					$this->form_validation->set_message('check_std_email_already_used_on_insert', 'Invalid {field}, the {field} already used.');
					return FALSE;
				}
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

			if ($std_data != NULL){
				if (sizeof($std_data) > 0){
					$this->form_validation->set_message('check_std_email_already_used_on_update', 'Invalid {field}, the {field} already used.');
					return FALSE;
				}
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

		public function get_all_deleted_students(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}

			$students = $this->admin_mod->select_all_deleted_students();

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

				$stdCurData = $this->admin_mod->select_std_by_id($data['studentID']);
					
				if ($this->admin_mod->mark_student_data_as_deleted($data['studentID']) == 1){

					if ($stdCurData != NULL){
						if (sizeof($stdCurData) > 0){
							// Audit Trail
							$facultyIDNum = $this->session->userdata('admin_session_facultyNum');
							$actionDone = "Remove student (". $stdCurData['lastName'] .", ". $stdCurData['firstName'] .")";
							$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'STUD', $facultyIDNum);
						}
					}
						
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Successfully Deleted"
					);
				}
			}
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function restore_deleted_student_data(){
			
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

				$stdCurData = $this->admin_mod->select_deleted_std_by_id($data['studentID']);
					
				if ($this->admin_mod->restore_deleted_student_data($data['studentID']) == 1){

					if ($stdCurData != NULL){
						if (sizeof($stdCurData) > 0){
							// Audit Trail
							$facultyIDNum = $this->session->userdata('admin_session_facultyNum');
							$actionDone = "Restore student (". $stdCurData['lastName'] .", ". $stdCurData['firstName'] .")";
							$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'STUD', $facultyIDNum);
						}
					}
						
						
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Successfully Restore"
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


		public function search_deleted_students(){

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
				$results = $this->admin_mod->select_deleted_students($data['search_string']);
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

					// Audit Trail
					$actionDone = "Added new agriculture principle (".$data['principle'].")";
					$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'PRPL', $facultyIDNum);

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
				
				$principleData = $this->admin_mod->select_principle_by_id($data['principleID']);
				$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

				if ($this->admin_mod->mark_principle_as_deleted($data['principleID']) == 1){

					// Audit Trail
					if ($principleData != NULL){
						if (sizeof($principleData) > 0){
							$actionDone = "Remove agriculture principle (".$principleData['principle'].")";
							$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'PRPL', $facultyIDNum);
						}
					}
						

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

		public function restore_principle(){
			
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
				
				$principleData = $this->admin_mod->select_deleted_principle_by_id($data['principleID']);
				$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

				if ($this->admin_mod->mark_principle_as_undeleted($data['principleID']) == 1){

					// Audit Trail
					if ($principleData != NULL){
						if (sizeof($principleData) > 0){
							$actionDone = "Restore agriculture principle (".$principleData['principle'].")";
							$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'PRPL', $facultyIDNum);
						}
					}
						

					$is_done = array(
						"done" => "TRUE",
						"msg" => "Successfully Restore"
					);
				}
			}

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
				
				$principleData = $this->admin_mod->select_principle_by_id($data['principleID']);

				if ($this->admin_mod->update_principle($data['principleID'], $data['principle'], $data['facultyIDNum']) == 1){

					// Audit Trail
					if ($principleData != NULL){
						if (sizeof($principleData) > 0){
							$actionDone = "Update agriculture principle from ".$principleData['principle']." to " . $data['principle'];
							$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'PRPL', $facultyIDNum);
						}
					}
						

					$is_done = array(
						"done" => "TRUE",
						"msg" => "Updated Successfully"
					);
				}
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));

		}


		public function get_all_deleted_principles(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$principles = $this->admin_mod->select_all_deleted_principles();
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($principles));
		}


		public function search_deleted_principles(){
			
			// print_r($this->input->post());
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
				$results = $this->admin_mod->search_deleted_principle($data['search_string']);
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($results));
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

					// Audit Trail
					$actionDone = "Added new agriculture principle sub topic (" . $data['sub_topic'] .")";
					$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'SBTP', $facultyIDNum);

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

				$subTopicData = $this->admin_mod->select_principles_sub_topic_by_topic_id($data['topicID']);
				
				if ($this->admin_mod->update_principle_sub_topic($data['topicID'], $data['principleID'], $data['sub_topic'], $data['facultyIDNum']) == 1){

					if ($subTopicData != NULL){
						// Audit Trail
						if (sizeof($subTopicData) > 0){
							$actionDone = "Update agriculture principle sub topic from " . $subTopicData['topic'] ." to ". $data['sub_topic'];
							$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'SBTP', $facultyIDNum);
						}
					}
						

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


		public function get_all_deleted_principles_sub_topics(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$principles = $this->admin_mod->select_all_deleted_principles_sub_topics();
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


		public function search_deleted_principles_sub_topics(){
			
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
				$results = $this->admin_mod->search_deleted_principle_sub_topics($data['search_string']);
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
				
				$subTopicData = $this->admin_mod->select_principles_sub_topic_by_topic_id($data['topicID']);
				$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

				if ($this->admin_mod->mark_principle_sub_topic_as_deleted($data['topicID']) == 1){

					if ($subTopicData != NULL){
						// Audit Trail
						if (sizeof($subTopicData) > 0){
							$actionDone = "Remove agriculture principle sub topic (" . $subTopicData['topic'] . ")";
							$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'SBTP', $facultyIDNum);
						}
					}
						

					$is_done = array(
						"done" => "TRUE",
						"msg" => "Successfully Deleted"
					);
				}
			}
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}

		public function restore_principle_sub_topic(){
			
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
				
				$subTopicData = $this->admin_mod->select_deleted_principles_sub_topic_by_id($data['topicID']);
				$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

				if ($this->admin_mod->restore_deleted_principle_sub_topic($data['topicID']) == 1){

					if ($subTopicData != NULL){
						// Audit Trail
						if (sizeof($subTopicData) > 0){
							$actionDone = "Restore agriculture principle sub topic (" . $subTopicData['topic'] . ")";
							$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'SBTP', $facultyIDNum);
						}
					}
						

					$is_done = array(
						"done" => "TRUE",
						"msg" => "Successfully Restore"
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
					
					$actionDone = "Added new topic chapter (" . $data['chapterTitle'] . ")";
					$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'CHAP', $facultyIDNum);

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

		public function get_all_deleted_topics_chapters(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$chapters = $this->admin_mod->select_all_deleted_topics_chapters();
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


		public function search_deleted_topics_chapters(){
			
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
				$chapters = $this->admin_mod->search_deleted_chapter($data['search_str']);
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

				if ($chapters == NULL){
					$chapters = array();
				}

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

				$chapterCurrentData = $this->admin_mod->select_chapter_by_id($data['chapterID']);
					
				if ($this->admin_mod->update_topic_chapter($data['chapterID'], $data['principleID'], $data['topicID'], $data['chapterTitle'], $data['addedByFacultyNum']) == 1){
					
					if ($chapterCurrentData != NULL){
						if (sizeof($chapterCurrentData) > 0){
							$actionDone = "Update topic chapter from " . $chapterCurrentData['chapterTitle'] . " to ". $data['chapterTitle'];
							$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'CHAP', $facultyIDNum);
						}
					}
						
					
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

				$chapterCurrentData = $this->admin_mod->select_chapter_by_id($data['chapterID']);
				$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

				if ($this->admin_mod->mark_topic_chapter_as_deleted($data['chapterID']) == 1){

					if ($chapterCurrentData != NULL){
						if (sizeof($chapterCurrentData) > 0){
							$actionDone = "Remove topic chapter (" . $chapterCurrentData['chapterTitle'] . ")";
							$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'CHAP', $facultyIDNum);
						}
					}
					

					$is_done = array(
						"done" => "TRUE",
						"msg" => "Successfully Deleted"
					);
				}
			}
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function restore_deleted_topic_chapter(){
			
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

				$chapterCurrentData = $this->admin_mod->select_deleted_chapter_by_id($data['chapterID']);
				$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

				if ($this->admin_mod->restore_deleted_topic_chapter($data['chapterID']) == 1){

					if ($chapterCurrentData != NULL){
						if (sizeof($chapterCurrentData) > 0){
							$actionDone = "Restore topic chapter (" . $chapterCurrentData['chapterTitle'] . ")";
							$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'CHAP', $facultyIDNum);
						}
					}
						
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

							// Audit trail
							$actionDone = "Added new lesson (".$data['lesson_title'].")";
							$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'LESS', $facultyIDNum);

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
							
						// Audit trail
						$actionDone = "Added new lesson (".$data['lesson_title'].")";
						$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'LESS', $facultyIDNum);

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



		public function update_lesson(){
			// print_r($_POST);
			// print_r($_FILES);	

			// exit();
			
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

			$lesson_id = $this->input->post("lesson_id");
			$chapter_id = $this->input->post("chapter_id");
			$lesson_title = $this->input->post("lesson_title");
			$cover_photo_len = $this->input->post("cover_photo_len");
			$cover_photo_orientation = $this->input->post("cover_photo_orientation");
			$lesson_content = $this->input->post("lesson_content");
			$update_summary = $this->input->post("update_summary");

			$data = array(
				"lesson_id" => $lesson_id,
				"chapter_id" => $chapter_id,
				"lesson_title" => $lesson_title,
				"cover_photo_len" => $cover_photo_len,
				"cover_photo_orientation" => $cover_photo_orientation,
				"lesson_content" => $lesson_content,
				"faculty_id_num" => $facultyIDNum,
				"update_summary" => $update_summary
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("lesson_id", "Lesson ID", "trim|required");
			$this->form_validation->set_rules("chapter_id", "Chapter ID", "trim|required");
			$this->form_validation->set_rules("lesson_title", "Lesson title", "trim|required|min_length[5]");
			$this->form_validation->set_rules("lesson_content", "Lesson Content", "trim|required");
			$this->form_validation->set_rules("cover_photo_len", "Cover photo len", "trim|required");
			$this->form_validation->set_rules("faculty_id_num", "Faculty Id number", "trim|required");
			$this->form_validation->set_rules("update_summary", "Update Summary", "trim|required");

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
		            $config['max_width']            = 2048;
		            $config['max_height']           = 1536;
		            $config['file_ext_tolower']     = TRUE;
		            $config['encrypt_name']     	= TRUE;

		            $results = $this->upload_file($config, "cover_photo");
	
		            if ($results['is_upload_done'] == "TRUE"){
		            	
		            	$slug = url_title($data['lesson_title'],'underscore', TRUE);
						
						if ($this->admin_mod->update_lesson_with_cover($data['lesson_id'],
																			$data['chapter_id'], 
																			$data['lesson_title'], 
																			$slug, 
																			$data['lesson_content'],
																			$results['results']['upload_data']['file_name'], 
																			$data['cover_photo_orientation'] ,
																			$data['faculty_id_num']) == 1){

							$this->admin_mod->insert_lesson_update_summary($data['lesson_id'], $data['update_summary'], $facultyIDNum);

							// Audit trail
							$actionDone = "Update lesson (".$data['lesson_title']."), please go to update summary history for more details";
							$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'LESS', $facultyIDNum);

							$is_done = array(
								"done" => "TRUE",
								"msg" => "Updated Successfully"
							);

						}else{
							$is_done = array(
								"done" => "FALSE",
								"msg" => "Error updating lesson"
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

					if ($this->admin_mod->update_lesson_without_cover($data['lesson_id'], 
																		$data['chapter_id'], 
																		$data['lesson_title'], 
																		$slug, 
																		$data['lesson_content'], 
																		$data['faculty_id_num']) == 1){

						$this->admin_mod->insert_lesson_update_summary($data['lesson_id'], $data['update_summary'], $data['faculty_id_num']);

						// Audit trail
						$actionDone = "Update lesson (".$data['lesson_title']."), please go to update summary history for more details";
						$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'LESS', $facultyIDNum);

						$is_done = array(
							"done" => "TRUE",
							"msg" => "Updated Successfully"
						);
					}else{
						$is_done = array(
							"done" => "FALSE",
							"msg" => "Error updating lesson"
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

				$lessonCurData = $this->admin_mod->select_lesson_actual_data_by_id($data['lessonID']);

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

				// Audit trail
				if ($is_done['done'] == "TRUE" && $lessonCurData != NULL){
					if (sizeof($lessonCurData) > 0){
						$actionDone = "Deleted lesson (".$lessonCurData[0]['title'].")";
						$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'LESS', $facultyIDNum);
					}
				}
			}
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function restore_deleted_lesson(){
			
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

				$lessonCurData = $this->admin_mod->select_deleted_lesson_actual_data_by_id($data['lessonID']);
				
				if ($this->admin_mod->restore_deleted_lesson($data['lessonID']) == 1){
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Successfully Restore"
					);
				}

				// Audit trail
				if ($is_done['done'] == "TRUE" && $lessonCurData != NULL){
					if (sizeof($lessonCurData) > 0){
						$actionDone = "Restore lesson (".$lessonCurData[0]['title'].")";
						$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'LESS', $facultyIDNum);
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

		public function get_all_deleted_lessons_by_current_user(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$lessons = $this->admin_mod->select_all_deleted_lessons($facultyIDNum);
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

		public function search_deleted_lessons(){

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
				$lessons = $this->admin_mod->select_deleted_lessons($data['search_str']);
			}
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($lessons));
		}

		public function get_lesson_by_id(){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$lesson_id = $this->input->post('lesson_id');
			$is_actual_data = $this->input->post('is_actual_data');

			$data = array(
				"lesson_id" => $lesson_id,
				"is_actual_data" => $is_actual_data
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("lesson_id", "Lesson ID", "trim|required");
			$this->form_validation->set_rules("is_actual_data", "Is actual data", "trim|required");

			$lessons = array();

			if ($this->form_validation->run() === TRUE){

				if ($data['is_actual_data'] == "YES"){
					$lessons = $this->admin_mod->select_lesson_actual_data_by_id($data['lesson_id']);
				}else{
					$lessons = $this->admin_mod->select_lesson_by_id($data['lesson_id']);
				}

				if ($lessons == NULL){
					$lessons = array();
				}

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


		public function get_all_audit_trails(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$userType = $this->get_user_type();
			if ($userType == "faculty" || $userType == "dean"){
				redirect("/admin_main_panel");
			}
			$audit_trail_list = $this->admin_mod->select_all_audit_trail();

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($audit_trail_list));
		}

		public function search_audit_trail(){

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$affectedModule = ($this->input->post('affectedModule') != "") ? $this->input->post('affectedModule') : "";
			$startDate = ($this->input->post('startDate') != "") ? $this->input->post('startDate') : "";
			$endDate = ($this->input->post('endDate') != "") ? $this->input->post('endDate') : "";

			$startDate = $this->toValidMySQLDate($startDate);
			$endDate = $this->toValidMySQLDate($endDate);

			$data = array(
				"affectedModule" => $affectedModule,
				"startDate" => ($startDate == "1970-01-01") ? "" : $startDate,
				"endDate" => ($endDate == "1970-01-01") ? "" : $endDate
			);
			
			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("affectedModule", "Affected Module", "trim");
			$this->form_validation->set_rules("startDate", "Start Date", "trim");
			$this->form_validation->set_rules("endDate", "End Date", "trim");

			$audits = array();

			if ($this->form_validation->run() === TRUE){
				
				$audits = $this->admin_mod->select_audit_trail($data['affectedModule'], $data['startDate'], $data['endDate']);

			}else{
				$audits = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}


			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($audits));
		}


		public function add_lesson_comment(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			
			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$data = array(
				"lessonID" => $this->input->post('lessonID'),
				"comments" => $this->input->post('comments')
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);

			$this->form_validation->set_rules("lessonID", "Lesson ID", "trim|required|is_natural");
			$this->form_validation->set_rules("comments", "Comments", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{

				if ($this->students_mod->insert_lesson_comment($data['lessonID'], $data['comments'], $facultyIDNum, 'FAC') == 1){

					$is_done = array(
						"done" => "TRUE",
						"msg" => "Inserted Successfully"
					);
				}

			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function update_faculty_profile(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			// $userType = $this->get_user_type();
			// if ($userType == "faculty" || $userType == "dean"){
			// 	redirect("/admin_main_panel");
			// }

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$facultyID = $this->session->userdata('admin_session_faculty_id');
			$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$data = array(
				"facultyID" => $facultyID,
				"faculty_id_num" => $this->input->post('faculty_id_num'),
				"email" => $this->input->post('email'),
				"lastname" => $this->input->post('lastname'),
				"firstname" => $this->input->post('firstname'),
				"facultyIDNum" => $facultyIDNum,
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);

			$this->form_validation->set_rules("facultyID", "faculty ID", "trim|required"); 
			$this->form_validation->set_rules("faculty_id_num", "Faculty ID number", "trim|required|is_natural");
			$this->form_validation->set_rules("email", "email", "trim|required|valid_email");
			$this->form_validation->set_rules("lastname", "Faculty Lastname", "trim|required");
			$this->form_validation->set_rules("firstname", "Faculty Firstname", "trim|required");
			$this->form_validation->set_rules("facultyIDNum", "Faculty id number", "trim|required"); 

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{

				$is_faculty_id_or_email_valid = TRUE;

				$faculty_data = $this->admin_mod->select_faculty_by_id_and_id_number($facultyID, $facultyIDNum);

				if ($faculty_data != NULL){
					if (sizeof($faculty_data) > 0){
						$is_done = array(
							"done" => "FALSE",
							"msg" => "The faculty id number is already used"
						);

						$is_faculty_id_or_email_valid = FALSE;
					}
				}
					

				$faculty_data = $this->admin_mod->select_faculty_by_id_and_email($facultyID, $data['email']);

				if ($faculty_data != NULL){
					if (sizeof($faculty_data) > 0){
						$is_done = array(
							"done" => "FALSE",
							"msg" => "The email is already used"
						);

						$is_faculty_id_or_email_valid = FALSE;
					}
				}
					
				if ($is_faculty_id_or_email_valid == TRUE){
					$pswd = $this->input->post('password');
					$pswd_conf = $this->input->post('confirm_pass');

					// $facuCurData = $this->admin_mod->select_faculty_by_id($data['facultyID']);

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

							$data['password'] = $hashPass;
							
							// $facuCurData['cur_pswd'] = $this->admin_mod->select_faculty_password_by_id($data['facultyID']);

							if ($this->admin_mod->update_faculty_with_pass($data) == 1){

								// $this->faculty_update_audit_trail($facuCurData, $data, 'with_pass');

								$is_done = array(
									"done" => "TRUE",
									"msg" => "Updated Successfully with password"
								);
							}
						}
						
					}else{

						if ($this->admin_mod->update_faculty_without_pass($data) == 1){

							// $this->faculty_update_audit_trail($facuCurData, $data, 'without_pass');

							$is_done = array(
								"done" => "TRUE",
								"msg" => "Updated Successfully"
							);
						}
					}
				}

					
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}

		public function add_new_chapter_quiz(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$chapterID = $this->input->post('chapterID');
			$quiz_title = $this->input->post('quiz_title');
			$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$data = array(
				"chapterID" => $chapterID,
				"quiz_title" => $quiz_title,
				"facultyIDNum" => $facultyIDNum
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("chapterID", "Chapter ID", "trim|required");
			$this->form_validation->set_rules("quiz_title", "Quiz Title", "trim|required");
			$this->form_validation->set_rules("facultyIDNum", "Faculty ID Number", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{
				
				$slug = url_title($data['quiz_title'],'underscore', TRUE);

				if ($this->admin_mod->insert_new_chapter_quiz($data['chapterID'], $data['quiz_title'], $slug, $data['facultyIDNum']) == 1){

					$chapterData = $this->admin_mod->select_chapter_by_id($data['chapterID']);

					if ($chapterData != null){
						if (sizeof($chapterData) > 0){

							// Audit Trail
							$actionDone = "Added new quiz (". $chapterData['chapterTitle'] ." - ". $data['quiz_title'] .")";
							$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'QUIZ', $facultyIDNum);

						}
					}

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


		public function get_all_chapter_quizes(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$results = array();

			$chapterID = $this->input->post('chapterID');

			$data = array(
				"chapterID" => $chapterID
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("chapterID", "Chapter ID", "trim|required");

			if ($this->form_validation->run() === TRUE){
				$results = $this->admin_mod->select_all_chapter_quiz($data['chapterID']);
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($results));
		}


		public function add_quiz_question(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$is_done = array(
				"done" => "FALSE",
				"msg" => "",
				"questionID" => 0
			);

			$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$data = array(
				"quizID" => $this->input->post('quizID'),
				"question" => $this->input->post('question'),
				"addedByFacultyNum" => $facultyIDNum
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("quizID", "Quiz ID", "trim|required|is_natural");
			$this->form_validation->set_rules("question", "Question", "trim|required");
			$this->form_validation->set_rules("addedByFacultyNum", "Faculty Number", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>'),
					"questionID" => 0
				);
			}else{

				$questionID = $this->admin_mod->insert_new_quiz_question($data['quizID'], $data['question'], $data['addedByFacultyNum']);

				if ($questionID != false){

					$quizData = $this->admin_mod->select_chapter_quiz_by_id($data['quizID']);

					if ($quizData != null){
						if (sizeof($quizData) > 0){
							// Audit Trail
							$actionDone = "Add new quiz question - ". $quizData['quizTitle'] ." -> " . $data['question'];
							$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'QUES', $facultyIDNum);
						}
					}

					$is_done = array(
						"done" => "TRUE",
						"msg" => "Inserted Successfully",
						"questionID" => $questionID
					);
				}
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function get_quiz_questions_by_id(){
			
			$question_data = array();

			$data = array(
				"questionID" => $this->input->post('questionID'),
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("questionID", "Question ID", "trim|required|is_natural");

			if ($this->form_validation->run() === TRUE){
				$question_data = $this->admin_mod->select_quiz_question_by_id($data['questionID']);
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($question_data));

		}


		public function update_quiz_question(){
				
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$data = array(
				"questionID" => $this->input->post('questionID'),
				"question" => $this->input->post('question')
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("questionID", "Question ID", "trim|required|is_natural");
			$this->form_validation->set_rules("question", "Question", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{

				$question_data = $this->admin_mod->select_quiz_question_by_id($data['questionID']);

				// print_r($question_data);
				if ($this->admin_mod->update_quiz_question($data['questionID'], $data['question']) == 1){

					if ($question_data != NULL){
						if (sizeof($question_data) > 0){
							// Audit Trail
							$actionDone = "Update quiz question - ". $question_data['question'] ." -> " . $data['question'];
							$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'QUES', $facultyIDNum);
						}
					}


					$is_done = array(
						"done" => "TRUE",
						"msg" => "Updated Successfully"
					);
				}

			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}

		public function add_question_choice(){
			

			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$questionID = $this->input->post('questionID');
			$choiceLen = $this->input->post('choiceLen');

			$data = array(
				"questionID" => $this->input->post('questionID'),
				"choiceLen" => $this->input->post('choiceLen'),
				"addedByFacultyNum" => $facultyIDNum
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("questionID", "Question ID", "trim|required|is_natural");
			$this->form_validation->set_rules("choiceLen", "Number of Choices", "trim|required");
			$this->form_validation->set_rules("addedByFacultyNum", "Faculty Number", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{

				$choiceLen = (int) $data['choiceLen'];

				$countAddedSuccessful = 0;

				for($i=0; $i<$choiceLen; $i++){

					$choice = $this->input->post('choice_'.$i);
					$isChoiceRight = $this->input->post('isChoiceIsRightAns_'.$i);

					if (! empty($choice) && is_numeric($isChoiceRight)){

						if ($this->admin_mod->insert_question_choice($data['questionID'], $choice, $isChoiceRight, $data['addedByFacultyNum']) == 1){

							$questionData = $this->admin_mod->select_quiz_question_by_id($data['questionID']);

							if ($questionData != null){
								if (sizeof($questionData) > 0){
									// Audit Trail
									$actionDone = "Add new question's choice - ". $questionData['question'] ." -> " . $choice;
									$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'ANS', $facultyIDNum);
								}
							}

							$countAddedSuccessful += 1;
							
						}

					}

				}

				// echo $countAddedSuccessful ." - ". $data['choiceLen'];
				if ($countAddedSuccessful == ((int) $data['choiceLen'])){
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Inserted Successfully"
					);
				}else{
					$is_done = array(
						"done" => "TRUE",
						"msg" => $countAddedSuccessful . " choices inserted successfully"
					);
				}
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function update_question_choice(){
				
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$data = array(
				"choiceID" => $this->input->post('choiceID'),
				"choice" => $this->input->post('choice')
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("choiceID", "Choice ID", "trim|required|is_natural");
			$this->form_validation->set_rules("choice", "Choice", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{

				$choice_data = $this->admin_mod->select_choices_by_id($data['choiceID']);

				if ($this->admin_mod->update_question_choice($data['choiceID'], $data['choice']) == 1){

					if ($choice_data != NULL){
						if (sizeof($choice_data) > 0){
							// Audit Trail
							$actionDone = "Update question choice - ". $choice_data['choiceStr'] ." -> " . $data['choice'];
							$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'ANS', $facultyIDNum);
						}
					}


					$is_done = array(
						"done" => "TRUE",
						"msg" => "Updated Successfully"
					);
				}

			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function add_new_question_choice(){
				
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$data = array(
				"questionID" => $this->input->post('questionID'),
				"choice" => $this->input->post('choice'),
				"isAns" => $this->input->post('isAns')
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("questionID", "Question ID", "trim|required|is_natural");
			$this->form_validation->set_rules("choice", "Choice", "trim|required");
			$this->form_validation->set_rules("isAns", "isAns", "trim|required|is_natural");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{

				if ($this->admin_mod->insert_question_choice($data['questionID'], $data['choice'], $data['isAns'], $facultyIDNum) == 1){
					$is_done = array(
						"done" => "TRUE",
						"msg" => "Added Successfully"
					);
				}
			}	


			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function get_questions_choice_by_id(){
			
			$choice_data = array();

			$data = array(
				"choiceID" => $this->input->post('choiceID'),
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("choiceID", "Choice ID", "trim|required|is_natural");

			if ($this->form_validation->run() === TRUE){
				$choice_data = $this->admin_mod->select_choices_by_id($data['choiceID']);
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($choice_data));

		}

		public function get_quiz_questions_and_choices_tmp($data){

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("quizID", "Quiz ID", "trim|required|is_natural");

			if ($this->form_validation->run() === TRUE){
				$quiz_questions = $this->admin_mod->select_all_quiz_questions($data['quizID']);

				$questions_len = sizeof($quiz_questions);

				for($i=0; $i<$questions_len; $i++){
					$questionIDTmp = $quiz_questions[$i]['id'];
					$facultyIDNum = $quiz_questions[$i]['addedByFacultyNum'];

					$choices = $this->admin_mod->select_question_choices_by_id($questionIDTmp);
					$correctAnsLenArr = $this->admin_mod->select_number_of_correct_ans($questionIDTmp);

					$correctAnsLen = 0;
					if ($correctAnsLenArr != NULL){
						$correctAnsLen = $correctAnsLenArr['count'];
					}
					
					if ($choices == NULL){
						$quiz_questions[$i]['choices'] = array();
						$quiz_questions[$i]['choicesCorrectAnsLen'] = 0;
					}else{	
						$quiz_questions[$i]['choices'] = $choices;
						$quiz_questions[$i]['choicesCorrectAnsLen'] = $correctAnsLen;					
					}
					

					$facultyData = $this->admin_mod->select_faculty_by_id_num($facultyIDNum);

					if ($facultyData != null){
						if (sizeof($facultyData) > 0){
							$quiz_questions[$i]['facultyName'] = $facultyData['firstName'] ." ". $facultyData['lastName'];
						}else{
							$quiz_questions[$i]['facultyName'] = "Not found";
						}
					}
					
				}

				return $quiz_questions;
			}

			return array();
		}

		public function get_quiz_questions_and_choices_matrix(){
			
			$data = array(
				"quizID" => $this->input->post('quizID'),
			);

			$matrix = $this->get_quiz_questions_and_choices_tmp($data);

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($matrix));

		}


		public function get_quiz_questions_and_choices_matrix_get($quizID){
			
			$data = array(
				"quizID" => $quizID
			);

			$matrix = $this->get_quiz_questions_and_choices_tmp($data);

			return $matrix;
		}


		public function delete_quiz_question(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$questionID = $this->input->post('questionID');
			// $quizID = $this->input->post('quizID');

			$data = array(
				"questionID" => $questionID
			);
			// "quizID" => $quizID
			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("questionID", "Question ID", "trim|required");
			// $this->form_validation->set_rules("quizID", "Quiz ID", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{
				
				$questionData = $this->admin_mod->select_quiz_question_by_id($data['questionID']);
				// $quizID = $this->admin_mod->select_quiz_question_by_id($data['questionID']);

				if ($this->admin_mod->mark_quiz_question_data_as_deleted($data['questionID']) == 1){

					if ($questionData != NULL){
						// audit trail
						$facultyIDNum = $this->session->userdata('admin_session_facultyNum'); // it can be use in audit trail later
						$actionDone = "Remove Question -> " . $questionData['question'];
						$this->admin_mod->insert_audit_trail_new_entry($actionDone, "QUES", $facultyIDNum);
					}
					

					$is_done = array(
						"done" => "TRUE",
						"msg" => "Successfully Deleted"
					);
				}
			}
			
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function delete_question_choice(){
				
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$facultyIDNum = $this->session->userdata('admin_session_facultyNum');

			$data = array(
				"choiceID" => $this->input->post('choiceID')
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("choiceID", "Choice ID", "trim|required|is_natural");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{

				$choice_data = $this->admin_mod->select_choices_by_id($data['choiceID']);

				if ($this->admin_mod->mark_question_choice_as_deleted($data['choiceID']) == 1){

					if ($choice_data != NULL){
						if (sizeof($choice_data) > 0){
							// Audit Trail
							$actionDone = "Deleted question choice - ". $choice_data['choiceStr'];
							$this->admin_mod->insert_audit_trail_new_entry($actionDone, 'ANS', $facultyIDNum);
						}
					}


					$is_done = array(
						"done" => "TRUE",
						"msg" => "Deleted Successfully"
					);
				}

			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function get_all_stds_quizzes_results(){

			$stdQuizzes = $this->admin_mod->get_std_quizzes_results(200);

			$quizzesLen = sizeof($stdQuizzes);

			for($i=0; $i<$quizzesLen; $i++){
				$rightAnsLen = $this->students_mod->get_quiz_number_right_answers($stdQuizzes[$i]['quizID']);

				if ($rightAnsLen != NULL){
					$stdQuizzes[$i]['rightAnsLen'] = $rightAnsLen['count'];
				}else{
					$stdQuizzes[$i]['rightAnsLen'] = 0;
				}
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($stdQuizzes));
		}

	}

?>