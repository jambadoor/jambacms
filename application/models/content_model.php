<?php
	class Content_Model extends MY_Model {
		public function __construct() {
			$this->table = 'content';
			parent::__construct();
		}

		public function get_latest($category = '') {
			if ($category !== '') {
				$this->db->where('category', $category);
			}
			$this->db->order_by('last_modified', 'desc')->limit(1);
			$query = $this->db->get($this->table);
			return $query->result()[0];
		}

		public function get_by_name($name) {
			$query = $this->db->where('name', $name)->get($this->table);
			if ($query->num_rows === 1) {
				return $query->result()[0];
			} else {
				if ($query->num_rows > 1) {
					show_error(__METHOD__."<br>There is more than one content block with the name '$name'.");
				}
				if ($query->num_rows === 0) {
					show_error(__METHOD__."<br>There is no content block with the name '$name'.");
				}
			}
		}

		public function get_categories() {
			$query = $this->db->distinct()->select('category')->get($this->table);
			$categories = array();
			foreach ($query->result() as $category) {
				if ($category->category != '') {
					$categories[] = $category->category;
				}
			}
			return $categories;
		}

		public function get_id($name) {
			$query = $this->db->where('name', $name)->select('id')->get($this->table);
			if ($query->num_rows === 1) {
				return $query->result()[0]->id;
			} else {
				if ($query->num_rows > 1) {
					show_error(__METHOD__."<br>There is more than one content block with the name '$name'.");
				}
				if ($query->num_rows === 0) {
					show_error(__METHOD__."<br>There is no content block with the name '$name'.");
				}
			}
		}

		public function get_by_category($category = '', $name = '') {
			$this->db->order_by('last_modified', 'desc');
			if ($category !== '') {
				$this->db->where('category', $category);
				//if there is a name supplied we look for a single record
				if ($name !== '') {
					$this->db->where('name', $name);
					$query = $this->db->get($this->table);
					if ($query->num_rows === 1) {
						return $query->result()[0];
					} else {
						if ($query->num_rows > 1) {
							show_error(__METHOD__."<br>There is more than one content block in ".$category." with the name '$name'.");
						}
						if ($query->num_rows === 0) {
							show_error(__METHOD__."<br>There is no content block in ".$category." with the name '$name'.");
						}
					}
				//otherwise we return an array of records that are in supplied category
				} else {
					$query = $this->db->get($this->table);
					$records = array();
					foreach ($query->result() as $record) {
						$records[$record->name] = $record;
					}
					return $records;
				}
			} else {
				//if no parameters supplied, we return array that represents the items by category
				$records = array();
				$query = $this->db->get($this->table);

				foreach ($query->result() as $record) {
					$records[$record->category][$record->name] = $record;
				}

				return $records;
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

		public function insert($record) {
			if ($this->db->where('name', $record->name)->where('category', $record->category)->get($this->table)->num_rows < 1) {
				$this->db->insert($this->table, $record);
			} else {
				return FALSE;
			}
		}
	}
?>
