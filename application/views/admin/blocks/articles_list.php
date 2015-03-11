<?php 
	if ($user->permissions['articles']['create']) {
		$config = array(
			'icon' => 'plus icon',
			'class' => 'ui labeled icon button',
			'text' => 'Add Article',
			'href' => '/admin/articles/add',
			'id' => 'add-article-button'
		);
		$this->ui->add_button($config);
	}

	if ($user->type === 'dev') {
		$config = array(
			'icon' => 'plus icon',
			'class' => 'ui labeled icon right floated button',
			'id' => 'generate-articles-button',
			'href' => '/admin/articles/generator',
			'text' => 'Generate Random Articles'
		);
		$this->ui->add_button($config);
	}

	$this->ui->render();
	
	//Create our list
	$config = array (
		'headers' => array ('Name', 'Category', 'Author', 'Created On', 'Active', 'Options')
	);
	$this->ui_table->open($config);
	foreach ($articles as $article) {
		$this->ui_table->open_row();
			$this->ui_table->add_column('<a href="/admin/articles/view/'.$article->category.'/'.$article->name.'">'.$article->name.'</a>');
			$this->ui_table->add_column('<a href="/admin/articles/view/'.$article->category.'">'.$article->category.'</a>');
			$this->ui_table->add_column($article->created_by);
			$this->ui_table->add_column($article->date_created);
			$this->ui_table->add_column($article->active);
			$options = '';
			$options .= '<a href="/admin/articles/view/'.$article->category.'/'.$article->name.'">View</a> | ';
			$options .= '<a href="/admin/articles/edit/'.$article->category.'/'.$article->name.'">Edit</a> | ';
			$options .= '<a href="/admin/articles/del/'.$article->category.'/'.$article->name.'">Deactivate</a>';
			$this->ui_table->add_column($options);
		$this->ui_table->close_row();
	}
	$this->ui_table->close();
	$this->ui_table->render();
?>
