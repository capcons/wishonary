<?php 	
	if($product->get_rating_count() > 0){
		wc_get_template( 'single-product/rating.php' ); 
	}	
?>