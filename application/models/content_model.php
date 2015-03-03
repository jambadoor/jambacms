<?php
	class Content_Model extends MY_Model {
		public function __construct() {
			$this->table = 'content';
			parent::__construct();
		}

		public function get($name) {
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

		public function get_all() {
			$query = $this->db->get($this->table);

			$content_by_name = array();
			foreach ($query->result() as $result) {
				$content_by_name[$result->name] = $result;
			}

			return $content_by_name;
		}
	}
?>
