<?php
/**
 * Single view Job meta box
 *
 * Hooked into single_job_listing_start priority 20
 *
 * @since  1.14.0
 */
global $post;
if(get_option('timezone_string') != ""){
date_default_timezone_set(get_option('timezone_string'));
}
do_action( 'single_job_listing_meta_before' ); ?>

<ul class="job-listing-meta meta">
	<?php do_action( 'single_job_listing_meta_start' ); ?>

	<?php if ( get_option( 'job_manager_enable_types' ) ) { ?>
		<?php if ( function_exists( 'wpjm_get_the_job_types' ) ){ ?>
		<?php $types = wpjm_get_the_job_types(); ?>
		<?php if ( ! empty( $types ) ) : foreach ( $types as $type ) : ?>

			<li class="job-type <?php echo esc_attr( sanitize_title( $type->slug ) ); ?>" itemprop="employmentType"><?php echo esc_html( $type->name ); ?></li>

		<?php endforeach; endif; ?>
        <?php } ?>
	<?php } ?>

	<li class="location" itemprop="jobLocation"><?php the_job_location(); ?></li>

	<li class="date-posted" itemprop="datePosted"><date><?php printf( __( 'Posted %s ago', 'service-finder' ), human_time_diff( get_post_time( 'U' ), time() ) ); ?></date></li>

	<?php if ( is_position_filled() ) : ?>
		<li class="position-filled"><?php _e( 'This position has been filled', 'service-finder' ); ?></li>
	<?php elseif ( ! candidates_can_apply() && 'preview' !== $post->post_status ) : ?>
		<li class="listing-expired"><?php _e( 'Applications have closed', 'service-finder' ); ?></li>
	<?php endif; ?>

	<?php do_action( 'single_job_listing_meta_end' ); ?>
</ul>

<?php do_action( 'single_job_listing_meta_after' ); ?>
