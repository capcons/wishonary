<?php
/**
 * @package name
 */

/**
 * 
 * Add the Additional column Values for the video_category Taxonomy
 * 
 * @param string $out
 * @param string $column
 * @param int $term_id
 * @return string
 */
function pavi_manage_video_category_custom_column($out,$column,$term_id){
    switch($column){
        case 'shortcode':
            $temp = '[pa_video category=' . $term_id . ']';
            return $temp;
            break;
    }
}

add_action( 'manage_video_category_custom_column' , 'pavi_manage_video_category_custom_column',10,3); 

/**
 * 
 * Add the Additional column Values for the video Post Type
 * 
 * @global type $post
 * @param string $column
 */

function pavi_manage_video_custom_column($column){
    global $post;
    switch($column){
        case 'category':
            $terms = wp_get_object_terms($post->ID  ,'video_category');
            foreach($terms as $term){
                $temp  = " <a href=\"" . admin_url('edit-tags.php?action=edit&taxonomy=video_category&tag_ID=' . $term->term_id . '&post_type=video') . "\" ";
                $temp .= " class=\"row-title\">{$term->name}</a><br/>";
                echo $temp;
            }
            break;
    }
}

add_action( 'manage_video_posts_custom_column' , 'pavi_manage_video_custom_column'); 

/**
 * Category Based Filtering options
 * 
 * @global string $typenow
 */

function pavi_video_restrict_manage_posts(){
    global $typenow;
    
    if($typenow=='video'){
        ?>
        <select name="video_category">
            <option value="0"><?php _e('Selecte Category','pressapps-video'); ?></option>
        <?php
        $categories = get_terms('video_category');
        if(count($categories)>0){
            foreach($categories as $cat){
                if($_GET['video_category']==$cat->slug){
                    echo "<option value={$cat->slug} selected=\"selected\">{$cat->name}</option>";
                }else{
                    echo "<option value={$cat->slug} >{$cat->name}</option>";
                }
            }
        }
        ?>
        </select>
        <?php
    }
    
}

add_action('restrict_manage_posts','pavi_video_restrict_manage_posts');


/**
 * Shortcode field for the Edit Taxonomy Page
 * 
 * @param string $taxonomy
 */

function pavi_video_category_edit_form_fields($taxonomy){
    $tag_id = $_GET['tag_ID'];
    ?>
    <tr>
        <th scope="row" valign="top"><label for="shortcode"><?php _e('Shortcode','pressapps-video');?></label></th>
        <td>[video category=<?php echo $tag_id; ?>]</td>
    </tr>
    <?php
}

add_action('video_category_edit_form_fields','pavi_video_category_edit_form_fields');

