<?php

global $pressapps_video_data,$post;
global $pavi_settings;
if(count($pressapps_video_data['videos'])==0){
    _e('No Video Found','pressapps-video');
    return ;
}
?>
<div id="pavi-container" class="uk-margin-large-bottom">
    <div data-uk-grid>

        <?php 
        if (isset($pressapps_video_data['featured']) && $pressapps_video_data['featured'] != 'false') {

        $autoplay = isset($pavi_settings['autoplay']) ? '="autoplay: false"' : '="autoplay: false"';
        $args = array( 'post_type' => 'video', 'p' => $pressapps_video_data['featured'] );
        $theme_post_query = new WP_Query( $args );    

        while( $theme_post_query->have_posts() ) : $theme_post_query->the_post();
            $pa_video_youtube = get_post_meta( get_the_ID(), 'pa_video_youtube', true );
            $pa_video_vimeo = get_post_meta( get_the_ID(), 'pa_video_vimeo', true );
            $pa_video_url = get_post_meta( get_the_ID(), 'pa_video_url', true );
            ?>
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
            <div class="pavi-video-content uk-width-1-<?php echo $pavi_settings['content-layout'] ? $pavi_settings['content-layout'] : '1'; ?>@m">
                <h2><?php the_title(); ?></h2>
                <div><?php the_content(); ?></div>
            </div> <!-- end .entry-content -->
        <?php     
        endwhile;     
        wp_reset_postdata();    
        }
        ?>
    </div> 
</div>          

<?php if(isset($pressapps_video_data['terms'])){ ?>
    <div data-uk-filter="target: .pavi-filter">
        <?php if ($pavi_settings['filter-nav'] == 'display') { ?>
            <ul class="uk-subnav uk-subnav-pill uk-margin-medium-bottom">
                <li class="uk-active" data-uk-filter-control><a href="#"><?php _e( 'All', 'pressapps-video' ); ?></a></li>
                <?php
                foreach($pressapps_video_data['terms'] as $terms){
                ?>
                <li data-uk-filter-control=".<?php echo $terms->slug; ?>"><a href="#"><?php echo $terms->name; ?></a></li>
                <?php
                }
                ?>
            </ul>
        <?php } ?>
<?php } else { ?>
    <div>
<?php } ?>
        <ul class="pavi-filter <?php echo $pavi_settings['sortable-columns'] == '1' ? 'uk-child-width-1-1' : 'uk-child-width-1-2@s uk-child-width-1-' . $pavi_settings['sortable-columns'] . '@m'; ?> uk-grid-match" data-uk-grid>
            <?php if(count($pressapps_video_data['videos'])>0){  
                foreach($pressapps_video_data['videos'] as $post){
                    setup_postdata($post);
                    $imagesize  = 'image_735x413';
                    $image      = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), $imagesize ); 
                    $classes    = array();

                    if(isset($pressapps_video_data['terms'])){
                        foreach($pressapps_video_data['objrelation'][$post->ID] as $val ){
                            $term       = $pressapps_video_data['terms'][$val];
                            $classes[]  = $term->slug;
                        }
                    }

                    $autoplay = isset($pavi_settings['autoplay']) ? '="video-autoplay: true"' : '';
                    $pa_video_youtube = get_post_meta( get_the_ID(), 'pa_video_youtube', true );
                    $pa_video_vimeo = get_post_meta( get_the_ID(), 'pa_video_vimeo', true );
                    $pa_video_url = get_post_meta( get_the_ID(), 'pa_video_url', true );

                    if ($pa_video_youtube) {
                        $lightbox_video = 'https://www.youtube.com/watch?v=' . $pa_video_youtube;
                    } elseif ($pa_video_vimeo) {
                        $lightbox_video = 'https://vimeo.com/' . $pa_video_vimeo;
                    } elseif ($pa_video_url) {
                        $lightbox_video = $pa_video_url;
                    }

                    if ($pavi_settings['sortable-columns'] == '1') {
                        include( plugin_dir_path( __FILE__ ) . 'partials/card-media-left.php');
                    } else {
                        include( plugin_dir_path( __FILE__ ) . 'partials/card-media-top.php');
                    }
                    
                    ?>
                <?php
                } 
            } ?> 
        </ul>
    </div>