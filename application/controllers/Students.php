<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Students extends CI_Controller{

		public function index(){

			if ($this->is_student_still_logged_in() === TRUE){
				redirect("/home_page");
			}

			$data['page_title'] = "Login - Students";
			$data['page_code'] = "login";
			$data['agriculture_matrix'] = $this->admin_mod->get_principles_sub_topics_chapters_matrix();

			$this->load->view("students/header", $data);
			$this->load->view("students/topbar");
			$this->load->view("students/sidebar");
			$this->load->view("students/login");
			$this->load->view("students/footer");
		}

		public function registration(){

			if ($this->is_student_still_logged_in() === TRUE){
				redirect("/home_page");
			}

			$data['page_title'] = "Registration";
			$data['page_code'] = "registration";
			$data['agriculture_matrix'] = $this->admin_mod->get_principles_sub_topics_chapters_matrix();

			$this->load->view("students/header", $data);
			$this->load->view("students/topbar");
			$this->load->view("students/sidebar");
			$this->load->view("students/register");
			$this->load->view("students/footer");
		}


		public function registration_code($stdNum=""){

			if ($this->is_student_still_logged_in() === TRUE){
				redirect("/home_page");
			}

			if ($stdNum == ""){
				show_404();
			}

			if ($this->session->has_userdata('student_num_registration')){
				if ($stdNum != $this->session->userdata('student_num_registration')){
					show_404();
				}
			}else{
				redirect("/student_registration_page");
			}

			$data['page_code'] = "registration_code";
			$data['page_title'] = "Registration";
			$data['agriculture_matrix'] = $this->admin_mod->get_principles_sub_topics_chapters_matrix();

			$this->load->view("students/header", $data);
			$this->load->view("students/topbar");
			$this->load->view("students/sidebar");

			if ($this->session->has_userdata('student_num_registration')){
				$this->load->view("students/registration_code");
			}else{
				$this->load->view("students/registration_exprd");
			}

			$this->load->view("students/footer");
		}

		public function registration_done_msg(){

			if ($this->is_student_still_logged_in() === TRUE){
				redirect("/home_page");
			}

			$data['page_title'] = "Registration";
			$data['page_code'] = "registration_code";
			$data['agriculture_matrix'] = $this->admin_mod->get_principles_sub_topics_chapters_matrix();

			$this->load->view("students/header", $data);
			$this->load->view("students/topbar");
			$this->load->view("students/sidebar");
			$this->load->view("students/done_registration");
			$this->load->view("students/footer");
		}


		public function password_recovery(){

			if ($this->is_student_still_logged_in() === TRUE){
				redirect("/home_page");
			}

			$data['page_title'] = "Password Recovery";
			$data['page_code'] = "passwd_recovery_page";
			$data['agriculture_matrix'] = $this->admin_mod->get_principles_sub_topics_chapters_matrix();

			$this->load->view("students/header", $data);
			$this->load->view("students/topbar");
			$this->load->view("students/sidebar");
			$this->load->view("students/password_recovery");
			$this->load->view("students/footer");
		}


		public function password_recovery_code($stdNum=""){

			if ($stdNum == ""){
				show_404();
			}

			if ($this->session->has_userdata('student_num_recovery')){
				if ($stdNum != $this->session->userdata('student_num_recovery')){
					show_404();
				}
			}else{
				redirect("/student_login_page");
			}

			$data['page_code'] = "pswd_recovery_code";
			$data['page_title'] = "Password Recovery";
			$data['agriculture_matrix'] = $this->admin_mod->get_principles_sub_topics_chapters_matrix();

			$this->load->view("students/header", $data);
			$this->load->view("students/topbar");
			$this->load->view("students/sidebar");

			if ($this->session->has_userdata('student_num_recovery')){
				$this->load->view("students/password_recovery_code");
			}else{
				$this->load->view("students/password_recovery_code_exprd");
			}

			$this->load->view("students/footer");
		}

		//
		public function student_change_password_form(){

			if ($this->session->has_userdata('student_num_recovery') && 
				$this->session->has_userdata('is_ready_to_change_pswd') && 
				$this->session->userdata('is_ready_to_change_pswd') == 'YES'){
				
				$data['page_code'] = "change_password";
				$data['page_title'] = "Password Recovery";
				$data['agriculture_matrix'] = $this->admin_mod->get_principles_sub_topics_chapters_matrix();

				$this->load->view("students/header", $data);
				$this->load->view("students/topbar");
				$this->load->view("students/sidebar");

				$this->load->view("students/change_password");

				$this->load->view("students/footer");

			}else{
				redirect("/student_login_page");
			}
				
		}


		public function pswd_recovery_done_msg(){

			if ($this->is_student_still_logged_in() === TRUE){
				redirect("/home_page");
			}

			$data['page_title'] = "Registration";
			$data['page_code'] = "registration_code";
			
			$data['agriculture_matrix'] = $this->admin_mod->get_principles_sub_topics_chapters_matrix();

			$this->load->view("students/header", $data);
			$this->load->view("students/topbar");
			$this->load->view("students/sidebar");
			$this->load->view("students/done_password_recovery");
			$this->load->view("students/footer");
		}

		public function home(){

			if ($this->is_student_still_logged_in() === FALSE){
				redirect("/student_login_page");
			}

			$data['page_title'] = "Home - Students";
			$data['page_code'] = "home";
			$data['agriculture_matrix'] = $this->admin_mod->get_principles_sub_topics_chapters_matrix();

			// $data['latest_lessons_cover_img'] = $this->students_mod->select_latest_lessons_cover_img();

			$latest_lessons_with_cover = $this->students_mod->select_latest_lessons_with_cover();
			$data['latest_lessons_with_cover_len'] = sizeof($latest_lessons_with_cover);
			$data['latest_lessons_with_cover'] = $latest_lessons_with_cover;

			$latest_lessons_without_cover =$this->students_mod->select_latest_lessons_without_cover();
			$data['latest_lessons_without_cover_len'] = sizeof($latest_lessons_without_cover);
			$data['latest_lessons_without_cover'] = $latest_lessons_without_cover;

			$this->load->view("students/header", $data);
			$this->load->view("main/sidebar");
			$this->load->view("main/topbar");
			$this->load->view("main/home");
			$this->load->view("students/footer");
		}

		public function view_lesson($lessonID=0, $slug=""){

			if ($this->is_student_still_logged_in() === FALSE){
				redirect("/student_login_page");
			}

			$lessonData = array(
						'id' => $lessonID,
						'slug' => $slug
					);

			$lessonData = $this->security->xss_clean($lessonData);

			$data['page_title'] = "Home - Students";
			$data['page_code'] = "view_lesson";
			$data['agriculture_matrix'] = $this->admin_mod->get_principles_sub_topics_chapters_matrix();


			$lessonData = $this->admin_mod->select_lesson_by_id($lessonData['id']);
			$data['lesson_data'] = $lessonData;

			$chapter_lessons = $this->admin_mod->select_lesson_by_chapter_id($lessonData[0]['chapterID']);
			$data['chapter_lessons'] = $chapter_lessons;

			$quizzes = $this->admin_mod->select_all_chapter_quiz($lessonData[0]['chapterID']);
			$data['quizzes'] = $quizzes;

			$this->load->view("students/header", $data);
			$this->load->view("main/sidebar");
			$this->load->view("main/topbar");
			$this->load->view("main/view_lesson");
			$this->load->view("students/footer");
		}

		public function update_profile(){

			if ($this->is_student_still_logged_in() === FALSE){
				redirect("/student_login_page");
			}

			$studentID = $this->session->userdata('std_session_id');
			$studentIDNum = $this->session->userdata('std_session_stdNum');

			if (is_numeric($studentID) && $studentID > 0 && $studentID != 0 && $studentIDNum != ""){

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

			$data['page_title'] = "Student Profile";
			$data['page_code'] = "student_profile_panel";
			$data['agriculture_matrix'] = $this->admin_mod->get_principles_sub_topics_chapters_matrix();

			$this->load->view("students/header", $data);
			$this->load->view("main/sidebar");
			$this->load->view("main/topbar");
			$this->load->view("students/update_profile");
			$this->load->view("students/footer");
		}

		public function profile(){

			if ($this->is_student_still_logged_in() === FALSE){
				redirect("/student_login_page");
			}

			$studentID = $this->session->userdata('std_session_id');
			$studentIDNum = $this->session->userdata('std_session_stdNum');

			if (is_numeric($studentID) && $studentID > 0 && $studentID != 0 && $studentIDNum != ""){

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

			$data['page_title'] = "Student Profile";
			$data['page_code'] = "student_profile_panel";
			$data['agriculture_matrix'] = $this->admin_mod->get_principles_sub_topics_chapters_matrix();

			$this->load->view("students/header", $data);
			$this->load->view("main/sidebar");
			$this->load->view("main/topbar");
			$this->load->view("students/profile");
			$this->load->view("students/footer");
		}

		public function search_lessons_view($search_str=""){
			if ($this->is_student_still_logged_in() === FALSE){
				redirect("/student_login_page");
			}

			$data = array(
				"search_str" => $search_str
			);

			$data['lessons_data'] = array();

			if ($data['search_str'] != ""){

				$data = $this->security->xss_clean($data);

				$this->form_validation->set_data($data);
				$this->form_validation->set_rules("search_str", "Search String", "trim|required");

				if ($this->form_validation->run() === TRUE){
					$data['lessons_data'] = $this->admin_mod->select_lessons($data['search_str']);
				}else{
					$data['lessons_data'] = $this->students_mod->select_latest_lessons_with_or_without_cover();
				}

			}else{
				$data['lessons_data'] = $this->students_mod->select_latest_lessons_with_or_without_cover();
			}

			$data['lessons_data_len'] = sizeof($data['lessons_data']);

			$data['page_title'] = "Search Lesson - Students";
			$data['page_code'] = "search_lessons";
			$data['agriculture_matrix'] = $this->admin_mod->get_principles_sub_topics_chapters_matrix();

			// $data['search_string'] = rawurldecode(rawurldecode($search_str));
			
			$this->load->view("students/header", $data);
			$this->load->view("main/sidebar");
			$this->load->view("main/topbar");
			$this->load->view("main/search_lessons");
			$this->load->view("students/footer");
		}

		public function add_chapter_quiz($chapterID=0){

			if ($this->is_student_still_logged_in() === FALSE){
				redirect("/student_login_page");
			}

			$lessonData = array(
						'id' => $lessonID,
						'slug' => $slug
					);

			$lessonData = $this->security->xss_clean($lessonData);

			$data['page_title'] = "Home - Students";
			$data['page_code'] = "view_lesson";
			$data['agriculture_matrix'] = $this->admin_mod->get_principles_sub_topics_chapters_matrix();

			$lessonData = $this->admin_mod->select_lesson_by_id($lessonData['id']);
			$data['lesson_data'] = $lessonData;

			$chapter_lessons = $this->admin_mod->select_lesson_by_chapter_id($lessonData[0]['chapterID']);
			$data['chapter_lessons'] = $chapter_lessons;

			$this->load->view("students/header", $data);
			$this->load->view("main/sidebar");
			$this->load->view("main/topbar");
			$this->load->view("main/view_lesson");
			$this->load->view("students/footer");
		}

		public function search_lessons($search_str=""){

			if ($this->is_student_still_logged_in() === FALSE){
				redirect("/student_login_page");
			}

			$search_str = rawurlencode($search_str);
			redirect(base_url("search_lessons_view/". $search_str));
		}


		public function chapter_take_quiz($quizID="", $quiz_slug){

			if ($this->is_student_still_logged_in() === FALSE){
				redirect("/student_login_page");
			}

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

			$chapterData = $this->admin_mod->select_chapter_by_id($quiz_data['chapterID']);
			$data['chapterData'] = $chapterData;

			$topicData = $this->admin_mod->select_principles_sub_topic_by_topic_id($chapterData['topicID']);
			$data['topicData'] = $topicData;
			
			$principleData = $this->admin_mod->select_principle_by_id($chapterData['principleID']);
			$data['principleData'] = $principleData;

			$data['page_title'] = "Quiz - Students";
			$data['page_code'] = "chapter_take_quiz";
			$data['agriculture_matrix'] = $this->admin_mod->get_principles_sub_topics_chapters_matrix();

			$data['quiz_questions_choices_matrix'] = $this->get_quiz_questions_and_choices_matrix($quizData['quizID']);

			$this->load->view("students/header", $data);
			$this->load->view("main/sidebar");
			$this->load->view("main/topbar");
			$this->load->view("main/take_chapter_quiz");
			$this->load->view("students/footer");
		}


		public function chapter_take_quiz_results($resultsID){

			if ($this->is_student_still_logged_in() === FALSE){
				redirect("/student_login_page");
			}

			$studentIDNum = $this->session->userdata('std_session_stdNum');

			$resultsID = $this->security->xss_clean($resultsID);

			$quiz_results = $this->students_mod->get_std_last_chapter_quiz($resultsID, $studentIDNum);

			if ($quiz_results != NULL){

				$data['quiz_results'] = $quiz_results;

				$quizData = array(
							'chapterID' => $quiz_results['chapterID'],
							'quizID' => $quiz_results['quizID']
						);

				$quizData = $this->security->xss_clean($quizData);

				$data['quiz_answers'] = $this->students_mod->get_std_last_chapter_quiz_answers($quiz_results['id'], $studentIDNum);

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

				$data['page_title'] = "Quiz - Students";
				$data['page_code'] = "chapter_take_quiz";
				$data['agriculture_matrix'] = $this->admin_mod->get_principles_sub_topics_chapters_matrix();

				$data['quiz_questions_choices_matrix'] = $this->get_quiz_questions_and_choices_matrix($quizData['quizID']);

				$this->load->view("students/header", $data);
				$this->load->view("main/sidebar");
				$this->load->view("main/topbar");
				$this->load->view("main/take_chapter_quiz_results");
				$this->load->view("students/footer");
			}else{
				show_404();
			}
		}


		public function quizzes_results(){

			if ($this->is_student_still_logged_in() === FALSE){
				redirect("/student_login_page");
			}

			// $studentID = $this->session->userdata('std_session_id');
			$studentIDNum = $this->session->userdata('std_session_stdNum');

			$quizzes_results = $this->students_mod->get_std_quizzes_results($studentIDNum);
			$quizzesLen = sizeof($quizzes_results);

			for($i=0; $i<$quizzesLen; $i++){
				$rightAnsLen = $this->students_mod->get_quiz_number_right_answers($quizzes_results[$i]['quizID']);

				if ($rightAnsLen != NULL){
					$quizzes_results[$i]['rightAnsLen'] = $rightAnsLen['count'];
				}else{
					$quizzes_results[$i]['rightAnsLen'] = 0;
				}
			}

			$data['quizzes_results'] = $quizzes_results;

			$data['page_title'] = "Student Profile";
			$data['page_code'] = "quizzes_results";
			$data['agriculture_matrix'] = $this->admin_mod->get_principles_sub_topics_chapters_matrix();

			$this->load->view("students/header", $data);
			$this->load->view("main/sidebar");
			$this->load->view("main/topbar");
			$this->load->view("students/quizzes_results");
			$this->load->view("students/footer");
		}

		//
		//
		//

		private function send_email($stdEmail,$subject , $msg){

			// $config['protocol'] = 'sendmail';
			// $config['mailpath'] = '/usr/sbin/sendmail';
			$config['charset'] = 'iso-8859-1';
			$config['wordwrap'] = TRUE;
			$config['mailtype'] = 'html';
			$this->email->initialize($config);

			$this->email->from('elearning.tau2018@gmai.com', 'ELearning');
			$this->email->to($stdEmail);
			// $this->email->cc('another@another-example.com');
			// $this->email->bcc('them@their-example.com');

			$this->email->subject($subject);
			$this->email->message($msg);

			$this->email->send();
		}


		public function destroy_student_session(){

			$sessions = array(
				'std_session_id',
				'std_session_stdNum',
				'std_session_firstName',
				'std_session_lastName',
				'std_session_email',
				'logged_in'
			);

			$this->session->unset_userdata($sessions);

			redirect('student_login_page');
		}

		public function is_student_still_logged_in(){
			if (
				$this->session->has_userdata('std_session_id') &&
				$this->session->has_userdata('logged_in') &&
				($this->session->userdata('logged_in') == TRUE)
				){

				return TRUE;
			}
			
			return FALSE;
		}

		public function login(){

			$is_done = array(
					"done" => "FALSE",
					"msg" => "Login failed"
				);

			$stdNum = $this->input->post('stdNum');
			$password = $this->input->post('password');

			$data = array(
				"stdNum" => $stdNum,
				"password" => $password
			);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("stdNum", "Student Number", "trim|required"); // |max_length[10]|min_length[10]
			$this->form_validation->set_rules("password", "Password", "trim|required");


			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors()
				);
			}else{
				$hashPass = hashSHA512($password);

				$results = $this->students_mod->is_student_can_login($data['stdNum'], $hashPass);

				if ($results != null){
					if (sizeof($results) > 0){
						if ($results['id'] > 0 && $results['stdNum'] != ''){

							$std_session_data = array(
								'std_session_id' => $results['id'],
								'std_session_stdNum' => $results['stdNum'],
								'std_session_firstName' => $results['firstName'],
								'std_session_lastName' => $results['lastName'],
								'std_session_email' => $results['email'],
								'logged_in' => TRUE
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
					
			}
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function add_lesson_comment(){
			
			if ($this->is_student_still_logged_in() === FALSE){
				redirect("/student_login_page");
			}

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$session_std_num = $this->session->userdata('std_session_stdNum');

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

				if ($this->students_mod->insert_lesson_comment($data['lessonID'], $data['comments'], $session_std_num, 'STD') == 1){

					$is_done = array(
						"done" => "TRUE",
						"msg" => "Inserted Successfully"
					);
				}

			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}

		public function toValidMySQLDateWithHrsMins($date){
            $dateTmp = strtotime($date);
            $date = date("Y-m-d H:i:s", $dateTmp);

            return $date;
        }

		public function getTimeSpan($commentedDate){

			$commentedDate = $this->toValidMySQLDateWithHrsMins($commentedDate);

            $arrTime = $this->students_mod->getDatesMinsDifference_today($commentedDate);

            $minutes = $arrTime['timeDiff'];

            // return $minutes;
            if ($minutes < 60){

                if ($minutes < 1){
                    return "less than a min ago";
                }else if ($minutes == 1){
                    return $minutes . " min ago";
                }else{
                    return $minutes . " mins ago";
                }

            }else if($minutes == 60){
                return ($minutes / 60) . " hr ago";
            }else if ($minutes > 60){

                $hrs = intval($minutes / 60);

                if ($hrs < 24){
                    return $hrs . " hrs ago";
                }else if ($hrs == 24){
                    return "1 day ago";
                }else{
                    $days = intval($hrs / 24);
                    $daysHrs = intval($hrs % 24);


                    if ($days > 365){
                    	$dateGreaterThan1Day = $this->students_mod->getFormattedDate_with_year($commentedDate);
	                    	
                    	return $dateGreaterThan1Day['formattedDate'];
                    }else{
                    	if ($days > 1){
	                    	$dateGreaterThan1Day = $this->students_mod->getFormattedDate_without_year($commentedDate);
	                    	
	                    	return $dateGreaterThan1Day['formattedDate'];
	                    }else{
	                    	if ($daysHrs > 0){
		                        if ($days == 1){
		                        	if ($daysHrs == 1){
		                        		return $days . " day and " . $daysHrs . " hr ago";
		                        	}else{
		                        		return $days . " day and " . $daysHrs . " hrs ago";	
		                        	}
		                        }else{
		                            return $days . " day/s and " . $daysHrs . " hrs ago";
		                        }
		                    }else{
		                        return $days . " days ago";
		                    }
	                    }
                    }
                }
            }

            $dateGreaterThan1Day = $this->students_mod->getFormattedDate_with_year($commentedDate);
        	return $dateGreaterThan1Day['formattedDate'];
        }

		public function get_all_lesson_comments(){
			
			if ($this->is_student_still_logged_in() === FALSE){
				redirect("/student_login_page");
			}

			$comments = array();

			$data = array(
				"lessonID" => $this->input->post('lessonID')
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);

			$this->form_validation->set_rules("lessonID", "Lesson ID", "trim|required|is_natural");

			if ($this->form_validation->run() === TRUE){
				$comments = $this->students_mod->get_all_lesson_comments($data['lessonID']);
			}

			$commentsLen = sizeof($comments);

			for($i=0; $i<$commentsLen; $i++){
				$comments[$i]['timelapse'] = $this->getTimeSpan($comments[$i]['dateCommented']);

				$userTypeTmp = $comments[$i]['userType'];
				$userIDNum = $comments[$i]['stdNum_facNum'];

				if ($userTypeTmp == 'STD'){
					$userDataTmp = $this->admin_mod->select_std_by_std_num($userIDNum);
					$comments[$i]['commentedBy'] = $userDataTmp['firstName'] ." ". $userDataTmp['lastName'];
				}else if ($userTypeTmp == 'FAC'){
					$userDataTmp = $this->admin_mod->select_faculty_by_id_num($userIDNum);
					$comments[$i]['commentedBy'] = $userDataTmp['firstName'] ." ". $userDataTmp['lastName'];
				}

			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($comments));
		}

		public function get_random_reg_code(){
			$today = date("Y-m-d H:i:s");
			$hashToday = hashSHA512($today) . rand();
			return substr($hashToday, 0, 6);
		}

		public function initial_registration(){
			

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$randomRegCode = $this->get_random_reg_code();
			$get_reg_exp_date = $this->students_mod->get_code_exp_date();

			$exp_date = $get_reg_exp_date['curDate'];

			$data = array(
				"student_id_num" => $this->input->post('student_id_num'),
				"email" => $this->input->post('email'),
				"lastname" => $this->input->post('lastname'),
				"firstname" => $this->input->post('firstname'),
				"password" => $this->input->post('password'),
				"confirm_pass" => $this->input->post('confirm_pass'),
				"regCode" => strtoupper($randomRegCode)
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
				$data['hashPass'] = $hashPass;
				$data['expDate'] = $this->toValidMySQLDateWithHrsMins($exp_date);

				if ($this->students_mod->insert_student_init_reg($data) == 1){

					$this->session->set_userdata("student_num_registration", $data['student_id_num']);

					$msg = "<h4 style='color: skyblue'>Verify your email address</h4>";
					$msg .= "<br/><br/>";
					$msg .= "<p>To finish setting up your ELearning account, we just need to make sure this email address is yours.</p>";
					$msg .= "<br/><br/>";
					$msg .= "<p>To verify your email address use this registration code: <strong>". $data['regCode'] ."</strong></p>";
					$msg .= "<br/><br/>";
					$msg .= "<p>If you didn't request this code, you can safely ignore this email. Someone else might have typed your email address by mistake.</p>";
					$msg .= "<br/><br/>";
					$msg .= "<p>Thanks, <br/> ELearning - Tarlac Agriculture University, Agriculture Department</p>";

					$this->send_email($data['email'], "E-Learning Registration Code", $msg);

					$is_done = array(
						"done" => "TRUE",
						"msg" => "Submitted Successfully, <br/> please visit your email account and enter the registration code"
					);
				}

			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}

		// private function send_email_notif_registration_code($code, $stdEmail, $stdNum){

		// 	// $config['protocol'] = 'sendmail';
		// 	// $config['mailpath'] = '/usr/sbin/sendmail';
		// 	$config['charset'] = 'iso-8859-1';
		// 	$config['wordwrap'] = TRUE;

		// 	$this->email->from('elearning.tau2018@gmai.com', 'ELearning');
		// 	$this->email->to('Raniel.Garcia@onsemi.com');
		// 	// $this->email->cc('another@another-example.com');
		// 	// $this->email->bcc('them@their-example.com');

		// 	$this->email->subject('Student Registertion - E-Learning Tarlac Agriculture University');
		// 	$this->email->message('Testing the email class.');

		// 	$this->email->send();
		// }

		public function verify_registration_code(){
			
			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			if (! $this->session->has_userdata('student_num_registration')){
				
				$is_done = array(
					"done" => "FALSE",
					"msg" => "Please go to registration page and input all required fields"
				);

			}else{

				$data = array(
					"registration_code" => $this->input->post('registration_code'),
					"std_num" => $this->session->userdata('student_num_registration')
				);


				$data = $this->security->xss_clean($data);

				$this->form_validation->set_data($data);
				$this->form_validation->set_rules("registration_code", "Registration Code", "trim|required|max_length[6]|min_length[6]");
				$this->form_validation->set_rules("std_num", "Student Number", "trim|required");



				if ($this->form_validation->run() === FALSE){
					$is_done = array(
						"done" => "FALSE",
						"msg" => validation_errors('<span>', '</span>')
					);
				}else{

					$is_code_exist = $this->students_mod->is_std_reg_code_exists($data['registration_code'], $data['std_num']);

					if ($is_code_exist == TRUE){

						$is_code_not_yet_exprd = $this->students_mod->is_std_reg_code_not_yet_exprd($data['registration_code']);

						if ($is_code_not_yet_exprd == TRUE){

							$is_std_code_not_not_yet_confrm = $this->students_mod->is_std_reg_code_not_yet_confirm($data['registration_code'], $data['std_num']);
							if ($is_std_code_not_not_yet_confrm == TRUE){


								$is_now_confirm = $this->students_mod->confirm_std_registration($data['registration_code'], $data['std_num']);

								if ($is_now_confirm == 1){

									$std_reg_data = $this->students_mod->get_std_reg_data($data['registration_code'], $data['std_num']);

									if ($this->students_mod->move_student_registered($std_reg_data) == 1){
										$is_done = array(
											"done" => "TRUE",
											"msg" => "You have been successfully registered!"
										);

										$this->session->unset_userdata("student_num_registration");
									}

								}

							}else{

								$is_done = array(
									"done" => "FALSE",
									"msg" => "Invalid Registration Code, please <a href='". base_url("student_initial_registration") ."'>register now</a>"
								);

								$this->session->unset_userdata("student_num_registration");

							}

						}else{

							$is_done = array(
								"done" => "FALSE",
								"msg" => "The entered registration code has expired, <a href='". base_url("student_initial_registration") ."'>register again</a>"
							);

							$this->session->unset_userdata("student_num_registration");
						}
					}else{

						$is_done = array(
							"done" => "FALSE",
							"msg" => "Invalid Registration Code..."
						);
					}


				}
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}

		

		public function check_is_student_enrolled($stdIDNum){

			$std_data = $this->admin_mod->select_std_num($stdIDNum);

			if ($std_data == NULL){
				// if (sizeof($std_data) == 0){
				// 	$this->form_validation->set_message('check_is_student_enrolled', 'Invalid {field}, you are not in the master list, please contact system admin.');
				// 	return FALSE;
				// }
				$this->form_validation->set_message('check_is_student_enrolled', 'Invalid {field}, you are not in the master list, please contact system admin.');
				return FALSE;
			}

			return TRUE;
		}


		public function check_std_id_number_already_used_on_insert($stdIDNum){

			$std_data = $this->admin_mod->select_std_by_id_and_id_number(0, $stdIDNum);

			if ($std_data != NULL){
				if (sizeof($std_data) > 0){
					$this->form_validation->set_message('check_std_id_number_already_used_on_insert', 'Invalid {field}, the {field} already used.');
					return FALSE;
				}
			}
				

			return TRUE;
		}


		public function check_std_email_already_used_on_insert($email){

			$std_data = $this->admin_mod->select_std_by_id_and_email(0, $email);

			if ($std_data != NULL){
				if (sizeof($std_data) > 0){
					$this->form_validation->set_message('check_std_email_already_used_on_insert', 'Invalid {field}, the {field} already used.');
					return FALSE;
				}
			}

			return TRUE;
		}

		public function recover_password(){

			$is_done = array(
					"done" => "FALSE",
					"msg" => "Please input all fields"
				);

			$stdNum = $this->input->post('stdNum');
			$stdEmail = $this->input->post('stdEmail');

			$data = array(
				"stdNum" => $stdNum,
				"email" => $stdEmail,
				"randomCode" => strtoupper($this->get_random_reg_code())
			);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("stdNum", "Student Number", "trim|required");
			$this->form_validation->set_rules("email", "Email address", "trim|required");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors()
				);
			}else{

				$std_data = $this->students_mod->get_std_data_for_pswd_recovery($data['stdNum'], $data['email']);

				if ($std_data != NULL){
					if (sizeof($std_data) > 0 && $std_data['count'] == "1"){

						$get_reg_exp_date = $this->students_mod->get_code_exp_date();
						$exp_date = $get_reg_exp_date['curDate'];
						$data['expDate'] = $this->toValidMySQLDateWithHrsMins($exp_date);

						if ($this->students_mod->insert_student_for_pswd_recovery($data) == 1){

							// send email

							$this->session->set_userdata("student_num_recovery", $data['stdNum']);

							$is_done = array(
								"done" => "TRUE",
								"msg" => "Successfully submitted, please check your email account to get the recovery code"
							);

						}

					}else{
						$is_done = array(
							"done" => "FALSE",
							"msg" => "Invalid student number or email"
						);

					}
				}
					
				
			}
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function verify_pswd_recovery_code(){
			
			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			if (! $this->session->has_userdata('student_num_recovery')){
				
				$is_done = array(
					"done" => "FALSE",
					"msg" => "Please go to registration page and input all required fields"
				);

			}else{

				$data = array(
					"recovery_code" => $this->input->post('recovery_code'),
					"std_num" => $this->session->userdata('student_num_recovery')
				);


				$data = $this->security->xss_clean($data);

				$this->form_validation->set_data($data);
				$this->form_validation->set_rules("recovery_code", "Recovery Code", "trim|required|max_length[6]|min_length[6]");
				$this->form_validation->set_rules("std_num", "Student Number", "trim|required");


				if ($this->form_validation->run() === FALSE){
					$is_done = array(
						"done" => "FALSE",
						"msg" => validation_errors('<span>', '</span>')
					);
				}else{

					$is_code_exist = $this->students_mod->is_std_recovery_code_exists($data['recovery_code'], $data['std_num']);

					if ($is_code_exist == TRUE){

						$is_code_not_yet_exprd = $this->students_mod->is_std_recovery_code_not_yet_exprd($data['recovery_code']);

						if ($is_code_not_yet_exprd == TRUE){

							$is_std_code_not_not_yet_confrm = $this->students_mod->is_std_recovery_code_not_yet_confirm($data['recovery_code'], $data['std_num']);
							if ($is_std_code_not_not_yet_confrm == TRUE){


								$is_now_confirm = $this->students_mod->confirm_std_pswd_recovery($data['recovery_code'], $data['std_num']);

								if ($is_now_confirm == 1){

									$is_done = array(
											"done" => "TRUE",
											"msg" => "Successfully Submitted!"
										);

									$this->session->set_userdata("is_ready_to_change_pswd", "YES");

									// $this->session->unset_userdata("student_num_recovery");

								}

							}else{

								$is_done = array(
									"done" => "FALSE",
									"msg" => "Invalid recovery code, <br/> <a href='". base_url("student_login_page") ."'>Login</a>"
								);

								$this->session->unset_userdata("student_num_recovery");

							}

						}else{

							$is_done = array(
								"done" => "FALSE",
								"msg" => "The entered recovery code has expired, <a href='". base_url("student_login_page") ."'>Login</a>"
							);

							$this->session->unset_userdata("student_num_recovery");
						}
					}else{

						$is_done = array(
							"done" => "FALSE",
							"msg" => "Invalid rcovery code..."
						);
					}


				}
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}


		public function change_student_password(){

			$is_done = array(
					"done" => "FALSE",
					"msg" => "Please input all fields"
				);

			if ($this->session->has_userdata('student_num_recovery') && 
				$this->session->has_userdata('is_ready_to_change_pswd') && 
				$this->session->userdata('is_ready_to_change_pswd') == 'YES'){

				$data = array(
					"new_password" => $this->input->post('new_password'),
					"confirm_pass" => $this->input->post('confirm_new_password'),
				);

				$this->form_validation->set_data($data);
				$this->form_validation->set_rules("new_password", "New Password", "trim|required");
				$this->form_validation->set_rules("confirm_pass", "Confirm Password", "trim|required|matches[new_password]");

				if ($this->form_validation->run() === FALSE){
					$is_done = array(
						"done" => "FALSE",
						"msg" => validation_errors()
					);
				}else{

					$data['student_num'] = $this->session->userdata("student_num_recovery");
					$data['new_password_hash'] = hashSHA512($data['new_password']);

					if ($this->students_mod->update_student_password($data) == 1){
						$is_done = array(
							"done" => "TRUE",
							"msg" => "You have been successfully changed your password"
						);

						$this->session->unset_userdata("student_num_recovery");
						$this->session->unset_userdata("is_ready_to_change_pswd");
					}
				}

			}else{
				$is_done = array(
					"done" => "FALSE",
					"msg" => "Unauthorized password change"
				);
			}
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}

		public function update_student_data(){

			if ($this->is_student_still_logged_in() === FALSE){
				redirect("/student_login_page");
			}

			$studentID = $this->session->userdata('std_session_id');
			$studentIDNum = $this->session->userdata('std_session_stdNum');

			$is_done = array(
				"done" => "FALSE",
				"msg" => ""
			);

			$data = array(
				"studentID" => $studentID, 
				"email" => $this->input->post('email'),
				"lastname" => $this->input->post('lastname'),
				"firstname" => $this->input->post('firstname'),
				"password" => $this->input->post('password'),
				"confirm_pass" => $this->input->post('confirm_pass'),
				"section" => $this->input->post('section')
			);

			$data = $this->security->xss_clean($data);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("studentID", "Student ID", "trim|required");
			$this->form_validation->set_rules("email", "Email", "trim|required|valid_email");
			$this->form_validation->set_rules("lastname", "Student Lastname", "trim|required");
			$this->form_validation->set_rules("firstname", "Student Firstname", "trim|required");
			$this->form_validation->set_rules("section", "Student Section", "trim");

			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors('<span>', '</span>')
				);
			}else{

				$is_email_valid = TRUE;

				$std_data = $this->admin_mod->select_std_by_id_and_email($studentID, $data['email']);

				if ($std_data != NULL){
					if (sizeof($std_data) > 0){
						$is_done = array(
							"done" => "FALSE",
							"msg" => "Invalid Email address, already used"
						);

						$is_email_valid = FALSE;
					}
				}

				if ($is_email_valid == TRUE){
					$pswd = $this->input->post('password');
					$pswd_conf = $this->input->post('confirm_pass');

					// $stdCurData = $this->admin_mod->select_std_by_id($data['studentID']);

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

							// $stdCurData['password'] = $this->admin_mod->select_std_pswd_by_id($data['studentID']);				

							if ($this->students_mod->update_student_with_pass($data) == 1){

								// $this->student_update_audit_trail($stdCurData, $data, "with_pass");

								$is_done = array(
									"done" => "TRUE",
									"msg" => "Updated Successfully with password"
								);
							}
						}
						
					}else{
					
						if ($this->students_mod->update_student_without_pass($data) == 1){

							// $this->student_update_audit_trail($stdCurData, $data, "without_pass");

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

		public function get_quiz_questions_and_choices_matrix($quizID){
			
			$matrix = array();

			$data = array(
				"quizID" => $quizID
			);

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
						$quiz_questions[$i]['choicesCorrectAnsLen'] = 0;
						$quiz_questions[$i]['choices'] = array();
					}else{
						$quiz_questions[$i]['choicesCorrectAnsLen'] = $correctAnsLen;
						$quiz_questions[$i]['choices'] = $choices;
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

				$matrix = $quiz_questions;
			}

			return $matrix;
			// $this->output->set_content_type('application/json');
			// $this->output->set_output(json_encode($matrix));

		}

		public function insert_student_quiz_answer(){

			$quiz_results_ID = 0;

			if ($this->is_student_still_logged_in() === FALSE){
				redirect("/student_login_page");
			}

			$studentIDNum = $this->session->userdata('std_session_stdNum');

			$is_done = array(
				"done" => "FALSE",
				"msg" => "",
				"quiz_results_ID" => 0
			);

			$answersInput = $this->input->post();
			$answers = $answersInput['ans'];
			
			$ansLen = sizeof($answers);

			$countAns = 0;

			$scoreCount = 0;

			if ($ansLen > 0){

				$dataResults = array(
						"chapterID" => $answers[0]['chapterID'],
						"quizID" => $answers[0]['quizID']
					);

				$dataResults = $this->security->xss_clean($dataResults);
				$this->form_validation->set_data($dataResults);
				$this->form_validation->set_rules("chapterID", "Chapter ID", "trim|required|is_natural");
				$this->form_validation->set_rules("quizID", "Quiz ID", "trim|required|is_natural");

				if ($this->form_validation->run() === TRUE){

					for($i=0; $i<$ansLen; $i++){

						$data = array(
							"questionID" => $answers[$i]['questionID'],
							"choiceID" => $answers[$i]['choiceID']
						);

						$data = $this->security->xss_clean($data);

						$this->form_validation->set_data($data);
						$this->form_validation->set_rules("questionID", "Question ID", "trim|required|is_natural");
						$this->form_validation->set_rules("choiceID", "Choice ID", "trim|required|is_natural");

						if ($this->form_validation->run() === TRUE){

							$is_choice_right_ans = $this->students_mod->is_choice_is_right_ans($data['choiceID'], $data['questionID']);

							if ($is_choice_right_ans != NULL){
								if (sizeof($is_choice_right_ans) > 0){
									if ($is_choice_right_ans['count'] == "1"){
										$scoreCount += 1;
									}
								}
							}
						}
					}// COMPUTING RIGHT ANSWERS

					// INSERT QUIZ RESULTS
					$quiz_results_ID = $this->students_mod->insert_student_quiz_results($dataResults['chapterID'], $dataResults['quizID'], $scoreCount, $studentIDNum);

					if ($quiz_results_ID !== NULL){
						if ($quiz_results_ID > 0){

							for($i=0; $i<$ansLen; $i++){

								$data = array(
									"resultsID" => $quiz_results_ID,
									"stdNum" => $studentIDNum,
									"questionID" => $answers[$i]['questionID'],
									"choiceID" => $answers[$i]['choiceID']
								);

								$data = $this->security->xss_clean($data);

								$this->form_validation->set_data($data);
								$this->form_validation->set_rules("questionID", "Question ID", "trim|required|is_natural");
								$this->form_validation->set_rules("choiceID", "Choice ID", "trim|required|is_natural");
								$this->form_validation->set_rules("resultsID", "Results ID", "trim|required|is_natural");

								if ($this->form_validation->run() === TRUE){

									if ($this->students_mod->insert_student_quiz_answer($data) == 1){
										$countAns += 1;
									}
									
								}
							}

						}
					}// INSERTING ANSWERS
					
				}

			}

			if ($ansLen == $countAns){
				$is_done = array(
					"done" => "TRUE",
					"msg" => "Successfully submitted",
					"quiz_results_ID" => $quiz_results_ID
				);
			}

			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}
	}

?>