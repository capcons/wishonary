<?php

if( ! defined( 'WPINC') )
    die;



require_once(plugin_dir_path(__FILE__) . 'inc/class-eub-build-utm-urls.php');

function eub_generate_html(){

    if ( !current_user_can( 'manage_options' ) )  {
        wp_die( __( 'You do not have sufficient permissions to access this page.' ) );
    }

    $custom_posts_names = array();
    $custom_posts_labels = array();

    $args = array(
        'public'    => true,
        '_builtin'  => false
    );

    $output = 'objects';

    $operator = 'and';

    $post_types = get_post_types($args, $output, $operator);

    foreach($post_types as $post_type){

        $custom_posts_names[] = $post_type->name;
        $custom_posts_labels[] = $post_type->labels->singular_name;

    }


?>

    <style>
        .campaign-fields{
            width: 100%;
        }
        .star{
            color: #ff0000;
            float: right;
        }
    </style>
    <div class="wrap">

        <h2 align="center">Easy UTM Builder</h2>

        <h4 align="right"><a href="http://tools.atlasgondal.com/Google-Analytics-UTM-URL-Builder/?utm_source=wp&utm_campaign=developed&utm_medium=plugin&utm_content=easy+utm+builder" target="_blank">Build For Non-WordPress Site</a> </h4>

        <div id="WtiLikePostOptions" class="postbox">

            <div class="inside">

                <form id="infoForm" method="post">

                    <table class="form-table">

                        <tr>

                            <th>Select a Post Type: <span class="star">*</span></th>

                            <td>

                                <label><input type="radio" name="post-type" value="any" required="required" checked /> All Post Types (pages, posts, and custom post types)</label><br/>
                                <label><input type="radio" name="post-type" value="page" required="required" /> Pages</label><br/>
                                <label><input type="radio" name="post-type" value="post" required="required" /> Posts</label><br/>

<?php

                                if(!empty($custom_posts_names) && !empty($custom_posts_labels)){
                                    for( $i = 0; $i < count($custom_posts_names); $i++ ){
                                        echo '<label><input type="radio" name="post-type" value="'. $custom_posts_names[$i] . '" required="required" /> ' . $custom_posts_labels[$i] . ' Posts</label><br>';
                                    }
                                }
?>

                            </td>

                        </tr>

                        <tr>

                            <th>Campaign Source: <span class="star">*</span></th>

                            <td>

                                <input type="text" name="campaign-source" class="campaign-fields" required="required" placeholder="That is sending traffic to your website, for example: google, newsletter4, billboard." title="That is sending traffic to your website, for example: google, newsletter4, billboard." />

                            </td>

                        </tr>

                        <tr>

                            <th>Campaign Medium: <span class="star">*</span></th>

                            <td>

                                <input type="text" name="campaign-medium" class="campaign-fields" required="required" placeholder="The advertising or marketing medium, for example: cpc, banner, email newsletter." title="The advertising or marketing medium, for example: cpc, banner, email newsletter." />

                            </td>

                        </tr>

                        <tr>

                            <th>Campaign Name: <span class="star">*</span></th>

                            <td>

                                <input type="text" name="campaign-name" class="campaign-fields" required="required" placeholder="The individual campaign name, slogan, promo code, etc. for a product." title="The individual campaign name, slogan, promo code, etc. for a product." />

                            </td>

                        </tr>

                        <tr>

                            <th>Campaign Term:</th>

                            <td>

                                <input type="text" name="campaign-term" class="campaign-fields" placeholder="Identify paid search keywords. If you're manually tagging paid keyword campaigns, you should also use utm_term to specify the keyword." title="Identify paid search keywords. If you're manually tagging paid keyword campaigns, you should also use utm_term to specify the keyword." />

                            </td>

                        </tr>

                        <tr>

                            <th>Campaign Content:</th>

                            <td>

                                <input type="text" name="campaign-content" class="campaign-fields" placeholder="Used to differentiate ads or links that point to the same URL, for example: button, image, name." />

                            </td>

                        </tr>

                        <tr>

                            <th>Output: <span class="star">*</span></th>

                            <td>

                                <label><input type="radio" name="output-type" value="here" required="required" checked /> Here</label><br/>
                                <label><input type="radio" name="output-type" value="csv" required="required" /> CSV</label><br/>

                            </td>

                        </tr>

                        <tr>
                            <?php wp_nonce_field('check_eub_referral'); ?>
                            <td></td><td><input type="submit" name="build-utm-urls" class="button button-primary" value="Build UTM URLs"/></td>

                        </tr>

                    </table>


                </form>

            </div>

        </div>

        <h4 align="right">Developed by: <a href="http://atlasgondal.com/?utm_source=wp&utm_medium=plugins&utm_campaign=developed&utm_content=easy+utm+builder" target="_blank">Atlas Gondal</a></h4>

    </div>



<?php

    if (isset($_POST['build-utm-urls'])) {

        check_admin_referer('check_eub_referral');

        $eub_build_utm_urls = new eub_build_utm_urls();

        $post_type              = (!empty($_POST['post-type']) ? sanitize_text_field( stripslashes($_POST['post-type'])) : 'any');
        $output_type            = (!empty($_POST['output-type']) ? sanitize_text_field( stripslashes($_POST['output-type'])) : 'here' );

        if ( $post_type ) {

            $campaign_source    = sanitize_text_field( stripslashes($_POST['campaign-source']));
            $campaign_medium    = sanitize_text_field( stripslashes($_POST['campaign-medium']));
            $campaign_name      = sanitize_text_field( stripslashes($_POST['campaign-name']));
            $campaign_term      = sanitize_text_field( stripslashes($_POST['campaign-term']));
            $campaign_content   = sanitize_text_field( stripslashes($_POST['campaign-content']));

            if( empty($post_type) || empty($campaign_source) || empty($campaign_medium) || empty($campaign_name) ){
                die('<h2 style="color: red;">Sorry, you have skipped mandatory field, please re-check and try again!</h2>');
            }

            $utm_data = '?utm_source='.$campaign_source.'&utm_medium='.$campaign_medium.'&utm_campaign='.$campaign_name;
            $utm_data .= ((!empty($campaign_content)) ? "&utm_content=$campaign_content" : "");
            $utm_data .= ((!empty($campaign_term)) ? "&utm_term=$campaign_term" : "");

            $utm_data = $eub_build_utm_urls->trim_all(strtolower($utm_data));

            if( !isset($post_type_data) ){
                $post_type_data = new stdClass();
            }
            $post_type_data->post_type = $post_type;
            $post_type_data->post_type_names = $custom_posts_names;

            $selected_post_type = $eub_build_utm_urls->get_selected_post_type($post_type_data);

            if (!isset($generate_output_data) ){
                $generate_output_data = new stdClass();
            }

            $generate_output_data->post_type    = $selected_post_type;
            $generate_output_data->output_type  = $output_type;
            $generate_output_data->data         = $utm_data;

            $eub_build_utm_urls->generate_output($generate_output_data);

        }

    }

}

eub_generate_html();

