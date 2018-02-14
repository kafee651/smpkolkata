<?php
/*	
	*	CrunchPress Social Sharing File
	*	---------------------------------------------------------------------
	* 	@version	1.0
	* 	@author		CrunchPress
	* 	@link		http://crunchpress.com
	* 	@copyright	Copyright (c) CrunchPress
	*	---------------------------------------------------------------------
	*	This file return the Social Sharing to the selected post_type
	*	---------------------------------------------------------------------
	*/
	function theneeds_include_social_shares($social_icons=""){
		
		global $theneeds_social_settings;
		
		/* Social Sharing  */
		$facebook_sharing = '';
		$twitter_sharing = '';
		$stumble_sharing = '';
		$delicious_sharing = '';
		$googleplus_sharing = '';
		$digg_sharing = '';
		$myspace_sharing = '';
		$reddit_sharing = '';	
		$theneeds_social_settings = '';
		
		/* Getting Values from database */
		$theneeds_social_settings = get_option('social_settings');
		
		if($theneeds_social_settings <> ''){
			$theneeds_social = new DOMDocument ();
			$theneeds_social->loadXML ( $theneeds_social_settings );
		
			/* Social Sharing Values */
			$facebook_sharing = theneeds_find_xml_value($theneeds_social->documentElement,'facebook_sharing');
			$twitter_sharing = theneeds_find_xml_value($theneeds_social->documentElement,'twitter_sharing');
			$stumble_sharing = theneeds_find_xml_value($theneeds_social->documentElement,'stumble_sharing');
			$delicious_sharing = theneeds_find_xml_value($theneeds_social->documentElement,'delicious_sharing');
			$googleplus_sharing = theneeds_find_xml_value($theneeds_social->documentElement,'googleplus_sharing');
			$digg_sharing = theneeds_find_xml_value($theneeds_social->documentElement,'digg_sharing');
			$myspace_sharing = theneeds_find_xml_value($theneeds_social->documentElement,'myspace_sharing');
			$reddit_sharing = theneeds_find_xml_value($theneeds_social->documentElement,'reddit_sharing');
		}

			$currentUrl = $_SERVER['SERVER_NAME'].$_SERVER['REQUEST_URI'];
			
			$currentUrl = esc_url($currentUrl);
			
			$facebook = 'http://www.facebook.com/share.php?u='.$currentUrl;
			$twitter = 'http://twitter.com/home?status='.str_replace(" ", "%20", get_the_title()).'%20-%20'.$currentUrl;
			$delicious = 'http://delicious.com/post?url='.$currentUrl.'&#038;title='.get_the_title();
			$gplus = 'https://plus.google.com/share?url={'.$currentUrl.'}';
			$reddit = 'http://reddit.com/submit?url='.$currentUrl.'&#038;title='.get_the_title();
			$digg = 'http://digg.com/submit?url='.$currentUrl.'&#038;title='.get_the_title();
			$myspace = 'http://www.myspace.com/Modules/PostTo/Pages/?u='.$currentUrl;
			$linkedIn = 'http://www.linkedin.com/shareArticle?mini=true&url='.$currentUrl;
		
				/* Facebook Share */
				if($facebook_sharing == 'enable'){ ?>
					<li><a href="<?php echo esc_url($facebook);?>"><i class="fa fa-facebook"></i></a></li>
				<?php }
				/* Twitter Share */
				if($twitter_sharing == 'enable'){ ?>
					<li><a href="<?php echo esc_url($twitter);?>"><i class="fa fa-twitter"></i></a></li>
				<?php }
				/* Delicious Share */
				if($delicious_sharing == 'enable'){ ?>
					<li><a href="<?php echo esc_url($delicious);?>"><i class="fa fa-delicious"></i></a></li>
				<?php }
				/* Google Plus Share */
				if($googleplus_sharing == 'enable'){ ?>
					<li><a href="<?php echo esc_url($gplus);?>"><i class="fa fa-google-plus"></i></a></li>
				<?php }
				/* Reddit Share */
				if($reddit_sharing == 'enable'){ ?>
					<li><a href="<?php echo esc_url($reddit);?>"><i class="fa fa-reddit-alien"></i></a></li>
				<?php }
				/*  Digg Share */
				if($digg_sharing == 'enable'){ ?>
					<li><a href="<?php echo esc_url($digg);?>"><i class="fa fa-digg"></i></a></li>
				<?php }
				/*  LinkedIn Share */
				if($myspace_sharing == 'enable'){ ?>
					<li><a href="<?php echo esc_url($linkedIn);?>"><i class="fa fa-linkedin"></i></a></li>
				<?php }
	}
?>