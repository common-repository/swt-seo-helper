<?php
/**
 * Plugin Name: SWT SEO HELPER
 * Plugin URI: http://www.phpkida.com/swt-seo-helper
 * Description: The first complete free all in one SEO solution for WordPress websites, including home page, archive pages, single post page etc. you can also set custome keywords, social media links for your hole website, also supporting open graph meta data (OG) and twitter meta data etc.
 * Version: 1.0
 * Author: Mukesh Jakhar
 * Author URI: http://www.phpkida.com/mukesh-jakhar-wordpress-php-web-developer-and-designer/
 * Text Domain: swt-seo-helper
 * License: GPL2
**/



define('URL_CONTACTUSFORM', plugins_url(plugin_basename(dirname(__FILE__))));

// create database for save custome keywords
register_activation_hook( __FILE__, 'swtsh_create_db' );
function swtsh_create_db() {
	global $wpdb;
	$charset_collate = $wpdb->get_charset_collate();
	$swtsh_table_name = $wpdb->prefix . "swt_seo"; 
	$swtsh_sql = "CREATE TABLE IF NOT EXISTS $swtsh_table_name (
	  id int(11) NOT NULL AUTO_INCREMENT,
	  comman_keywords text NOT NULL,
	  home_title varchar(100) NOT NULL,
	  home_keywords text NOT NULL,
	  home_description varchar(200) NOT NULL,
	  home_og_image varchar(200) NOT NULL,
	  archive_title varchar(100) NOT NULL,
	  archive_keywords text NOT NULL,
	  archive_description varchar(200) NOT NULL,
	  facebook varchar(100) NOT NULL,
	  twitter varchar(100) NOT NULL,
	  google_plus varchar(100) NOT NULL,
	  type varchar(50) NOT NULL,
	  PRIMARY KEY id (id)
	) $charset_collate;";
	
	$wpdb->query( $swtsh_sql );
}	
	
	// Hook for adding admin menus
	add_action('admin_menu', 'swtsh_add_seo_menu');
	// action function for above hook
	function swtsh_add_seo_menu() {
		// Add a new top-level menu (ill-advised):
		add_menu_page('WP SEO','WP SEO', 'manage_options', 'seo-setting', 'swtsh_seo_menu_link');
	}
	// mt_toplevel_page() displays the page content for the custom Test Toplevel menu
	function swtsh_seo_menu_link() {
	   include dirname( __FILE__ )  . '/seo_dashboard.php';
	}
	


add_action( 'wp_head', 'swtsh_show_metadata' );

