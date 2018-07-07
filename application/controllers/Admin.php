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
				$this->session->has_userdata('admin_session_admin_id') && 
				$this->session->has_userdata('admin_session_email') &&
				$this->session->has_userdata('admin_logged_in') &&
				($this->session->userdata('admin_logged_in') == TRUE)
				){

				return TRUE;
			}
			
			return FALSE;
		}

		public function destroy_admin_session(){

			$sessions = array(
				'admin_session_admin_id',
				'admin_session_faculty_id',
				'admin_session_facultyNum',
				'admin_session_firstName',
				'admin_session_lastName',
				'admin_session_email',
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

				$results = $this->admin_mod->is_faculty_admin_can_login($data['facNum'], $hashPass);

				if (sizeof($results) > 0){
					if ($results['adminID'] > 0 && $results['facultyIDNum'] != ""){

						$std_session_data = array(
							'admin_session_admin_id' => $results['adminID'],
							'admin_session_faculty_id' => $results['facultyID'],
							'admin_session_facultyNum' => $results['facultyIDNum'],
							'admin_session_firstName' => $results['firstName'],
							'admin_session_lastName' => $results['lastName'],
							'admin_session_email' => $results['email'],
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

			$data['page_title'] = "Admin Main Panel";
			$data['page_code'] = "main_panel";

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

			$data['principleID'] = 0;

			if (is_numeric($principleID) && $principleID > 0 && $principleID != 0){

				$principle_data = $this->admin_mod->select_principle_by_id($principleID);

				if (sizeof($principle_data) == 0){
					show_404();
				}

				$data['principle_to_update_data'] = $principle_data;
				$data['principleID'] = $principleID;
			}
			
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

			if (is_numeric($topicID) && $topicID > 0 && $topicID != 0){

				$topic_data = $this->admin_mod->select_principles_sub_topic_by_topic_id($topicID);

				if (sizeof($topic_data) == 0){
					show_404();
				}

				$data['topic_to_update_data'] = $topic_data;
				$data['topicID'] = $topicID;
				$data['principleID'] = $topic_data['principleID'];
			}

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

		##
		##
		## // ACTIONS:
		##
		##

		public function add_principle(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
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

		public function delete_principle(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
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


		public function add_principle_sub_topic(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
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

		public function get_all_principles_sub_topics(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
			}

			$principles = $this->admin_mod->select_all_principles_sub_topics();
			$this->output->set_content_type('application/json');
			$this->output->set_output(json_encode($principles));
		}

		public function delete_principle_sub_topic(){
			
			if ($this->is_admin_still_logged_in() === FALSE){
				redirect("/admin_login_page");
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

	}

?>