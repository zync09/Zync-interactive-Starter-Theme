<?php
$composer_autoload = __DIR__ . '/vendor/autoload.php';
if ( file_exists( $composer_autoload ) ) {
	require_once $composer_autoload;
	$timber = new Timber\Timber();
}

use Timber\Menu;
use Timber\Site;
use Timber\Timber;

Timber::$dirname = array('views', 'components');

/**
 * By default, Timber does NOT autoescape values. Want to enable Twig's autoescape?
 * No prob! Just set this value to true
 */
Timber::$autoescape = false;


class ZyncStarter extends Site
{
    public function __construct()
    {
        add_action('wp_enqueue_scripts', [$this, 'enqueue_scripts']);
        add_action('after_setup_theme', [$this, 'theme_supports']);
        add_filter('timber/context', [$this, 'add_to_context']);
        add_filter('timber/twig', [$this, 'add_to_twig']);
        //add_filter('use_block_editor_for_post_type', [$this, 'use_block_editor_for_post_type'], 10, 2);
        add_action('init', [$this, 'register_custom_post_types']);
        add_action('init', [$this, 'register_taxonomies']);

        parent::__construct();
    }

    public function add_to_context($context)
    {
        $context['site'] = $this;
        $context['menu']['primary'] = new Menu('Primary Menu');
        $context['menu']['footer'] = new Menu('Footer Menu');
        $context['admin_bar'] = is_admin_bar_showing();

        // $context['options'] = get_fields('option');

        return $context;
    }

    public function add_to_twig($twig)
    {

        return $twig;
    }

    public function theme_supports()
    {
        //add_theme_support('automatic-feed-links');
        add_theme_support(
            'html5',
            [
                'comment-form',
                'comment-list',
                'gallery',
                'caption'
            ]
        );
        add_theme_support('menus');
        add_theme_support('post-thumbnails');
        add_theme_support('title-tag');

        /** Removing the Website field from WordPress comments is a proven way to reduce spam */
        add_filter('comment_form_default_fields', 'remove_website_field');
        function remove_website_field($fields)
        {
            if (isset($fields['url'])) {
                unset($fields['url']);
            }
            return $fields;
        }

        /** Limit comment depth to two. If you need more, you will need to adjust the Tailwind styling */
        add_filter('thread_comments_depth_max', function ($max) {
            return 2;
        });
    }

    public function enqueue_scripts()
    {
        wp_dequeue_style('wp-block-library');
        wp_dequeue_style('wp-block-library-theme');
        wp_dequeue_style('wp-block-style');
        //wp_dequeue_script('jquery');
        // wp_enqueue_script( 'jquery', '', [], false, true );

        $manifestFile = file_get_contents(__DIR__ . '/mix-manifest.json');
        $manifest = json_decode($manifestFile, true);

        $fileJS = $manifest['/dist/app.js'];
        $fileCSS = $manifest['/dist/app.css'];
        $fileCSS = $manifest['/dist/tailwind.css'];

        wp_enqueue_script('app', get_template_directory_uri() . $fileJS, null, null, true);
        wp_enqueue_style('style', get_template_directory_uri() . $fileCSS, null, null );
        wp_enqueue_style('style', get_template_directory_uri() . $fileCSS, null, null );
    }

    public function use_block_editor_for_post_type($is_enabled, $post_type)
    {
        if ($post_type === 'page') return false;
        return $is_enabled;
    }

    public function register_custom_post_types()
    {
                
    }

    public function register_taxonomies()
    {
                
    }
}

new ZyncStarter();