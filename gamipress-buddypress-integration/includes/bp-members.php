<?php
/**
 * BuddyPress Membership
 *
 * @package GamiPress\BuddyPress\BuddyPress_Members
 * @since 1.0.1
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

/**
 * Loads GamiPress_BP_Component Class from bp_init
 *
 * @since 1.0.1
 */
function gamipress_bp_load_components() {

    if ( function_exists( 'buddypress' ) && buddypress() && ! buddypress()->maintenance_mode && gamipress_bp_is_active( 'xprofile' ) ) {

        // Load the component if site pass all checks
        $GLOBALS['gamipress_points_bp_component'] = new GamiPress_Points_BP_Component();
        $GLOBALS['gamipress_achievements_bp_component'] = new GamiPress_Achievements_BP_Component();
        $GLOBALS['gamipress_ranks_bp_component'] = new GamiPress_Ranks_BP_Component();

    }

}
add_action( 'bp_init', 'gamipress_bp_load_components', 1 );

/**
 * Creates a BuddyPress member page for points
 *
 * @since 1.0.8
 */
function gamipress_bp_member_points() {

    add_action( 'bp_template_content', 'gamipress_bp_member_points_content' );

    bp_core_load_template( apply_filters( 'gamipress_bp_member_points', 'members/single/plugins' ) );

}

/**
 * Displays a member points
 *
 * @since 1.0.8
 */
function gamipress_bp_member_points_content() {

    $points_types_to_show = gamipress_bp_members_get_points_types();

    if ( empty( $points_types_to_show ) ) {
        return;
    }

    echo gamipress_points_shortcode( array(
        'type'          => implode( ',', $points_types_to_show ),
        'current_user'  => 'no',
        'user_id'       => bp_displayed_user_id(),
        'wpms'          => (bool) gamipress_get_option( 'ms_show_all_achievements', false ) ? 'yes' : 'no',
    ) );

}

/**
 * Creates a BuddyPress member page for achievements
 *
 * @since 1.0.1
 */
function gamipress_bp_member_achievements() {

    add_action( 'bp_template_content', 'gamipress_bp_member_achievements_content' );

    bp_core_load_template( apply_filters( 'gamipress_bp_member_achievements', 'members/single/plugins' ) );

}

/**
 * Displays a member achievements
 *
 * @since 1.0.1
 */
function gamipress_bp_member_achievements_content() {

    $achievements_types_to_show = gamipress_bp_members_get_achievements_types();

    // Bail if not types provided
    if ( empty( $achievements_types_to_show ) ) return;

    $achievements_tab_title = gamipress_bp_get_option( 'achievements_tab_title', __( 'Achievements', 'gamipress-buddypress-integration' ) );
    $achievements_tab_slug = gamipress_bp_get_option( 'achievements_tab_slug', '' );

    // If empty slug generate it from the title
    if( empty( $achievements_tab_slug ) )
        $achievements_tab_slug = sanitize_title( $achievements_tab_title );

    $type = '';
    $current_uri = $_SERVER['REQUEST_URI'];

    foreach ( $achievements_types_to_show as $achievement_type ) {

        // Check if current URI matches any type (need to check the achievements tab slug + achievement type
        if ( strpos( $current_uri, $achievements_tab_slug . '/' . $achievement_type ) ) {
            $type = $achievement_type;
            // Exit on find achievement type
            break;
        }
    }

    if ( empty( $type ) ) {

        if( isset( $achievements_types_to_show[0] ) ) {
            $type = $achievements_types_to_show[0];
        } else {
            return;
        }
    }

    $prefix = 'members_achievements_';

    // Setup achievement atts
    $achievement_atts = array();

    // Loop achievement shortcode fields to pass to the shortcode call
    foreach( GamiPress()->shortcodes['gamipress_achievement']->fields as $field_id => $field_args ) {

        if( $field_id === 'id' ) {
            continue;
        }

        if( $field_args['type'] === 'checkbox' ) {
            $achievement_atts[$field_id] = ( (bool) gamipress_bp_get_option( $prefix . $field_id, false ) ? 'yes' : 'no' );
        } else {
            $achievement_atts[$field_id] = gamipress_bp_get_option( $prefix . $field_id, ( isset( $field_args['default'] ) ? $field_args['default'] : '' ) );
        }

    }

    echo gamipress_achievements_shortcode( array_merge( array(
        'type'          => $type,
        'columns'       => gamipress_bp_get_option( $prefix . 'columns', '1' ),
        'filter'        => 'no',
        'filter_value'  => 'completed',
        'search'        => 'no',
        'current_user'  => 'no',
        'user_id'       => bp_displayed_user_id(),
        'wpms'          => (bool) gamipress_get_option( 'ms_show_all_achievements', false ) ? 'yes' : 'no',
        'limit'         => gamipress_bp_get_option( $prefix . 'limit', '10' ),
        'orderby'     	=> gamipress_bp_get_option( $prefix . 'orderby', 'menu_order' ),
        'order'       	=> gamipress_bp_get_option( $prefix . 'order', 'ASC' ),
        'include'     	=> '',
        'exclude'     	=> '',
    ), $achievement_atts ) );

}

