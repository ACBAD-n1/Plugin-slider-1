<?php 
    $meta = get_post_meta( $post->ID );
    $link_text = get_post_meta($post->ID, 'ad_slider_link_text', true);
    $link_url = get_post_meta($post->ID, 'ad_slider_link_url', true);
?>

<table class="form-table ad-slider-metabox">
<input type="hidden" name="ad_slider_nonce" value="<?php wp_create_nonce("ad_slider_nonce"); ?>">
    <tr>
        <th>
            <label for="ad_slider_link_text">Link Text</label>
        </th>
        <td>
            <input 
                type="text"
                name="ad_slider_link_text"
                id="ad_slider_link_text"
                class="regular-text link-text"
                value="<?php echo (isset($link_text)) ? esc_html($link_text): ''; ?>"
                required
            >
        </td>
    </tr>
    <tr>
        <th>
            <label for="ad_slider_link_url">Link URL</label>
        </th>
        <td>
            <input 
                type="url"
                name="ad_slider_link_url"
                id="ad_slider_link_url"
                class="regular-text link-url"
                value="<?php echo (isset($link_url)) ? esc_html($link_url): ''; ?>"
                required
            >
        </td>
    </tr>
    
</table>