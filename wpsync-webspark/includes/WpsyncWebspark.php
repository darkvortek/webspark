<?php

class WpsyncWebspark {

	protected $loader;

	public function __construct() {
		$this->load_dependencies();
		$this->define_hooks();
	}

	private function load_dependencies() {

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/Loader.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'import/Import.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'import/src/ApiConnect.php';

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'import/src/ImportProduct.php';

		$this->loader = new Wpsync_Webspark_Loader();
	}

	private function define_hooks() {

        $import = new Import();

        $this->loader->add_action( 'admin_menu', $import, 'add_admin_page' );
        $this->loader->add_action( 'admin_post_nopriv_wpsync-webspark', $import, 'sync_products');
        $this->loader->add_action( 'admin_post_wpsync-webspark', $import, 'sync_products');
	}

	public function run() {
		$this->loader->run();
	}

}
