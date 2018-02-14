<form method="get" action="<?php  echo esc_url(home_url('/')); ?>">
	<input type="text" required="" placeholder="<?php esc_html_e('Enter Your Keywords','theneeds');?>" name="s" value="<?php the_search_query();?>"/>
	<button type="submit"><i class="fa fa-search" aria-hidden="true"></i></button>
</form>


				