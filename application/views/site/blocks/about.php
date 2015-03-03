<section id="about">
	<article id="about-me">
		<header class="ui centered header">
			<h2>Hello World!</h2>
			<img src="/assets/img/face.png" class="ui centered circular image" width="400px" height="400px">
			<h5>My name is</h5>
			<h3>JASON BENFORD</h3>
			<h5>and I am a</h5>
			<h1>WEB DEVELOPER</h1>
			<h5>You may be wondering...</h5>
		</header>

		<div class="ui two column doubling grid">
			<div class="column">
				<h4><i><?=$content['why_so_lonely']->header;?></i></h4>
				<p><?=$content['why_so_lonely']->content;?></p>
			</div>
			<div class="column">
				<h4><i><?=$content['why_you_care']->header;?></i></h4>
				<p><?=$content['why_you_care']->content;?></p>
			</div>
		</div>
	</article>
</section>
