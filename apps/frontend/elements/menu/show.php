
<?php if(!empty($menu) && $menu->status == 1): ?>
	<ul id="menu-<?php echo $menu->id;?>" class="menunav">
		<?php $this->menu($menu->id,0,0) ?>
	</ul>
<?php endif; ?>