<?php

class ImportProduct
{

    public function createNew($title, $content = '', $status = 'publish')
    {
        if (empty($title)) {
            die('Title not found');
        }

        $data = array(
            'post_title' => $title,
            'post_content' => $content,
            'post_status' => $status,
            'post_type' => 'product'
        );

        $product_id = wp_insert_post( $data );
        wp_set_object_terms( $product_id, 'simple', 'product_type' );
        return $product_id;
    }

    public static function deleteProduct($product_id)
    {
        $product = wc_get_product($product_id);
        $product->delete(true);
    }

    public function updateProductData($product_id, $data)
    {
        if(isset($data->sku) && !empty($data->sku)) {
            $this->updateSku($product_id, $data->sku);
        }

        if(isset($data->price) && !empty($data->price)) {
            $this->updatePrice($product_id, $data->price);
        }

        if(isset($data->in_stock) && !empty($data->in_stock)) {
            $this->updateStock($product_id, $data->in_stock);
        }

    }

    public function updateSku($product_id, $sku)
    {
        update_post_meta( $product_id, '_sku', $sku );
    }

    public function updatePrice($product_id, $price)
    {
        update_post_meta( $product_id, '_price', $price );
        update_post_meta( $product_id, '_regular_price', $price );
    }

    public function updateStock($product_id, $stock)
    {
        update_post_meta( $product_id, '_stock', $stock );
        if($stock > 0) {
            update_post_meta( $product_id, '_stock_status', 'instock');
        } else {
            update_post_meta( $product_id, '_stock_status', 'outofstock');
        }
    }
}