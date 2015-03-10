<?php
	$config = array(
		'class' => 'ui form segment',
		'id' => 'edit-adlink-form',
		'action' => '/admin/adlinks/update/'.$adlink->link_url, 
		'header' => 'Edit Adlink'
	);
	$this->ui_form->open($config);
		$this->ui_form->open_group(2);
			$this->ui_form->add_input_field('link_url', "Link URL", $adlink->link_url);
			$this->ui_form->add_input_field('redirect_url', "Redirect URL", $adlink->redirect_url);
		$this->ui_form->close_group();
		$this->ui_form->add_textarea('description', 'Description', $adlink->description);
		$this->ui_form->add_submit();
	$this->ui_form->close();
	$this->ui_form->render();
?>
