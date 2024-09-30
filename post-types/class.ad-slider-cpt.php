<?php 

if( !class_exists( 'AD_Slider_Post_Type' ) ) {
    class AD_Slider_Post_Type {
        function __construct() {
            add_action( 'init', [$this, 'create_post_type'] );
            add_action( 'add_meta_boxes', [$this, 'add_meta_boxes'] );
            add_action( 'save_post', [$this, 'save_post'], 10, 2 );
            add_filter( 'manage_ad-slider_posts_columns', [$this, 'ad_slider_cpt_columns'] );
            add_action( 'manage_ad-slider_posts_custom_column', [$this, 'ad_slider_custom_columns'], 10, 2 );
            add_filter('manage_edit-ad-slider_sortable_columns', [$this, 'ad_slider_sortable_columns']);
        }

        public function create_post_type() {
            register_post_type(
                'ad-slider', [
                    'label'                 =>  'Masing Slider',
                    'description'           =>  'Here You can Add Amazing Slider',
                    'labels'                =>  [
                        'name'              =>  'Sliders',
                        'singular_name'     =>  'Slider',
                    ],
                    'public'                =>  true,
                    'supports'              =>  ['title', 'editor', 'thumbnail'],
                    'hierarchical'          =>  false,
                    'show_ui'               =>  true,
                    'show_in_menu'          =>  false,
                    'menu_position'         =>  5,
                    'show_in_admin_bar'     =>  true,
                    'show_in_nav_menus'     =>  true,
                    'can_export'            =>  true,
                    'has_archive'           =>  true,
                    'exclude_from_search'   =>  true,
                    'publicly_queryable'    =>  true,
                    'show_in_rest'          =>  true,
                    'menu_icon'             =>  'dashicons-slides',
                ]);
        }

        public function ad_slider_cpt_columns( $columns ) {
            $columns['ad_slider_link_text'] =   esc_html__('Link Text', 'ad-slider');
            $columns['ad_slider_link_url'] =   esc_html__('Link URL', 'ad-slider');
            return $columns;
        }

        public function ad_slider_custom_columns( $column, $post_id ) {
            switch( $column ) {
                case 'ad_slider_link_text':
                    echo esc_html( get_post_meta( $post_id, 'ad_slider_link_text', true ) );
                break;
                case 'ad_slider_link_url':
                    echo esc_url( get_post_meta( $post_id, 'ad_slider_link_url', true ) );
                break;
                }
        }

        public function ad_slider_sortable_columns( $columns ) {
            $columns['ad_slider_link_text'] = 'ad_slider_link_text';
            return $columns;
        }

        public function add_meta_boxes() {
            add_meta_box(
                'ad_slider_meta_box', 
                'Link Options', 
                [$this, 'add_inner_meta_boxes'],
                'ad-slider',
                'normal',
                'high'
            );
        }

        public function add_inner_meta_boxes( $post ) {
            require_once( AD_SLIDER_PATH . '/views/ad-slider_metabox.php' );
        }

        public function save_post( $post_id ) {
            // Check nonce
            if (isset($_POST['ad_slider_nonce'])) {
                if (!wp_verify_nonce($_POST['ad_slider_nonce'], 'ad_slider_nonce')) {
                    return;
                }
            }
        
            // Check if this is an autosave
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return;
            }
        
            // Check user permissions
            if (isset($_POST['post_type']) && $_POST['post_type'] === 'ad-slider') {
                if (!current_user_can('edit_post', $post_id)) {
                    return;
                }
            }
        
            // Retrieve new link text and URL
            $new_link_text = $_POST['ad_slider_link_text'];
            $new_link_url  = $_POST['ad_slider_link_url'];
        
            // Update the link text meta
            if (empty($new_link_text)) {
                update_post_meta($post_id, 'ad_slider_link_text', 'Add Some Text');
            } else {
                update_post_meta($post_id, 'ad_slider_link_text', sanitize_text_field($new_link_text));
            }
        
            // Update the link URL meta
            if (empty($new_link_url)) {
                update_post_meta($post_id, 'ad_slider_link_url', '#');
            } else {
                update_post_meta($post_id, 'ad_slider_link_url', esc_url_raw($new_link_url));
            }
        }
        
    }
}