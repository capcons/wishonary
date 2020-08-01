<?php
/**
 * Add Menu Page
 */
add_action( 'admin_menu', 'htpmpro_submenu' );
function htpmpro_submenu() {

	$menu = 'add_menu_' . 'page';
    $menu(
        'htpmpro_plugin_panel',
        esc_html__( 'Plugin Manager', 'htpmpro' ),
        esc_html__( 'Plugin Manager', 'htpmpro' ),
        'htpmpro_page',
        NULL,
        HTPMPRO_ROOT_URL . '/assets/images/menu-icon.png',
        65
    );

	add_submenu_page( 
		'htpmpro_page', 
		esc_html__('Settings', 'htpmpro'), 
		esc_html__('Settings', 'htpmpro'), 
		'manage_options', 
		'htpmpro-options', 
		'htpmpro_options_page_html'
	);

}

/**
 * Render the option page
 */
function htpmpro_options_page_html() {
	 // check user capabilities
	 if ( ! current_user_can( 'manage_options' ) ) {
	 	return;
	 }

	 // show message when updated
	 if ( isset( $_GET['settings-updated'] ) ) {
	 	add_settings_error( 'htpmpro_messages', 'htpmpro_message', esc_html__( 'Settings Saved', 'htpmpro' ), 'updated' );
	 }
	 
	 // show error/update messages
	 settings_errors( 'htpmpro_messages' );
	 ?>
		<div class="wrap">
			<h1><?php echo esc_html( 'WP Plugin Manager' ); ?> <?php echo esc_html( get_admin_page_title() ); ?></h1>
			<form action="options.php" method="post">
				<?php
					// output general section and their fields
					do_settings_sections( 'options_group_general' );

					// general option fields
					settings_fields( 'options_group_general' );

					// output save settings button
					submit_button( 'Save Settings' );
				?>
			</form>
		</div>
	<?php
}

/**
 * Register option name & group
 * Add section
 * Add fields
 */
add_action( 'admin_init', 'htpmpro_settings_init' );
function htpmpro_settings_init() {
	// reginster option named "htpm_options"
	register_setting( 'options_group_general', 'htpm_options' );

	add_settings_section(
		'section_1',
		'',
		'',
		'options_group_general'
	);

	add_settings_field(
		'htpm_list_plugins', // field name
		esc_html__( 'WP Plugins Manager', 'htpmpro' ),
		'htpmpro_list_plugins_cb',
		'options_group_general',
		'section_1',
		[
			'label_for' => 'htpm_list_plugins',
			'class' => 'htpmpro_row',
		]
	);
}

/**
 * htpmpro_list_plugins_cb callback
 */
