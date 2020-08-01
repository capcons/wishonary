<?php

/**
 * Add the Additional Columns For the video_category Taxonomy
 * 
 * @param array $columns
 * @return array
 */       
function pavi_manage_edit_video_category_columns($columns){
    
    $new_columns['cb']          = $columns['cb'];
    $new_columns['name']        = $columns['name'];
    $new_columns['shortcode']   = __("Shortcode",'pressapps-video');
    $new_columns['slug']        = $columns['slug'];
    $new_columns['posts']       = $columns['posts'];
    
    return $new_columns;
}

add_filter('manage_edit-video_category_columns','pavi_manage_edit_video_category_columns');


/**
 * 
 * Rename the Columns for the video post type and adding new Columns
 * 
 * @param array $columns
 * @return array
 */

function pavi_manage_edit_video_columns($columns){
    
    $new_columns['cb']          = $columns['cb'];
    $new_columns['title']       = __('Title','pressapps-video');
    $new_columns['category']    = __('Category','pressapps-video');
    $new_columns['date']        = $columns['date'];

    return $new_columns;
}

add_filter('manage_edit-video_columns','pavi_manage_edit_video_columns');