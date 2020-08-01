<?php

function pavi_help_tab(){
    
    $screen = get_current_screen();
    
    if(in_array($screen->id,array('edit-video_category','video','edit-video', 'pavi-options'))){
    
        $screen->add_help_tab( array(
            'id'	=> 'pressapps_video_shortcode',
            'title'	=> __( 'Video Shortcode', 'pressapps-video' ),
            'content'	=>
            
                '<p>' . __('<h2>Video Shortcode</h2>','pressapps-video') . '</p>' .
            
                '<p>' . __( 'You can use <code>[pa_video]</code> shortcode to include the Videos on any page, post or custom post type.', 'pressapps-video' ) . '</p>' .

                '<p>' . __( 'The shortcode accepts four optional attributes:', 'pressapps-video' ) . '</p>' . 
                '<p>' . __( '(1) <b>category</b> = <i>-1</i> <b>|</b> <i>{any video category id}</i>', 'pressapps-video' ) . '</p>' . 
                '<p>' . __( '(2) <b>featured</b> = <i>75</i> <b>|</b> <i>{any video post id}</i>', 'pressapps-video' ) . '</p>' . 
                '<p>' . __( '(4) <b>lightbox</b> = <i>true</i>', 'pressapps-video' ) . '</p>' . 
                '<p>' . __( '<b>Examples</b>', 'pressapps-video' ) . '</p>' . 
                '<p>' . __( '1. <code>[pa_video]</code>', 'pressapps-video' ) . '</p>' .
                '<p>' . sprintf(__( '2. <code>[pa_video category={category_id}]</code> {category_id} you will find it <a href="%s">here</a> under shortcode column', 'pressapps-video' ),admin_url('edit-tags.php?taxonomy=video_category&post_type=video') ). '</p>' .
                '<p>' . __( '3. <code>[pa_video category={category_id} featured={video_post_id} lightbox="true"]</code>', 'pressapps-video' ) . '</p>' 
                

        ));
    }
}

add_action( 'admin_print_styles' ,'pavi_help_tab');