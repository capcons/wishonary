<?php

function pavi_get_display_video($args = array()){
    global $pressapps_video_data,$wpdb,$pavi_settings;

    $default = array(
        'category'      => -1,
        'featured'      => 'false',
        'template'      => 'filter',
        'lightbox'      => false,
    );

    $args = shortcode_atts($default,$args);
    
    $qry_args = array(
        'post_type'     => 'video',
        'numberposts'   => -1,
    );
    
    if(isset($args['category']) && $args['category']!=-1){
        $qry_args['tax_query']   = array(array(
                'taxonomy'  => 'video_category',
                'field'     => 'id',
                'terms'     => $args['category'],
            ),
        );
        $pressapps_terms       = get_terms('video_category',array(
            'child_of'  => $args['category']
        ));
    }else{
        $pressapps_terms = get_terms('video_category');
    }
    
    if(count($pressapps_terms)>0){
        
        foreach($pressapps_terms as $term){
            $terms[$term->term_id] = $term;
        }
        /**
         * Fetch all the post id based on the category ids available to us
         */
        $qry  = " SELECT A.object_id,C.term_id ";
        $qry .= " FROM {$wpdb->term_relationships} A ,{$wpdb->posts} B , {$wpdb->term_taxonomy} C ";
        $qry .= " WHERE A.object_id = B.ID AND B.post_status = 'publish' ";
        $qry .= " AND C.term_taxonomy_id = A.term_taxonomy_id ";
        $qry .= " AND C.term_id IN (" . implode(",",  array_keys($terms)) . ") ";
        
        $result = $wpdb->get_results($qry,ARRAY_A);
        
        for($i=0;$i<count($result);$i++){
            $objrelationship[$result[$i]['object_id']][]    = $result[$i]['term_id'];
        }
        /**
         * Fetch All the videos 
         */
        $videos = get_posts(array_merge($qry_args,array(
            'include'   => array_keys($objrelationship),
        )));
        
        $pressapps_video_data = array(
            'objrelation'   => $objrelationship,
            'dispaly_terms' => TRUE,
            'terms'         => $terms,
            'videos'        => $videos,
            'template'      => $args[ 'template' ],
            'featured'      => $args['featured'],
            'lightbox'      => $args[ 'lightbox' ],
        );
    }else{
        
        $pressapps_videos = get_posts($qry_args);
        
        $pressapps_video_data = array(
            'dispaly_terms' => FALSE,
            'videos'        => $pressapps_videos,
            'template'      => $args[ 'template' ],
            'featured'      => $args['featured'],
            'lightbox'      => $args[ 'lightbox' ],
        );
    }
    
    /**
     * Select the Proper Template file to be Render the video Structure
     * 
     */
        
    $default_filename           = PAVI_PLUGIN_TEMPLATES_DIR . "/video-filter.php";  
    $theme_default_filename     = get_stylesheet_directory() . "/video-filter.php";
    
    $default_template_filename  = PAVI_PLUGIN_TEMPLATES_DIR . "/video-{$args['template']}.php";
    $theme_template_filename    = get_stylesheet_directory() . "/video-{$args['template']}.php";
    
    if(@file_exists($theme_template_filename)){
        $filename = $theme_template_filename;
    }elseif(@file_exists($default_template_filename)){
        $filename = $default_template_filename;
    }elseif(@file_exists($theme_default_filename)){
        $filename = $theme_default_filename;
    }else{
        $filename = $default_filename;
    }

    ob_start();
    include_once $filename;

    wp_enqueue_style('pavi-video');
    wp_enqueue_script('pavi-video');
    
    wp_reset_query();
    return ob_get_clean();
    
}

/**
 * 
 * Disply the video HTML generated based on the template file of video.
 * 
 * @param array $args
 */
function pavi_the_display_video($args   = array()){
    echo pavi_get_display_video($args);
}

/**
 * Add the Shortcode for the video part with the following options 
 * 
 * @param array $atts
 * @return string
 */
function pavi_shortcode_video($atts = array()){
        
    return pavi_get_display_video($atts);
}


add_shortcode('pa_video', 'pavi_shortcode_video');


/*****ADD VIDEO TEXTAREA META BOX ON VIDEO POST PAGE*******/
add_action( 'load-post.php', 'pavi_post_meta_boxes_setup' );
add_action( 'load-post-new.php', 'pavi_post_meta_boxes_setup' );