function swtsh_show_metadata() {

	global $wpdb;
	$swtsh_table_name = $wpdb->prefix . "swt_seo";	
	$swtsh_fetch_res = $wpdb->get_row("select  * from $swtsh_table_name where type='seo' limit 1");
	// showing seo data for a single page
	if(is_single())
	{
		$swtsh_postid = get_query_var("p");
		$swtsh_post = get_post($swtsh_postid);
		$swtsh_seo_description = substr(strip_tags($swtsh_post->post_content),0,160);
		
echo ("\n\n\n<!---------------    THIS WEBSITE USING SWT SEO HELPER WORDPRESS PLUGIN   ---------------> \n");

		$swtsh_my_posttags = get_the_tags();
		$swtsh_my_all_tags="";
		if (is_array($swtsh_my_posttags)){ foreach($swtsh_my_posttags as $swtsh_my_tag){$swtsh_my_all_tags.=$swtsh_my_tag->name.", "; }}

		//$swtsh_postcat = get_post();
		$swtsh_all_categories_tag="";
		$swtsh_postcat = get_the_category($swtsh_post->ID);
		
		$swtsh_catlist = get_the_category($swtsh_post->ID);
		if (is_array($swtsh_catlist)) { foreach ($swtsh_catlist as $swtsh_catlist) { $swtsh_all_categories_tag .= ", ".$swtsh_catlist->name;	}}
		$swtsh_taglist = get_the_tags($swtsh_post->ID);
		if (is_array($swtsh_taglist)) { foreach ($swtsh_taglist as $taglist) {	$swtsh_all_categories_tag .= ", ".$swtsh_taglist->name; }}
		
		?>
		
<title><?php the_title(); ?> - <?php echo get_bloginfo();?></title>
<meta name="description" content="<?php echo $swtsh_seo_description; ?>"/>
<meta name="keywords" content="<?php echo swtsh_all_categories_tag;?> <?php echo $swtsh_fetch_res->comman_keywords;?>"/>
<?php
$swtsh_taglist = get_the_tags($swtsh_post->ID);
if (is_array($swtsh_taglist)){foreach ($swtsh_taglist as $swtsh_taglist){
echo '<meta property="article:tag" content="'.$swtsh_taglist->name.'" />'; 
echo "\n";}}
?>
<?php
$swtsh_catlist = get_the_category($swtsh_post->ID);
if (is_array($swtsh_catlist)){foreach ($swtsh_catlist as $swtsh_catlist){
echo '<meta property="article:section" content="'.$swtsh_catlist->name.'" />';
echo ("\n");}}
?>

<meta property="og:title" content="<?php the_title(); ?>" />
<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>" />
<meta property="og:url" content="<?php the_permalink(); ?>" />
<meta property="og:description" content="<?php echo $swtsh_seo_description; ?>" />
<meta property="og:type" content="article" />
<meta property="og:locale" content="<?php echo get_locale(); ?>" />
<?php 
if ( has_post_thumbnail()) :
	$swtsh_post_image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'large' ); 
?>
<meta property="og:image" content="<?php echo $swtsh_post_image[0]; ?>"/>
<?php endif; ?>
<meta name="twitter:card" value="summary" />
<meta name="twitter:url" value="<?php the_permalink(); ?>" />
<meta name="twitter:title" value="<?php the_title(); ?>" />
<meta name="twitter:description" value="<?php echo $swtsh_seo_description; ?>" />
<meta name="twitter:image" value="<?php echo $swtsh_post_image[0]; ?>" />
<meta name="twitter:site" value="<?php echo $swtsh_fetch_res->twitter;?>" />

<meta name="robots" content="noodp"/>
<meta property="article:publisher" content="<?php echo $swtsh_fetch_res->facebook;?>" />
<meta property="article:author" content="<?php echo get_the_author(); ?>" />
<meta property="article:published_time" content="<?php echo get_the_modified_date();?>" />
<meta name="twitter:creator" content="<?php echo $swtsh_fetch_res->twitter;?>" />
<meta name="twitter:site" content="<?php echo $swtsh_fetch_res->twitter;?>" />
<meta property="DC.date.issued" content="<?php echo get_the_modified_date();?>" />
	<?php
echo "<!---------------    THIS WEBSITE USING SWT SEO HELPER WORDPRESS PLUGIN    ---------------> \n\n\n";
	}
	?>
