<?php
$tags                                           = get_tags( array( 'pad_counts' => true ) );

if ( count( $tags ) > 0 ) {

$counts									        = $tag_links = array();

foreach ( $tags as $tag ) {
	$counts[ $tag->name ]				        = $tag->count;
	$tag_links[ $tag->name ]			        = get_tag_link( $tag->term_id );
}

asort( $counts );

$counts									        = array_reverse( $counts, true );
$i										        = 0;
?>

<div class="<?php echo $this->get_prefix( 'wrapper' ); ?>">
	<span class="<?php echo $this->get_prefix( 'title' ); ?>">
		<?php _e( 'Tags', $this->get_module_name() ); ?>
	</span>
	<div class="<?php echo $this->get_prefix(); ?>">
	<?php
	foreach ( $counts as $tag => $count ) {
		$i++;
		$tag_link					    	    = esc_url( $tag_links[ $tag ] );
		$tag							        = str_replace( ' ', '&nbsp;', esc_html( $tag ) );

		if ( $i <= ( $settings['limit'] ? $settings['limit'] : 3 ) ) {
		?>
		<a href="<?php echo $tag_link; ?>"
		   title="<?php echo esc_attr( sprintf( __( 'View all posts in %s', $this->get_module_name() ), $tag ) ); ?>">
			<?php echo $tag; ?>
		</a>
		<?php
		}
	}

	?>
	</div>
</div>
<?php } ?>