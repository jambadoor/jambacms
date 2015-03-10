<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Content extends Admin_Controller {
		public function __construct() {
			parent::__construct();

			$this->view_data['tab'] = 'content';
			$this->load->model('content_model', 'content');

			//check for permission to view
			if (!$this->user->permissions['content']['read']) {
				redirect('/admin');
			}
		}

		public function index() {
			$this->view();
		}

		public function view() {
			$this->view_data['content_sections'] = $this->content->get_all_active();
			$this->view_data['tab_content'] = 'blocks/content_list';

			$this->load->view('master', $this->view_data);
		}

		public function edit($name) {
			$section = $this->content->get_by_name($name);

			//if user has permission or is creator
			if ($this->user->permissions['content']['update'] || $this->user->id == $section->created_by) {
				$this->view_data['content_section'] = $section;
				$this->view_data['tab_content'] = 'forms/edit_content';

				//tinyeditor
				$this->view_data['css_plugins'][] = 'tinyeditor/tinyeditor.css';
				$this->view_data['js_plugins'][] = 'tinyeditor/tinyeditor.js';
			} else {
				$this->view_data['tab_content'] = 'blocks/content_list';
			}

			$this->load->view('master', $this->view_data);
		}

		public function add() {
			if ($this->user->permissions['content']['create']) {
				$this->view_data['tab_content'] = 'forms/add_content';
				$this->session->set_flashdata('back', '/admin/users');

				//tinyeditor
				$this->view_data['css_plugins'][] = 'tinyeditor/tinyeditor.css';
				$this->view_data['js_plugins'][] = 'tinyeditor/tinyeditor.js';
			} else {
				$this->view_data['tab_content'] = 'blocks/content_list';
			}

			$this->load->view('master', $this->view_data);
		}

		/*CRUD*/
		public function create() {
			if ($this->user->permissions['content']['create']) {
				$new_content = $this->input->post();	
				$new_content['created_by'] = $this->user->id;
				$new_content['date_created'] = date('Y-m-d');
				$new_content['last_modified'] = date('Y-m-d');
				$new_content['last_modified_by'] = $this->user->id;
				$this->content->insert($new_content);
				redirect('/admin/content/view');
			} else {
				//TODO: send a message
				redirect('/admin/content');
			}
		}

		public function del($id) {
			if ($this->user->permissions['content']['delete']) {
				$this->content->del($id);
				redirect('/admin/content');
			} else {
				//TODO: send a message
				redirect('/admin/content');
			}
		}

		public function update($name) { 
			$content = $this->input->post();
			$content['last_modified'] = date('Y-m-d');
			$content['last_modified_by'] = $this->user->id;
			
			if ($this->user->permissions['content']['update'] || $this->user->id == $content->created_by) {
				$id = $this->content->get_id($name);
				$this->content->update($id, $content);
				redirect('/admin/content/view');
			} else {
				//TODO: send message
				redirect('/admin/content');
			}
		}

		public function crawl() {
		}

		/*
		 * This generates some ipsum content in the table
		 */
		public function generate_content () {
			$ipsum = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ornare dui ac mi porttitor vestibulum. Ut porttitor dolor a sem interdum, et faucibus massa consectetur. Vivamus euismod odio in tristique vestibulum. In ultrices felis vel fringilla finibus. Duis tincidunt eros velit, ut pretium diam vulputate quis. Cras at vestibulum lorem. Maecenas hendrerit tortor nibh, at tristique orci dignissim in. Integer vel pretium dolor, eu euismod metus. Nunc a cursus diam. Phasellus egestas maximus sollicitudin. Cras ac semper tortor. Nulla malesuada felis sem, sit amet porttitor odio dapibus non. Fusce eu massa sollicitudin, lobortis lacus non, dictum dolor. Pellentesque non nibh ex. Morbi in magna eget erat vulputate bibendum.";
			$sentences = explode(". ", $ipsum);
			$words = explode(' ', $ipsum);
			foreach ($words as $index=>$word) {
				$words[$index] = ucfirst(chop($word, '.,'));
				if ($words[$index] == '' || $words[$index] == ' ') {
					unset($words[$index]);
				}
				
			}
			$categories = array();
			for ($category = 0; $category < 10; $category++) {
				$categories[] = $words[rand(0, count($words) - 1)];
			}

			$record = new stdClass();

			$this->db->query('delete from content where id>2');

			for ($category = 1; $category <= 10; $category++) {
				for ($item = 1; $item <= 10; $item++) {
					$num_paragraphs = rand(3, 6);
					$header = '';
					$num_words = rand(1, 5);
					for ($word = 0; $word < $num_words; $word++) {
						$header .= $words[rand(0, count($words) - 1)].' ';
					}
					$header = chop($header, ' ');
					$content = '';
					for ($paragraph = 0; $paragraph < $num_paragraphs; $paragraph++) {
						$num_sentences = rand(10, 20);
						$content .= "<p>";
						for ($sentence = 0; $sentence < $num_sentences; $sentence++) {
							$content .= $sentences[rand(0, count($sentences) - 1)];
							$content .= '. ';
						}
						$content .= "</p>";
					}
					$record->name = str_replace(' ', '-', strtolower($header));
					$record->header = $header;
					$record->content = $content;
					$record->category = $categories[$category - 1];
					$date_created = new DateTime();
					$date_created->sub(DateInterval::createFromDateString(rand(0, 365).' days'));
					$record->date_created = $date_created->format('Y-m-d');
					$record->last_modified = $date_created->format('Y-m-d');
						
					$this->content->insert($record);
				}
			}
			redirect("/articles/view");
		}
	}
?>
