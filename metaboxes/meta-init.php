<?php

/**
 * Add Metaboxes
 * @param array $meta_boxes
 * @return array 
 */
function ale_metaboxes($meta_boxes) {
	
	$meta_boxes = array();

    $prefix = "ale_";

    $meta_boxes[] = array(
        'id'         => 'pages_metabox',
        'title'      => esc_html__('Pages Settings','ale'),
        'pages'      => array( 'page' ), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields' => array(

            array(
                'name' => esc_html__('Select icon for heading','ale'),
                'desc' => esc_html__('Select custom icon for page heading','ale'),
                'id'   => $prefix . 'post_heading_icon',
                'type'    => 'select',
                'options' => array(
                    array( 'name' => esc_html__('Sun Icon','ale'), 'value' => 'sun', ),
                    array( 'name' => esc_html__('Map Icon','ale'), 'value' => 'map', ),
                    array( 'name' => esc_html__('Sale Icon','ale'), 'value' => 'sale', ),
                    array( 'name' => esc_html__('Gallery Icon','ale'), 'value' => 'gallery', ),
                    array( 'name' => esc_html__('Feather Icon','ale'), 'value' => 'feather', ),
                ),
            ),
				)
    );

    $meta_boxes[] = array(
        'id'         => 'posts_metabox',
        'title'      => esc_html__('Posts Settings','ale'),
        'pages'      => array( 'post' ), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields' => array(

            array(
                'name' => esc_html__('Video Link for Video  Format Post','ale'),
                'desc' => esc_html__('Specify a video link','ale'),
                'id'   => $prefix . 'video_link',
                'type'    => 'text',
            ),
				)
    );

    $meta_boxes[] = array(
        'id'         => 'galleries_metabox',
        'title'      => esc_html__('Gallery Settings','ale'),
        'pages'      => array( 'galleries' ), // Post type
        'context'    => 'normal',
        'priority'   => 'high',
        'show_names' => true, // Show field names on the left
        'fields' => array(

            array(
                'name' => esc_html__('Author','ale'),
                'desc' => esc_html__('Specify the Author','ale'),
                'id'   => $prefix . 'author',
                'type'    => 'text',
            ),
            array(
                'name' => esc_html__('Year','ale'),
                'desc' => esc_html__('Specify the Year','ale'),
                'id'   => $prefix . 'year',
                'type'    => 'text',
            ),
            array(
                'name' => esc_html__('Location','ale'),
                'desc' => esc_html__('Specify the Location','ale'),
                'id'   => $prefix . 'location',
                'type'    => 'text',
            ),
				)
    );

    
	return $meta_boxes;
}