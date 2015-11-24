
		<?php if(isset($list_item) && !empty($list_item)): ?>

			<?= $this->tag->stylesheetLink("library/slick/slick/slick.css"); ?>
			<?= $this->tag->javascriptInclude("library/slick/slick/jquery-migrate-1.2.1.min.js"); ?>
			<?= $this->tag->javascriptInclude("library/slick/slick/slick.js"); ?>

			<script type="text/javascript">
				$(document).ready(function(){
			        $('.fade').slick({
						dots: false,
						infinite: true,
						autoplay: true,
						speed: 3000,
						fade: true,
						cssEase: 'linear'
					});
			    });
			</script>

			<div class="fade">
				<?php foreach ($list_item as $key => $value): ?>
					<div>
						<div class="image">
							<img src="<?php echo PUBLIC_URL.$value->image;?>">
						</div>
						<span class="title"><?= $value->title; ?></span>
					</div>
				<?php endforeach ?>
			</div>
			<div class="clr"></div>
		<?php endif ?>