<?php
/**
 * Zoom integration admin tab
 *
 * @since 1.0.0
 */

// Exit if accessed directly.
defined( 'ABSPATH' ) || exit;

/**
 * Setup Zoom integration admin tab class.
 *
 * @since 1.0.0
 */
class BP_Zoom_Admin_Integration_Tab extends BP_Admin_Integration_tab {
	protected $current_section;

	/**
	 * Initialize
	 *
	 * @since 1.0.0
	 */
	public function initialize() {
		$this->tab_order       = 50;
		$this->current_section = 'bp_zoom-integration';
		$this->intro_template = $this->root_path . '/templates/admin/integration-tab-intro.php';
	}

	/**
	 * Zoom Integration is active?
	 *
	 * @since 1.0.0
	 * @return bool
	 */
	public function is_active() {
		return (bool) apply_filters( 'bp_zoom_integration_is_active', true );
	}

	/**
	 * Load the settings html
	 *
	 * @since 1.0.0
	 */
	public function form_html() {
		// Check Group component active.
		if ( ! bbp_pro_is_license_valid() ) {
			if ( is_file( $this->intro_template ) ) {
				require $this->intro_template;
			}
		} else {
			parent::form_html();
		}
	}

	/**
	 * Zoom Integration tab scripts
	 *
	 * @since 1.0.0
	 */
	public function register_admin_script() {
		if ( 'bp-zoom' === $this->tab_name ) {
			$min = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
			wp_enqueue_script( 'bp-zoom-meeting-common', bp_zoom_integration_url( '/assets/js/bp-zoom-meeting-common' . $min . '.js' ), array( 'jquery' ), bb_platform_pro()->version, true );
			wp_localize_script(
				'bp-zoom-meeting-common',
				'bpZoomMeetingCommonVars',
				array(
					'ajax_url' => admin_url( 'admin-ajax.php' ),
				)
			);
		}
		parent::register_admin_script();
	}

	/**
	 * Method to save the fields.
	 *
	 * @since 1.0.0
	 */
	public function settings_save() {
		$bp_zoom_api_key    = isset( $_POST['bp-zoom-api-key'] ) ? $_POST['bp-zoom-api-key'] : false;
		$bp_zoom_api_secret = isset( $_POST['bp-zoom-api-secret'] ) ? $_POST['bp-zoom-api-secret'] : false;
		$bp_zoom_api_email  = isset( $_POST['bp-zoom-api-email'] ) ? $_POST['bp-zoom-api-email'] : false;

		if ( ! empty( $bp_zoom_api_secret ) && ! empty( $bp_zoom_api_key ) && ! empty( $bp_zoom_api_email ) ) {
			bp_zoom_conference()->zoom_api_key    = $bp_zoom_api_key;
			bp_zoom_conference()->zoom_api_secret = $bp_zoom_api_secret;

			$user_info = bp_zoom_conference()->get_user_info( $bp_zoom_api_email );

			if ( 200 !== $user_info['code'] ) {
				unset( $_POST['bp-zoom-api-email'] );
				bp_delete_option( 'bp-zoom-api-email' );
				bp_delete_option( 'bp-zoom-api-host' );
				bp_delete_option( 'bp-zoom-api-host-user' );
			} else {
				bp_update_option( 'bp-zoom-api-host', $user_info['response']->id );
				bp_update_option( 'bp-zoom-api-host-user', json_encode( $user_info['response'] ) );
			}
		}

		parent::settings_save();
	}

