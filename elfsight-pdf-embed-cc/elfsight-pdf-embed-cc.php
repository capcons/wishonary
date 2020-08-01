<?php
/*
Plugin Name: Elfsight PDF Embed CC
Description: An easy tool for integrating PDF docs in your web page with view and download available.
Plugin URI: https://elfsight.com/pdf-embed-widget/codecanyon/?utm_source=markets&utm_medium=codecanyon&utm_campaign=pdf-embed&utm_content=plugin-site
Version: 1.0.1
Author: Elfsight
Author URI: https://elfsight.com/?utm_source=markets&utm_medium=codecanyon&utm_campaign=pdf-embed&utm_content=plugins-list
*/

if (!defined('ABSPATH')) exit;


require_once('core/elfsight-plugin.php');

$elfsight_pdf_embed_config_path = plugin_dir_path(__FILE__) . 'config.json';
$elfsight_pdf_embed_config = json_decode(file_get_contents($elfsight_pdf_embed_config_path), true);

new ElfsightPdfEmbedPlugin(
    array(
        'name' => esc_html__('PDF Embed'),
        'description' => esc_html__('An easy tool for integrating PDF docs in your web page with view and download available.'),
        'slug' => 'elfsight-pdf-embed',
        'version' => '1.0.1',
        'text_domain' => 'elfsight-pdf-embed',
        'editor_settings' => $elfsight_pdf_embed_config['settings'],
        'editor_preferences' => $elfsight_pdf_embed_config['preferences'],
        'script_url' => plugins_url('assets/elfsight-pdf-embed.js', __FILE__),

        'plugin_name' => esc_html__('Elfsight PDF Embed'),
        'plugin_file' => __FILE__,
        'plugin_slug' => plugin_basename(__FILE__),

        'vc_icon' => plugins_url('assets/img/vc-icon.png', __FILE__),

        'menu_icon' => plugins_url('assets/img/menu-icon.svg', __FILE__),
        'update_url' => esc_url('https://a.elfsight.com/updates/v1/'),

        'preview_url' => plugins_url('preview/preview.html', __FILE__),
        'observer_url' => plugins_url('preview/pdf-embed-observer.js', __FILE__),

        'product_url' => esc_url('https://codecanyon.net/item/pdf-embed-wordpress-pdf-viewer-plugin/24004896?ref=Elfsight'),
        'support_url' => esc_url('https://elfsight.ticksy.com/submit/#100015408')
    )
);

?>
