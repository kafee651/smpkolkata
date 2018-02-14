<?php 
	/*
	 * This file is used to generate comments form.
	 */	
	if (post_password_required()){
		?> <p class="nopassword"><?php echo esc_html__('This post is password protected. Enter the password to view comments.','theneeds'); ?></p> <?php
		return;
	}
	if ( have_comments() ) : ?>
		
		<h3><?php comments_number(esc_html__('No Comment','theneeds'), esc_html__('One Comment','theneeds'), esc_html__('% Comments','theneeds') );?></h3>
		<ul id="comments" class="cp-comments">
			<?php wp_list_comments(array('callback' => 'get_comment_list')); ?>
		</ul>
		<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) : ?>
		<br>
		<div class="comments-navigation">
			<div class="previous"> <?php previous_comments_link(esc_html__('Older Comments','theneeds')); ?> </div>
			<div class="next"> <?php next_comments_link(esc_html__('Newer Comments','theneeds')); ?> </div>
		</div>
		<?php endif;  
	
	endif; 
                  
	/* Form Args() */				
	$theneeds_comment_form = array( 
	
		'title_reply_before'  => '<h2 id="reply-title" class="comment-reply-title">',
		
		'title_reply_after'  => '</h2>',
		
		'fields' => apply_filters( 'comment_form_default_fields', array(
			
			'author' => '<div class = "row"><div class="col-md-4">' .						
						'<input class="comm-field" id="author" name="author" placeholder="'.esc_html__('Name *','theneeds').'" type="text" value="' .
						esc_attr( $commenter['comment_author'] ) . '" size="30" tabindex="1" />' .						
						'</div>',
						
			'email'  => '<div class="col-md-4">' .
						'<input id="email" class="comm-field" name="email" placeholder="'.esc_html__('Email *','theneeds').'" type="text" value="' . esc_attr(  $commenter['comment_author_email'] ) . '" size="30" tabindex="2" />' .						
						'</div>',

			'url'  => '<div class="col-md-4">' .
						'<input id="url" class="comm-field" name="url" placeholder="'.esc_html__('Subject *','theneeds').'" type="text" value="' . esc_attr(  $commenter['comment_author_url'] ) . '" size="30" tabindex="3" />' .						
						'</div></div>' ) ),
						
			'comment_field' => '' .
						'<div class = "row"><div class="col-md-12">'.												
						'<textarea cols="60" rows="10" placeholder="'.esc_html__('Comments *','theneeds').'" class="comm-area" id="comment" name="comment" aria-required="true" tabindex="4"></textarea></div></div>' .
						'',
		'title_reply' => esc_html__('Leave a Comment','theneeds'),
	);
	
	comment_form($theneeds_comment_form, $post->ID); 
?>