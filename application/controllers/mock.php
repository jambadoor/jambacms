<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
	class Mock extends Public_Controller {
		public function __construct() {
			parent::__construct();

			$this->load->model('content_model', 'content');
			$this->load->model('blog_model', 'blog');

			$this->view_data['layout'] = 'main';

			$this->view_data['css_plugins'][] = 'semantic-ui/menu.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/grid.css';
			$this->view_data['css_plugins'][] = 'semantic-ui/list.css';
			
			$this->view_data['site_header'] = $this->content->get_by_name('site-header');
		}

		public function index() {
			$this->view_data['welcome_to_jamba_cms'] = $this->content->get_by_name('welcome-to-jamba-cms');
			$this->view_data['latest_blog_entry'] = $this->blog->get_latest();

			$this->view_data['page'] = 'home';

			$this->load->view('master', $this->view_data);
		}

		public function mockup ($category = '', $item = '') {
			$this->view_data['categories'] = $this->content->get_categories();
			$item = "item-".$item;

			if ($category) {
				$this->view_data['content'] = $this->content->get_by_category($category, $item);
				$this->view_data['category'] = $category;
				$this->view_data['item'] = 'item-'.$item;
				$this->view_data['page'] = 'mock_item';
			} else {
				$this->view_data['page'] = 'mock_list';
			}

			$this->load->view('master', $this->view_data);
		}

		/*
		 * This generates some ipsum content in the table
		 */
		public function generate_content () {
			$ipsum = "Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ornare dui ac mi porttitor vestibulum. Ut porttitor dolor a sem interdum, et faucibus massa consectetur. Vivamus euismod odio in tristique vestibulum. In ultrices felis vel fringilla finibus. Duis tincidunt eros velit, ut pretium diam vulputate quis. Cras at vestibulum lorem. Maecenas hendrerit tortor nibh, at tristique orci dignissim in. Integer vel pretium dolor, eu euismod metus. Nunc a cursus diam. Phasellus egestas maximus sollicitudin. Cras ac semper tortor. Nulla malesuada felis sem, sit amet porttitor odio dapibus non. Fusce eu massa sollicitudin, lobortis lacus non, dictum dolor. Pellentesque non nibh ex. Morbi in magna eget erat vulputate bibendum.";
			for ($i = 0; $i < 10; $i++) {
				for ($j = 0; $j < 10; $j++) {
					$header = "Content Item ".$i."/".$j;
					$item->name = "item-".$i."/".$j;
					$item->header = $title;
					$item->content = $ipsum;
					$item->category = $i;
					$item->date_created = date('Y-m-d');
					$item->last_modified = date('Y-m-d');
						
					$this->content->insert($item);
				}
			}
		}
	}
?>
