<div id="custom-<?php echo $element->id;?>" class="custom">
	<div class="module">
		<?php if($element->showtitle == 1):?>
			<?php echo '<div class="moduletitle"><h3>' . $element->name . '</h3></div>';?>
		<?php endif;?>

		<div class="modulecontent">
			<?php echo $element->content;?>
		</div>
	</div>
</div>