<?php
	class Articles_Model extends MY_Model {
		public function __construct() {
			$this->table = 'articles';
			parent::__construct();
		}

		/*
		 * gets the latest article
		 * if no parameter supplied, it get's newest of all articles
		 * and then you can supply more specificity
		 */
		public function get_latest($category = '', $subcategory = '') {
			if ($category !== '') {
				$this->db->where('category', $category);
				if ($subcategory != '') {
					$this->db->where('subcategory', $subcategory);
				}
			}
			$this->db->order_by('last_modified', 'desc')->limit(1);
			$query = $this->db->get($this->table);
			$article = $query->result()[0];

			//now add in the author's name
			$this->_add_author_name($article);

			return $article;
		}


		/*
		 * gets a single article with the name supplied
		 * throws error if there is more than one
		 */
		public function get_by_name($name) {
			$query = $this->db->where('name', $name)->get($this->table);
			if ($query->num_rows === 1) {
				$article = $query->result()[0];

				//now add in the author's name
				$this->_add_author_name($article);

				return $article;
			} else {
				if ($query->num_rows > 1) {
					show_error(__METHOD__."<br>There is more than one content block url the name '$name'.");
				}
				if ($query->num_rows === 0) {
					show_error(__METHOD__."<br>There is no content block with the name '$name'.");
				}
			}
		}

		/*
		 * gets an array containing all category names
		 */
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

		/*
		 * gets the article id from the name
		 */
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

		/*
		 * if no parameters are supplied it returns 2d array of articles by category
		 * then you can increase specificity
		 */
		public function get_by_category($category = '', $name = '') {
			$this->db->order_by('last_modified', 'desc');
			if ($category !== '') {
				$this->db->where('category', $category);
				//if there is a name supplied we look for a single record
				if ($name !== '') {
					$this->db->where('name', $name);
					$query = $this->db->get($this->table);
					if ($query->num_rows === 1) {
						$article = $query->result()[0];
						$this->_add_author_name($article);
						return $article;
					} else {
						if ($query->num_rows > 1) {
							show_error(__METHOD__."<br>There is more than one content block in ".$category." with the url '$name'.");
						}
						if ($query->num_rows === 0) {
							show_error(__METHOD__."<br>There is no content block in ".$category." with the url '$name'.");
						}
					}
				//otherwise we return an array of articles that are in supplied category
				} else {
					$query = $this->db->get($this->table);
					$article = array();
					foreach ($query->result() as $article) {
						$this->_add_author_name($article);
						$articles[$article->name] = $article;
					}
					return $articles;
				}
			} else {
				//if no parameters supplied, we return array that represents the items by category
				$articles = array();
				$query = $this->db->get($this->table);

				foreach ($query->result() as $article) {
					$this->_add_author_name($article);
					$articles[$article->category][$article->name] = $article;
				}

				return $articles;
			}
		}

		public function get_all_active($cols='') {
			$articles = array();
			foreach ($this->_get_all_active($cols) as $article) {
				$this->_add_author_name($article);
				$articles[$article->name] = $article;
			}

			return $content_by_name;
		}

		public function get_all($cols='') {
			$artilces = array();
			foreach ($this->_get_all($cols) as $article) {
				$this->_add_author_name($article);
				$articles[$article->name] = $article;
			}

			return $articles;
		}

		public function insert($record) {
			if ($this->db->where('name', $record['name'])->where('category', $record['category'])->get($this->table)->num_rows < 1) {
				$this->db->insert($this->table, $record);
			} else {
				return FALSE;
			}
		}

		/*
		 * utility function to ammend the authors name into the object before returning to the controller
		 */
		private function _add_author_name(&$article) {
			$this->db->where('id', $article->created_by);
			$user = $this->db->get('users')->result()[0];
			$article->author = $user->first_name." ".$user->last_name;
		}

	}
?>
