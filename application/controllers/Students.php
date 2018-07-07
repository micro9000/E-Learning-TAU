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

		public function home(){
			$data['page_title'] = "Home - Students";
			$data['page_code'] = "home";

			$this->load->view("students/header", $data);
			// $this->load->view("students/topbar");
			// $this->load->view("students/sidebar");
			$this->load->view("main/sidebar");
			$this->load->view("main/topbar");
			$this->load->view("main/home");
			$this->load->view("students/footer");
		}

	}

?>