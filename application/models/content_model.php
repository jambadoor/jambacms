<?php
	class Content_Model extends MY_Model {
		public function __construct() {
			$this->table = 'content';
			parent::__construct();
		}

		public function get_by_name($name) {
			$query = $this->db->where('name', $name)->get($this->table);
			if ($query->num_rows === 1) {
				return $query->result()[0];
			} else {
				exit("Couldn't retrieve.");
			}
		}

		public function get_id($name) {
			$query = $this->db->where('name', $name)->select('id')->get($this->table);

			if ($query->num_rows === 1) {
				return $query->result()[0]->id;
			} else {
				exit("Couldn't retrieve");
			}
		}

		public function get_all_active($cols='') {
			$all_content = $this->_get_all_active($cols);

			$content_by_name = array();
			foreach ($all_content as $content) {
				$content_by_name[$content->name] = $content;
			}

			return $content_by_name;
		}
	}
?>
