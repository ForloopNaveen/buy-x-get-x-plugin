<?php
$args = array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => -1,
    'meta_query' => array(
        'relation' => 'OR',
        array(
            'key' => '_buy_x_get_x_enabled',
            'compare' => 'NOT EXISTS',
        ),
        array(
            'key' => '_buy_x_get_x_enabled',
            'value' => 'no',
            'compare' => '='
        )
    )
);
$products = get_posts($args);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toggle Dropdown</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<div class="bxgx-container">
    <div class="notification"></div>
    <div class="bxgx-form-box">
        <div class="bxgx-navbar">
            <ul>
                <li id="menu-list1"><?php echo esc_html__('Select Buy-x-get-x products','buy-x-get-x');?></li>|
                <li id="menu-list2"><?php echo esc_html__('Unselect Buy-x-get-x products','buy-x-get-x'); ?></li>
            </ul>
            <hr/>
        </div>

        <div class="menu1" id="menu1">
            <div class="bxgx-input">
                <div class="input-title">
                    <span style="color: seagreen; font-weight: 500;"><?php echo esc_html__('Select the Free Product','buy-x-get-x');?></span>
                </div>
                <div class="wrapper" id="wrapper">
                    <div class="select-btn">
                        <span><?php echo esc_html__('Select Product','buy-x-get-x'); ?></span>
                        <i class='bx bx-chevron-down'></i>
                    </div>
                    <div class="content">
                        <div class="search">
                            <i class='bx bx-search-alt-2'></i>
                            <input type="text" placeholder="Search..." id="search">
                        </div>
                        <ul id="product-list" class="un-order-list">
                            <?php foreach ($products as $product) : ?>
                                <li class="bxgx-values" data-id="<?php echo $product->ID; ?>"><?php echo $product->post_title; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="display-products">
                <span style="color: seagreen; font-weight: 500;"><?php echo esc_html__('Selected Product','buy-x-get-x'); ?></span>
                <div class="selected-products">
                    <ul id="selected-product-list" class="un-order-list">
                        <!-- Selected products will appear here -->
                    </ul>
                </div>
            </div>
            <form method="post" id="product-form">
                <input type="hidden" name="selected_products" id="selected_products_input">
                <button type="submit" class="submit-btn"><?php echo esc_html__('Submit','buy-x-get-x');?></button>
            </form>
        </div>
        <?php
        $args = array(
            'post_type' => 'product',
            'post_status' => 'publish',
            'posts_per_page' => -1,
            'meta_query' => array(
                array(
                    'key' => '_buy_x_get_x_enabled',
                    'value' => 'yes',
                    'compare' => '='
                )
            )
        );
        $products = get_posts($args);
        ?>
        <div class="menu2" id="menu2" style="display:none;">
            <div class="bxgx-input">
                <div class="input-title">
                    <span style="color: crimson; font-weight: 500;"><?php echo esc_html__('Unselect the Free Product','buy-x-get-x');?></span>
                </div>
                <div class="wrapper" id="wrapper2">
                    <div class="select-btn">
                        <span><?php echo esc_html__('Unselect Product','buy-x-get-x');?></span>
                        <i class='bx bx-chevron-down'></i>
                    </div>
                    <div class="content">
                        <div class="search">
                            <i class='bx bx-search-alt-2'></i>
                            <input type="text" placeholder="Search..." id="search2">
                        </div>
                        <ul id="product-list2" class="un-order-list">
                            <?php foreach ($products as $product) : ?>
                                <li class="bxgx-values" data-id="<?php echo $product->ID; ?>"><?php echo $product->post_title; ?></li>
                            <?php endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="display-products">
                <span style="color: crimson; font-weight: 500;"><?php echo esc_html__('Unselected Products','buy-x-get-x')?></span>
                <div class="selected-products">
                    <ul id="selected-product-list2" class="un-order-list">
                        <!-- Unselected products will appear here -->
                    </ul>
                </div>
            </div>
            <form method="post" id="unselect-product-form">
                <input type="hidden" name="unselected_products" id="unselected_products_input">
                <button type="submit" class="submit-btn"><?php echo esc_html__('Unselect','buy-x-get-x');?></button>
            </form>
        </div>

    </div>

</body>
</html>
