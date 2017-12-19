<?php
/**
 * The path to the WordPress tests
 */
$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

/**
 * When using Windows
 */
if ( strtolower( PHP_SHLIB_SUFFIX ) === 'dll' ) {
	$_tests_dir = 'C:\Apache24\tmp\wordpress-tests-lib';
}

/**
 * The WordPress tests functions.
 *
 * We are loading this so that we can add our tests filter
 * to load the plugin, using tests_add_filter().
 */
require_once $_tests_dir . '/includes/functions.php';

/**
 * Manually load the plugin main file.
 *
 * The plugin won't be activated within the test WP environment,
 * that's why we need to load it manually.
 *
 * You will also need to perform any installation necessary after
 * loading your plugin, since it won't be installed.
 */
function _manually_load_plugin() {
    require dirname( dirname( dirname( __FILE__ ) ) ) . '/zodiacpress/zodiacpress.php';
	require dirname( dirname( __FILE__ ) ) . '/zp-house-systems.php';
}
tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );
 
/**
 * Sets up the WordPress test environment.
 */
require $_tests_dir . '/includes/bootstrap.php';

// Activate core plugin, ZodiacPress
activate_plugin( 'zodiacpress/zodiacpress.php' );
// Install
ZodiacPress::activate( null );
global $zodiacpress_options;
$zodiacpress_options = get_option( 'zodiacpress_settings' );

// Activate ZP House Systems
activate_plugin( 'zp-house-systems/zp-house-systems.php' );
echo "Activated ZP House Systems........................\n";

// Include helper
require_once 'helper.php';