<?php
add_action( 'cmb2_admin_init', 'theplus_ele_testimonial_setting_metaboxes' );


function theplus_ele_testimonial_setting_metaboxes() {

	$prefix = 'theplus_testimonial_';
	$post_name=theplus_testimonial_post_name();
	$testimonial_field = new_cmb2_box(
		array(
			'id'         => 'testimonial_setting_metaboxes',
			'title'      => esc_html__('ThePlus Testimonial Options', 'theplus'),
			'object_types'      => array($post_name),
			'context'    => 'normal',
			'priority'   => 'high',
			'show_names' => true,
		)
	);
	$testimonial_field->add_field(
		array(
		   'name'	=> esc_html__('Author Text', 'theplus'),
			   'desc'	=> '',
			   'id'	=> $prefix . 'author_text',
			   'type'	=> 'wysiwyg',
			   'options' => array(
					'wpautop' => false,
					'media_buttons' => false,
					'textarea_rows' => get_option('default_post_edit_rows', 7),
				),
		)
	);
	$testimonial_field->add_field(
		array(
		   'name'	=> esc_html__('Title', 'theplus'),
			   'desc'	=>  esc_html__('Enter title of testimonial.', 'theplus'),
			   'id'	=> $prefix . 'title',
			   'type'	=> 'text',
		)
	);
	$testimonial_field->add_field(
		array(
		   'name'	=> esc_html__('Logo Upload', 'theplus'),
			   'desc'	=> '',
			   'id'	=> $prefix . 'logo',
			   'type'	=> 'file',
		)
	);
	$testimonial_field->add_field(
		array(
		   'name'	=> esc_html__('Designation', 'theplus'),
			   'desc'	=>  esc_html__('Enter author Designation', 'theplus'),
			   'id'	=> $prefix . 'designation',
			   'type'	=> 'text',
		)
	);
	
}
