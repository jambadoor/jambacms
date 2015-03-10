<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	/*
	 * the articles tab of our dashboard
	 * used to manage our articles table
	 */
	class Articles extends Admin_Controller {
		public function __construct() {
			parent::__construct();

			$this->view_data['tab'] = 'articles';
			$this->load->model('articles_model', 'articles');

			//check for permission to view
			if (!$this->user->permissions['articles']['read']) {
				redirect('/admin');
			}
		}

		/*
		 * we load up the list if /admin/articles
		 */
		public function index() {
			$this->view();
		}

		/*
		 * loads up a list of articles
		 */
		public function view() {
			$this->view_data['articles'] = $this->articles->get_all();
			$this->view_data['tab_content'] = 'blocks/articles_list';

			$this->load->view('master', $this->view_data);
		}


		/*
		 * FORMS
		 ****************************************************************************/

		/*
		 * loads up the edit article form with article specified by $url
		 */
		public function edit($name) {
			$article = $this->articles->get_by_name($name);

			//if user has permission or is creator
			if ($this->user->permissions['articles']['update'] || $this->user->id == $article->created_by) {
				$this->load->library('UI_Form');
				$this->view_data['article'] = $article;
				$this->view_data['tab_content'] = 'forms/edit_article';

				//tinyeditor
				$this->view_data['css_plugins'][] = 'tinyeditor/tinyeditor.css';
				$this->view_data['js_plugins'][] = 'tinyeditor/tinyeditor.js';
			} else {
				$this->view_data['tab_content'] = 'blocks/article_list';
			}

			$this->load->view('master', $this->view_data);
		}

		/*
		 * loads up the add article form
		 */
		public function add() {
			if ($this->user->permissions['articles']['create']) {
				$this->load->library('UI_Form');
				$this->view_data['tab_content'] = 'forms/add_article';

				//tinyeditor
				$this->view_data['css_plugins'][] = 'tinyeditor/tinyeditor.css';
				$this->view_data['js_plugins'][] = 'tinyeditor/tinyeditor.js';
			} else {
				$this->view_data['tab_content'] = 'blocks/articles_list';
			}

			$this->load->view('master', $this->view_data);
		}

		/*
		 * CRUD
		 ****************************************************************************/

		/*
		 * creates a new articles from post
		 */
		public function create() {
			if ($this->user->permissions['articles']['create']) {
				$new_article = $this->input->post();	
				print_r($new_article);
				$new_article['created_by'] = $this->user->id;
				$new_article['date_created'] = date('Y-m-d');
				$new_article['last_modified'] = date('Y-m-d');
				$new_article['last_modified_by'] = $this->user->id;
				$this->articles->insert($new_article);
				redirect('/admin/articles/view');
			} else {
				//TODO: send a message
				redirect('/admin/articles');
			}
		}

		/*
		 * sets active to false
		 */
		public function del($id) {
			if ($this->user->permissions['articles']['delete']) {
				$this->articles->del($id);
				redirect('/admin/articles');
			} else {
				//TODO: send a message
				redirect('/admin/articles');
			}
		}

		/*
		 * updates the article specified by $url with post
		 */
		public function update($name) { 
			$article = $this->input->post();
			$article['last_modified'] = date('Y-m-d');
			$article['last_modified_by'] = $this->user->id;
			
			//TODO: this doesn't do what you would expect, need to load in the article's owner from db, this $article is from post
			if ($this->user->permissions['articles']['update'] || $this->user->id == $article->created_by) {
				$id = $this->articles->get_id($name);
				$this->articles->update($id, $article);
				redirect('/admin/articles/view');
			} else {
				//TODO: send message
				redirect('/admin/articles');
			}
		}

		/*
		 * This generates some ipsum content in the table
		 */
		public function generate_content () {
			//TODO: only allow dev users to do this
			
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

			$article = new stdClass();

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
					$article->name = str_replace(' ', '-', strtolower($header));
					$article->header = $header;
					$article->content = $content;
					$article->category = $categories[$category - 1];
					$date_created = new DateTime();
					$date_created->sub(DateInterval::createFromDateString(rand(0, 365).' days'));
					$article->date_created = $date_created->format('Y-m-d');
					$article->last_modified = $date_created->format('Y-m-d');
						
					$this->articles->insert($record);
				}
			}

			redirect("/admin/articles/view");
		}
	}
?>
