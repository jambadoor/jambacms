<?php
	$config = array (
		'class' => 'ui form segment',
		'id' => 'add-article-form',
		'header' => 'New Article',
		'action' => '/admin/articles/create',
		'indent_level' => 2
	);

	$this->ui_form->open($config);
	$this->ui_form->add_input_field('name', 'Name');
	$this->ui_form->add_input_field('headline', 'Headline');
	$this->ui_form->add_tinyeditor('content', 'Content');
	$this->ui_form->add_input_field('category', 'Category');
	$this->ui_form->add_input_field('subcategory', 'Sub-Category');
	$this->ui_form->add_submit();
	$this->ui_form->close();
	$this->ui_form->render();
