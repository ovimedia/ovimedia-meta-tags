<?php
/*
Plugin Name: Ovimedia Meta Tags
Description: Plugin que genera meta tags en el sitio web.
Author: Ovi García - ovimedia.es
Author URI: http://www.ovimedia.es/
Text Domain: ovimedia_meta_tags
Version: 0.2
Plugin URI: http://www.ovimedia.es/
*/

if ( ! class_exists( 'ovimedia_meta_tags' ) ) 
{
	class ovimedia_meta_tags 
    {
        function __construct() 
        {   
            add_action( 'wp_head',  array( $this, 'wmt_add_tags') );
        }

        function wmt_add_tags()
        {
            global $post;

            $type = ucfirst($post->post_type);

            if($type == "Post") $type = "Article";

            $image = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'full' );
            $thumbnail = wp_get_attachment_image_src( get_post_thumbnail_id( $post->ID ), 'thumbnail' );

            $description =get_post_meta(get_the_ID(), '_yoast_wpseo_metadesc', true);
            $keywords = get_post_meta(get_the_ID(), '_yoast_wpseo_focuskw', true);
            ?>

            <!-- BEGIN Metadata Ovimedia Meta Tags plugin -->
            <?php if($description != ""){ ?><meta name="description" content=" <?php echo $description; ?>" /><?php } ?>

            <?php if($keywords != ""){?><meta name="keywords" content="<?php echo $keywords; ?>" /><?php } ?>

            <?php if($description != ""){ ?><meta name="dcterms:description" content=" <?php echo $description; ?>" /><?php } ?>

            <?php if($keywords != ""){?><meta name="dcterms:subject" content="<?php echo $keywords; ?>" /><?php } ?>
            
            <meta name="dcterms:title" content="<?php echo $post->post_title; ?>" />
            <meta name="dcterms:identifier" content="<?php echo get_permalink(); ?>" />
            <meta name="dcterms:creator" content="<?php echo get_the_author(); ?>" />
            <meta name="dcterms:created" content="<?php echo $post->post_date; ?>" />
            <meta name="dcterms:available" content="<?php echo $post->post_date; ?>" />
            <meta name="dcterms:modified" content="<?php echo $post->post_modified; ?>" />
            <meta name="dcterms:language" content="<?php echo get_bloginfo("language");  ?>" />
            <meta name="dcterms:publisher" content="<?php echo get_home_url(); ?>" />
            <meta name="dcterms:rights" content="<?php echo get_home_url(); ?>" />
            <meta name="dcterms:coverage" content="World" />
            <meta name="dcterms:type" content="Text" />
            <meta name="dcterms:format" content="<?php echo get_bloginfo("html_type"); ?>" />
            <link rel="publisher" type="text/html" title="<?php echo get_bloginfo(); ?>" href="<?php echo get_home_url(); ?>" />
            <link rel="author" type="text/html" title="<?php echo get_the_author(); ?>" href="<?php echo get_home_url(); ?>author/<?php echo get_the_author(); ?>/" />
            <script type="application/ld+json">
            {"@context":"http:\/\/schema.org","@type":"<? echo $type; ?>",
            "publisher":{"@type":"Organization","name":"<?php echo get_bloginfo(); ?>",
            "description":<?php echo json_encode(get_bloginfo('description')); ?>,
            "url":<?php echo json_encode(get_home_url()); ?>,"sameAs":[]},
            "author":{"@type":"Person",
            "name":<?php echo json_encode(get_the_author()); ?>,
            "image":[{"@type":"ImageObject",
            "url":<?php echo json_encode(get_avatar_url( get_the_author())); ?>,
            "contentUrl":<?php echo json_encode(get_avatar_url( get_the_author())); ?>,
            "width":"96",
            "height":"96"}],
            "url":<?php echo json_encode(get_home_url().'/author/'.get_the_author().'/'); ?> },
            "url":<?php echo json_encode(get_permalink()); ?>,
            "mainEntityOfPage":<?php echo json_encode(get_permalink()); ?>,
            "datePublished":"<?php echo $post->post_date; ?>",
            "dateModified":"<?php echo $post->post_modified; ?>",
            "copyrightYear":"<?php echo substr($post->post_modified,0,4); ?>",
            "inLanguage":"<?php echo get_bloginfo("language");  ?>",
            "name":<?php echo json_encode($post->post_title); ?>,
            "headline":<?php echo json_encode($post->post_title); ?>,
            "description": <?php echo json_encode($description); ?>,
            "articleSection":<?php echo json_encode(substr($postterms, 0, -1)); ?>,
            "keywords":<?php echo json_encode(substr($postterms, 0, -1)); ?>
            <?php if(get_the_post_thumbnail($post->ID) != ""){ ?>
            ,
            "image":[{"@type":"ImageObject",
            "name":<?php echo json_encode($post->post_title); ?>,
            "url":<?php echo json_encode($image[0]); ?>,
            "sameAs":<?php echo json_encode(get_permalink()); ?>,
            "thumbnailUrl":<?php echo json_encode($thumbnail[0]); ?>,
            "contentUrl":<?php echo json_encode($image[0]); ?>,
            "width": <?php echo json_encode($image[1]); ?>,"height": <?php echo json_encode($image[2]); ?>,
            "encodingFormat":"image\/<?php echo substr($image[0], strrpos($image[0], '.') + 1); ?>"}],
            "thumbnailUrl":<?php echo json_encode($thumbnail[0]); ?>

            <?php } ?>}
            </script>
            
            <!-- END Metadata Ovimedia Meta Tags plugin -->

            <?php
        }


    }
}

$GLOBALS['ovimedia_meta_tags'] = new ovimedia_meta_tags();   
    
?>
