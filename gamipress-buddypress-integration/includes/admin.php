<?php
/**
 * Admin
 *
 * @package GamiPress\BuddyPress\Admin
 * @since 1.0.3
 */

// Exit if accessed directly
if( !defined( 'ABSPATH' ) ) exit;

require_once GAMIPRESS_BP_DIR . 'includes/admin/recount-activity.php';

/**
 * Shortcut function to get plugin options
 *
 * @since  1.0.8
 *
 * @param string    $option_name
 * @param bool      $default
 *
 * @return mixed
 */
function gamipress_bp_get_option( $option_name, $default = false ) {

    $prefix = 'bp_';

    return gamipress_get_option( $prefix . $option_name, $default );
}

/**
 * BuddyPress Settings meta boxes
 *
 * @since  1.0.3
 *
 * @param $meta_boxes
 *
 * @return mixed
 */
function gamipress_bp_settings_meta_boxes( $meta_boxes ) {

    $prefix = 'bp_';

    if ( gamipress_bp_is_active( 'xprofile' ) ) {

        // Setup dynamic achievement fields
        $achievement_fields = array();

        foreach( GamiPress()->shortcodes['gamipress_achievement']->fields as $field_id => $field_args ) {

            if( $field_id === 'id' ) {
                continue;
            }

            if( $field_args['type'] === 'checkbox' && isset( $field_args['default'] ) ) {
                unset( $field_args['default'] );
            }

            $achievement_fields[$prefix . 'members_achievements_' . $field_id] = $field_args;

        }

        // Setup dynamic rank fields
        $rank_fields = array();

        foreach( GamiPress()->shortcodes['gamipress_rank']->fields as $field_id => $field_args ) {

            if( $field_id === 'id' ) {
                continue;
            }

            if( $field_args['type'] === 'checkbox' && isset( $field_args['default'] ) ) {
                unset( $field_args['default'] );
            }

            $rank_fields[$prefix . 'members_ranks_' . $field_id] = $field_args;

        }

        $meta_boxes['gamipress-bp-settings'] = array(
            'title' => __( 'BuddyPress', 'gamipress-buddypress-integration' ),
            'fields' => apply_filters( 'gamipress_bp_settings_fields', array_merge( array(

                // Points Types

                $prefix . 'points_placement' => array(
                    'name' => __( 'Where Place User Points?', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Check this option to show the user points on the BuddyPress profile.', 'gamipress-buddypress-integration' ),
                    'type' => 'select',
                    'options' => array(
                        ''      => __( 'Not display', 'gamipress-buddypress-integration' ),
                        'tab'   => __( 'As a new profile tab', 'gamipress-buddypress-integration' ),
                        'top'   => __( 'At top (before the user name)', 'gamipress-buddypress-integration' ),
                        'both'  => __( 'Both', 'gamipress-buddypress-integration' ),
                    ),
                ),
                $prefix . 'points_tab_title' => array(
                    'name' => __( 'User Profile Points Tab Title', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Text to show on the BuddyPress user profile.', 'gamipress-buddypress-integration' ),
                    'type' => 'text',
                    'default' => __( 'Points', 'gamipress-buddypress-integration' ),
                ),
                $prefix . 'points_tab_slug' => array(
                    'name' => __( 'User Profile Points Tab Slug (Option)', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'URL slug to use on the profile tab. Leave blank and slug will be a URL version of the tab title (eg: "My Tab Title" will have a slug like "my-tab-title").', 'gamipress-buddypress-integration' )
                        . '<br>' . __( '<strong>Important:</strong> If you set a tab title with special characters then provide a slug with URL friendly characters.', 'gamipress-buddypress-integration' ),
                    'type' => 'text',
                ),
                $prefix . 'members_points_types' => array(
                    'name' => __( 'User Profile Points Types', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Choose the points types you want to show on BuddyPress user profile.', 'gamipress-buddypress-integration' )
                        . '<br>' . __( '<strong>Note:</strong> You can drag and drop this options to reorder them. The order you set will affect to the order they will get displayed on the profile.', 'gamipress-buddypress-integration' ),
                    'type' => 'multicheck',
                    'options_cb' => 'gamipress_bp_members_points_types_option_cb',
                ),
                $prefix . 'members_points_types_top_display_title' => array(
                    'name' => __( 'Points At Top Display Options', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Setup how points should look at top of the BuddyPress user profile.', 'gamipress-buddypress-integration' ),
                    'type' => 'title',
                ),
                $prefix . 'members_points_types_top_thumbnail' => array(
                    'name' => __( 'Show Thumbnail', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Show the points type featured image.', 'gamipress-buddypress-integration' ),
                    'type' => 'checkbox',
                    'classes' => 'gamipress-switch',
                ),
                $prefix . 'members_points_types_top_thumbnail_size' => array(
                    'name' => __( 'Thumbnail Size', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Set the thumbnail size (in pixels).', 'gamipress-buddypress-integration' ),
                    'type' => 'text',
                    'default' => '25',
                ),
                $prefix . 'members_points_types_top_label' => array(
                    'name' => __( 'Show Label', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Show the points type singular or plural label.', 'gamipress-buddypress-integration' ),
                    'type' => 'checkbox',
                    'classes' => 'gamipress-switch',
                ),

                // Achievement Types

                $prefix . 'achievements_placement' => array(
                    'name' => __( 'Where Place User Achievements?', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Check this option to show the user achievements on the BuddyPress profile.', 'gamipress-buddypress-integration' ),
                    'type' => 'select',
                    'options' => array(
                        ''      => __( 'Not display', 'gamipress-buddypress-integration' ),
                        'tab'   => __( 'As a new profile tab', 'gamipress-buddypress-integration' ),
                        'top'   => __( 'At top (before the user name)', 'gamipress-buddypress-integration' ),
                        'both'  => __( 'Both', 'gamipress-buddypress-integration' ),
                    ),
                ),
                $prefix . 'achievements_tab_title' => array(
                    'name' => __( 'User Profile Achievement Types Tab Title', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Text to show on the BuddyPress user profile.', 'gamipress-buddypress-integration' ),
                    'type' => 'text',
                    'default' => __( 'Achievements', 'gamipress-buddypress-integration' ),
                ),
                $prefix . 'achievements_tab_slug' => array(
                    'name' => __( 'User Profile Achievement Types Tab Slug (Option)', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'URL slug to use on the profile tab. Leave blank and slug will be a URL version of the tab title (eg: "My Tab Title" will have a slug like "my-tab-title").', 'gamipress-buddypress-integration' )
                        . '<br>' . __( '<strong>Important:</strong> If you set a tab title with special characters then provide a slug with URL friendly characters.', 'gamipress-buddypress-integration' ),
                    'type' => 'text',
                ),
                $prefix . 'members_achievements_types' => array(
                    'name' => __( 'User Profile Achievement Types', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Choose the achievement types you want to show on BuddyPress user profile achievements tab.', 'gamipress-buddypress-integration' )
                        . '<br>' . __( '<strong>Note:</strong> You can drag and drop this options to reorder them. The order you set will affect to the order they will get displayed on the profile.', 'gamipress-buddypress-integration' ),
                    'type' => 'multicheck',
                    'options_cb' => 'gamipress_bp_members_achievements_types_option_cb',
                ),
                $prefix . 'members_achievements_top_display_title' => array(
                    'name' => __( 'Achievements At Top Display Options', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Setup how achievements should look at top of the BuddyPress user profile.', 'gamipress-buddypress-integration' ),
                    'type' => 'title',
                ),
                $prefix . 'members_achievements_top_thumbnail' => array(
                    'name' => __( 'Show Thumbnail', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Show the achievement featured image.', 'gamipress-buddypress-integration' ),
                    'type' => 'checkbox',
                    'classes' => 'gamipress-switch',
                ),
                $prefix . 'members_achievements_top_thumbnail_size' => array(
                    'name' => __( 'Thumbnail Size', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Set the thumbnail size (in pixels).', 'gamipress-buddypress-integration' ),
                    'type' => 'text',
                    'default' => '25',
                ),
                $prefix . 'members_achievements_top_title' => array(
                    'name' => __( 'Show Title', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Show the achievements title.', 'gamipress-buddypress-integration' ),
                    'type' => 'checkbox',
                    'classes' => 'gamipress-switch',
                ),
                $prefix . 'members_achievements_top_link' => array(
                    'name' => __( 'Show Link', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Add a link to the achievement page.', 'gamipress-buddypress-integration' ),
                    'type' => 'checkbox',
                    'classes' => 'gamipress-switch',
                ),
                $prefix . 'members_achievements_top_label' => array(
                    'name' => __( 'Show Label', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Show the achievement type label.', 'gamipress-buddypress-integration' ),
                    'type' => 'checkbox',
                    'classes' => 'gamipress-switch',
                ),
                $prefix . 'members_achievements_top_limit' => array(
                    'name' => __( 'Limit', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Number of achievements to display.', 'gamipress-buddypress-integration' ),
                    'type' => 'text',
                    'default' => '10',
                ),
                $prefix . 'members_achievements_template_title' => array(
                    'name'        => __( 'Achievements Tab Display Options', 'gamipress-buddypress-integration' ),
                    'description' => __( 'Setup how achievements should look on the BuddyPress user profile tab.', 'gamipress-buddypress-integration' ),
                    'type'        => 'title',
                ),
                $prefix . 'members_achievements_columns' => array(
                    'name'        => __( 'Columns', 'gamipress-buddypress-integration' ),
                    'description' => __( 'Columns to divide achievements.', 'gamipress-buddypress-integration' ),
                    'type'  => 'select',
                    'options' => array(
                        '1' => __( '1 Column', 'gamipress-buddypress-integration' ),
                        '2' => __( '2 Columns', 'gamipress-buddypress-integration' ),
                        '3' => __( '3 Columns', 'gamipress-buddypress-integration' ),
                        '4' => __( '4 Columns', 'gamipress-buddypress-integration' ),
                        '5' => __( '5 Columns', 'gamipress-buddypress-integration' ),
                        '6' => __( '6 Columns', 'gamipress-buddypress-integration' ),
                    ),
                    'default' => '1'
                ),
                $prefix . 'members_achievements_limit' => array(
                    'name'        => __( 'Limit', 'gamipress-buddypress-integration' ),
                    'description' => __( 'Number of achievements to display.', 'gamipress-buddypress-integration' ),
                    'type'        => 'text',
                    'default'     => 10,
                ),
                $prefix . 'members_achievements_orderby' => array(
                    'name'        => __( 'Order By', 'gamipress-buddypress-integration' ),
                    'description' => __( 'Parameter to use for sorting.', 'gamipress-buddypress-integration' ),
                    'type'        => 'select',
                    'options'      => array(
                        'menu_order' => __( 'Menu Order', 'gamipress-buddypress-integration' ),
                        'ID'         => __( 'Achievement ID', 'gamipress-buddypress-integration' ),
                        'title'      => __( 'Achievement Title', 'gamipress-buddypress-integration' ),
                        'date'       => __( 'Published Date', 'gamipress-buddypress-integration' ),
                        'modified'   => __( 'Last Modified Date', 'gamipress-buddypress-integration' ),
                        'author'     => __( 'Achievement Author', 'gamipress-buddypress-integration' ),
                        'rand'       => __( 'Random', 'gamipress-buddypress-integration' ),
                    ),
                    'default'     => 'menu_order',
                ),
                $prefix . 'members_achievements_order' => array(
                    'name'        => __( 'Order', 'gamipress-buddypress-integration' ),
                    'description' => __( 'Sort order.', 'gamipress-buddypress-integration' ),
                    'type'        => 'select',
                    'options'      => array( 'ASC' => __( 'Ascending', 'gamipress-buddypress-integration' ), 'DESC' => __( 'Descending', 'gamipress-buddypress-integration' ) ),
                    'default'     => 'ASC',
                ),

                // Rank Types

                $prefix . 'ranks_placement' => array(
                    'name' => __( 'Where Place User Ranks?', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Check this option to show the user ranks on the BuddyPress profile.', 'gamipress-buddypress-integration' ),
                    'type' => 'select',
                    'options' => array(
                        ''      => __( 'Not display', 'gamipress-buddypress-integration' ),
                        'tab'   => __( 'As a new profile tab', 'gamipress-buddypress-integration' ),
                        'top'   => __( 'At top (before the user name)', 'gamipress-buddypress-integration' ),
                        'both'  => __( 'Both', 'gamipress-buddypress-integration' ),
                    ),
                ),
                $prefix . 'ranks_tab_title' => array(
                    'name' => __( 'User Profile Rank Types Tab Title', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Text to show on the BuddyPress user profile.', 'gamipress-buddypress-integration' ),
                    'type' => 'text',
                    'default' => __( 'Ranks', 'gamipress-buddypress-integration' ),
                ),
                $prefix . 'ranks_tab_slug' => array(
                    'name' => __( 'User Profile Rank Types Tab Slug (Option)', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'URL slug to use on the profile tab. Leave blank and slug will be a URL version of the tab title (eg: "My Tab Title" will have a slug like "my-tab-title").', 'gamipress-buddypress-integration' )
                        . '<br>' . __( '<strong>Important:</strong> If you set a tab title with special characters then provide a slug with URL friendly characters.', 'gamipress-buddypress-integration' ),
                    'type' => 'text',
                ),
                $prefix . 'members_ranks_types' => array(
                    'name' => __( 'User Profile Rank Types', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Choose the rank types you want to show on BuddyPress user profile ranks tab.', 'gamipress-buddypress-integration' )
                        . '<br>' . __( '<strong>Note:</strong> You can drag and drop this options to reorder them. The order you set will affect to the order they will get displayed on the profile.', 'gamipress-buddypress-integration' ),
                    'type' => 'multicheck',
                    'options_cb' => 'gamipress_bp_members_ranks_types_option_cb',
                ),
                $prefix . 'members_ranks_top_display_title' => array(
                    'name' => __( 'Ranks At Top Display Options', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Setup how ranks should look at top of the BuddyPress user profile.', 'gamipress-buddypress-integration' ),
                    'type' => 'title',
                ),
                $prefix . 'members_ranks_top_thumbnail' => array(
                    'name' => __( 'Show Thumbnail', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Show the achievement featured image.', 'gamipress-buddypress-integration' ),
                    'type' => 'checkbox',
                    'classes' => 'gamipress-switch',
                ),
                $prefix . 'members_ranks_top_thumbnail_size' => array(
                    'name' => __( 'Thumbnail Size', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Set the thumbnail size (in pixels).', 'gamipress-buddypress-integration' ),
                    'type' => 'text',
                    'default' => '25',
                ),
                $prefix . 'members_ranks_top_title' => array(
                    'name' => __( 'Show Title', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Show the rank title.', 'gamipress-buddypress-integration' ),
                    'type' => 'checkbox',
                    'classes' => 'gamipress-switch',
                ),
                $prefix . 'members_ranks_top_link' => array(
                    'name' => __( 'Show Link', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Add a link to the rank page.', 'gamipress-buddypress-integration' ),
                    'type' => 'checkbox',
                    'classes' => 'gamipress-switch',
                ),
                $prefix . 'members_ranks_top_label' => array(
                    'name' => __( 'Show Label', 'gamipress-buddypress-integration' ),
                    'desc' => __( 'Show the rank type label.', 'gamipress-buddypress-integration' ),
                    'type' => 'checkbox',
                    'classes' => 'gamipress-switch',
                ),
                $prefix . 'members_ranks_template_title' => array(
                    'name'        => __( 'Ranks Tab Display Options', 'gamipress-buddypress-integration' ),
                    'description' => __( 'Setup how ranks should look on the BuddyPress user profile tab.', 'gamipress-buddypress-integration' ),
                    'type'        => 'title',
                ),
                $prefix . 'members_ranks_columns' => array(
                    'name'        => __( 'Columns', 'gamipress-buddypress-integration' ),
                    'description' => __( 'Columns to divide ranks.', 'gamipress-buddypress-integration' ),
                    'type'  => 'select',
                    'options' => array(
                        '1' => __( '1 Column', 'gamipress-buddypress-integration' ),
                        '2' => __( '2 Columns', 'gamipress-buddypress-integration' ),
                        '3' => __( '3 Columns', 'gamipress-buddypress-integration' ),
                        '4' => __( '4 Columns', 'gamipress-buddypress-integration' ),
                        '5' => __( '5 Columns', 'gamipress-buddypress-integration' ),
                        '6' => __( '6 Columns', 'gamipress-buddypress-integration' ),
                    ),
                    'default' => '1'
                ),
                $prefix . 'members_ranks_orderby' => array(
                    'name'        => __( 'Order By', 'gamipress-buddypress-integration' ),
                    'description' => __( 'Parameter to use for sorting.', 'gamipress-buddypress-integration' ),
                    'type'        => 'select',
                    'options'      => array(
                        'priority'   => __( 'Priority', 'gamipress-buddypress-integration' ),
                        'ID'         => __( 'Rank ID', 'gamipress-buddypress-integration' ),
                        'title'      => __( 'Rank Title', 'gamipress-buddypress-integration' ),
                        'date'       => __( 'Published Date', 'gamipress-buddypress-integration' ),
                        'modified'   => __( 'Last Modified Date', 'gamipress-buddypress-integration' ),
                        'rand'       => __( 'Random', 'gamipress-buddypress-integration' ),
                    ),
                    'default'     => 'priority',
                ),
                $prefix . 'members_ranks_order' => array(
                    'name'        => __( 'Order', 'gamipress-buddypress-integration' ),
                    'description' => __( 'Sort order.', 'gamipress-buddypress-integration' ),
                    'type'        => 'select',
                    'options'      => array( 'ASC' => __( 'Ascending', 'gamipress-buddypress-integration' ), 'DESC' => __( 'Descending', 'gamipress-buddypress-integration' ) ),
                    'default'     => 'DESC',
                ),

            ), $achievement_fields, $rank_fields ) ),
            'vertical_tabs' => true,
            'tabs' => apply_filters( 'gamipress_bp_settings_tabs', array(
                'points' => array(
                    'title' => __( 'Points', 'gamipress-buddypress-integration' ),
                    'icon' => 'dashicons-star-filled',
                    'fields' => array(
                        $prefix . 'points_placement',
                        $prefix . 'points_tab_title',
                        $prefix . 'points_tab_slug',
                        $prefix . 'members_points_types',

                        $prefix . 'members_points_types_top_display_title',
                        $prefix . 'members_points_types_top_thumbnail',
                        $prefix . 'members_points_types_top_thumbnail_size',
                        $prefix . 'members_points_types_top_label'
                    )
                ),
                'achievements' => array(
                    'title' => __( 'Achievements', 'gamipress-buddypress-integration' ),
                    'icon' => 'dashicons-awards',
                    'fields' => array_merge( array(
                        $prefix . 'achievements_placement',
                        $prefix . 'achievements_tab_title',
                        $prefix . 'achievements_tab_slug',
                        $prefix . 'members_achievements_types',

                        $prefix . 'members_achievements_top_display_title',
                        $prefix . 'members_achievements_top_thumbnail',
                        $prefix . 'members_achievements_top_thumbnail_size',
                        $prefix . 'members_achievements_top_title',
                        $prefix . 'members_achievements_top_link',
                        $prefix . 'members_achievements_top_label',
                        $prefix . 'members_achievements_top_limit',

                        $prefix . 'members_achievements_template_title',
                        $prefix . 'members_achievements_columns',
                        $prefix . 'members_achievements_limit',
                        $prefix . 'members_achievements_orderby',
                        $prefix . 'members_achievements_order',
                    ), array_keys( $achievement_fields ) )
                ),
                'ranks' => array(
                    'title' => __( 'Ranks', 'gamipress-buddypress-integration' ),
                    'icon' => 'dashicons-rank',
                    'fields' => array_merge( array(
                        $prefix . 'ranks_placement',
                        $prefix . 'ranks_tab_title',
                        $prefix . 'ranks_tab_slug',
                        $prefix . 'members_ranks_types',

                        $prefix . 'members_ranks_top_display_title',
                        $prefix . 'members_ranks_top_thumbnail',
                        $prefix . 'members_ranks_top_thumbnail_size',
                        $prefix . 'members_ranks_top_title',
                        $prefix . 'members_ranks_top_link',
                        $prefix . 'members_ranks_top_label',

                        $prefix . 'members_ranks_template_title',
                        $prefix . 'members_ranks_columns',
                        $prefix . 'members_ranks_orderby',
                        $prefix . 'members_ranks_order',
                    ), array_keys( $rank_fields ) )
                )
            ) )
        );

    }

    return $meta_boxes;

}
add_filter( 'gamipress_settings_addons_meta_boxes', 'gamipress_bp_settings_meta_boxes' );

function gamipress_bp_members_points_types_option_cb() {

    $points_types_slugs = gamipress_get_points_types_slugs();

    $gamipress_settings = ( $exists = get_option( 'gamipress_settings' ) ) ? $exists : array();

    $points_types_order = isset( $gamipress_settings['bp_members_points_types_order'] ) ?
        $gamipress_settings['bp_members_points_types_order'] : $points_types_slugs;

    $points_types = gamipress_get_points_types();

    $options = array();

    foreach( $points_types_order as $points_type_slug ) {

        // Skip if points type not exists
        if( ! isset( $points_types[$points_type_slug] ) ) {
            continue;
        }

        $options[$points_type_slug] = '<input type="hidden" name="bp_members_points_types_order[]" value="' . $points_type_slug . '" />'
            . $points_types[$points_type_slug]['plural_name'];
    }

    $unordered_points_types = array_diff( $points_types_slugs, $points_types_order );

    // Append new achievement types
    foreach( $unordered_points_types as $unordered_points_type ) {

        // Skip if points type not exists
        if( ! isset( $points_types[$unordered_points_type] ) ) {
            continue;
        }

        $options[$unordered_points_type] = '<input type="hidden" name="bp_members_points_types_order[]" value="' . $unordered_points_type . '" />'
            . $points_types[$unordered_points_type]['plural_name'];
    }

    return $options;

}

function gamipress_bp_members_achievements_types_option_cb() {

    $achievement_types_slugs = array_diff(
        gamipress_get_achievement_types_slugs(),
        gamipress_get_requirement_types_slugs()
    );

    $gamipress_settings = ( $exists = get_option( 'gamipress_settings' ) ) ? $exists : array();

    $achievement_types_order = isset( $gamipress_settings['bp_members_achievements_types_order'] ) ?
        $gamipress_settings['bp_members_achievements_types_order'] : $achievement_types_slugs;

    $achievement_types = gamipress_get_achievement_types();

    $options = array();

    foreach( $achievement_types_order as $achievement_type_slug ) {

        // Skip if is a requirement type or not exists on $achievement_types
        if( in_array( $achievement_type_slug, gamipress_get_requirement_types_slugs() ) || ! isset( $achievement_types[$achievement_type_slug] ) ) {
            continue;
        }

        $options[$achievement_type_slug] = '<input type="hidden" name="bp_members_achievements_types_order[]" value="' . $achievement_type_slug . '" />'
            . $achievement_types[$achievement_type_slug]['plural_name'];
    }

    $unordered_achievement_types = array_diff( $achievement_types_slugs, $achievement_types_order );

    // Append new achievement types
    foreach( $unordered_achievement_types as $unordered_achievement_type ) {

        // Skip if achievement not exists
        if( ! isset( $achievement_types[$unordered_achievement_type] ) ) {
            continue;
        }

        $options[$unordered_achievement_type] = '<input type="hidden" name="bp_members_achievements_types_order[]" value="' . $unordered_achievement_type . '" />'
            . $achievement_types[$unordered_achievement_type]['plural_name'];
    }

    return $options;

}

function gamipress_bp_members_ranks_types_option_cb() {

    $rank_types_slugs = gamipress_get_rank_types_slugs();

    $gamipress_settings = ( $exists = get_option( 'gamipress_settings' ) ) ? $exists : array();

    $rank_types_order = isset( $gamipress_settings['bp_members_ranks_types_order'] ) ?
        $gamipress_settings['bp_members_ranks_types_order'] : $rank_types_slugs;

    $rank_types = gamipress_get_rank_types();

    $options = array();

    foreach( $rank_types_order as $rank_type_slug ) {

        // Skip if rank not exists
        if( ! isset( $rank_types[$rank_type_slug] ) ) {
            continue;
        }

        $options[$rank_type_slug] = '<input type="hidden" name="bp_members_ranks_types_order[]" value="' . $rank_type_slug . '" />'
            . $rank_types[$rank_type_slug]['plural_name'];

    }

    $unordered_rank_types = array_diff( $rank_types_slugs, $rank_types_order );

    // Append new rank types
    foreach( $unordered_rank_types as $unordered_rank_type ) {

        // Skip if rank not exists
        if( ! isset( $rank_types[$unordered_rank_type] ) ) {
            continue;
        }

        $options[$unordered_rank_type] = '<input type="hidden" name="bp_members_ranks_types_order[]" value="' . $unordered_rank_type . '" />'
            . $rank_types[$unordered_rank_type]['plural_name'];

    }

    return $options;

}

function gamipress_bp_save_gamipress_settings() {

    if( ! isset( $_POST['submit-cmb'] ) ) {
        return;
    }

    if( ! ( isset( $_REQUEST['page'] ) && $_REQUEST['page'] == 'gamipress_settings' ) ) {
        return;
    }

    if( ! isset( $_POST['bp_members_points_types_order'] ) || ! isset( $_POST['bp_members_achievements_types_order'] ) || ! isset( $_POST['bp_members_ranks_types_order'] ) ) {
        return;
    }

    // Setup GamiPress options
    $gamipress_settings = ( $exists = get_option( 'gamipress_settings' ) ) ? $exists : array();

    // Setup new setting
    $gamipress_settings['bp_members_points_types_order'] = $_POST['bp_members_points_types_order'];
    $gamipress_settings['bp_members_achievements_types_order'] = $_POST['bp_members_achievements_types_order'];
    $gamipress_settings['bp_members_ranks_types_order'] = $_POST['bp_members_ranks_types_order'];

    // Update GamiPress settings
    update_option( 'gamipress_settings', $gamipress_settings );

}
add_action( 'cmb2_save_options-page_fields', 'gamipress_bp_save_gamipress_settings' );

/**
 * BuddyPress automatic updates
 *
 * @since  1.0.4
 *
 * @param array $automatic_updates_plugins
 *
 * @return array
 */
function gamipress_bp_automatic_updates( $automatic_updates_plugins ) {

    $automatic_updates_plugins['gamipress-buddypress-integration'] = __( 'BuddyPress integration', 'gamipress-buddypress-integration' );

    return $automatic_updates_plugins;
}
add_filter( 'gamipress_automatic_updates_plugins', 'gamipress_bp_automatic_updates' );