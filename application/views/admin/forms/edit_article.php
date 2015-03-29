<?php
	$config = array (
		'class' => 'ui form segment',
		'id' => 'edit-article-form',
		'header' => 'Edit Article',
		'action' => '/admin/articles/update/'.$article->name
	);
	$this->ui_form->open($config);
	$this->ui_form->add_input_field('name', 'Name', $article->name);
	$this->ui_form->add_input_field('headline', 'Headline', $article->headline);
	$this->ui_form->add_tinyeditor('content', 'Content', $article->content);
	$this->ui_form->add_input_field('category', 'Category', $article->category);
	$this->ui_form->add_input_field('subcategory', 'Sub-Category', $article->subcategory);
	$this->ui_form->add_submit();
	$this->ui_form->close();
	$this->ui_form->render();
