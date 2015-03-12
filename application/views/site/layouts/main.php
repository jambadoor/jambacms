<?php
	$this->load->view('blocks/sticky_top_bar');
	$this->ui->open_div('ui centered page grid');
	$this->ui->render();
	$this->load->view("pages/$page");
	$this->ui->close_div();
	$this->ui->render();
?>