	/**
	 * Register setting fields for zoom integration.
	 *
	 * @since 1.0.0
	 */
	public function register_fields() {

		$sections = $this->get_settings_sections();

		foreach ( (array) $sections as $section_id => $section ) {

			// Only add section and fields if section has fields
			$fields = $this->get_settings_fields_for_section( $section_id );

			if ( empty( $fields ) ) {
				continue;
			}

			$section_title    = ! empty( $section['title'] ) ? $section['title'] : '';
			$section_callback = ! empty( $section['callback'] ) ? $section['callback'] : false;

			// Add the section
			$this->add_section( $section_id, $section_title, $section_callback );

			// Loop through fields for this section
			foreach ( (array) $fields as $field_id => $field ) {

				$field['args'] = isset( $field['args'] ) ? $field['args'] : array();

				if ( ! empty( $field['callback'] ) && ! empty( $field['title'] ) ) {
					$sanitize_callback = isset( $field['sanitize_callback'] ) ? $field['sanitize_callback'] : array();
					$this->add_field( $field_id, $field['title'], $field['callback'], $sanitize_callback, $field['args'] );
				}
			}
		}
	}

	/**
	 * Get setting sections for zoom integration.
	 *
	 * @since 1.0.0
	 *
	 * @return array $settings Settings sections for zoom integration.
	 */
	public function get_settings_sections() {

		$settings = array(
			'bp_zoom_settings_section' => array(
				'page'  => 'zoom',
				'title' => __( 'Zoom Settings', 'buddyboss-pro' ),
			),
			'bp_zoom_gutenberg_section' => array(
				'page'  => 'zoom',
				'title' => __( 'Zoom Gutenberg Blocks', 'buddyboss-pro' ),
			),
		);

		return $settings;
	}

	/**
	 * Get setting fields for section in zoom integration.
	 *
	 * @since 1.0.0
	 *
	 * @return array|false $fields setting fields for section in zoom integration false otherwise.
	 */
	public function get_settings_fields_for_section( $section_id = '' ) {

		// Bail if section is empty
		if ( empty( $section_id ) ) {
			return false;
		}

		$fields = $this->get_settings_fields();
		$fields = isset( $fields[ $section_id ] ) ? $fields[ $section_id ] : false;

		return $fields;
	}

	/**
	 * Register setting fields for zoom integration.
	 *
	 * @since 1.0.0
	 *
	 * @return array $fields setting fields for zoom integration.
	 */
	public function get_settings_fields() {

		$fields = array();

		$fields['bp_zoom_settings_section'] = array(
			'bp-zoom-enable' => array(
				'title'             => __( 'Enable Zoom', 'buddyboss-pro' ),
				'callback'          => 'bp_zoom_settings_callback_enable_field',
				'sanitize_callback' => 'string',
				'args'              => array(),
			),
		);

		if ( bp_zoom_is_zoom_enabled() ) {
			$fields['bp_zoom_gutenberg_section']['bp-zoom-api-key'] = array(
				'title'             => __( 'Zoom API Key', 'buddyboss-pro' ),
				'callback'          => 'bp_zoom_settings_callback_api_key_field',
				'sanitize_callback' => 'string',
				'args'              => array(),
			);

			$fields['bp_zoom_gutenberg_section']['bp-zoom-api-secret'] = array(
				'title'             => __( 'Zoom API Secret', 'buddyboss-pro' ),
				'callback'          => 'bp_zoom_settings_callback_api_secret_field',
				'sanitize_callback' => 'string',
				'args'              => array(),
			);

			$fields['bp_zoom_gutenberg_section']['bp-zoom-api-email'] = array(
				'title'             => __( 'Zoom Account Email', 'buddyboss-pro' ),
				'callback'          => 'bp_zoom_settings_callback_api_email_field',
				'sanitize_callback' => 'string',
				'args'              => array(),
			);

			if ( ! empty( bp_zoom_api_key() ) && ! empty( bp_zoom_api_secret() ) && ! empty( bp_zoom_api_email() ) ) {
				$fields['bp_zoom_gutenberg_section']['bp_zoom_api_check_connection'] = array(
					'title'    => __( '&#160;', 'buddyboss-pro' ),
					'callback' => 'bp_zoom_api_check_connection_button',
				);
			} else {
				$fields['bp_zoom_gutenberg_section']['bp_zoom_api_zoom_settings_tutorial'] = array(
					'title'    => __( '&#160;', 'buddyboss-pro' ),
					'callback' => 'bp_zoom_api_zoom_settings_tutorial',
				);
			}

			if ( bp_is_active( 'groups' ) ) {
				$fields['bp_zoom_settings_section']['bp-zoom-enable-groups'] = array(
					'title'             => __( 'Social Groups', 'buddyboss-pro' ),
					'callback'          => 'bp_zoom_settings_callback_groups_enable_field',
					'sanitize_callback' => 'string',
					'args'              => array(),
				);
			}

			$fields['bp_zoom_settings_section']['bp-zoom-enable-recordings'] = array(
				'title'             => __( 'Recordings', 'buddyboss-pro' ),
				'callback'          => 'bp_zoom_settings_callback_recordings_enable_field',
				'sanitize_callback' => 'string',
				'args'              => array(),
			);

			$fields['bp_zoom_settings_section']['bp_zoom_settings_tutorial'] = array(
				'title'    => __( '&#160;', 'buddyboss-pro' ),
				'callback' => 'bp_zoom_settings_tutorial',
			);
		}

		return $fields;
	}

