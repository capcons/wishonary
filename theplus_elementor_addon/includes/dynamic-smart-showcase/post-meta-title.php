<?php if(!isset($post_title_tag) && empty($post_title_tag)){
	$post_title_tag='h3';
}
?>
<<?php echo $post_title_tag; ?> class="post-title <?php echo $title_desc_word_break;?>">
	<a href="<?php echo esc_url(get_the_permalink()); ?>"><?php echo theplus_get_title($post_title_count); ?></a>
</<?php echo $post_title_tag; ?>>