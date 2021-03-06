<?php
defined('ABSPATH') || exit;

/**
 * A custom Expedited Order WooCommerce Email class
 *
 * @since 0.1
 * @extends \WC_Email
 */
class WPCF_Target_Reached extends WC_Email {

	protected $email_body;

	protected $sent_to_admin;
	protected $sent_to_user;
	protected $email_template;
	/**
	 * Set email defaults
	 *
	 * @since 0.1
	 */
	public function __construct() {

        // Triggers for campaign reached target
		add_action( 'pre_post_update', array( $this, 'trigger' ), 999, 2 ); // Order Complete Action

		// set ID, this simply needs to be a unique name
		$this->id = 'wp_crowdfunding_target_reached_email';

		// this is the title in WooCommerce Email settings
		$this->title = 'WP CrowdFunding Target is Reached';

		// this is the description in WooCommerce email settings
		$this->description = __('Get email notification when a campaign target is reached', 'wp-crowdfunding-pro');

		// these are the default heading and subject lines that can be overridden using the settings
		$this->heading = __('WP Crowdfunding Campaign Target is Reached', 'wp-crowdfunding-pro');
		$this->subject = __('WP Crowdfunding Campaign Target is Reached', 'wp-crowdfunding-pro');

		$this->email_body = $this->get_option('body');

		$this->email_template = 'campaign-target-reached.php';
		// these define the locations of the templates that this email should use, we'll just use the new order template since this email is similar
		$this->template_html  = $this->email_template;
		$this->template_plain = $this->email_template;

		// Call parent constructor to load any other defaults not explicity defined here
		parent::__construct();

		// this sets the recipient to the settings defined below in init_form_fields()
		$this->recipient = $this->get_option( 'recipient' );
		$this->sent_to_admin = $this->get_option( 'is_email_to_admin' );
		$this->sent_to_user = $this->get_option( 'is_email_to_user' );

		// if none was entered, just use the WP admin email as a fallback
		if ( ! $this->recipient ){
			$this->recipient = get_option( 'admin_email' );
		}

	}


	/**
	 * Determine if the email should actually be sent and setup email merge variables
	 *
	 * @since 0.1
	 * @param int $order_id
	 */
	public function trigger( $ID, $post ) {
		if ( ! $this->is_enabled() || ! $this->get_recipient() ) {
			return;
        }
        
		//Don't send if post is not order
		if ( $post['post_type'] !== 'shop_order' ){
			return;
        }

		//Don't send if post is not complete
		if ( $post['post_status'] !== 'wc-completed' ){
			return;
        }

        $order = wc_get_order( $ID );
        $items = $order->get_items();

        foreach ( $items as $item ) {
            $campaign_id = $item->get_product_id();
            $campaign_title  = $item->get_name();
            $author         = get_userdata( $item->get_product()->post->post_author );
            $dislay_name    = $author->display_name;

            $campaignRunning = wpcf_function()->is_campaign_valid( $campaign_id );

            if( !$campaignRunning ) {
                $campaign_link  = site_url( '?post_type=product&p='.$campaign_id );
                $campaign_short_link  =  site_url( '?p='.$campaign_id );
                $shortcode      = array( '[user_name]', '[campaign_title]', '[campaign_link]', '[campaign_short_link]' );
                $replace_str    = array( $dislay_name, $campaign_title, $campaign_link, $campaign_short_link );

                $str            = $this->get_content();
                $email_str      = str_replace( $shortcode, $replace_str, $str );
                $subject        = str_replace( $shortcode, $replace_str, $this->get_subject() );

                if ($this->sent_to_admin) {
                    $this->setup_locale();
                    $this->send( $this->recipient, $subject, $email_str, $this->get_headers(), $this->get_attachments() );
                    $this->restore_locale();
                }

                if ($this->sent_to_user){
                    $backer_email_str      = str_replace($shortcode, $replace_str, $this->get_backer_content_html());
                    $backer_subject        = str_replace($shortcode, $replace_str, $this->get_option('subject_for_campaign_owner'));

                    $this->setup_locale();
                    $this->send( $author->user_email, $backer_subject, $backer_email_str, $this->get_headers(), $this->get_attachments() );
                    $this->restore_locale();
                }
            }
        }
	}

	/**
	 * get_content_html function.
	 *
	 * @since 0.1
	 * @return string
	 */
	public function get_content_html() {
		ob_start();
		$email_heading = $this->get_heading();
		$email_body = $this->email_body;
		wc_get_template( $this->template_html, array(
			'email_heading' => $email_heading,
			'email_body' 	=> $email_body,
			'plain_text'    => false
		) );
		return ob_get_clean();
	}


