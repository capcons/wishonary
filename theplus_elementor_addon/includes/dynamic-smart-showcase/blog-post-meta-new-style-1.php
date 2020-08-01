<div class="post-meta-info style-1">
	
	
	<span class="post-author"><i class="fa fa-user"></i><a href="<?php echo get_author_posts_url(get_the_author_meta('ID')); ?>" rel="author" class="fn"><?php echo get_the_author(); ?></a> </span>
	<i class="fa fa-clock-o"></i><?php include THEPLUS_INCLUDES_URL. 'dynamic-smart-showcase/meta-date.php'; ?>
		<div class="post-meta-info-inner"><i class="fa fa-comments"></i><span class="post-comment-count"><?php echo get_comments_number(get_the_ID()); ?></span></div>
</div>

