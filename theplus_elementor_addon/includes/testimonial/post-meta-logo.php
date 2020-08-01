<?php 
	
	if($display_thumbnail=='yes' && !empty($thumbnail)){		
		$testimonial_logo=get_the_post_thumbnail_url(get_the_ID(),$thumbnail);		
	}else{
		$testimonial_logo = get_post_meta(get_the_id(), 'theplus_testimonial_logo', true); 		
	}
	
if(!empty($testimonial_logo)){ 
?>
	<div class="testimonial-author-logo"><img src="<?php echo esc_url($testimonial_logo); ?>" /></div>
<?php } ?>