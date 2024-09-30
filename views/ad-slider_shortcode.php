<h3><?php echo ( !empty($content) )? esc_html($content): esc_html(AD_Slider_Settings::$options['ad_slider_title']); ?></h3>
<div class="ad-slider flexslider <?php echo ( isset( AD_Slider_Settings::$options['ad_slider_style'] ) ) ? esc_attr( AD_Slider_Settings::$options['ad_slider_style'] ) : 'style-1'; ?> ">
    <ul class="slides">

    <?php 
    $args = [
        'post_type'     =>  'ad-slider',
        'post_status'   =>  'publish',
        'post__in'      =>  $id,
        'orderby'       =>  $orderby
    ];

    $my_query = new WP_Query( $args );

    if( $my_query->have_posts() ):
        while( $my_query->have_posts() ) : $my_query->the_post();

        $button_text = get_post_meta(get_the_ID(), 'ad_slider_link_text', true);
        $button_url = get_post_meta(get_the_ID(), 'ad_slider_link_url', true);

    ?>

        <li>
        <?php 
        if (has_post_thumbnail()) {
            the_post_thumbnail('full', ['class' => 'img-fluid']);
        } else { ?>
            <img src="<?php echo esc_url(AD_SLIDER_URL . 'assets/images/image-2935360_1280.png'); ?>" alt="Default Image" class="img-fluid wp-post-image">
        <?php } ?>


            <div class="ads-container">
                <div class="slider-details-container">
                    <div class="wrapper">
                        <div class="slider-title">
                            <h2><?php the_title(); ?></h2>
                        </div>
                        <div class="slider-description">
                            <div class="subtitle"><?php the_content(); ?></div>
                            <a class="link" href="<?php echo esc_url($button_url); ?>"><?php echo esc_html($button_text); ?></php></a>
                        </div>
                    </div>
                </div>
            </div>
        </li>
        <?php 
            endwhile;
            wp_reset_postdata();
        endif;
        ?>
    </ul>
</div>