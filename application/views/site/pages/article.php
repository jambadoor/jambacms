<?php
	$this->ui->open_div('', 'top-spacer');
	$this->ui->close_div();
	$this->ui->open_column('twelve wide');
		$this->ui->add_breadcrumb(array(
			'crumbs' => array(
				'/articles' => 'All',
				"/articles/$article->category" => $article->category,
				'' => $article->headline
			)
		));
	$this->ui->close_column();
	$this->ui->open_column('four wide');
	$this->ui->close_column();
	$this->ui->open_column('four wide');
		$this->ui->open_div('ui segment');
			$this->ui->add_h(3, 'More '.$article->category);
			$this->ui->open_div('ui list');
				foreach ($articles[$article->category] as $name => $item) {
					$this->ui->open_div('item');
						$this->ui->add_link('/articles/view/'.$article->category.'/'.$name, $item->headline); 
					$this->ui->close_div();
				}
			$this->ui->close_div();
		$this->ui->close_div();
		$this->ui->open_div('ui segment');
			$this->ui->add_h(3, 'Categories');
			$this->ui->open_div('ui list');
				foreach ($categories as $category) {
					$this->ui->open_div('item');
						$this->ui->add_link('/articles/view/'.$category, $category);
					$this->ui->close_div();
				}
			$this->ui->close_div();
		$this->ui->close_div();
	$this->ui->close_column();
	$this->ui->open_column('twelve wide');
		$this->ui->open_div('ui segment');
			$this->ui->add_h(3, $article->headline);
			$this->ui->add_content($article->content);
			$this->ui->add_content($article->last_modified);
		$this->ui->close_div();
	$this->ui->close_div();
?>
