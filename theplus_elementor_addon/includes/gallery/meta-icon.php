<?php if(!empty($settings["custom_icon_image"]["url"])){
	$icon_content ='<img src="'.esc_url($settings["custom_icon_image"]["url"]).'" alt="'.esc_attr('zoom','theplus').'"/>';
}else{
	$icon_content ='<i class="fa fa-search-plus" aria-hidden="true"></i>';
} ?>
<div class="meta-search-icon">
	<?php	
	 if(!empty($settings['display_box_link']) && $settings['display_box_link']=='yes'){ ?>
		<div <?php echo $popup_attr_icon; ?>><?php echo $icon_content; ?></div>
	<?php }else{ ?>
		<a href="<?php echo esc_url($full_image); ?>" <?php echo $popup_attr_icon; ?>><?php echo $icon_content; ?></a>
	<?php } ?>
</div>