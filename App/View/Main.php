<?php
$args = array(
    'post_type' => 'product',
    'post_status' => 'publish',
    'posts_per_page' => -1,

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
                        <form method="post" id="product-form">
                            <ul id="product-list" class="un-order-list">
                                <?php foreach ($products as $product) :
                                    $buy_x_get_x_enabled = get_post_meta($product->ID, "_buy_x_get_x_enabled", true);
                                ?><li>
                                        <input type="checkbox" name="selected_products[]" class="bxgx-values" value="<?php echo $product->ID; ?>"<?php echo ($buy_x_get_x_enabled == 'yes') ? 'checked' : ''; ?>>
                                        <?php echo $product->post_title; ?>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                    </div>
                </div> </div>
                            <button type="submit" class="submit-btn"><?php echo esc_html__('Submit','buy-x-get-x');?></button>
                        </form>



        </div>
    </div>
</div>


</body>
</html>