	public function settings_saved() {
		$this->db_install_zoom_meetings();
		parent::settings_saved();
	}

	/**
	 * Install database tables for the Groups zoom meetings.
	 *
	 * @since 1.0.0
	 */
	public function db_install_zoom_meetings() {

		// check zoom enabled.
		if ( ! bp_zoom_is_zoom_enabled() ) {
			return;
		}

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		require_once buddypress()->plugin_dir . '/bp-core/admin/bp-core-admin-schema.php';
		$switched_to_root_blog = false;

		// Make sure the current blog is set to the root blog.
		if ( ! bp_is_root_blog() ) {
			switch_to_blog( bp_get_root_blog_id() );
			$switched_to_root_blog = true;
		}

		$sql             = array();
		$charset_collate = $GLOBALS['wpdb']->get_charset_collate();
		$bp_prefix       = bp_core_get_table_prefix();

		$sql[] = "CREATE TABLE {$bp_prefix}bp_zoom_meetings (
				id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				group_id bigint(20) NOT NULL,
				activity_id bigint(20) NOT NULL,
				user_id bigint(20) NOT NULL,
				host_id varchar(150) NOT NULL,
				title varchar(300) NOT NULL,
				description varchar(800) NULL,
				start_date datetime NOT NULL,
				timezone varchar(150) NOT NULL,
				password varchar(150) NOT NULL,
				duration int(11) NOT NULL,
				join_before_host bool default 0,
				host_video bool default 0,
				participants_video bool default 0,
				mute_participants bool default 0,
				waiting_room bool default 0,
				meeting_authentication bool default 0,
				recurring bool default 0,
				auto_recording varchar(75) default 'none',
				alternative_host_ids text NULL,
				meeting_id varchar(150) NOT NULL,
				start_date_utc datetime NOT NULL,
				hide_sitewide bool default 0,
				KEY group_id (group_id),
				KEY activity_id (activity_id),
				KEY meeting_id (meeting_id)
			) {$charset_collate};";

		$sql[] = "CREATE TABLE {$bp_prefix}bp_zoom_meeting_meta (
				id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				meeting_id bigint(20) NOT NULL,
				meta_key varchar(255) DEFAULT NULL,
				meta_value longtext DEFAULT NULL,
				KEY meeting_id (meeting_id),
				KEY meta_key (meta_key(191))
			) {$charset_collate};";

		$sql[] = "CREATE TABLE {$bp_prefix}bp_zoom_recordings (
				id bigint(20) NOT NULL AUTO_INCREMENT PRIMARY KEY,
				recording_id varchar(255) NOT NULL,
				meeting_id bigint(20) NOT NULL,
				uuid varchar(255) NOT NULL,
				details varchar(800) NULL,
				file_type varchar(800) NULL,
				password varchar(150) NOT NULL,
				start_time datetime NOT NULL,
				KEY recording_id (recording_id),
				KEY meeting_id (meeting_id)
			) {$charset_collate};";

		dbDelta( $sql );

		if ( $switched_to_root_blog ) {
			restore_current_blog();
		}
	}
}