/**
 * Creates a BuddyPress member page for achievements
 *
 * @since 1.1.1
 */
function gamipress_bp_member_ranks() {

    add_action( 'bp_template_content', 'gamipress_bp_member_ranks_content' );

    bp_core_load_template( apply_filters( 'gamipress_bp_member_ranks', 'members/single/plugins' ) );

}

/**
 * Displays a member ranks
 *
 * @since 1.1.1
 */
function gamipress_bp_member_ranks_content() {

    $ranks_types_to_show = gamipress_bp_members_get_ranks_types();

    if ( empty( $ranks_types_to_show ) ) return;

    $prefix = 'members_ranks_';

    // Setup rank atts
    $rank_atts = array();

    // Loop rank shortcode fields to pass to the shortcode call
    foreach( GamiPress()->shortcodes['gamipress_rank']->fields as $field_id => $field_args ) {

        if( $field_id === 'id' ) {
            continue;
        }

        if( $field_args['type'] === 'checkbox' ) {
            $rank_atts[$field_id] = ( (bool) gamipress_bp_get_option( $prefix . $field_id, false ) ? 'yes' : 'no' );
        } else {
            $rank_atts[$field_id] = gamipress_bp_get_option( $prefix . $field_id, ( isset( $field_args['default'] ) ? $field_args['default'] : '' ) );
        }

    }

    echo gamipress_ranks_shortcode( array_merge( array(
        'type'          => implode( ',', $ranks_types_to_show ),
        'columns'       => gamipress_bp_get_option( $prefix . 'columns', '1' ),
        'current_user'  => 'no',
        'user_id'       => bp_displayed_user_id(),
        'wpms'          => (bool) gamipress_get_option( 'ms_show_all_achievements', false ) ? 'yes' : 'no',
        'orderby'     	=> gamipress_bp_get_option( $prefix . 'orderby', 'priority' ),
        'order'       	=> gamipress_bp_get_option( $prefix . 'order', 'DESC' ),
        'include'     	=> '',
        'exclude'     	=> '',
    ), $rank_atts ) );

}

/**
 * Displays user information at top
 *
 * @since 1.1.1
 */
