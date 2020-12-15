<?php

class Import {

    public function add_admin_page()
    {
        add_menu_page(
            'Product Sync',
            'Product Sync',
            'manage_options',
            'wpsync-webspark/import/partials/import-page.php'
        );
    }

    public function sync_products()
    {
        $errors = array();
        $success = array();
        $api = new ApiConnect;
        $get = $api->sendRequest('https://my.api.mockaroo.com/products.json?key=89b23a40');

        if( $get === false ){
            $errors[] = array(
                'message' => $api->getErrorMessage()
            );
        } else {
            $api_products = $api->getData();

            if (!empty($api_products)) {
                $updated_products = array();
                $new_products = array();
                $deleted_products = array();
                $old_products = get_posts(
                    array(
                        'post_type' => 'product',
                        'numberposts' => -1,
                        'post_status' => 'any'
                    )
                );
                $import_product = new ImportProduct();

                foreach ($api_products as $product_data) {
                    $product_id = wc_get_product_id_by_sku($product_data->sku);

                    if ( $product_id == 0 ) {
                        $product_id = $import_product->createNew($product_data->name, $product_data->description);
                        $new_products[] = $product_id;
                    } else {
                        $updated_products[] = $product_id;
                        foreach ($old_products as $key => $value) {
                            if ($value->ID == $product_id) {
                                unset($old_products[$key]);
                            }
                        }
                    }

                    $import_product->updateProductData($product_id, $product_data);

                    $img_id = media_sideload_image( $product_data->picture, $product_id, $product_data->name, 'id' );

                    if( is_wp_error($img_id) ){
                        $errors[] = array(
                            'message' => $img_id->get_error_message()
                        );
                    } else {
                        update_post_meta( $product_id, '_thumbnail_id', $img_id );
                    }
                }

                foreach ($old_products as $old_product) {
                    $deleted_products[] = $old_product->ID;
                    ImportProduct::deleteProduct($old_product->ID);
                }

                $success = array(
                    'created' => count($new_products),
                    'updated' => count($new_products),
                    'deleted' => count($deleted_products)
                );
            } else {
                $errors[] = array(
                    'message' => 'Products not found in request data'
                );
            }
        }

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'import/partials/import-end.php';
    }

}
