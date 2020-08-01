<?php

/*-----------------------------------------------------------------------------------*/
/* Register the admin page with the 'admin_menu' */
/*-----------------------------------------------------------------------------------*/

function pavi_admin_menu() {
	$page = add_submenu_page( 'options-general.php', __( 'PressApps Video', 'pressapps-video' ), __( 'PressApps Video', 'pressapps-video' ), 'manage_options', 'pavi-options', 'pavi_options', 99 );
}
add_action( 'admin_menu', 'pavi_admin_menu' );


/*-----------------------------------------------------------------------------------*/
/* Load HTML that will create the outter shell of the admin page */
/*-----------------------------------------------------------------------------------*/

function pavi_options() {

	// Check that the user is able to view this page.
	if ( ! current_user_can( 'manage_options' ) )
		wp_die( __( 'You do not have sufficient permissions to access this page.', 'pressapps-video' ) ); ?>

	<div class="wrap">
		<div id="icon-themes" class="icon32"></div>
		<h2><?php _e( 'PressApps Video Settings', 'pressapps-video' ); ?></h2>

		<form action="options.php" method="post">
			<?php settings_fields( 'pavi_setup_options' ); ?>
			<?php do_settings_sections( 'pavi_setup_options' ); ?>
			<?php submit_button(); ?>
		</form>

	</div>
<?php }

/*-----------------------------------------------------------------------------------*/
/* Registers all sections and fields with the Settings API */
/*-----------------------------------------------------------------------------------*/

function pavi_init_settings_registration() {
	$option_name = 'pavi_settings';

	// Check if settings options exist in the database. If not, add them.
	if ( get_option( $option_name ) )
		add_option( $option_name );

	// Define settings sections.
	add_settings_section( 'pavi_setup_section', __( 'Setup', 'pressapps-video' ), 'pavi_setup_options', 'pavi_setup_options' );

	add_settings_field( 'content_layout', __( 'Featured Video Layout', 'pressapps-video' ), 'pavi_settings_field_select', 'pavi_setup_options', 'pavi_setup_section', array(
		'options-name' => $option_name,
		'id'				=> 'content-layout',
		'class' 			=> '',
		'value'			=> array(
								'3' => __( 'Video Left - Title & Text Right' , 'pressapps-video' ),
								'1' => __( 'Full Width Video - Title & Text Below', 'pressapps-video' ),
								),
		'label'			=> __( 'Select video layout for desktop.', 'pressapps-video' ),
	) );
	add_settings_field( 'sortable_columns', __( 'Thumbnail Columns', 'pressapps-video' ), 'pavi_settings_field_select', 'pavi_setup_options', 'pavi_setup_section', array(
		'options-name' => $option_name,
		'id'				=> 'sortable-columns',
		'class' 			=> '',
		'value'			=> array(
								// '1' => __( '1 Column', 'pressapps-video' ),
								'2' => __( '2 Columns', 'pressapps-video' ),
								'3' => __( '3 Columns', 'pressapps-video' ),
								'4' => __( '4 Columns', 'pressapps-video' ),
								'5' => __( '5 Columns', 'pressapps-video' ),
								),
		'label'			=> __( 'Select number of thumbnail columns.', 'pressapps-video' ),
	) );
	add_settings_field( 'filter_nav', __( 'Filter Navigation', 'pressapps-video' ), 'pavi_settings_field_select', 'pavi_setup_options', 'pavi_setup_section', array(
		'options-name' => $option_name,
		'id'				=> 'filter-nav',
		'class' 			=> '',
		'value'			=> array(
								'display' => __( 'Display' , 'pressapps-video' ),
								'hide' => __( 'Hide', 'pressapps-video' ),
								),
		'label'			=> __( 'Display category filter navigation.', 'pressapps-video' ),
	) );
	add_settings_field( 'autoplay', __( 'Autoplay Videos', 'pressapps-video' ), 'pavi_settings_field_checkbox', 'pavi_setup_options', 'pavi_setup_section', array(
		'options-name' => $option_name,
		'id'				=> 'autoplay',
		'class'			=> '',
		'value'			=> '',
		'label'			=> __( 'Autoplay a video when thumbnail clicked.', 'pressapps-video' ),
	) );
	add_settings_field( 'scroll', __( 'Scroll To Top', 'pressapps-video' ), 'pavi_settings_field_checkbox', 'pavi_setup_options', 'pavi_setup_section', array(
		'options-name' => $option_name,
		'id'				=> 'scroll',
		'class'			=> '',
		'value'			=> '',
		'label'			=> __( 'Enable scroll to top on thumbnail click (does not apply when lightbox enabled).', 'pressapps-video' ),
	) );



	add_settings_field( 'custom_css', __( 'Custom CSS', 'pressapps-video' ), 'pavi_settings_field_textarea', 'pavi_setup_options', 'pavi_setup_section', array(
		'options-name' => $option_name,
		'id'				=> 'custom-css',
		'class'			=> '',
		'value'			=> '',
		'label'			=> __( 'Add custom CSS code.', 'pressapps-video' ),
	) );


	// Register settings with WordPress so we can save to the Database
	register_setting( 'pavi_setup_options', $option_name, 'pavi_options_sanitize' );
}
add_action( 'admin_init', 'pavi_init_settings_registration' );