function pavi_post_meta_boxes_setup() {

    /* Add meta boxes on the 'add_meta_boxes' hook. */
    add_action( 'add_meta_boxes', 'pavi_textarea_meta_boxes' );

    /* Save post meta on the 'save_post' hook. */
    add_action( 'save_post', 'pavi_save_post_class_meta', 10, 2 );
}

function pavi_textarea_meta_boxes() {

    add_meta_box(
        'video-metabox',                       // Unique ID
        esc_html__( 'Video', 'pressapps-video' ),       // Title
        'pavi_textarea_meta_box',              // Callback function
        'video',                                // Admin page (or post type)
        'normal',                               // Context
        'default'                               // Priority
    );
}

function pavi_textarea_meta_box( $object, $box ) {

    wp_nonce_field( basename( __FILE__ ), 'pavi_textarea_nonce' );?>

    <table class="form-table" role="presentation">
        <tbody>
        <tr>
            <th scope="row"><label for="video-youtube">YouTube</label></th>
            <td><input class="regular-text" type="text" name="video-youtube" id="video-youtube" value="<?php echo esc_attr( get_post_meta( $object->ID, 'pa_video_youtube', true ) ); ?>"></input>
            <p class="description" id="video-youtube">Enter YouTube video ID only e.g. <code>pYzILzTu35A</code></p>    
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="video-vimeo">Vimeo</label></th>
            <td><input class="regular-text" type="text" name="video-vimeo" id="video-vimeo" value="<?php echo esc_attr( get_post_meta( $object->ID, 'pa_video_vimeo', true ) ); ?>"></input>
            <p class="description" id="video-vimeo">Enter Vimeo video ID only e.g. <code>93745373</code></p>    
            </td>
        </tr>
        <tr>
            <th scope="row"><label for="video-url">URL</label></th>
            <td><input class="regular-text" type="url" name="video-url" id="video-url" value="<?php echo esc_attr( get_post_meta( $object->ID, 'pa_video_url', true ) ); ?>"></input>
            <p class="description" id="video-url">Enter full URL to the video e.g. <code>https://somesite.com/video.mp4</code></p>    
            </td>
        </tr>
        </tbody>
    </table>        
    <?php
}

function pavi_save_post_class_meta( $post_id, $post ) {

    /* Verify the nonce before proceeding. */
    if ( !isset( $_POST['pavi_textarea_nonce'] ) || !wp_verify_nonce( $_POST['pavi_textarea_nonce'], basename( __FILE__ ) ) )
        return $post_id;

    /* Get the post type object. */
    $post_type = get_post_type_object( $post->post_type );

    /* Check if the current user has permission to edit the post. */
    if ( ! current_user_can( 'edit_post', $post_id ) ) { 
		return $post_id;
	}

    /* Get the posted data and sanitize it for use as an HTML class. */
    $new_meta_value_youtube =   ( isset( $_POST['video-youtube'] ) ? $_POST['video-youtube']: '' );
    $new_meta_value_vimeo =     ( isset( $_POST['video-vimeo'] ) ? $_POST['video-vimeo']: '' );
    $new_meta_value_url =       ( isset( $_POST['video-url'] ) ? $_POST['video-url']: '' );

    /* Get the meta keys. */
    $meta_key_youtube = 'pa_video_youtube';
    $meta_key_vimeo =   'pa_video_vimeo';
    $meta_key_url =     'pa_video_url';

    /* Get the meta value of the custom field key. */
    $meta_value_youtube =   get_post_meta( $post_id, $meta_key_youtube, true );
    $meta_value_vimeo =     get_post_meta( $post_id, $meta_key_vimeo, true );
    $meta_value_url =       get_post_meta( $post_id, $meta_key_url, true );

    /* If a new meta value was added and there was no previous value, add it. */
    if ( $new_meta_value_youtube && '' == $meta_value_youtube )
        add_post_meta( $post_id, $meta_key_youtube, $new_meta_value_youtube, true );

    /* If the new meta value does not match the old value, update it. */
    elseif ( $new_meta_value_youtube && $new_meta_value_youtube != $meta_value_youtube )
        update_post_meta( $post_id, $meta_key_youtube, $new_meta_value_youtube );

    /* If there is no new meta value but an old value exists, delete it. */
    elseif ( '' == $new_meta_value_youtube && $meta_value_youtube )
        delete_post_meta( $post_id, $meta_key_youtube, $meta_value_youtube );


    if ( $new_meta_value_vimeo && '' == $meta_value_vimeo )
        add_post_meta( $post_id, $meta_key_vimeo, $new_meta_value_vimeo, true );

    elseif ( $new_meta_value_vimeo && $new_meta_value_vimeo != $meta_value_vimeo )
        update_post_meta( $post_id, $meta_key_vimeo, $new_meta_value_vimeo );

    elseif ( '' == $new_meta_value_vimeo && $meta_value_vimeo )
        delete_post_meta( $post_id, $meta_key_vimeo, $meta_value_vimeo );


    if ( $new_meta_value_url && '' == $meta_value_url )
        add_post_meta( $post_id, $meta_key_url, $new_meta_value_url, true );

    elseif ( $new_meta_value_url && $new_meta_value_url != $meta_value_url )
        update_post_meta( $post_id, $meta_key_url, $new_meta_value_url );

    elseif ( '' == $new_meta_value_url && $meta_value_url )
        delete_post_meta( $post_id, $meta_key_url, $meta_value_url );

}


