<div id="content">
	<div class="row">
		<div class="span12">
			<h1><?php echo $page_title ?></h1>
		</div>

		<div id="page_text" class="span12">
			<?php 
				echo htmlspecialchars_decode($page_description);
				Event::run('ushahidi_action.page_extra', $page_id);
			?>
		</div>
	</div>
</div>
