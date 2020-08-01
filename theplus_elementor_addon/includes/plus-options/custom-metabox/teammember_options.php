<?php
add_action( 'cmb2_admin_init', 'theplus_ele_team_memmber_setting_metaboxes' );
/**
 * Define the metabox and field configurations.
 *
 * @param  array $meta_boxes
 * @return array
 */

function theplus_ele_team_memmber_setting_metaboxes() {

	$prefix = 'theplus_tm_';
	$post_name=theplus_team_member_post_name();
	$tema_mem_field = new_cmb2_box(
		array(
			'id'         => 'team_memmber_setting_metaboxes',
			'title'      => esc_html__('TP Team member options', 'theplus'),
			'object_types'      => array($post_name),
			'context'    => 'normal',
			'priority'   => 'core',
			'show_names' => true, 
		)
	);
	$tema_mem_field->add_field(
		array(
		   'name'	=> esc_html__('Custom Url', 'theplus'),
			   'desc'	=> '',
			   'id'	=> $prefix . 'custom_url',
			   'type'	=> 'text_url',
		)
	);
	$tema_mem_field->add_field(
		array(
		   'name'	=> esc_html__('Designation', 'theplus'),
			   'desc'	=> '',
			   'id'	=> $prefix . 'designation',
			   'type'	=> 'text_medium',
		)
	);
    $tema_mem_field->add_field(
		array(
		    'name'	=> esc_html__('Website Url', 'theplus'),
            'desc'	=> '',
            'id'	=> $prefix . 'website_url',
			'type'	=> 'text',
        )
	);
	$tema_mem_field->add_field(
		array(
		   'name'	=> esc_html__('Website Url', 'theplus'),
			   'desc'	=> '',
			   'id'	=> $prefix . 'website_url',
			   'type'	=> 'text',
		)
	);
	$tema_mem_field->add_field(
		array(
			'name' => esc_html__( 'Facebook Link', 'theplus' ),
			'type' => 'text',
			'id'	=> $prefix . 'face_link',
		)
	);
    $tema_mem_field->add_field(
		array(
			'name'	=> esc_html__('Google plus Link', 'theplus'),
			'desc'	=> '',
			'id'	=> $prefix . 'googgle_link',
			'type'	=> 'text',
		)
	);
	$tema_mem_field->add_field(
		array(
				'name' => esc_html__( 'Instagram Link', 'theplus' ),
				'type' => 'text',
				'id'	=> $prefix . 'insta_link',
		)
	);
	$tema_mem_field->add_field(
		array(
				'name' => esc_html__( 'Twitter Link', 'theplus' ),
				'type' => 'text',
				'id'	=> $prefix . 'twit_link',
		)		
	);
	$tema_mem_field->add_field(
		array(
				'name' => esc_html__( 'Linkedin Link', 'theplus' ),
				'type' => 'text',
				'id'	=> $prefix . 'linked_link',
		)
	);
}
