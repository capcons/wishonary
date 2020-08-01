<?php 
	global $post;
	$postid = get_the_ID();
$featured_image_url = wp_get_attachment_url( get_post_thumbnail_id( get_the_ID() ) );
	
	if(! empty( $featured_image_url )){
		if(!empty($layout) && $layout=='grid'){
			if((!empty($display_thumbnail) && $display_thumbnail=='yes') && !empty($thumbnail)){
				$featured_image=get_the_post_thumbnail_url(get_the_ID(),$thumbnail);
			}else{
				$featured_image=get_the_post_thumbnail_url(get_the_ID(),'tp-image-grid');
			}
			
			$featured_image='<img src="'.esc_url($featured_image).'" alt="'.esc_attr(get_the_title()).'">';
			
		}else if(!empty($layout) && $layout=='masonry'){
			if((!empty($display_thumbnail) && $display_thumbnail=='yes') && !empty($thumbnail)){				
				$featured_image=get_the_post_thumbnail_url(get_the_ID(),$thumbnail);
			}else{
				$featured_image=get_the_post_thumbnail_url(get_the_ID(),'full');
			}			
			$featured_image='<img src="'.esc_url($featured_image).'" alt="'.esc_attr(get_the_title()).'">';
			
		}else if(!empty($layout) && $layout=='carousel'){
			
			if(empty($featured_image_type)){
				$featured_image_type='full';				
			}else{
				if($featured_image_type=='grid'){
				 $featured_image_type='tp-image-grid';
				}else if($featured_image_type=='custom'){
					 $featured_image_type=$thumbnail_car;
				}
			}
			
			$featured_image=get_the_post_thumbnail_url(get_the_ID(),$featured_image_type);
			$featured_image='<img src="'.esc_url($featured_image).'" alt="'.esc_attr(get_the_title()).'">';
			
		}else{
			
			$featured_image=get_the_post_thumbnail_url(get_the_ID(),'full');
			$featured_image='<img src="'.esc_url($featured_image).'" alt="'.esc_attr(get_the_title()).'">';		
		
		}
	}else{
		$featured_image=theplus_get_thumb_url();
		$featured_image=$featured_image='<img src="'.esc_url($featured_image).'" alt="'.esc_attr(get_the_title()).'">';
	}
?>
	<div class="product-featured-image">
	<span class="thumb-wrap">
		<?php echo $featured_image; ?>
	</span>
	</div>