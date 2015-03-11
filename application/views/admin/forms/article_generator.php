<?php
	$config = array(
		'header' => 'Article Generator',
		'class' => 'ui form segment',
		'action' => '/admin/articles/generate_articles'
	);
	$this->ui_form->open($config);
	$this->ui_form->add_input_field('categories', 'Categories');
	$this->ui_form->add_input_field('keywords', 'Keywords');
	$this->ui_form->add_input_field('num_articles', 'Number of Articles per Category');
	$this->ui_form->add_textarea('ipsum', 'Ipsum');
	$this->ui_form->add_submit();
	$this->ui_form->close();
	$this->ui_form->render();
?>