<?php
	// Seo For Home Page
	if ( is_home() || is_front_page() ) {

echo ("\n\n\n<!---------------    THIS WEBSITE USING SWT SEO HELPER WORDPRESS PLUGIN    ---------------> \n");
	?>
<title> <?php echo $swtsh_fetch_res->home_title;?> </title>
<meta name="description" content="<?php echo $swtsh_fetch_res->home_description;?>"/>
<meta name="keywords" content="<?php echo $swtsh_fetch_res->home_keywords;?>"/>
<meta name="robots" content="noodp"/>
<link rel="canonical" href="<?php the_permalink(); ?>" />
<link rel="publisher" href="<?php echo $swtsh_fetch_res->google_plus;?>"/>


<meta property="og:title" content="<?php echo $swtsh_fetch_res->home_title;?>" />
<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>" />
<meta property="og:url" content="<?php the_permalink(); ?>" />
<meta property="og:description" content="<?php echo $swtsh_fetch_res->home_description;?>" />
<meta property="og:type" content="article" />
<meta property="og:image" content="<?php echo $swtsh_fetch_res->home_og_image;?>"/>
<meta property="og:locale" content="<?php language_attributes(); ?>" />
<meta property="article:publisher" content="<?php echo $swtsh_fetch_res->facebook;?>" />

<meta name="twitter:card" value="summary" />
<meta name="twitter:url" value="<?php the_permalink(); ?>" />
<meta name="twitter:title" value="<?php echo $swtsh_fetch_res->home_title;?>" />
<meta name="twitter:description" value="<?php echo $swtsh_fetch_res->home_description;?>" />
<meta name="twitter:image" value="<?php echo $swtsh_fetch_res->home_og_image;?>" />

<meta name="twitter:site" value="<?php echo $swtsh_fetch_res->twitter;?>" />
<meta name="twitter:creator" content="<?php echo $swtsh_fetch_res->twitter;?>" />

<?php
echo "<!---------------    THIS WEBSITE USING SWT SEO HELPER WORDPRESS PLUGIN    ---------------> \n\n\n";
	}
	// end home page or front page


	// Seo For Archive Page
	if ( is_archive() ) {
	/*global $wpdb;
	$table_name = $wpdb->prefix . "swt_seo";
	$archive_seo = $wpdb->get_row("select  * from $table_name where type='seo' limit 1");*/

echo ("\n\n\n<!---------------    THIS WEBSITE USING SWT SEO HELPER WORDPRESS PLUGIN    ---------------> \n");
		if (is_category()) {
		?>
<title><?php echo $swtsh_fetch_res->archive_title;?> - <?php echo single_cat_title();?></title>;
<meta name="description" content="<?php echo $swtsh_fetch_res->archive_description;?>"/>
<meta name="keywords" content="<?php echo $swtsh_fetch_res->archive_keywords;?>"/>
<meta name="robots" content="noodp"/>
<link rel="canonical" href="<?php the_permalink(); ?>" />
<link rel="publisher" href="<?php echo $swtsh_fetch_res->google_plus;?>"/>


<meta property="og:title" content="<?php echo $swtsh_fetch_res->archive_title;?> - <?php echo single_cat_title();?>" />
<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>" />
<meta property="og:url" content="<?php the_permalink(); ?>" />
<meta property="og:description" content="<?php echo $swtsh_fetch_res->archive_description;?>" />
<meta property="og:type" content="article" />
<meta property="og:image" content="<?php echo $swtsh_fetch_res->archive_og_image;?>"/>
<meta property="og:locale" content="<?php language_attributes(); ?>" />
<meta property="article:publisher" content="<?php echo $swtsh_fetch_res->facebook;?>" />

<meta name="twitter:card" value="summary" />
<meta name="twitter:url" value="<?php the_permalink(); ?>" />
<meta name="twitter:title" value="<?php echo $swtsh_fetch_res->archive_title;?> - <?php echo single_cat_title();?>" />
<meta name="twitter:description" value="<?php echo $swtsh_fetch_res->archive_description;?>" />
<meta name="twitter:image" value="<?php echo $swtsh_fetch_res->archive_og_image;?>" />
<meta name="twitter:site" value="<?php echo $swtsh_fetch_res->twitter;?>" />
<meta name="twitter:creator" content="<?php echo $swtsh_fetch_res->twitter;?>" />
		<?php
		}
		
		if (is_tag()) {
		?>
<title><?php echo $swtsh_fetch_res->archive_title;?> - <?php echo single_tag_title();?></title>;
<meta name="description" content="<?php echo $swtsh_fetch_res->archive_description;?>"/>
<meta name="keywords" content="<?php echo $swtsh_fetch_res->archive_keywords;?>"/>
<meta name="robots" content="noodp"/>
<link rel="canonical" href="<?php the_permalink(); ?>" />
<link rel="publisher" href="<?php echo $swtsh_fetch_res->google_plus;?>"/>


<meta property="og:title" content="<?php echo $swtsh_fetch_res->archive_title;?> - <?php echo single_tag_title();?>" />
<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>" />
<meta property="og:url" content="<?php the_permalink(); ?>" />
<meta property="og:description" content="<?php echo $swtsh_fetch_res->archive_description;?>" />
<meta property="og:type" content="article" />
<meta property="og:image" content="<?php echo $swtsh_fetch_res->archive_og_image;?>"/>
<meta property="og:locale" content="<?php language_attributes(); ?>" />
<meta property="article:publisher" content="<?php echo $swtsh_fetch_res->facebook;?>" />

<meta name="twitter:card" value="summary" />
<meta name="twitter:url" value="<?php the_permalink(); ?>" />
<meta name="twitter:title" value="<?php echo $swtsh_fetch_res->archive_title;?> - <?php echo single_tag_title();?>" />
<meta name="twitter:description" value="<?php echo $swtsh_fetch_res->archive_description;?>" />
<meta name="twitter:image" value="<?php echo $swtsh_fetch_res->archive_og_image;?>" />
<meta name="twitter:site" value="<?php echo $swtsh_fetch_res->twitter;?>" />
<meta name="twitter:creator" content="<?php echo $swtsh_fetch_res->twitter;?>" />
		<?php
		}
		
		if (is_day()) {
		?>
<title><?php echo $swtsh_fetch_res->archive_title;?> - <?php echo the_time('F jS, Y');?></title>;
<meta name="description" content="<?php echo $swtsh_fetch_res->archive_description;?>"/>
<meta name="keywords" content="<?php echo $swtsh_fetch_res->archive_keywords;?>"/>
<meta name="robots" content="noodp"/>
<link rel="canonical" href="<?php the_permalink(); ?>" />
<link rel="publisher" href="<?php echo $swtsh_fetch_res->google_plus;?>"/>


<meta property="og:title" content="<?php echo $swtsh_fetch_res->archive_title;?> - <?php echo the_time('F jS, Y');?>" />
<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>" />
<meta property="og:url" content="<?php the_permalink(); ?>" />
<meta property="og:description" content="<?php echo $swtsh_fetch_res->archive_description;?>" />
<meta property="og:type" content="article" />
<meta property="og:image" content="<?php echo $swtsh_fetch_res->archive_og_image;?>"/>
<meta property="og:locale" content="<?php language_attributes(); ?>" />
<meta property="article:publisher" content="<?php echo $swtsh_fetch_res->facebook;?>" />

<meta name="twitter:card" value="summary" />
<meta name="twitter:url" value="<?php the_permalink(); ?>" />
<meta name="twitter:title" value="<?php echo $swtsh_fetch_res->archive_title;?> - <?php echo the_time('F jS, Y');?>" />
<meta name="twitter:description" value="<?php echo $swtsh_fetch_res->archive_description;?>" />
<meta name="twitter:image" value="<?php echo $swtsh_fetch_res->archive_og_image;?>" />
<meta name="twitter:site" value="<?php echo $swtsh_fetch_res->twitter;?>" />
<meta name="twitter:creator" content="<?php echo $swtsh_fetch_res->twitter;?>" />
		<?php
		}
		
		if (is_month()) {
		?>
<title><?php echo $swtsh_fetch_res->archive_title;?> - <?php echo the_time('F, Y');?></title>;
<meta name="description" content="<?php echo $swtsh_fetch_res->archive_description;?>"/>
<meta name="keywords" content="<?php echo $swtsh_fetch_res->archive_keywords;?>"/>
<meta name="robots" content="noodp"/>
<link rel="canonical" href="<?php the_permalink(); ?>" />
<link rel="publisher" href="<?php echo $swtsh_fetch_res->google_plus;?>"/>


<meta property="og:title" content="<?php echo $swtsh_fetch_res->archive_title;?> - <?php echo the_time('F, Y');?>" />
<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>" />
<meta property="og:url" content="<?php the_permalink(); ?>" />
<meta property="og:description" content="<?php echo $swtsh_fetch_res->archive_description;?>" />
<meta property="og:type" content="article" />
<meta property="og:image" content="<?php echo $swtsh_fetch_res->archive_og_image;?>"/>
<meta property="og:locale" content="<?php language_attributes(); ?>" />
<meta property="article:publisher" content="<?php echo $swtsh_fetch_res->facebook;?>" />

<meta name="twitter:card" value="summary" />
<meta name="twitter:url" value="<?php the_permalink(); ?>" />
<meta name="twitter:title" value="<?php echo $swtsh_fetch_res->archive_title;?> - <?php echo the_time('F, Y');?>" />
<meta name="twitter:description" value="<?php echo $swtsh_fetch_res->archive_description;?>" />
<meta name="twitter:image" value="<?php echo $swtsh_fetch_res->archive_og_image;?>" />
<meta name="twitter:site" value="<?php echo $swtsh_fetch_res->twitter;?>" />
<meta name="twitter:creator" content="<?php echo $swtsh_fetch_res->twitter;?>" />
		<?php
		}
		
		if (is_year()) {
		?>
<title><?php echo $swtsh_fetch_res->archive_title;?> - <?php echo date("Y");?></title>;
<meta name="description" content="<?php echo $swtsh_fetch_res->archive_description;?>"/>
<meta name="keywords" content="<?php echo $swtsh_fetch_res->archive_keywords;?>"/>
<meta name="robots" content="noodp"/>
<link rel="canonical" href="<?php the_permalink(); ?>" />
<link rel="publisher" href="<?php echo $swtsh_fetch_res->google_plus;?>"/>


<meta property="og:title" content="<?php echo $swtsh_fetch_res->archive_title;?> - <?php echo date("Y");?>" />
<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>" />
<meta property="og:url" content="<?php the_permalink(); ?>" />
<meta property="og:description" content="<?php echo $swtsh_fetch_res->archive_description;?>" />
<meta property="og:type" content="article" />
<meta property="og:image" content="<?php echo $swtsh_fetch_res->archive_og_image;?>"/>
<meta property="og:locale" content="<?php language_attributes(); ?>" />
<meta property="article:publisher" content="<?php echo $swtsh_fetch_res->facebook;?>" />

<meta name="twitter:card" value="summary" />
<meta name="twitter:url" value="<?php the_permalink(); ?>" />
<meta name="twitter:title" value="<?php echo $swtsh_fetch_res->archive_title;?> - <?php echo date("Y");?>" />
<meta name="twitter:description" value="<?php echo $swtsh_fetch_res->archive_description;?>" />
<meta name="twitter:image" value="<?php echo $swtsh_fetch_res->archive_og_image;?>" />
<meta name="twitter:site" value="<?php echo $swtsh_fetch_res->twitter;?>" />
<meta name="twitter:creator" content="<?php echo $swtsh_fetch_res->twitter;?>" />
		<?php
		}
		
		if (is_search()) {
		?>
<title><?php echo $swtsh_fetch_res->archive_title;?> - <?php _e('Search Results');?></title>;
<meta name="description" content="<?php echo $swtsh_fetch_res->archive_description;?>"/>
<meta name="keywords" content="<?php echo $swtsh_fetch_res->archive_keywords;?>"/>
<meta name="robots" content="noodp"/>
<link rel="canonical" href="<?php the_permalink(); ?>" />
<link rel="publisher" href="<?php echo $swtsh_fetch_res->google_plus;?>"/>


<meta property="og:title" content="<?php echo $swtsh_fetch_res->archive_title;?> - <?php _e('Search Results');?>" />
<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>" />
<meta property="og:url" content="<?php the_permalink(); ?>" />
<meta property="og:description" content="<?php echo $swtsh_fetch_res->archive_description;?>" />
<meta property="og:type" content="article" />
<meta property="og:image" content="<?php echo $swtsh_fetch_res->archive_og_image;?>"/>
<meta property="og:locale" content="<?php language_attributes(); ?>" />
<meta property="article:publisher" content="<?php echo $swtsh_fetch_res->facebook;?>" />

<meta name="twitter:card" value="summary" />
<meta name="twitter:url" value="<?php the_permalink(); ?>" />
<meta name="twitter:title" value="<?php echo $swtsh_fetch_res->archive_title;?> - <?php _e('Search Results');?>" />
<meta name="twitter:description" value="<?php echo $swtsh_fetch_res->archive_description;?>" />
<meta name="twitter:image" value="<?php echo $swtsh_fetch_res->archive_og_image;?>" />
<meta name="twitter:site" value="<?php echo $swtsh_fetch_res->twitter;?>" />
<meta name="twitter:creator" content="<?php echo $swtsh_fetch_res->twitter;?>" />
		<?php
		}
		
		if (is_author()) {
		?>
<title><?php echo $swtsh_fetch_res->archive_title;?> - <?php the_author(); ?></title>;
<meta name="description" content="<?php echo $swtsh_fetch_res->archive_description;?>"/>
<meta name="keywords" content="<?php echo $swtsh_fetch_res->archive_keywords;?>"/>
<meta name="robots" content="noodp"/>
<link rel="canonical" href="<?php the_permalink(); ?>" />
<link rel="publisher" href="<?php echo $swtsh_fetch_res->google_plus;?>"/>


<meta property="og:title" content="<?php echo $swtsh_fetch_res->archive_title;?> - <?php the_author(); ?>" />
<meta property="og:site_name" content="<?php bloginfo( 'name' ); ?>" />
<meta property="og:url" content="<?php the_permalink(); ?>" />
<meta property="og:description" content="<?php echo $swtsh_fetch_res->archive_description;?>" />
<meta property="og:type" content="article" />
<meta property="og:image" content="<?php echo $swtsh_fetch_res->archive_og_image;?>"/>
<meta property="og:locale" content="<?php language_attributes(); ?>" />
<meta property="article:publisher" content="<?php echo $swtsh_fetch_res->facebook;?>" />

<meta name="twitter:card" value="summary" />
<meta name="twitter:url" value="<?php the_permalink(); ?>" />
<meta name="twitter:title" value="<?php echo $swtsh_fetch_res->archive_title;?> - <?php the_author(); ?>" />
<meta name="twitter:description" value="<?php echo $swtsh_fetch_res->archive_description;?>" />
<meta name="twitter:image" value="<?php echo $swtsh_fetch_res->archive_og_image;?>" />
<meta name="twitter:site" value="<?php echo $swtsh_fetch_res->twitter;?>" />
<meta name="twitter:creator" content="<?php echo $swtsh_fetch_res->twitter;?>" />
		<?php
		}
		?>

<?php
echo "<!---------------    THIS WEBSITE USING SWT SEO HELPER WORDPRESS PLUGIN    ---------------> \n\n\n";
	}
	// end archive
} //end function

?>