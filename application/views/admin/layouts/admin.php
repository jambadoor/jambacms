	<div class="ui page grid">
		<?php $this->load->view('blocks/top_bar'); ?>

<div id="top_spacer"></div>

<?php 
	if (isset($notifications) && is_array($notifications)) {
		foreach ($notifications as $notification) {
			$view = $notification['view'];
			$data = $notification['data'];
			$this->load->view("blocks/$view", $data); 
		}
	}
?>

<?php $this->load->view("pages/$page"); ?>

<?php $this->load->view('blocks/footer'); ?>

</div>
