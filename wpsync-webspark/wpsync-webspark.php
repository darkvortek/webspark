<?php

/**
 * Plugin Name: Sync products for Woocommerce | Webspark
 * Description: Тестовое задание для Webspark
 * Version:           1.0.0
 * Author:            Anton Babichev
 * Author URI:        https://www.linkedin.com/in/anton-babichev/
 * Text Domain:       wpsync-webspark
 * Domain Path:       /languages
 */

if ( ! defined( 'WPINC' ) ) {
	die;
}

if ( !in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
    add_action( 'admin_notices', function() {
    	?>
    	<div class="notice notice-error is-dismissible">
			<p>Please install woocommerce</p>
		</div>
		<?php
		deactivate_plugins('wpsync-webspark/wpsync-webspark.php', true);
    });
}

require plugin_dir_path( __FILE__ ) . 'includes/WpsyncWebspark.php';

function wpsync_webspark_load() {
	$plugin = new WpsyncWebspark();
	$plugin->run();
}
wpsync_webspark_load();