	public function get_backer_content_html() {
		ob_start();
		$email_heading = $this->get_option('heading_for_campaign_owner');
		$email_body = $this->get_option('body_for_campaign_owner');
		wc_get_template( $this->template_html, array(
			'email_heading' => $email_heading,
			'email_body' 	=> $email_body,
			'plain_text'    => false
		) );
		return ob_get_clean();
	}

	/**
	 * get_content_plain function.
	 *
	 * @since 0.1
	 * @return string
	 */
	public function get_content_plain() {
		ob_start();
		$email_heading = $this->get_heading();
		$email_body = $this->email_body;
		wc_get_template( $this->template_plain, array(
			'email_heading' => $email_heading,
			'email_body' 	=> $email_body,
			'plain_text'    => false
		) );
		return ob_get_clean();
	}


	/**
	 * Initialize Settings Form Fields
	 *
	 * @since 2.0
	 */
	public function init_form_fields() {

		$this->form_fields = array(
			'enabled'    => array(
				'title'   => __('Enable/Disable', 'wp-crowdfunding-pro'),
				'type'    => 'checkbox',
				'label'   => __('Enable this email notification', 'wp-crowdfunding-pro'),
				'default' => 'yes'
			),

			'is_email_to_admin'    => array(
				'title'   => __('Enable/Disable', 'wp-crowdfunding-pro'),
				'type'    => 'checkbox',
				'label'   => __('Send Email to Admin', 'wp-crowdfunding-pro'),
				'default' => 'no'
			),

			'is_email_to_user'    => array(
				'title'   => __('Enable/Disable', 'wp-crowdfunding-pro'),
				'type'    => 'checkbox',
				'label'   => __('Send Email Notification to Campaign Owner', 'wp-crowdfunding-pro'),
				'default' => 'no'
			),

			'recipient'  => array(
				'title'       => __('Recipient(s)', 'wp-crowdfunding-pro'),
				'type'        => 'text',
				'description' => sprintf( __('Enter recipients (comma separated) for this email. Defaults to <code>%s</code>.', 'wp-crowdfunding-pro'), esc_attr( get_option( 'admin_email' ) ) ),
				'placeholder' => '',
				'default'     => ''
			),
			'subject'    => array(
				'title'       => __('Subject', 'wp-crowdfunding-pro'),
				'type'        => 'text',
				'description' => __('This controls the email subject line.', 'wp-crowdfunding-pro'),
				'placeholder' => '',
				'default'     => __('Campaign [campaign_title] Target is Reached', 'wp-crowdfunding-pro')
			),

			'subject_for_campaign_owner'    => array(
				'title'       => __('Subject for Campaign Owner', 'wp-crowdfunding-pro'),
				'type'        => 'text',
				'description' => __('This controls the campaign owner notification email subject line.', 'wp-crowdfunding-pro'),
				'placeholder' => '',
				'default'     => __('Campaign [campaign_title] Target is Reached', 'wp-crowdfunding-pro')
			),
			'heading'    => array(
				'title'       => __('Email Heading', 'wp-crowdfunding-pro'),
				'type'        => 'textarea',
				'description' => __( 'This controls the main heading contained within the email notification.', 'wp-crowdfunding-pro'),
				'placeholder' => '',
				'default'     => __('Campaign [campaign_title] Target is Reached', 'wp-crowdfunding-pro')
			),
			'heading_for_campaign_owner'    => array(
				'title'       => __('Email Heading for Campaign Owner', 'wp-crowdfunding-pro'),
				'type'        => 'textarea',
				'description' => __( 'This controls the main heading contained within the campaign owner email notification.', 'wp-crowdfunding-pro'),
				'placeholder' => '',
				'default'     => __('Campaign [campaign_title] Target is Reached', 'wp-crowdfunding-pro')
			),
			'body'    => array(
				'title'       => __('Email Body', 'wp-crowdfunding-pro'),
				'type'        => 'textarea',
				'description' => __('This controls the main email body contained within the email notification. Leave blank to keep it null, <code> Params: ( [user_name], [campaign_title], [campaign_link], [campaign_short_link] ) </code>', 'wp-crowdfunding-pro'),
				'placeholder' => '',
				'default'     => ''
			),
			'body_for_campaign_owner'    => array(
				'title'       => __('Email Body For Campaign owner', 'wp-crowdfunding-pro'),
				'type'        => 'textarea',
				'description' => __('This controls the main email body contained within the campaign owner email notification. Leave blank to keep it null', 'wp-crowdfunding-pro'),
				'placeholder' => '',
				'default'     => ''
			),


			'email_type' => array(
				'title'         => __( 'Email type', 'woocommerce' ),
				'type'          => 'select',
				'description'   => __( 'Choose which format of email to send.', 'woocommerce' ),
				'default'       => 'html',
				'class'         => 'email_type wc-enhanced-select',
				'options'       => $this->get_email_type_options(),
				'desc_tip'      => true,
			),
		);
	}


} // end \WC_Expedited_Order_Email class
