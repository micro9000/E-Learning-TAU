<?php defined('BASEPATH') OR exit('No direct script access allowed');
	
	class Students extends CI_Controller{

		// public function __construct()
  //       {
  //               parent::__construct();
                
  //               $this->load->library('Authentication');
  //       }

		public function index(){

			$data['page_title'] = "Login - Students";
			$data['page_code'] = "login";

			$this->load->view("students/header", $data);
			$this->load->view("students/topbar");
			$this->load->view("students/sidebar");
			$this->load->view("students/login");
			$this->load->view("students/footer");
		}

		public function login(){

			$is_done = array(
					"done" => "FALSE",
					"msg" => ""
				);

			$stdNum = $this->input->post('stdNum');
			$password = $this->input->post('password');

			$data = array(
				"stdNum" => $stdNum,
				"password" => $password
			);

			$this->form_validation->set_data($data);
			$this->form_validation->set_rules("stdNum", "Student Number", "trim|required|max_length[10]|min_length[10]");
			$this->form_validation->set_rules("password", "Password", "trim|required");


			if ($this->form_validation->run() === FALSE){
				$is_done = array(
					"done" => "FALSE",
					"msg" => validation_errors()
				);
			}else{
				$hashPass = hashSHA512($password);

				$results = $this->students_mod->is_student_can_login($data['stdNum'], $hashPass);


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
						array_push($agriculture_matrix[$p]['sub_topics'], $topicChapters);
					}
				}

			}

			// echo "<pre>";
			// print_r($agriculture_matrix);
			// echo "</pre>";
			return $agriculture_matrix;
		}

		public function home(){
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

	}

?>