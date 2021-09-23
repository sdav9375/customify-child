<?php
/**
 * Template Name: Shop Page
 *
 */
 
get_header(); ?>
<div class="content-inner">
	<?php
	do_action( 'customify/content/before' );

	if ( ! customify_is_e_theme_location( 'single' ) ) {
		while ( have_posts() ) :
			the_post(); ?>
			<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
			<?php if ( customify_is_post_title_display() ) { ?>
				<header class="entry-header">
					<?php the_title( '<h1 class="entry-title h3">', '</h1>' ); ?>
				</header><!-- .entry-header -->
			<?php } ?>
		
			<div class="entry-content">
				<?php
				the_content();
				// if ( is_plugin_active( "edd_fes/edd-fes.php" ) ) {
					
				
				$vendor_db = new FES_DB_Vendors();
				$args = array(
					'number'  => 1000,
					//'offset'  => ( $this->step -1 ) * $this->per_step,
					'orderby' => 'id',
					'order'   => 'DESC'
				);
		
				$vendors = $vendor_db->get_vendors( $args );
		
				if ( $vendors ) {
		
					foreach ( $vendors as $vendor ) {
						// foreach get products
						$user_id = ! empty( $vendor->user_id ) ? intval( $vendor->user_id ) : 0;
						$products = EDD_FES()->vendors->get_all_products( $user_id );
						
						
						if ( !empty( $products ) ){ ?>
							<div class="vendor-profile">
								<a href="<?php echo bp_core_get_user_domain( $user_id );?>">
								  <?php echo bp_core_fetch_avatar( array( 'item_id' => $user_id, 'class' => 'avatar', 'type' => 'full',  ) );?>
								</a>
							    <a class="vendor-store" href="<?php echo EDD_FES()->vendors->get_vendor_store_url( $user_id ); ?>"> Shop </a> 
								<a  class="author" href="<?php echo bp_core_get_user_domain( $user_id );?>">
									 <?php echo get_the_author_meta ( 'user_firstname', $user_id );?></a>
									 
								
							</div>
							<?php echo do_shortcode("[downloads author='. $user_id .' number='6' columns='3' ]");
						}
					}
				}
				// }
				wp_link_pages(
					array(
						'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'customify' ),
						'after'  => '</div>',
					)
				);
				?>
			</div><!-- .entry-content -->
		
		</article><!-- #post-<?php the_ID(); 
		endwhile; // End of the loop.
	}
	do_action( 'customify/content/after' );
	?>
</div><!-- #.content-inner -->
<?php
get_footer();