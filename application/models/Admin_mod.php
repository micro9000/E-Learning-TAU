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
	}

?>