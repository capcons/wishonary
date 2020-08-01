<?php

if( ! defined( 'WPINC') )
    die;


class eub_build_utm_urls{

    public function get_selected_post_type($post_type_data){

        $post_type = $post_type_data->post_type;
        $custom_posts_names = $post_type_data->post_type_names;

        switch ($post_type){

            case "any":

                $type = "any";
                break;

            case "page":

                $type = "page";
                break;

            case "post":

                $type = "post";
                break;

            default:

                for( $i = 0; $i < count($custom_posts_names); $i++ ){

                    if ($post_type == $custom_posts_names[$i] ){

                        $type = $custom_posts_names[$i];

                    }

                }

        }

        return $type;


    }

    public function trim_all( $str , $what = NULL , $with = '+' )
    {
        if( $what === NULL )
        {
            $what   = "\\x00-\\x20";
        }

        return trim( preg_replace( "/[".$what."]+/" , $with , $str ) , $what );
    }


    public function generate_output($generate_output_data){

        $selected_post_type = $generate_output_data->post_type;
        $output_type = $generate_output_data->output_type;
        $utm_data = $generate_output_data->data;
        
        $counter = 0;
        $html = array();

        if ($output_type == "here") {
            $line_break = "<br/>";
        }
        else {
            $line_break = "\n";
        }



        $posts_query = new WP_Query( array(
            'post_type' => $selected_post_type,
            'posts_per_page' => '-1',
            'post_status' => 'publish',
            'orderby' => 'title',
            'order'   => 'ASC'
        ) );

        if( $posts_query->have_posts() ):
            while ( $posts_query->have_posts() ):

                $posts_query->the_post();
                $html['type'][$counter] = get_post_type( get_the_ID() );
                $html['title'][$counter] = get_the_title( get_the_ID() );
                $html['url'][$counter] = get_permalink().$utm_data.$line_break;
                $counter++;

            endwhile;
        endif;

        $this->export__selected_urls($html, $output_type, $counter);

        wp_reset_postdata();
    }

    protected function export__selected_urls($urls, $output_type, $counter){

        $upload_dir = $_SERVER['DOCUMENT_ROOT']."/wp-content/uploads/";
        $file_path = wp_upload_dir();
        $file_path = $file_path['baseurl'];

        if($counter == 0){
            echo '<div class="notice notice-warning is-dismissible">
                  <p>I was unable to find any URL in your selected options. Please change your selection and try again!</p>
              </div>';
            exit();
        }
        if($counter > 5000){
            echo '<div class="notice notice-warning is-dismissible">
                  <p>You have more than 5000 URLs and if you face <strong>Low Memory</strong> or <strong>Timeout Errors</strong>. Please contact your Server Administrator!</p>
              </div>';
        }

        switch ($output_type){

            case "csv":

                $file_name = 'UTM_URLs.CSV';
                $headers = array();
                $data = array();

                $file = $upload_dir.$file_name;
                $myfile = fopen($file, "w") or die("Unable to create a file on your server, Please Contact Server Administrator OR Use other Output Type!");
                fprintf( $myfile, "\xEF\xBB\xBF");

                $headers[] = 'Page/Post Title';
                $headers[] = 'Post Type';
                $headers[] = 'URLs';

                fputcsv($myfile, $headers);

                for( $i = 0; $i < $counter; $i++ ){
                    $data = array(
                        $urls['title'][$i],
                        $urls['type'][$i],
                        $urls['url'][$i]
                    );

                    fputcsv($myfile, $data);
                }


                fclose($myfile);

                echo "<div class='updated'>UTM URLs Exported Successfully! <a href='".$file_path."/".$file_name."' target='_blank'><strong>Click here</strong></a> to Download.</div>";

                break;

            case "here":

                echo "<h1><strong>Selected URLs with UTM Parameters:</strong></h1>";

                foreach($urls['url'] as $url){
                    echo $url;
                }

                break;

            default:

                echo "Sorry, you've missed post type field, Please Select <strong>Post Type</strong> and try again! :)";
                break;


        }



    }

}

