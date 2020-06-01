<?php
/**
 * The template for displaying all single posts
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package customify
 */

get_header(); ?>

	<div class="content-inner">
		<?php
		do_action( 'customify/content/before' );
		if ( ! customify_is_e_theme_location( 'single' ) ) {
			while ( have_posts() ) :
				$post_type = get_post_type();
		
				if ( has_action( "customify_single_{$post_type}_content" ) ) {
					do_action( "customify_single_{$post_type}_content" );
					
				} else {
					customify_single_post(); ?>
					<span class="date">
					<?php echo date( 'F Y', strtotime( get_the_date() ) ) ; ?>
					</span>
					
					<?php
					$post_meta = get_post_meta( get_the_ID(), 'projects_assigned', false );
					$project_array = array();
					foreach($post_meta as $project) {
						$project_array[] = (int) $project['ID'];
					}
					
                    $string = implode(',', $project_array);

                    if ( $string != 0 ) {
                        
                        $shortcode = '[mpp-list-gallery search_terms="" in="' .  $string . '" show_creator=1  before_creator="By: " ]';
                                            
                        echo do_shortcode( $shortcode, false );
                    } else {
                        echo "<p class='no-projects'>This topic contains no projects</p>";
                    }
					
			}
			endwhile; // End of the loop.
		}
		do_action( 'customify/content/after' );
		?>
	</div><!-- #.content-inner -->
<?php
get_footer();
