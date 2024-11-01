<?php
/*
Plugin Name: WooCommerce Product Grids
Plugin URI: https://worldclassthemes.com
Description: Add Beautiful Responsive Grids to your WooCommerce Website Pages.
Version: 2.3
Author: Suhail Ahmad
Author URI: https://worldclassthemes.com
*/



function wct_enqueue_scripts() 
{
    wp_enqueue_style( 'myCSS', plugins_url( '/wct_grid_assets/wct_core.css', __FILE__ ) );
	wp_enqueue_style( 'myCSS2', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );
}

add_action('admin_enqueue_scripts', 'wct_enqueue_scripts');


// create custom plugin settings menu
add_action('admin_menu', 'wct_grid_plugin_menu');

function wct_grid_plugin_menu() {

	//create new top-level menu
	add_menu_page('Add beautiful grids to WooCommerce Products', 'WooCommerce Grid', 'administrator', __FILE__, 'wct_grid_plugin_page' );

	//call register settings function
	add_action( 'admin_init', 'register_wct_grid_plugin' );
}


function register_wct_grid_plugin() {
	//register our settings
	register_setting( 'wct-grid-plugin-settings-group', 'cat' );
	register_setting( 'wct-grid-plugin-settings-group', 'tag_color' );
	register_setting( 'wct-grid-plugin-settings-group', 'add_to_cart_1_color' );
	register_setting( 'wct-grid-plugin-settings-group', 'add_to_cart_2_color' );
	register_setting( 'wct-grid-plugin-settings-group', 'view_1_color' );
	register_setting( 'wct-grid-plugin-settings-group', 'view_2_color' );
	register_setting( 'wct-grid-plugin-settings-group', 'product_title_color' );
	register_setting( 'wct-grid-plugin-settings-group', 'font_color' );
	register_setting( 'wct-grid-plugin-settings-group', 'num_prod' );
	register_setting( 'wct-grid-plugin-settings-group', 'title_size' );
	register_setting( 'wct-grid-plugin-settings-group', 'option_etc' );
}

function wct_grid_plugin_page() {
	
	wp_enqueue_script( 'js-color', plugins_url( '/js-color/jscolor.js', __FILE__ ) );
	
	$args = array(
		'type'                     => 'product',
		'child_of'                 => 0,
		'parent'                   => '',
		'orderby'                  => 'name',
		'order'                    => 'ASC',
		'hide_empty'               => 0,
		'hierarchical'             => 1,
		'exclude'                  => '',
		'include'                  => '',
		'number'                   => '',
		'taxonomy'                 => 'product_cat',
		'pad_counts'               => false 
	
	); 
	
	$cats = get_categories( $args );
	
	global $wpdb;
	
	/*$query = mysql_query("SELECT DISTINCT meta_key FROM $wpdb->postmeta ");
	
	while($row = mysql_fetch_assoc($query)){
		$meta_keys[] = $row['meta_key'];
	}
	
	$query2 = mysql_query("SELECT DISTINCT post_type FROM $wpdb->posts ");
	
	while($row = mysql_fetch_assoc($query2)){
		$post_types[] = $row['post_type'];
	}*/
	
	/*while($wpdb->get_row("SELECT DISTINCT meta_key FROM $wpdb->postmeta ", 'ARRAY_A')){
		
	}*/
	
	/*echo "<pre>";
	print_r($meta_keys);
	echo "</pre>";*/
	
	?>
    
    
    
    <h1>Shortcode</h1>
    
    <p>Use this shortcode to to show the WCT Grid on any of your page.</p>
    <input value="[wct_grid]" type="text" />
    
    <br /><br /><br />
    <form method="post" action="options.php">
    
    <?php settings_fields( 'wct-grid-plugin-settings-group' ); ?>
    <?php do_settings_sections( 'wct-grid-plugin-settings-group' ); ?>
    
    <label>Please select the product category which you want to show</label><br />
    <select name="cat" id="cat_cat" >
    	<option value="0">All Cats</option>
		<?php
        foreach($cats as $cat){?>
        <option value="<?php echo $cat->cat_ID;?>::::<?php echo $cat->name;?>" <?php if(get_option('cat')==$cat->cat_ID."::::".$cat->name){ echo "selected"; } ?> ><?php echo $cat->name;?></option>
        <?php } ?>
    </select><br /><br />
    Number of products: <input name="num_prod" type="number" value="<?php if(get_option('num_prod')!=NULL){ echo esc_attr( get_option('num_prod') ); } else { echo "10"; } ?>"><br /><br />
    Title Font Size: <input name="title_size" type="number" value="<?php if(get_option('title_size')!=NULL){ echo esc_attr( get_option('title_size') ); } else { echo "20"; } ?>"><br /><br />
    Category Tag Color: <input name="tag_color" class="jscolor" value="<?php if(get_option('tag_color')!=NULL){ echo esc_attr( get_option('tag_color') ); } else { echo "0066FF"; } ?>"><br /><br />
    Add to cart button Color: <input name="add_to_cart_1_color" class="jscolor" value="<?php if(get_option('add_to_cart_1_color')!=NULL){ echo esc_attr( get_option('add_to_cart_1_color') ); } else { echo "060"; } ?>"> to <input name="add_to_cart_2_color" class="jscolor" value="<?php if(get_option('add_to_cart_2_color')!=NULL){ echo esc_attr( get_option('add_to_cart_2_color') ); } else { echo "090"; } ?>"><br /><br />
    View product button Color: <input name="view_1_color" class="jscolor" value="<?php if(get_option('view_1_color')!=NULL){ echo esc_attr( get_option('view_1_color') ); } else { echo "999"; } ?>"> to <input name="view_2_color" class="jscolor" value="<?php if(get_option('view_2_color')!=NULL){ echo esc_attr( get_option('view_2_color') ); } else { echo "ccc"; } ?>"><br /><br />
	Product Title Color: <input name="product_title_color" class="jscolor" value="<?php if(get_option('product_title_color')!=NULL){ echo esc_attr( get_option('product_title_color') ); } else { echo "fff"; } ?>"><br /><br />
    Font Color: <input name="font_color" class="jscolor" value="<?php if(get_option('font_color')!=NULL){ echo esc_attr( get_option('font_color') ); } else { echo "fff"; } ?>">
    
    
    <?php submit_button(); ?>
    
	</form>
    
    
<?php

} 

