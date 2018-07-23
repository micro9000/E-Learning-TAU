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

		public function select_latest_lessons_cover_img($limit=15){
			$this->db->select("id, coverPhoto");
			$this->db->where(array(
						"isDeleted" => 0,
						"coverPhoto <>" => 'NA',
						"isWithCoverPhoto" => 1,
						"coverOrientation" => 'L'
					));
			$this->db->where("coverPhoto IS NOT NULL");
			$this->db->order_by("id", "DESC");
			$this->db->limit($limit);
			$results = $this->db->get("Lessons");
			return $results->result_array();
		}

		public function select_latest_lessons_with_cover($limit = 8){

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
							'Les.isWithCoverPhoto' => 1
						));
			$this->db->where("Les.coverPhoto <> 'NA' AND Les.coverOrientation <> '-'");
			$this->db->order_by("Les.id", "DESC");
			$this->db->limit($limit);

			$results = $this->db->get();
			return $results->result_array();
		}

		public function select_latest_lessons_without_cover($limit = 12){

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
							'Les.isWithCoverPhoto' => 0,
							'Les.coverPhoto' => 'NA',
							'Les.coverOrientation' => '-'
						));
			
			$this->db->order_by("Les.id", "DESC");
			$this->db->limit($limit);

			$results = $this->db->get();
			return $results->result_array();
		}

		public function insert_lesson_comment($lessonID, $comments, $stdNum_facNum, $userType){

			$data = array(
				'lessonID' => $lessonID,
				'comments' => $comments,
				'stdNum_facNum' => $stdNum_facNum,
				'userType' => $userType
			);

			$result = $this->db->insert('Lesson_comments', $data);
			return $result;
		}

		public function get_all_lesson_comments($lessonID){

			$this->db->where('lessonID', $lessonID);
			$results = $this->db->get('Lesson_comments');
			return $results->result_array();

		}
		
		// Use to display comments
		public function getDatesMinsDifference_today($date_1){
			$this->db->select("TIMESTAMPDIFF(MINUTE, '". $date_1 ."', CURRENT_TIMESTAMP ) as timeDiff");
			$results = $this->db->get();
			return $results->row_array();
		}

		public function getFormattedDate_without_year($date){
			$this->db->select("DATE_FORMAT('". $date ."', '%M %d, %r') as formattedDate");
			$results = $this->db->get();
			return $results->row_array();
		}

		public function getFormattedDate_with_year($date){
			$this->db->select("DATE_FORMAT('". $date ."', '%M %d, %Y %r') as formattedDate");
			$results = $this->db->get();
			return $results->row_array();
		}

	}

?>