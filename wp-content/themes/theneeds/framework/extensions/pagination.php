<?php 
/*	
*	CrunchPress Pagination File
*	---------------------------------------------------------------------
* 	@version	1.0
* 	@author		CrunchPress
* 	@link		http://crunchpress.com
* 	@copyright	Copyright (c) CrunchPress
*	---------------------------------------------------------------------
*	This file return the Pagination to the selected post_type
*	---------------------------------------------------------------------
*/
	
	if( !function_exists('pagination') ){
		function theneeds_pagination($pages = '', $range = 4)
		{		

			/* Don't print empty markup if there's only one page. */
			if ( $GLOBALS['wp_query']->max_num_pages < 2 ) {
				return;
			}
			

			$paged = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
						
			$pagenum_link = html_entity_decode( get_pagenum_link() );
			$query_args   = array();
			$url_parts    = explode( '?', $pagenum_link );

			if ( isset( $url_parts[1] ) ) {
				wp_parse_str( $url_parts[1], $query_args );
			}

			$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
			$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

			$format  = $GLOBALS['wp_rewrite']->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
			$format .= $GLOBALS['wp_rewrite']->using_permalinks() ? user_trailingslashit( 'page/%#%', 'paged' ) : '?paged=%#%';

			
			
			/* Set up paginated links.*/
			$links = paginate_links( array(
				'base'     => $pagenum_link,
				'format'   => $format,
				'total'    => $GLOBALS['wp_query']->max_num_pages,
				'current'  => $paged,
				'mid_size' => 1,
				'add_args' => array_map( 'urlencode', $query_args ),
				'prev_text' => esc_html__( '<', 'theneeds' ),
				'next_text' => esc_html__( '>', 'theneeds' ),
				'before_page_number' => '',
				'after_page_number'  => ''
			) );

			
			html_entity_decode($links);
			
			if ( $links ) :
				return $links;
			endif;

		}
	}
	
	
	if( !function_exists('theneeds_post_nav') ){
		function theneeds_post_nav() {
			/* Don't print empty markup if there's nowhere to navigate. */
			$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
			$next     = get_adjacent_post( false, '', false );

			if ( ! $next && ! $previous ) {
				return;
			}

			?>			
			<div class="nav-links">
				<?php
				if ( is_attachment() ) :
					previous_post_link( '%link', esc_html__( '<span class="meta-nav">Published In</span>%title', 'theneeds' ) );
				else :
					previous_post_link( '%link', esc_html__( '<span class="meta-nav">Previous Post</span>%title', 'theneeds' ) );
					next_post_link( '%link', esc_html__( '<span class="meta-nav">Next Post</span>%title', 'theneeds' ) );
				endif;
				?>
			</div><!-- .nav-links -->			
			<?php
		}
	}
	
	
	if( !function_exists('theneeds_post_next') ){
		function theneeds_post_next() {
			/* Don't print empty markup if there's nowhere to navigate. */
			$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
			$next     = get_adjacent_post( false, '', false );

			if ( ! $next && ! $previous ) {
				return;
			}

				if ( is_attachment() ) :
					echo '<div class="portfolio-thumb">';
					previous_post_link( '%link', esc_html__( '<span class="meta-nav">Published In</span>%title', 'theneeds' ) );
					echo '</div>';
				else :
					echo '<div class="portfolio-thumb">';
					previous_post_link( '%link', esc_html__( '<span class="meta-nav">Previous Post</span>%title', 'theneeds' ) );
					next_post_link( '%link', esc_html__( '<span class="meta-nav">Next Post</span>%title', 'theneeds' ) );
					echo '</div>';
				endif;
		}
	}
	
	/* Pagination Created For Gallery VC Extension */
	if( !function_exists('pagination_crunch') ){
		
		function pagination_crunch($pg_style = '',$style = '', $pages = '', $range = 4){
		
			$showitems = ($range * 2)+1; 
	
			global $paged;

			if(empty($paged)) $paged = 1;

				if($pages == ''){

					global $wp_query;
				 
					$pages = $wp_query->max_num_pages;

					if(!$pages){
						 
						$pages = 1;
						 
					}
				}   
		 
		 
				if(1 != $pages){
				
					$html = '';
					
					$html .= '
						<div class="pagination-box">
							<nav>
								<ul class="pagination">';
									
									$html .= "<li><a href='".get_pagenum_link($paged - 1)."'>".esc_html__('<','theneeds')."</a></li>";
			 
									for ($i=1; $i <= $pages; $i++){
					 
										if (1 != $pages &&( !($i >= $paged+$range+1 || $i <= $paged-$range-1) || $pages <= $showitems )) {
						
											 ($paged == $i)? $html .= "<li class=\"active\"><a href='".get_pagenum_link($i)."'>".$i."</a></li>": $html .= "<li><a href='".get_pagenum_link($i)."' class=\"inactive\">".$i."</a></li>";
										}
									}
			 
									$html .= "<li><a href=\"".get_pagenum_link($paged + 1)."\">".esc_html__('>','theneeds')."</a></li>";
									$html .= "
								</ul>
							</nav>
						</div>";
				
				}else{
				
					$html = "";
				}
			 
				return $html;
		}
	}
?>