function htpmpro_list_plugins_cb( $args ) {
	$options = get_option( 'htpm_options' );
	$htpmpro_list_plugins = $options['htpm_list_plugins'];
 ?>
	<div id="htpmpro_accordion" class="htpmpro_accordion">
		<?php
		$active_plugins = get_option('active_plugins');

		// remove pro plugin from the list
		if (($key = array_search('wp-plugin-manager-pro/plugin-main.php', $active_plugins)) !== false) {
		    unset($active_plugins[$key]);
		}

		$plugin_dir = HTPMPRO_PLUGIN_DIR;

		if($active_plugins):
			foreach($active_plugins as $plugin):
				$idividual_options = isset( $htpmpro_list_plugins[$plugin] ) ? $htpmpro_list_plugins[$plugin] : array( 'condition_list'=>'', 'enable_deactivation'=>Null, 'uri_type'=>'', 'condition_type'=>'', 'device_type'=>'', 'posts'=>'', 'pages'=>'' );
				$plugin_headers = get_plugin_data( $plugin_dir . '/' . $plugin );
			?>
			<h3 class="<?php echo isset( $idividual_options['enable_deactivation'] ) ? 'htpmpro_is_disabled' : ''; ?>"><?php echo esc_html( $plugin_headers['Name'] ); ?></h3>
			<div class="htpmpro_single_accordion" data-htpmpro_uri_type="<?php echo esc_attr( $idividual_options['uri_type'] ? $idividual_options['uri_type'] : 'page'); ?>">

			  	<div class="htpmpro_single_field">
				  	<label><?php echo esc_html__('Enable / Disable:', 'htpmpro') ?></label>
					<input type="checkbox" name="htpm_options[<?php echo esc_attr( $args['label_for'] ); ?>][<?php echo esc_attr($plugin) ?>][enable_deactivation]" value="yes" <?php checked( isset($idividual_options['enable_deactivation']), 1 ); ?>>
				</div>

				<div class="htpmpro_single_field">
				  	<label><?php echo esc_html__( 'Apply rule on:', 'htpmpro' ); ?></label>
				  	<select class="htpmpro_uri_type" name="htpm_options[<?php echo esc_attr( $args['label_for'] ); ?>][<?php echo esc_attr($plugin) ?>][device_type]">
				  		<option value="all" <?php selected( $idividual_options['device_type'], 'all' ) ?>><?php echo esc_html__( 'All', 'htpmpro' ) ?></option>
				  		<option value="desktop" <?php selected( $idividual_options['device_type'], 'desktop' ) ?>><?php echo esc_html__( 'Desktop', 'htpmpro' ) ?></option>
				  		<option value="tablet" <?php selected( $idividual_options['device_type'], 'tablet' ) ?>><?php echo esc_html__( 'Tablet', 'htpmpro' ) ?></option>
				  		<option value="mobile" <?php selected( $idividual_options['device_type'], 'mobile' ) ?>><?php echo esc_html__( 'Mobile', 'htpmpro' ) ?></option>
				  	</select>
				</div>

				<div class="htpmpro_single_field">
				  	<label><?php echo esc_html__( 'Condition Type:', 'htpmpro' ); ?></label>
				  	<select class="htpmpro_uri_type" name="htpm_options[<?php echo esc_attr( $args['label_for'] ); ?>][<?php echo esc_attr($plugin) ?>][condition_type]">
				  		<option value="disable_on_selected" <?php selected( $idividual_options['condition_type'], 'disable_on_selected' ) ?>><?php echo esc_html__( 'Disable On Selected', 'htpmpro' ) ?></option>
				  		<option value="enable_on_selected" <?php selected( $idividual_options['condition_type'], 'enable_on_selected' ) ?>><?php echo esc_html__( 'Enable On Selected', 'htpmpro' ) ?></option>
				  	</select>
				</div>

				<div class="htpmpro_single_field">
				  	<label><?php echo esc_html__( 'URI Type:', 'htpmpro' ); ?></label>
				  	<select class="htpmpro_uri_type" name="htpm_options[<?php echo esc_attr( $args['label_for'] ); ?>][<?php echo esc_attr($plugin) ?>][uri_type]">
				  		<option value="page" <?php selected( $idividual_options['uri_type'], 'page' ) ?>><?php echo esc_html__( 'Page', 'htpmpro' ) ?></option>
				  		<option value="post" <?php selected( $idividual_options['uri_type'], 'post' ) ?>><?php echo esc_html__( 'Post', 'htpmpro' ) ?></option>
				  		<option value="page_post" <?php selected( $idividual_options['uri_type'], 'page_post' ) ?>><?php echo esc_html__( 'Post And Pages', 'htpmpro' ) ?></option>
				  		<option value="custom" <?php selected( $idividual_options['uri_type'], 'custom' ) ?>><?php echo esc_html__('Custom', 'htpmpro') ?></option>
				  	</select>
				</div>

				<div class="htpmpro_single_field htpmpro_selected_page_checkboxes">
				  	<label><?php echo esc_html__( 'Select Pages:', 'htpmpro' ) ?></label>
				  	<div>
					  	<select class="htpmpro_select2_active" name="htpm_options[<?php echo esc_attr( $args['label_for'] ); ?>][<?php echo esc_attr($plugin) ?>][pages][]" multiple="multiple">
			  	  		  	<?php
			  	  		  		$pages = get_pages();
			  	  		  		foreach ( $pages as $key => $page ) {
			  	  		  			$option_value = esc_attr($page->ID) .','. esc_url(get_page_link( $page->ID ));
			  	  		  			$is_selected = in_array($option_value,  $idividual_options['pages']);
			  	  		  			?>
			  	  		  			<option value="<?php echo esc_attr($option_value); ?>" <?php selected($is_selected , true ) ?>><?php echo esc_html($page->post_title);  ?></option>
			  	  		  			<?php
			  	  		  			$option_page_id = false;
			  	  		  		}
			  	  		  	?>
					  	</select>
				  	</div>
				</div>
				
				<div class="htpmpro_single_field htpmpro_selected_post_checkboxes">
				  	<label><?php echo esc_html__( 'Select Posts:', 'htpmpro' ) ?></label>
				  	<div>
	  				  	<select class="htpmpro_select2_active" name="htpm_options[<?php echo esc_attr( $args['label_for'] ); ?>][<?php echo esc_attr($plugin) ?>][posts][]" multiple="multiple">
	  		  	  		  	<?php
	  		  	  		  		$posts = get_posts(array(
	  		  	  		  			'numberposts' => '-1'
	  		  	  		  		));
	  		  	  		  		foreach ( $posts as $key => $post ) {
	  		  	  		  			$option_value = esc_attr($post->ID) .','. esc_url(get_permalink( $post->ID ));
	  		  	  		  			$is_selected = in_array($option_value,  $idividual_options['posts']);
	  		  	  		  			?>
	  		  	  		  			<option value="<?php echo esc_attr($option_value); ?>" <?php selected($is_selected, true ) ?>><?php echo esc_html($post->post_title);  ?></option>
	  		  	  		  			<?php
	  		  	  		  		}
	  		  	  		  	?>
	  				  	</select>
				  	</div>
				</div>
			  	<table id="htpmprorepeatable-fieldset" class="htpmpro_repeater" width="100%">
		            <thead>
		                <tr>
		                    <th><?php echo esc_html__( 'URI Condition', 'htpmpro' ) ?></th>
		                    <th><?php echo esc_html__( 'Value', 'htpmpro' ); ?></th>
		                    <th><?php echo esc_html__( 'Action', 'htpmpro' ); ?></th>
		                </tr>
		            </thead>
		            <tbody>
		            	<?php 
		            	$condition_list = array();
		            	$condition_list = $idividual_options['condition_list'];
		            	if( !$condition_list):
		            	?>
		            		<tr>
		            	        <td>
		            	        	<select name="htpm_options[htpm_list_plugins][<?php echo esc_attr( $plugin ) ?>][condition_list][name][]">
		            	        		<option value="uri_equals"><?php echo esc_html__( 'URI Equals', 'htpmpro' ) ?></option>
		            	        		<option value="uri_not_equals"><?php echo esc_html__( 'URI Not Equals', 'htpmpro' ) ?></option>
		            	        		<option value="uri_contains"><?php echo esc_html__( 'URI Contains', 'htpmpro' ) ?></option>
		            	        		<option value="uri_not_contains"><?php echo esc_html__( 'URI Not Contains', 'htpmpro' ) ?></option>
		            	        	</select>
		            	        </td>
		            	        <td>
		            	            <input class="widefat" type="text" placeholder="<?php echo esc_html__('E.g: http://example.com/contact-us/ you can use \'contact-us\'', 'htpmpro'); ?>" name="htpm_options[htpm_list_plugins][<?php echo esc_attr($plugin) ?>][condition_list][value][]" value="">
		            	        </td>
		            	        <td>
		            	            <a class="button htpmpro-remove-row" href="#"><?php echo esc_html__('Remove', 'htpmpro') ?></a>
		            	            <a class="button htpmpro-add-row" href="#"><?php echo esc_html__( 'Clone', 'htpmpro' ) ?></a>
		            	        </td>
		            	    </tr>
		            	<?php
		            	endif;

		            	if($condition_list):
		            	for($i = 0; $i < count($condition_list['name']); $i++ ):
		            		if($condition_list['name'][$i]):
		            	?>
		            	<tr>
		                    <td>
		                    	<select name="htpm_options[htpm_list_plugins][<?php echo esc_attr( $plugin ) ?>][condition_list][name][]">
		                    		<option value="uri_equals" <?php selected( $condition_list['name'][$i], 'uri_equals') ?>><?php echo esc_html__( 'URI Equals', 'htpmpro' ) ?></option>
		                    		<option value="uri_not_equals" <?php selected( $condition_list['name'][$i], 'uri_not_equals') ?>><?php echo esc_html__( 'URI Not Equals', 'htpmpro' ) ?></option>
		                    		<option value="uri_contains" <?php selected( $condition_list['name'][$i], 'uri_contains') ?>><?php echo esc_html__( 'URI Contains', 'htpmpro' ) ?></option>
		                    		<option value="uri_not_contains" <?php selected( $condition_list['name'][$i], 'uri_not_contains') ?>><?php echo esc_html__( 'URI Not Contains', 'htpmpro' ) ?></option>
		                    	</select>
		                    </td>
		                    <td>
		                        <input class="widefat" type="text" placeholder="<?php echo esc_html__('E.g: http://example.com/contact-us/ you can use \'contact-us\'', 'htpmpro'); ?>'" name="htpm_options[htpm_list_plugins][<?php echo esc_attr($plugin) ?>][condition_list][value][]" value="<?php echo esc_attr($condition_list['value'][$i]); ?>">
		                    </td>
		                    <td>
		                        <a class="button htpmpro-remove-row" href="#"><?php echo esc_html__('Remove', 'htpmpro') ?></a>
		                        <a class="button htpmpro-add-row" href="#"><?php echo esc_html__( 'Clone', 'htpmpro' ) ?></a>
		                    </td>
		                </tr>
		            	<?php
		            		endif;
		            	endfor;
		            	endif;
		            	?>
		            </tbody>
	        	</table>
		        <table class="screen-reader-text">
		        	<!-- empty hidden one for jQuery -->
		        	<tr class="htpmpro-empty-row screen-reader-text">
		        	    <td>
		        	        <input type="text" placeholder="Enter Title" name="htpm_options[htpmpro_list_plugins][<?php echo esc_attr($plugin) ?>][condition_list][name][]">
		        	    </td>
		        	    <td>
		        	        <input type="text" placeholder="Enter Price" name="htpm_options[htpmpro_list_plugins][<?php echo esc_attr($plugin) ?>][condition_list][value][]">
		        	    </td>
		        	    <td>
		        	     	<a class="button htpmpro-remove-row" href="#"><?php echo esc_html__('Remove', 'htpmpro') ?></a>
		        	     	<a class="button htpmpro-add-row" href="#"><?php echo esc_html__( 'Add Another', 'htpmpro' ) ?></a>
		        	    </td>
		        	</tr>
		        </table>
			</div>
			<?php
			endforeach;
		endif;
		?>
	</div>
 <?php
}