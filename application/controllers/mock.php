<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Mock extends Public_Controller {
		public function __construct() {
			parent::__construct();

			$this->load->model('content_model', 'content');
			$this->load->model('blog_model', 'blog');

			$this->view_data['layout'] = 'main';

			$this->view_data['css_plugins'][] = 'semantic-ui/menu.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/grid.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/segment.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/list.css';
			
			$this->view_data['site_header'] = $this->content->get_by_name('site-header');
		}

		public function index() {
			$this->view_data['welcome_to_jamba_cms'] = $this->content->get_by_name('welcome-to-jamba-cms');
			$this->view_data['latest_blog_entry'] = $this->blog->get_latest();

			$this->view_data['page'] = 'home';

			$this->load->view('master', $this->view_data);
		}

		public function content ($category = '', $name = '') {
			$this->view_data['categories'] = $this->content->get_categories();

			if ($name === '') {
				//if there is nothing supplied
				if ($category === '') {
					//load up the list of all content
					$this->view_data['content_item'] = $this->content->get_latest();
					$this->view_data['content'] = $this->content->get_by_category();
				//if there is a category supplied
				} else {
					$this->view_data['content_item'] = $this->content->get_latest($category);
					$this->view_data['content'][$category] = $this->content->get_by_category($category);
				}
			} else {
				//if everything is supplied
				$this->view_data['content_item'] = $this->content->get_by_category($category, $name);
				$this->view_data['content'][$category] = $this->content->get_by_category($category);
			} 
			$this->view_data['page'] = 'mock_item';

			$this->load->view('master', $this->view_data);
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
			redirect("/mock/content");
		}
	}
?>