/*-----------------------------------------------------------------------------------*/
/* add_settings_section() function for the widget options */
/*-----------------------------------------------------------------------------------*/

function pavi_setup_options() {
	//echo '<p>' . __( 'You can add video posts to your site using [video] shortcode.', 'pressapps-video' ) . '.</p>';
}

/*-----------------------------------------------------------------------------------*/
/* he callback function to display textareas */
/*-----------------------------------------------------------------------------------*/

function pavi_settings_field_textarea( $args ) {
	// Set the options-name value to a variable
	$name = $args['options-name'] . '[' . $args['id'] . ']';

	// Get the options from the database
	$options = get_option( $args['options-name'] ); ?>

	<label for="<?php echo $args['id']; ?>"><?php esc_attr_e( $args['label'] ); ?></label><br />
	<textarea name="<?php echo $name; ?>" id="<?php echo $args['id']; ?>" class="large-text<?php if ( ! empty( $args['class'] ) ) echo ' ' . $args['class']; ?>" cols="30" rows="7"><?php esc_attr_e( $options[ $args['id'] ] ); ?></textarea>
<?php }


/*-----------------------------------------------------------------------------------*/
/* The callback function to display checkboxes */
/*-----------------------------------------------------------------------------------*/

function pavi_settings_field_checkbox( $args ) {
	// Set the options-name value to a variable
	$name = $args['options-name'] . '[' . $args['id'] . ']';

	// Get the options from the database
	$options = get_option( $args['options-name'] ); ?>

	<input type="checkbox" name="<?php echo $name; ?>" id="<?php echo $args['id']; ?>" <?php if ( ! empty( $args['class'] ) ) echo 'class="' . $args['class'] . '" '; ?>value="<?php esc_attr_e( $args['value'] ); ?>" <?php if ( isset( $options[ $args['id'] ] ) ) checked( $args['value'], $options[ $args['id'] ], true ); ?> />
	<label for="<?php echo $args['id']; ?>"><?php esc_attr_e( $args['label'] ); ?></label>
<?php }


/*-----------------------------------------------------------------------------------*/
/* The callback function to display selection dropdown */
/*-----------------------------------------------------------------------------------*/

function pavi_settings_field_select( $args ) {
	// Set the options-name value to a variable
	$name = $args['options-name'] . '[' . $args['id'] . ']';

	// Get the options from the database
	$options = get_option( $args['options-name'] ); ?>

	<select name="<?php echo $name; ?>" id="<?php echo $args['id']; ?>" <?php if ( ! empty( $args['class'] ) ) echo 'class="' . $args['class'] . '" '; ?>>
		<?php foreach ( $args['value'] as $key => $value ) : ?>
			<option value="<?php esc_attr_e( $key ); ?>"<?php if ( isset( $options[ $args['id'] ] ) ) selected( $key, $options[ $args['id'] ], true ); ?>><?php esc_attr_e( $value ); ?></option>
		<?php endforeach; ?>
	</select>
	<label for="<?php echo $args['id']; ?>" style="display:block;"><?php esc_attr_e( $args['label'] ); ?></label>
<?php }


/*-----------------------------------------------------------------------------------*/
/* The callback function to display text field */
/*-----------------------------------------------------------------------------------*/

function pavi_settings_field_text( $args ) {

	// Set the options-name value to a variable
	$name = $args['options-name'] . '[' . $args['id'] . ']';

	// Get the options from the database
	$options = get_option( $args['options-name'] ); ?>

	<input name="<?php echo $name; ?>" id="<?php echo $args['id']; ?>" type="text" class="regular-text code<?php if ( ! empty( $args['class'] ) ) echo ' ' . $args['class']; ?>" value="<?php if ( isset ( $options[ $args['id'] ] )) { esc_attr_e( $options[ $args['id'] ] ) ;} else { echo ''; } ?>"></input>

	<label for="<?php echo $args['id']; ?>" style="display:block;"><?php esc_attr_e( $args['label'] ); ?></label>
<?php }


/*-----------------------------------------------------------------------------------*/
/* The callback function to display info */
/*-----------------------------------------------------------------------------------*/

function pavi_settings_field_info( $args ) {
	// Set the options-name value to a variable
	$name = $args['options-name'] . '[' . $args['id'] . ']';

	// Get the options from the database
	$options = get_option( $args['options-name'] ); ?>

	<p><?php esc_attr_e( $args['value'] ); ?></p>

<?php }


/*-----------------------------------------------------------------------------------*/
/* Sanitization function */
/*-----------------------------------------------------------------------------------*/

function pavi_options_sanitize( $input ) {

	// Set array for the sanitized options
	$output = array();

	// Loop through each of $input options and sanitize them.
	foreach ( $input as $key => $value ) {
		if ( isset( $input[ $key ] ) )
			$output[ $key ] = strip_tags( stripslashes( $input[ $key ] ) );
	}

	return apply_filters( 'pavi_options_sanitize', $output, $input );
}

