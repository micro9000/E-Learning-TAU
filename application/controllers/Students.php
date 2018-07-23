<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Students extends CI_Controller{

		// public function __construct()
  //       {
  //               parent::__construct();
                
  //               $this->load->library('Authentication');
  //       }

		public function index(){

			if ($this->is_student_still_logged_in() === TRUE){
				redirect("/home_page");
			}

			$data['page_title'] = "Login - Students";
			$data['page_code'] = "login";

			$this->load->view("students/header", $data);
			$this->load->view("students/topbar");
			$this->load->view("students/sidebar");
			$this->load->view("students/login");
			$this->load->view("students/footer");
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

			// echo json_encode($is_done);
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($is_done));
		}

		public function get_principles_sub_topics_chapters_matrix(){

			$agriculture_matrix = array();

			$principles = $this->admin_mod->select_all_principles();
			$principlesLen = sizeof($principles);


			for($p=0; $p<$principlesLen; $p++){
				$agriculture_matrix[$p] = array(
							"principle_id" => $principles[$p]['id'],
							"principle" => $principles[$p]['principle'],
							"sub_topics" => array()
						);

				$principleID = $principles[$p]['id'];

				$principle_sub_topics = $this->admin_mod->select_principles_sub_topic_by_principle_id($principleID);
				$topicsLen = sizeof($principle_sub_topics);

				$topicChapters = array();

				for($st=0; $st<$topicsLen; $st++){

					$topicID = $principle_sub_topics[$st]['id'];

					$topicChapters = array(
									"topic_id" => $topicID,
									"topic" => $principle_sub_topics[$st]['topic'],
									"chapters" => array()
								);

					$chapters = $this->admin_mod->select_chapter_by_topic_id($topicID);
					$chaptersLen = sizeof ($chapters);

					for($ch=0; $ch<$chaptersLen; $ch++){
						$chapterID = $chapters[$ch]['id'];

						$topic_chapters = array(
									"chapter_id" => $chapterID,
									"chapter" => $chapters[$ch]['chapterTitle'],
									"lessons" => array()
								);

						$lessons = $this->admin_mod->select_lesson_by_chapter_id($chapterID);
						$lessonsLen = sizeof($lessons);

						for($les=0; $les<$lessonsLen; $les++){
							$lessonID = $lessons[$les]['id'];

							$lessonsList = array(
									"lessonID" => $lessonID,
									"lessonTitle" => $lessons[$les]['title'],
									"lessonSlug" => $lessons[$les]['slug']
							);

							array_push($topic_chapters['lessons'], $lessonsList);
						}

						array_push($topicChapters['chapters'], $topic_chapters);
						
					}
					array_push($agriculture_matrix[$p]['sub_topics'], $topicChapters);
				}

			}

			// echo "<pre>";
			// print_r($agriculture_matrix);
			// echo "</pre>";
			return $agriculture_matrix;
		}

		public function home(){

			if ($this->is_student_still_logged_in() === FALSE){
				redirect("/student_login_page");
			}

			$data['page_title'] = "Home - Students";
			$data['page_code'] = "home";
			$data['agriculture_matrix'] = $this->get_principles_sub_topics_chapters_matrix();

			$data['latest_lessons_cover_img'] = $this->students_mod->select_latest_lessons_cover_img();

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
			$data['agriculture_matrix'] = $this->get_principles_sub_topics_chapters_matrix();

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
	}

?>