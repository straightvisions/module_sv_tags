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