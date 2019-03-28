<?php
/*
Template Name: Contact Us - Version 3
*/
/*****************************************************************************
*
*	copyright(c) - aonetheme.com - Service Finder Team
*	More Info: http://aonetheme.com/
*	Coder: Service Finder Team
*	Email: contact@aonetheme.com
*
******************************************************************************/
get_header();
?>

<div class="page-content">
<?php 
$subheader = service_finder_sub_header();
$pagesubheader = get_post_meta(get_the_id(), '_display_banner', true);
$service_finder_options = get_option('service_finder_options');
if($subheader):
if($pagesubheader){ 
?>
<?php
$image_name = 'banner-image';
if (class_exists('SERVICE_FINDER_MultiPostThumbnails')) {
if (SERVICE_FINDER_MultiPostThumbnails::has_post_thumbnail('page', $image_name)) { 
$image_id = SERVICE_FINDER_MultiPostThumbnails::get_post_thumbnail_id( 'page', $image_name, get_the_id() );
$banner_image_url = wp_get_attachment_image_src( $image_id,'full' );
}   
}
if(empty($banner_image_url[0])){
$bannerimg = service_finder_contactus_banner();  
}else{
$bannerimg = (!empty($banner_image_url[0])) ? $banner_image_url[0] : '';
}
?>
<?php 
if(!empty($bannerimg)){ 
$bgcolor = (!empty($service_finder_options['inner-banner-bg-color'])) ? $service_finder_options['inner-banner-bg-color'] : '';
$bgopacity = (!empty($service_finder_options['inner-banner-opacity'])) ? $service_finder_options['inner-banner-opacity'] : '';
?>
<!-- inner page banner -->
<div class="banner-contact-row sf-overlay-wrapper" style="background-image:url(<?php echo esc_url($bannerimg); ?>)">
<div class="container text-white">
<h1>
<?php esc_html_e('Contact Us', 'service-finder'); ?>
</h1>
</div>
<div class="sf-overlay-main" style="opacity:<?php echo $bgopacity ?>; background-color:<?php echo $bgcolor ?>;"></div>
</div>
<?php 
}
}
?>
<!-- inner page banner END -->
<?php endif; ?>
<?php require get_template_directory() . '/lib/breadcrumb.php'; //Breadcrumb ?>
<!-- contact area -->
<div class="container">
<div class="section-content">
<div class="row">
<!-- Location map start-->
<div class="col-md-12">
<h4>
<?php esc_html_e('Our Location', 'service-finder'); ?>
</h4>
<div class="padding-10 bg-white margin-b-30 sf-rouned-box">
<div class='gmap-outer contact-area-bx'>
<?php
	$address = (!empty($service_finder_options['address'])) ? $service_finder_options['address'] : '';
	if(!empty($address)){
	$address = strip_tags($address, '<br>');
	$address = str_replace("\n","",$address);
	$address = str_replace(" ","+",$address);
	$address = str_replace(",","",$address);
	$address = preg_replace('/\s+/', '', $address);
	
	$res = service_finder_getLatLong_for_theme($address);
	$lat = (!empty($res['lat'])) ? $res['lat'] : '';
	$lng = (!empty($res['lng'])) ? $res['lng'] : '';
	$zoom_level = (!empty($service_finder_options['zoom-level'])) ? $service_finder_options['zoom-level'] : 14;
	
	if(!empty($providerInfo->avatar_id) && $providerInfo->avatar_id > 0){
		$src  = wp_get_attachment_image_src( $providerInfo->avatar_id, 'service_finder-provider-thumb' );
		$src  = $src[0];
	}else{
		$src  = '';
	}
	
	$icon = (!empty($service_finder_options['default-map-marker-icon']['url'])) ? $service_finder_options['default-map-marker-icon']['url'] : '';
	
	$markeraddress = $address;
	
	$marker = '[\"'.get_bloginfo('name').'\",\"'.esc_html($lat).'\",\"'.esc_html($lng).'\",\"'.esc_url($src).'\",\"'.esc_url($icon).'\",\"\",\"\",\"\",\"'.esc_html($markeraddress).'\",\"\"]';
	
	}else{
	$lat = '28.6430536';
	$lng = '77.2223442';
	$zoom_level = 2;
	$marker = '';
	}
	
	
	wp_add_inline_script( 'service_finder-js-theme-gmapfunctions', '/*Define global variable*/
var googlecode_regular_vars = {"general_latitude":"'.esc_js($lat).'", "general_longitude":"'.esc_js($lng).'","path":"","markers":"['.$marker.']","idx_status":"0","page_custom_zoom":"'.esc_js($zoom_level).'","generated_pins":"0","scrollwheel":false}; jQuery(document).ready(function($) {
						initializeSearchMap("no");
						});', 'before' );

	echo service_finder_contactmap($lat,$lng,'350px','100%',$address);
	?>
</div>
</div>
</div>
<!-- Location map end-->
<!-- contact form start-->
<div class="col-md-9">
<h4>
<?php echo get_the_title(); ?>
</h4>
<div class="padding-30 bg-white clearfix margin-b-30 sf-rouned-box">
<?php while ( have_posts() ) : the_post(); ?>
<?php the_content(); ?>
<?php endwhile; ?>
<?php echo do_shortcode('[service-finder-contactus]');?>
</div>
</div>
<!-- contact form end-->
<!-- contact info start-->
<div class="col-md-3">
<h4>
<?php esc_html_e('Contact Info', 'service-finder'); ?>
</h4>
<div class="padding-30 bg-white margin-b-30 sf-rouned-box">
<ul class="contact-info no-margin">
<li> <i class="fa fa-map-marker"></i>
<h6>
  <?php esc_html_e('Address', 'service-finder'); ?>
</h6>
<p><?php echo (!empty($service_finder_options['address'])) ? $service_finder_options['address'] : ''; ?></p>
</li>
<li> <i class="fa fa-envelope"></i>
<h6>
  <?php esc_html_e('EMAIl', 'service-finder'); ?>
</h6>
<p><?php echo (!empty($service_finder_options['email'])) ? $service_finder_options['email'] : ''; ?></p>
</li>
<li> <i class="fa fa-phone"></i>
<h6>
  <?php esc_html_e('PHONE', 'service-finder'); ?>
</h6>
<p><?php echo (!empty($service_finder_options['phone'])) ? $service_finder_options['phone'] : ''; ?></p>
</li>
</ul>
<br>
</div>
</div>
<!-- contact info end-->
</div>
</div>
</div>
<!-- contact area  END -->
</div>
<?php get_footer(); ?>
