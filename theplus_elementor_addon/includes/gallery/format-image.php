<?php 
	if($attachment){
		$featured_image_id = $attachment->ID;
	}else{
		$featured_image_id = $image_id;
	}
	
	if(!empty($featured_image_id) && !empty($display_thumbnail) && $display_thumbnail=='yes' && !empty($thumbnail)){
		if(!empty($layout) && ($layout=='grid' || $layout=='masonry')){
			$featured_image=wp_get_attachment_image( $featured_image_id, $thumbnail );
		}
	}else if(! empty( $featured_image_id )){
		if(!empty($layout) && $layout=='grid'){			
			$featured_image=wp_get_attachment_image( $featured_image_id, 'tp-image-grid' );
		}else if(!empty($layout) && $layout=='masonry'){		
			$featured_image=wp_get_attachment_image($featured_image_id ,'full');			
		}else if(!empty($layout) && $layout=='carousel'){
		
			//custom size carousel image
			if(!empty($featured_image_type) && $featured_image_type=='custom' && !empty($thumbnail_carousel)){			
				$featured_image=wp_get_attachment_image( $featured_image_id, $thumbnail_carousel );	
			}else if(empty($featured_image_type) || $featured_image_type=='full'){
				$featured_image_type='full';
				$featured_image=wp_get_attachment_image($featured_image_id ,$featured_image_type);
			}else{
				if($featured_image_type=='grid'){
				 $featured_image_type='tp-image-grid';
				}
				$featured_image=wp_get_attachment_image($featured_image_id ,$featured_image_type);
			}
		}else{			
			$featured_image=wp_get_attachment_image($featured_image_id ,'full');
		}
	}else{
		$featured_image=theplus_get_thumb_url();
		$featured_image=$featured_image='<img src="'.esc_url($featured_image).'" alt="'.esc_attr($image_alt).'">';
	}
	
?>
	<div class="gallery-image">
	<span class="thumb-wrap">
		<?php echo $featured_image; ?>
	</span>
	</div>