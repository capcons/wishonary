<?php if(!isset($post_title_tag) && empty($post_title_tag)){
	$post_title_tag='h3';
} ?>
<<?php echo $post_title_tag; ?> class="post-title">
	<?php if(empty($disable_link) && $disable_link!='yes'){ ?><a href="<?php echo esc_url($member_url); ?>"><?php } ?><?php echo esc_html(get_the_title()); ?><?php if(empty($disable_link) && $disable_link!='yes'){ ?></a><?php } ?>
</<?php echo $post_title_tag; ?>>