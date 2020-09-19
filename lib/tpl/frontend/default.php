<?php
	if(in_the_loop() && get_the_tags()){
		?>
		<div class="<?php echo $this->get_prefix(); ?>">
		<span class="<?php echo $this->get_prefix( 'title' ); ?>">
			<?php _e( 'Tags', 'sv100' ); ?>
		</span>
			<div class="<?php echo $this->get_prefix( 'wrapper' ); ?>">
				<?php
					the_tags( '', '', '' );
				?>
			</div>
		</div>
		<?php
	}elseif(!in_the_loop()) {
		$tags = get_tags(array('pad_counts' => true));

		if (count($tags) > 0) {
			$counts = $tag_links = array();

			foreach ($tags as $t) {
				$counts[$t->name] = $t->count;
				$tag_links[$t->name] = get_tag_link($t->term_id);
			}

			asort($counts);

			$counts = array_reverse($counts, true);
			$i = 0;
			?>
			<div class="<?php echo $this->get_prefix(); ?>">
		<span class="<?php echo $this->get_prefix('title'); ?>">
			<?php _e('Tags', 'sv100'); ?>
		</span>
				<div class="<?php echo $this->get_prefix('wrapper'); ?>">
					<?php
						foreach ($counts as $t => $count) {
							$i++;
							$tag_link = esc_url($tag_links[$t]);
							$t = str_replace(' ', '&nbsp;', esc_html($t));

							if ($i <= ($settings['limit'] ? $settings['limit'] : 3)) {
								?>
								<a href="<?php echo $tag_link; ?>"
								   title="<?php echo esc_attr(sprintf(__('View all posts in %s', 'sv100'), $t)); ?>">
									<?php echo $t; ?>
								</a>
								<?php
							}
						}
					?>
				</div>
			</div>
			<?php
		}
	}