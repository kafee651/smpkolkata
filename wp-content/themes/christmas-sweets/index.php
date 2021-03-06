<?php
/**
 * The main template file.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Christmas Sweets
 */

get_header();
?>
	<main id="main" class="site-main" role="main">
		<?php
		if ( have_posts() ) {
			if ( is_archive() ) {
			?>
				<header class="page-header">
					<?php
					the_archive_title( '<h1 class="entry-title">', '</h1>' );
					the_archive_description( '<div class="taxonomy-description">', '</div>' );
					?>
				</header><!-- .page-header -->
			<?php
			} elseif ( is_search() ) {
			?>
				<header class="page-header">
					<h1 class="entry-title"><?php printf( esc_html__( 'Search Results for: %s', 'christmas-sweets' ), '<span>' . get_search_query() . '</span>' ); ?></h1>
				</header><!-- .page-header -->
			<?php
			}

			while ( have_posts() ) : the_post();
				get_template_part( 'content' );
			endwhile;

		} else {
			// Nothing was found.
			?>
			<header class="page-header">
				<h1 class="entry-title"><?php esc_html_e( 'Nothing Found', 'christmas-sweets' ); ?></h1>
			</header><!-- .page-header -->
			<article class="entry-summary">
			<?php
			if ( is_home() && current_user_can( 'publish_posts' ) ) {
				?>
				<p>
				<?php
				printf( wp_kses( __( 'Ready to publish your first post? <a href="%1$s">Get started here</a>.', 'christmas-sweets' ),
				array( 'a' => array( 'href' => array() ) ) ),esc_url( admin_url( 'post-new.php' ) ) );
				?>
				</p>
			<?php
			} elseif ( is_search() ) {
				?>
				<p><?php esc_html_e( 'Sorry, but nothing matched your search terms. Please try again with some different keywords.', 'christmas-sweets' ); ?></p>
				<?php
				get_search_form();
			} elseif ( is_404() ) {
			?>
				<p><?php esc_html_e( 'Oops! That page can&rsquo;t be found. Perhaps searching can help.', 'christmas-sweets' ); ?></p><br/>
				<?php get_search_form(); ?>
				<br/>
			<?php
			} else {
				?>
				<p><?php esc_html_e( 'It seems we can&rsquo;t find what you&rsquo;re looking for. Perhaps searching can help.', 'christmas-sweets' ); ?></p><br/>
				<?php
				get_search_form();
			}
			echo '</article>';
		} // End if().

		the_posts_pagination( array(
			'type' => 'list',
			'prev_text'          => _x( 'Previous page', 'previous set of posts', 'christmas-sweets' ),
			'next_text'          => _x( 'Next page', 'next set of posts', 'christmas-sweets' ),
			'screen_reader_text' => esc_html__( 'View more posts:', 'christmas-sweets' ),
			'before_page_number' => '<span class="meta-nav screen-reader-text">' . __( 'Page', 'christmas-sweets' ) . ' </span>',
			)
		);
	?>
</main><!-- #main -->
<?php
get_footer();
