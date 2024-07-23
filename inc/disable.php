<?php 
/**
 * Reinforce security and sustainability by disabling some (never used) WordPress features.
 *
 * @return void
 */


// MARK: Comments

// Disable comments feeds.

/**
 * Redirects all feeds to home page.
 *
 * @since 1.0.0
 */
function ubu_disable_feeds(): void {
	wp_safe_redirect( home_url() );
}

add_action( 'do_feed_rss2_comments', 'ubu_disable_feeds', 1 );
add_action( 'do_feed_atom_comments', 'ubu_disable_feeds', 1 );

// Disable comments.

add_filter( 'comments_open', '__return_false' );


// Disable XML RPC for security.
add_filter( 'xmlrpc_enabled', '__return_false' );
add_filter( 'xmlrpc_methods', '__return_false' );
remove_action( 'wp_head', 'rsd_link' );

// Remove WordPress version.
remove_action( 'wp_head', 'wp_generator' );

// Remove meta rel=dns-prefetch href=//s.w.org.
remove_action( 'wp_head', 'wp_resource_hints', 2 );

// Remove relational links for the posts.
remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );

// Remove REST API link tag from <head>.
remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );

// Remove REST API link tag from HTML headers.
remove_action( 'template_redirect', 'rest_output_link_header', 11 );

// Remove shortlink tag from <head>.
remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );

// Remove shortlink tag from HTML headers.
remove_action( 'template_redirect', 'wp_shortlink_header', 11 );



// MARK: Users

/**
 * Disable default users API endpoints for security.
 * https://www.wp-tweaks.com/hackers-can-find-your-wordpress-username/
 *
 * @param array $endpoints List of endpoints.
 * @return array
 *
 * @since 1.0.0
 */
function ubu_disable_rest_endpoints( array $endpoints ): array {
	if ( ! is_user_logged_in() ) {
		if ( isset( $endpoints['/wp/v2/users'] ) ) {
			unset( $endpoints['/wp/v2/users'] );
		}

		if ( isset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] ) ) {
			unset( $endpoints['/wp/v2/users/(?P<id>[\d]+)'] );
		}
	}

	return $endpoints;
}
add_filter( 'rest_endpoints', 'ubu_disable_rest_endpoints' );


/**
 * Remove contributor, subscriber and author roles.
 *
 * @since 1.0.0
 */
function ubu_disable_remove_roles(): void {
	// remove_role( 'author' );
	remove_role( 'contributor' );
	remove_role( 'subscriber' );
}
add_action( 'init', 'ubu_disable_remove_roles' );