function gamipress_bp_before_member_header() {

    $user_id = bp_displayed_user_id();

    if ( ! is_user_logged_in() && ! $user_id ) {
        return;
    }

    /* -------------------------------
     * Points
       ------------------------------- */

    $points_placement = gamipress_bp_get_option( 'points_placement', '' );

    if( $points_placement === 'top' || $points_placement === 'both' ) {

        // Setup points types vars
        $points_types = gamipress_get_points_types();
        $points_types_slugs = gamipress_get_points_types_slugs();

        // Get points display settings
        $points_types_to_show = gamipress_bp_members_get_points_types();
        $points_types_thumbnail = (bool) gamipress_bp_get_option( 'members_points_types_top_thumbnail', false );
        $points_types_thumbnail_size = (int) gamipress_bp_get_option( 'members_points_types_top_thumbnail_size', 25 );
        $points_types_label = (bool) gamipress_bp_get_option( 'members_points_types_top_label', false );

        // Parse thumbnail size
        if( $points_types_thumbnail_size > 0 ) {
            $points_types_thumbnail_size = array( $points_types_thumbnail_size, $points_types_thumbnail_size );
        } else {
            $points_types_thumbnail_size = 'gamipress-points';
        }

        if( ! empty( $points_types_to_show ) ) : ?>

            <div class="gamipress-buddypress-points">

                <?php foreach( $points_types_to_show as $points_type_to_show ) :

                // If points type not registered, skip
                if( ! in_array( $points_type_to_show, $points_types_slugs ) )
                    continue;

                $points_type = $points_types[$points_type_to_show];
                $user_points = gamipress_get_user_points( $user_id, $points_type_to_show ); ?>

                <div class="gamipress-buddypress-points-type gamipress-buddypress-<?php echo $points_type_to_show; ?>">

                    <?php // The points thumbnail ?>
                    <?php if( $points_types_thumbnail ) : ?>

                        <span class="activity gamipress-buddypress-points-thumbnail gamipress-buddypress-<?php echo $points_type_to_show; ?>-thumbnail">
                            <?php echo gamipress_get_points_type_thumbnail( $points_type_to_show, $points_types_thumbnail_size ); ?>
                        </span>

                    <?php endif; ?>

                    <?php // The user points amount ?>
                    <span class="activity gamipress-buddypress-user-points gamipress-buddypress-user-<?php echo $points_type_to_show; ?>">
                        <?php echo $user_points; ?>
                    </span>

                    <?php // The points label ?>
                    <?php if( $points_types_label ) : ?>

                        <span class="activity gamipress-buddypress-points-label gamipress-buddypress-<?php echo $points_type_to_show; ?>-label">
                            <?php echo _n( $points_type['singular_name'], $points_type['plural_name'], $user_points ); ?>
                        </span>

                    <?php endif; ?>

                </div>

                <?php endforeach; ?>
            </div>
        <?php endif;

    }

    /* -------------------------------
     * Achievements
       ------------------------------- */

    $achievements_placement = gamipress_bp_get_option( 'achievements_placement', '' );

    if( $achievements_placement === 'top' || $achievements_placement === 'both' ) {

        // Setup achievement types vars
        $achievement_types = gamipress_get_achievement_types();
        $achievement_types_slugs = gamipress_get_achievement_types_slugs();

        // Get achievements display settings
        $achievement_types_to_show = gamipress_bp_members_get_achievements_types();
        $achievement_types_thumbnail = (bool) gamipress_bp_get_option( 'members_achievements_top_thumbnail', false );
        $achievement_types_thumbnail_size = (int) gamipress_bp_get_option( 'members_achievements_top_thumbnail_size', 25 );
        $achievement_types_title = (bool) gamipress_bp_get_option( 'members_achievements_top_title', false );
        $achievement_types_link = (bool) gamipress_bp_get_option( 'members_achievements_top_link', false );
        $achievement_types_label = (bool) gamipress_bp_get_option( 'members_achievements_top_label', false );
        $achievement_types_limit = (int) gamipress_bp_get_option( 'members_achievements_top_limit', 10 );

        // Parse thumbnail size
        if( $achievement_types_thumbnail_size > 0 ) {
            $achievement_types_thumbnail_size = array( $achievement_types_thumbnail_size, $achievement_types_thumbnail_size );
        } else {
            $achievement_types_thumbnail_size = 'gamipress-achievement';
        }

        if( ! empty( $achievement_types_to_show ) ) : ?>

            <div class="gamipress-buddypress-achievements">

                <?php foreach( $achievement_types_to_show as $achievement_type_to_show ) :

                    // If achievements type not registered, skip
                    if( ! in_array( $achievement_type_to_show, $achievement_types_slugs ) )
                        continue;

                    $achievement_type = $achievement_types[$achievement_type_to_show];
                    $user_achievements = gamipress_get_user_achievements( array(
                        'user_id' => $user_id,
                        'achievement_type' => $achievement_type_to_show,
                        'groupby' => 'achievement_id',
                        'limit' => $achievement_types_limit,
                    ) );

                    // If user has not earned any achievements of this type, skip
                    if( empty( $user_achievements ) ) {
                        continue;
                    } ?>

                    <div class="gamipress-buddypress-achievement gamipress-buddypress-<?php echo $achievement_type_to_show; ?>">

                        <?php // The achievement type label ?>
                        <?php if( $achievement_types_label ) : ?>
                        <span class="activity gamipress-buddypress-achievement-type-label gamipress-buddypress-<?php echo $achievement_type_to_show; ?>-label">
                            <?php echo $achievement_type['plural_name']; ?>:
                        </span>
                        <?php endif; ?>

                        <?php // Lets to get just the achievement thumbnail and title
                        foreach( $user_achievements as $user_achievement ) : ?>

                            <?php // The achievement thumbnail ?>
                            <?php if( $achievement_types_thumbnail ) : ?>

                                <?php // The achievement link ?>
                                <?php if( $achievement_types_link ) : ?>

                                    <a href="<?php echo get_permalink( $user_achievement->ID ); ?>" title="<?php echo get_the_title( $user_achievement->ID ); ?>" class="activity gamipress-buddypress-achievement-thumbnail gamipress-buddypress-<?php echo $achievement_type_to_show; ?>-thumbnail">
                                        <?php echo gamipress_get_achievement_post_thumbnail( $user_achievement->ID, $achievement_types_thumbnail_size ); ?>
                                    </a>

                                <?php else : ?>

                                    <span title="<?php echo get_the_title( $user_achievement->ID ); ?>" class="activity gamipress-buddypress-achievement-thumbnail gamipress-buddypress-<?php echo $achievement_type_to_show; ?>-thumbnail">
                                        <?php echo gamipress_get_achievement_post_thumbnail( $user_achievement->ID, $achievement_types_thumbnail_size ); ?>
                                    </span>

                                <?php endif; ?>

                            <?php endif; ?>

                            <?php // The achievement title ?>
                            <?php if( $achievement_types_title ) : ?>

                                <?php // The achievement link ?>
                                <?php if( $achievement_types_link ) : ?>

                                    <a href="<?php echo get_permalink( $user_achievement->ID ); ?>" title="<?php echo get_the_title( $user_achievement->ID ); ?>" class="gamipress-buddypress-achievement-title gamipress-buddypress-<?php echo $achievement_type_to_show; ?>-title">
                                        <?php echo get_the_title( $user_achievement->ID ); ?>
                                    </a>

                                <?php else : ?>

                                    <span class="activity gamipress-buddypress-achievement-title gamipress-buddypress-<?php echo $achievement_type_to_show; ?>-title">
                                        <?php echo get_the_title( $user_achievement->ID ); ?>
                                    </span>

                                <?php endif; ?>

                            <?php endif; ?>

                        <?php endforeach; ?>

                    </div>

                <?php endforeach; ?>

            </div>

        <?php endif;

    }

    /* -------------------------------
     * Ranks
       ------------------------------- */

    $ranks_placement = gamipress_bp_get_option( 'ranks_placement', '' );

    if( $ranks_placement === 'top' || $ranks_placement === 'both' ) {

        // Setup rank types vars
        $rank_types = gamipress_get_rank_types();
        $rank_types_slugs = gamipress_get_rank_types_slugs();

        // Get ranks display settings
        $rank_types_to_show = gamipress_bp_members_get_ranks_types();
        $rank_types_thumbnail = (bool) gamipress_bp_get_option( 'members_ranks_top_thumbnail', false );
        $rank_types_thumbnail_size = (int) gamipress_bp_get_option( 'members_ranks_top_thumbnail_size', 25 );
        $rank_types_title = (bool) gamipress_bp_get_option( 'members_ranks_top_title', false );
        $rank_types_link = (bool) gamipress_bp_get_option( 'members_ranks_top_link', false );
        $rank_types_label = (bool) gamipress_bp_get_option( 'members_ranks_top_label', false );

        // Parse thumbnail size
        if( $rank_types_thumbnail_size > 0 ) {
            $rank_types_thumbnail_size = array( $rank_types_thumbnail_size, $rank_types_thumbnail_size );
        } else {
            $rank_types_thumbnail_size = 'gamipress-rank';
        }

        if( ! empty( $rank_types_to_show ) ) : ?>

            <div class="gamipress-buddypress-ranks">

                <?php foreach( $rank_types_to_show as $rank_type_to_show ) :

                    // If rank type not registered, skip
                    if( ! in_array( $rank_type_to_show, $rank_types_slugs ) )
                        continue;

                    $rank_type = $rank_types[$rank_type_to_show];
                    $user_rank = gamipress_get_user_rank( $user_id, $rank_type_to_show ); ?>

                    <div class="gamipress-buddypress-rank gamipress-buddypress-<?php echo $rank_type_to_show; ?>">

                        <?php // The rank type label ?>
                        <?php if( $rank_types_label ) : ?>
                        <span class="activity gamipress-buddypress-rank-label gamipress-buddypress-<?php echo $rank_type_to_show; ?>-label">
                            <?php echo $rank_type['singular_name']; ?>:
                        </span>
                        <?php endif; ?>

                        <?php // The rank thumbnail ?>
                        <?php if( $rank_types_thumbnail ) : ?>

                            <?php // The rank link ?>
                            <?php if( $rank_types_link ) : ?>

                                <a href="<?php echo get_permalink( $user_rank->ID ); ?>" title="<?php echo $user_rank->post_title; ?>" class="activity gamipress-buddypress-rank-thumbnail gamipress-buddypress-<?php echo $rank_type_to_show; ?>-thumbnail">
                                    <?php echo gamipress_get_rank_post_thumbnail( $user_rank->ID, $rank_types_thumbnail_size ); ?>
                                </a>

                            <?php else : ?>

                                <span title="<?php echo $user_rank->post_title; ?>" class="activity gamipress-buddypress-rank-thumbnail gamipress-buddypress-<?php echo $rank_type_to_show; ?>-thumbnail">
                                <?php echo gamipress_get_rank_post_thumbnail( $user_rank->ID, $rank_types_thumbnail_size ); ?>
                            </span>

                            <?php endif; ?>

                        <?php endif; ?>

                        <?php // The rank title ?>
                        <?php if( $rank_types_title ) : ?>

                            <?php // The rank link ?>
                            <?php if( $rank_types_link ) : ?>

                                <a href="<?php echo get_permalink( $user_rank->ID ); ?>" title="<?php echo $user_rank->post_title; ?>" class="activity gamipress-buddypress-rank-title gamipress-buddypress-<?php echo $rank_type_to_show; ?>-title">
                                    <?php echo $user_rank->post_title; ?>
                                </a>

                            <?php else : ?>

                                <span class="activity gamipress-buddypress-rank-title gamipress-buddypress-<?php echo $rank_type_to_show; ?>-title">
                                <?php echo $user_rank->post_title; ?>
                            </span>

                            <?php endif; ?>

                        <?php endif; ?>

                    </div>

                <?php endforeach; ?>
            </div>
        <?php endif;

    }

}
add_action( 'bp_before_member_header_meta', 'gamipress_bp_before_member_header' );