/* Register Scripts. */
add_action( 'wp_enqueue_scripts', 'theme_register_scripts', 1 );
function theme_register_scripts() {

  /** Register JavaScript Functions File */
  wp_register_script('pavi_load_post', PAVI_PLUGIN_ASSETS_URL . '/js/load-post.js', array('jquery') );

  /** Localize Scripts */
  wp_localize_script( 'pavi_load_post', 'php_array', array( 'admin_ajax' => admin_url( 'admin-ajax.php' ) ) );
}

/* Enqueue Scripts. */
add_action( 'wp_enqueue_scripts', 'theme_enqueue_scripts' );
function theme_enqueue_scripts() {

  /* Enqueue JavaScript Functions File */
  wp_enqueue_script( 'pavi_load_post' );

}

/* Ajax Post */
add_action( 'wp_ajax_video_load', 'video_load_init' );
add_action( 'wp_ajax_nopriv_video_load', 'video_load_init' );

function video_load_init() {

    global $pavi_settings;

    // The WP_Query
    $args = array(
        'post_type' => 'video',
        'p' => $_POST[ 'id' ],
    );
    $query = new WP_Query( $args );    
    while( $query->have_posts() ) {
        $query->the_post();
        $pa_video_youtube = get_post_meta( get_the_ID(), 'pa_video_youtube', true );
        $pa_video_vimeo = get_post_meta( get_the_ID(), 'pa_video_vimeo', true );
        $pa_video_url = get_post_meta( get_the_ID(), 'pa_video_url', true ); 
        $autoplay = isset($pavi_settings['autoplay']) ? '="autoplay: true"' : '="autoplay: false"';
        ?>
        <div data-uk-grid>
            <div class="uk-width-expand">
                <?php
                if ($pa_video_youtube) {
                    ?>
                        <iframe src="https://www.youtube-nocookie.com/embed/<?php echo $pa_video_youtube; ?>?autoplay=0&amp;showinfo=0&amp;rel=0&amp;modestbranding=1&amp;playsinline=1" width="1920" height="1080" allowfullscreen data-uk-responsive data-uk-video<?php echo $autoplay; ?>></iframe>
                    <?php
                } elseif ($pa_video_vimeo) {
                    ?>
                        <iframe src="https://player.vimeo.com/video/<?php echo $pa_video_vimeo; ?>?title=0&byline=0&portrait=0" width="1920" height="1080" allow="autoplay; fullscreen" allowfullscreen data-uk-responsive data-uk-video<?php echo $autoplay; ?>></iframe>
                    <?php
                } elseif ($pa_video_url) {
                    ?>
                        <video src="<?php echo $pa_video_url; ?>" controls playsinline data-uk-responsive data-uk-video<?php echo $autoplay; ?>></video>
                    <?php
                }
                ?>
            </div>
            <div class="pavi-video-, falsecontent uk-width-1-<?php echo $pavi_settings['content-layout'] ? $pavi_settings['content-layout'] : '1'; ?>@m">
                <h2><?php the_title(); ?></h2>
                <div><?php the_content(); ?></div>
            </div> <!-- end .entry-content -->
        </div>
        <?php     
    }
    exit;
}

function print_custom_css() {

    global $pavi_settings;

    echo '<style id="video-custom-css">' . "\n" . sanitize_text_field( $pavi_settings['custom-css'] ) . "\n</style>\n";
}

