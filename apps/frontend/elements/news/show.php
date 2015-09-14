<div id="news-show-<?php echo $element->id;?>" class="news-show">
	<div class="module">
		<?php if($element->showtitle == 1):?>
			<?php echo '<div class="moduletitle"><h3>' . $element->name . '</h3></div>';?>
		<?php endif;?>

		<div class="modulecontent">
			<?php foreach ($articles as $key => $value):?>
				<div class="item">
					<div class="image"><?= $this->tag->linkTo(array('tin-tuc/'.$this->plugin->alias_name($value->news_category->title).'/'.$this->plugin->getLinkDetail($value, 'news'), '<img src="'.$value->image.'">')); ?></div>
					<h3 class="title"><?= $this->tag->linkTo(array('tin-tuc/'.$this->plugin->alias_name($value->news_category->title).'/'.$this->plugin->getLinkDetail($value, 'news'), $this->plugin->getCutString($value->title, 60))); ?></h3>
					<div class="description"><?php echo $this->plugin->getCutString($value->description, 150);?></div>
				</div>
			<?php endforeach;?>
			<div class="clear"></div>
		</div>
	</div>
</div>