/**
 * Override the achievement earners list to use BP details
 *
 * @since    1.0.1
 * @updated  1.1.1 Also hook to gamipress_get_rank_earners_list_user for ranks support
 *
 * @param string  $user_content The list item output for the given user
 * @param integer $user_id      The given user's ID
 *
 * @return string               The updated user output
 */
function gamipress_bp_override_earners( $user_content, $user_id ) {

    $user = new BP_Core_User( $user_id );

    return '<li><a href="' .  $user->user_url . '">' . $user->avatar_mini . '</a></li>';

}
add_filter( 'gamipress_get_achievement_earners_list_user', 'gamipress_bp_override_earners', 10, 2 );
add_filter( 'gamipress_get_rank_earners_list_user', 'gamipress_bp_override_earners', 10, 2 );

/**
 * Helper function to retrieve the points types configured at members screen
 *
 * @since  1.0.8
 *
 * @return array
 */
function gamipress_bp_members_get_points_types() {

    $points_types = array();

    $points_types_slugs = gamipress_get_points_types_slugs();

    $points_types_to_show = gamipress_bp_get_option( 'members_points_types', array() );

    foreach( $points_types_to_show as $points_type_slug ) {

        if( ! in_array( $points_type_slug, $points_types_slugs ) ) {
            continue;
        }

        $points_types[] = $points_type_slug;
    }

    return $points_types;

}

