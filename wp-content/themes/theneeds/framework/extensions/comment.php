<?php

	/*	
	*	CrunchPress Comment File
	*	---------------------------------------------------------------------
	* 	@version	1.0
	* 	@author		CrunchPress
	* 	@link		http://crunchpress.com
	* 	@copyright	Copyright (c) CrunchPress
	*	---------------------------------------------------------------------
	*	This file return the comment list to the selected post_type
	*	---------------------------------------------------------------------
	*/
	 
	function get_comment_list( $comment, $args, $depth ) {
	
		$GLOBALS['comment'] = $comment;
		
		switch ( $comment->comment_type ) :
			case 'pingback'  :
			case 'trackback' :
			?>
				<li class="post pingback">	
					<p>
						<?php esc_html_e( 'Pingback:', 'theneeds'); ?>
						<?php comment_author_link(); ?>
						<?php edit_comment_link( esc_html_e('(Edit)', 'theneeds'), ' ' ); ?>
					</p>
					</li>
			<?php
				break;
				
			default :
			?>
				<li <?php comment_class(); ?> id="comment-<?php comment_ID(); ?>">
					<div class="thumb">
						<?php echo get_avatar( $comment, 60 ); ?>
					</div>
					<div class="text">
						<h4><?php echo get_comment_author_link(); ?></h4>
						<?php comment_text(); ?>
						<div class="post-time">
							<ul>
								<li><p><?php echo get_comment_time();?> - <?php echo get_comment_date();?></p></li>
								<li><?php comment_reply_link( array_merge( $args, array( 'depth' => $depth, 'max_depth' => $args['max_depth'] ) ) ); ?></li>
							</ul>
						</div>
					</div>
				
			<?php
				break;
		endswitch;
		
	}
?>