function wct_dynamic_grid(){

wp_enqueue_style( 'myCSS', plugins_url( '/wct_grid_assets/wct_core.css', __FILE__ ) );
wp_enqueue_style( 'myCSS2', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.6.3/css/font-awesome.min.css' );

?>

<?php

$cats =  esc_attr( get_option('cat') );

$category = explode("::::", $cats);

$cat_name = $category[1];
$cat_id = $category[0];

//echo $cats;
//echo $cat_id;
//echo $cat_name;

$paged = get_query_var( 'page', 1 );

//echo $paged;

$posts_per_page = get_option('posts_per_page');

if($paged==1){
	
	$offset=0;
	
} else {
	$offset = ($paged*$posts_per_page)-$posts_per_page;
}

//echo $offset;

$args = array(
						'posts_per_page'   => get_option('num_prod'),
						'offset'           => 0,
						'category'         => '',
						'category_name'    => '',
						'orderby'          => 'date',
						'order'            => 'ASC',
						'include'          => '',
						'exclude'          => '',
						'meta_key'         => '',
						'meta_value'       => '',
						'post_type'        => 'product',
						'product_cat'			=> $cat_name,
						'post_mime_type'   => '',
						'post_parent'      => '',
						'author'	   => '',
						'post_status'      => 'publish',
						'suppress_filters' => true 
					);
		$products = get_posts( $args );
        
//print_r($products);
?>

<?php if(!empty($products)){ ?>

<div class="wct_grid_container">
	<div class="wct_grid_row">
    
    <?php foreach($products as $prod){ ?>
    
    	<?php 
		
		$thumb = get_the_post_thumbnail($prod->ID, "large");
		
		$thumb1 = explode("src=\"", $thumb);
		$thumb2 = explode("\"", $thumb1[1]);
		
		$thumbnail = $thumb2[0];
		
		$terms = get_the_terms( $prod->ID, 'product_cat' );
		
		$category = $terms[0];
		
		$_product = wc_get_product( $prod->ID );
		
		//echo "<pre>";
		//print_r($_product);
		//echo "</pre>";
		
		$regular_price = $_product->get_regular_price();
		$sale_price = $_product->get_sale_price();
		$price = $_product->get_price();
		$rating = $_product->get_average_rating();
		$currency = get_woocommerce_currency_symbol();
		
		
		
		//echo $rating;
		
		?>
    
    	<div class="wct_grid_col_xs_12 wct_grid_col_sm_6 wct_grid_col_md_4 wct_grid_col_lg_4">
        	<div class="wct_product" style="background-image:url(<?php echo $thumbnail; ?>);">
            	<?php if($rating>=1){ ?><div class="wct_rating wct_<?php echo $rating; ?>_star"></div><?php } ?>
            	<div class="wct_product_title"><?php echo $prod->post_title; ?> <br /><br /><p class="price"> <span class="not-price"><?php echo $currency.$regular_price; ?> </span> <?php echo $currency.$sale_price; ?></p></div>
                <a class="wct_btn wct_btn_green wct_add_to_cart" href="<?php echo site_url(); ?>?add-to-cart=<?php echo $prod->ID; ?>"><i class="fa fa-cart-plus"></i> </a>
                <!--<a class="wct_btn wct_btn_grey wct_compare compare" data-product_id="<?php echo $prod->ID; ?>" href="<?php echo site_url(); ?>?action=yith-woocompare-add-product&id=<?php echo $prod->ID; ?>"><i class="fa fa-refresh"></i> </a>-->
                <a class="wct_btn wct_btn_grey wct_product_view" href="<?php echo get_the_permalink($prod->ID); ?>"><i class="fa fa-eye"></i> </a>
                
                <?php if(!empty($category->name)){ ?><span class="sale_tag"><?php echo $category->name; ?></span><?php } ?>
            </div>
        </div>
        
    <?php } ?>       
        
    </div>
</div>

<!--<div class="wct_grid_col_xs_12 wct_grid_col_sm_12 wct_grid_col_md_12 wct_grid_col_lg_12">

    <?php //wct_pagination($offset, $paged); ?>

</div>-->

<style>

	.sale_tag {
		color:#<?php echo get_option('font_color'); ?> !important;
		background: #<?php echo get_option('tag_color'); ?> !important;
	}
	.wct_add_to_cart {
		color:#<?php echo get_option('font_color'); ?> !important;
		background: #<?php echo get_option('add_to_cart_1_color'); ?> !important; /* For browsers that do not support gradients */
		background: -webkit-linear-gradient(top, #<?php echo get_option('add_to_cart_1_color'); ?>, #<?php echo get_option('add_to_cart_2_color'); ?>) !important; /* For Safari 5.1 to 6.0 */
		background: -o-linear-gradient(bottom, #<?php echo get_option('add_to_cart_1_color'); ?>, #<?php echo get_option('add_to_cart_2_color'); ?>) !important; /* For Opera 11.1 to 12.0 */
		background: -moz-linear-gradient(bottom, #<?php echo get_option('add_to_cart_1_color'); ?>, #<?php echo get_option('add_to_cart_2_color'); ?>) !important; /* For Firefox 3.6 to 15 */
		background: linear-gradient(to bottom, #<?php echo get_option('add_to_cart_1_color'); ?>, #<?php echo get_option('add_to_cart_2_color'); ?>) !important;
	}
	
	.wct_product_view {
		color:#<?php echo get_option('font_color'); ?> !important;
		background: #<?php echo get_option('view_1_color'); ?> !important; /* For browsers that do not support gradients */
		background: -webkit-linear-gradient(top, #<?php echo get_option('view_1_color'); ?>, #<?php echo get_option('view_2_color'); ?>) !important; /* For Safari 5.1 to 6.0 */
		background: -o-linear-gradient(bottom, #<?php echo get_option('view_1_color'); ?>, #<?php echo get_option('view_2_color'); ?>) !important; /* For Opera 11.1 to 12.0 */
		background: -moz-linear-gradient(bottom, #<?php echo get_option('view_1_color'); ?>, #<?php echo get_option('view_2_color'); ?>) !important; /* For Firefox 3.6 to 15 */
		background: linear-gradient(to bottom, #<?php echo get_option('view_1_color'); ?>, #<?php echo get_option('view_2_color'); ?>) !important;
	}
	
	.wct_product_title {
		font-size: <?php echo get_option('title_size'); ?>px !important; 
	}
	
</style>

<?php } else { ?>

<h2>No products to show </h2>

<?php } ?>

<?php

}

add_shortcode( 'wct_grid', 'wct_dynamic_grid' );


function wct_pagination($offset, $paged) {
	?>
    <div class="wct_pagination">
        <?php if($paged>1){ ?><a href="<?php echo get_permalink(); ?>/page/<?php echo $paged-1; ?>"><span>Prev</span></a><?php } ?>
        <!--<span class="active">1</span>
       	<a href=""><span>2</span></a>
        <span>...</span>
        <a href=""><span>10</span></a>-->
        <a href="<?php echo get_permalink(); ?>/page/<?php echo $paged+1; ?>"><span>Next</span></a>
    </div>
    <?php
}