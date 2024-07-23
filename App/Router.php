<?php


namespace Bxgx\App;

defined("ABSPATH") or die();

use Bxgx\App\Controller\Admin\Main;

class Router
{
    /**
     * This function contains all of our hooks to perform a certain task
     *
     */
    public function init()
    {
        add_action('admin_menu', [Main::class, 'addSubMenuInProductTab']);
        add_action('admin_enqueue_scripts', [Main::class, 'enqueueScriptsAndStyles']);
        add_action('wp_ajax_update_buy_x_get_x', [Main::class,'saveBuyxGetxProducts']);
        add_action('wp_ajax_nopriv_update_buy_x_get_x',[Main::class,'saveBuyxGetxProducts']);

        add_action('woocommerce_single_product_summary', [Main::class,'displayFreeProductMessageInFrontend'], 20);
        add_action('woocommerce_add_to_cart', [Main::class,'addFreeProductToCart'], 10, 3);
        add_action('woocommerce_before_calculate_totals',[Main::class, 'setFreeProductPriceToZero'], 10, 1);
        add_action('woocommerce_after_cart_item_quantity_update', [Main::class,'synchronizeFreeProductQuantity'], 10, 4);
        add_action('woocommerce_remove_cart_item', [Main::class,'removeFreeProductWhenMainRemoved'], 10, 2);
        add_filter('woocommerce_get_item_data', [Main::class, 'displayFreeProductInfo'], 10, 2);



    }
}
