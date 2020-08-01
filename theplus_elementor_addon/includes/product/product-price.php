<?php $product_id=get_the_ID(); ?>
<div class="wrapper-cart-price">
	<?php		
		if(!empty($variation_price_on) && $variation_price_on=='yes'){
			if($product->is_type( 'variable' )) {
				$product = new WC_Product_Variable( $product_id );
			}else{
				$product = new WC_Product( $product_id );
			}
		}else{
			$product = new WC_Product( $product_id );	
		}
	?>
	<span class="price"><?php echo $product->get_price_html(); ?></span>
</div>