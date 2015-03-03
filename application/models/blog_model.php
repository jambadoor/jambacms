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
				exit("Couldn't retrieve.");
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
	}
?>