/**
 * Helper function to retrieve the achievement types configured at members screen
 *
 * @since  1.0.5
 *
 * @return array
 */
function gamipress_bp_members_get_achievements_types() {

    $achievements_types = array();

    $achievement_types_slugs = gamipress_get_achievement_types_slugs();

    $achievements_types_to_show = gamipress_bp_get_option( 'members_achievements_types', array() );

    foreach( $achievements_types_to_show as $achievement_type_slug ) {

        // Skip if not registered
        if( ! in_array( $achievement_type_slug, $achievement_types_slugs ) ) {
            continue;
        }

        $achievements_types[] = $achievement_type_slug;
    }

    return $achievements_types;

}

/**
 * Helper function to retrieve the rank types configured at members screen
 *
 * @since  1.1.1
 *
 * @return array
 */
function gamipress_bp_members_get_ranks_types() {

    $ranks_types = array();

    $rank_types_slugs = gamipress_get_rank_types_slugs();

    $ranks_types_to_show = gamipress_bp_get_option( 'members_ranks_types', array() );

    foreach( $ranks_types_to_show as $rank_type_slug ) {

        // Skip if not registered
        if( ! in_array( $rank_type_slug, $rank_types_slugs ) ) {
            continue;
        }

        $ranks_types[] = $rank_type_slug;
    }

    return $ranks_types;

}
