<?php
	$config = array(
		'class' => 'ui form segment',
		'id' => 'add-adlink-form',
		'action' => '/admin/adlinks/create/', 
		'header' => 'Add Adlink'
	);
	$this->ui_form->open($config);
		$this->ui_form->open_group(2);
			$this->ui_form->add_input_field('link_url', "Link URL");
			$this->ui_form->add_input_field('redirect_url', "Redirect URL");
		$this->ui_form->close_group();
		$this->ui_form->add_textarea('description', 'Description');
		$this->ui_form->add_submit();
	$this->ui_form->close();
	$this->ui_form->render();
