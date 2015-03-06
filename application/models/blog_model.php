<?php
	class Blog_Model extends MY_Model {
		public function __construct() {
			$this->table = 'blog';
			parent::__construct();
		}

		public function get_by_name($name) {
			$query = $this->db->where('name', $name)->get($this->table);
			if ($query->num_rows === 1) {
				return $query->result()[0];
			} else {
				if ($query->num_rows > 1) {
					show_error(__METHOD__."<br>There is more than one blog entry with the name '$name'.");
				}
				if ($query->num_rows === 0) {
					show_error(__METHOD__."<br>There is no blog entry with the name '$name'.");
				}
			}
		}

		public function get_id_from_name($name) {
			$query = $this->db->select('id')->where('name', $name)->get($this->table);
			if ($query->num_rows === 1) {
				return $query->result()[0]->id;
			} else {
				if ($query->num_rows > 1) {
					show_error(__METHOD__."<br>There is more than one blog entry with the name '$name'.");
				}
				if ($query->num_rows === 0) {
					show_error(__METHOD__."<br>There is no blog entry with the name '$name'.");
				}
			}
		}

		public function get_all_active($cols='') {
			$all_entries = $this->_get_all_active($cols);

			$entries_by_name = array();
			foreach ($all_entries as $entry) {
				$entries_by_name[$entry->name] = $entry;
			}

			return $entries_by_name;
		}

		public function get_latest() {
			$query = $this->db->order_by('last_modified', 'desc')->order_by('id', 'desc')->limit(1)->get($this->table);
			return $query->result()[0];
		}
	}
?>
