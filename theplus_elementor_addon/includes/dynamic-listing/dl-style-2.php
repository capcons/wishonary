<?php 
$postid=get_the_ID();
$bg_attr='';
if($layout=='metro'){
	if((!empty($display_thumbnail) && $display_thumbnail=='yes') && !empty($thumbnail)){
		$featured_image=get_the_post_thumbnail_url($postid,$thumbnail);		
	}else{
		$featured_image=get_the_post_thumbnail_url($postid,'full');		
	}
	if((!empty($display_thumbnail) && $display_thumbnail=='yes') && !empty($thumbnail)){
		if ( !empty($featured_image) ) {
			$bg_attr='style="background:url('.$featured_image.') #f7f7f7;"';
		}else{
			$bg_attr = theplus_loading_image_grid($postid,'background');
		}
	}else{
		if ( !empty($featured_image) ) {
			$bg_attr=theplus_loading_bg_image($postid);
		}else{
			$bg_attr = theplus_loading_image_grid($postid,'background');
		}
	}
}
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<div class="blog-list-content">
		<?php if($layout!='metro'){ ?>
		<?php if(!empty($feature_image) && $feature_image=='yes'){ ?>
		<div class="post-content-image">
			<a href="<?php echo esc_url(get_the_permalink()); ?>">
				<?php include THEPLUS_INCLUDES_URL. 'dynamic-listing/format-image.php'; ?>
			</a>
			<?php if($display_post_category=='yes' && $style_layout=='layout-style-2'){ ?>
				<?php include THEPLUS_INCLUDES_URL. 'dynamic-listing/dl-category-'.$post_category_style.'.php'; ?>
			<?php } ?>
		</div>
		<?php } ?>
		<?php } ?>
		<div class="post-content-bottom">
			<?php if($display_post_category=='yes' && $style_layout=='layout-style-1' || ($style_layout=='layout-style-2' && $layout=='metro')){ ?>
				<div class="post-metro-category-top">
					<?php include THEPLUS_INCLUDES_URL. 'dynamic-listing/dl-category-'.$post_category_style.'.php'; ?>
				</div>
			<?php } ?>
			<div class="post-metro-content">
				<?php include THEPLUS_INCLUDES_URL. 'dynamic-listing/post-meta-title.php'; ?>
				<?php if(!empty($display_excerpt) && $display_excerpt=='yes' && get_the_excerpt()){ ?>
					<div class="post-hover-content">
						<?php include THEPLUS_INCLUDES_URL. 'dynamic-listing/get-excerpt.php'; ?>
					</div>
				<?php } ?>
				<?php if(!empty($display_post_meta) && $display_post_meta=='yes'){ ?>
					<?php include THEPLUS_INCLUDES_URL. 'dynamic-listing/dl-post-meta-'.$post_meta_tag_style.'.php'; ?>
				<?php } ?>
			</div>
		</div>
		<?php if($layout=='metro'){ ?>
		<div class="blog-bg-image-metro" <?php echo $bg_attr; ?>></div>
		<?php } ?>
	</div>
</article>
