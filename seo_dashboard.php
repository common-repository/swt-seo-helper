<?php
function swtsh_show_html_form() {
global $wpdb;


	$swsht_table_name = $wpdb->prefix . "swt_seo";
	if(isset($_POST['swtsh_add_keywords']) && isset($_POST['swtsh_seo']) && isset($_POST['swtsh_nonce']))
	{		
		$nonce = $_POST['swtsh_nonce'];
		if ( wp_verify_nonce( $nonce, 'swtsh-nonce' ) )
		{
			
			if(!empty($_POST['swtsh_comman_keywords'])){
			$swtsh_comman_keywords=sanitize_text_field($_POST['swtsh_comman_keywords']);
			}else{$swtsh_comman_keywords='';}
			if(!empty($_POST['swtsh_home_title'])){
			$swtsh_home_title=sanitize_text_field($_POST['swtsh_home_title']);
			}else{$swtsh_home_title='';}
			if(!empty($_POST['swtsh_home_keywords'])){
			$swtsh_home_keywords=sanitize_text_field($_POST['swtsh_home_keywords']);
			}else{$swtsh_home_keywords='';}
			if(!empty($_POST['swtsh_home_description'])){
			$swtsh_home_description=sanitize_text_field($_POST['swtsh_home_description']);
			}else{$swtsh_home_description='';}
			if(!empty($_POST['swtsh_home_og_image'])){
			$swtsh_home_og_image=sanitize_text_field($_POST['swtsh_home_og_image']);
			}else{$swtsh_home_og_image='';}
			
			if(!empty($_POST['swtsh_archive_title'])){
			$swtsh_archive_title=sanitize_text_field($_POST['swtsh_archive_title']);
			}else{$swtsh_archive_title='';}
			if(!empty($_POST['swtsh_archive_keywords'])){
			$swtsh_archive_keywords=sanitize_text_field($_POST['swtsh_archive_keywords']);
			}else{$swtsh_archive_keywords='';}
			if(!empty($_POST['swtsh_archive_description'])){
			$swtsh_archive_description=sanitize_text_field($_POST['swtsh_archive_description']);
			}else{$swtsh_archive_description='';}
			
			if(!empty($_POST['swtsh_facebook_url'])){
			$swtsh_facebook_url=esc_url($_POST['swtsh_facebook_url']);
			}else{$swtsh_facebook_url='';}
			if(!empty($_POST['swtsh_twitter_url'])){
			$swtsh_twitter_url=esc_url($_POST['swtsh_twitter_url']);
			}else{$swtsh_twitter_url='';}
			if(!empty($_POST['swtsh_google_profile'])){
			$swtsh_google_profile=esc_url($_POST['swtsh_google_profile']);
			}else{$swtsh_google_profile='';}
			
			
			// count total no of rows grater than 1......
			$swtsh_total_rows=$wpdb->get_var("select  COUNT(id) from $swsht_table_name where type='seo' limit 1");
			
			if($swtsh_total_rows<1)
			{
				$seo="seo";
				$wpdb->query( $wpdb->prepare("INSERT INTO $swsht_table_name (comman_keywords, home_title, home_keywords, home_description, home_og_image, archive_title, archive_keywords, archive_description, facebook, twitter, google_plus, type) VALUES ( %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s )", $swtsh_comman_keywords, $swtsh_home_title, $swtsh_home_keywords, $swtsh_home_description, $swtsh_home_og_image, $swtsh_archive_title, $swtsh_archive_keywords, $swtsh_archive_description, $swtsh_facebook_url, $swtsh_twitter_url, $swtsh_google_profile, $seo) );
				
				//$wpdb->query("INSERT INTO $swsht_table_name (`comman_keywords`, `home_title`, `home_keywords`, `home_description`, `home_og_image`, `archive_title`, `archive_keywords`, `archive_description`, `facebook`, `twitter`, `google_plus`, `type`) VALUES ('$swtsh_comman_keywords', '$swtsh_home_title', '$swtsh_home_keywords', '$swtsh_home_description', '$swtsh_home_og_image', '$swtsh_archive_title', '$swtsh_archive_keywords', '$swtsh_archive_description', '$swtsh_facebook_url', '$swtsh_twitter_url', '$swtsh_google_profile', 'seo')");
			}
			else
			{
				$seo="seo";
				$wpdb->show_errors();
				$wpdb->update($swsht_table_name, array( 'comman_keywords' => $swtsh_comman_keywords, 'home_title' => $swtsh_home_title, 'home_keywords' => $swtsh_home_keywords, 'home_description' => $swtsh_home_description, 'home_og_image' => $swtsh_home_og_image, 'archive_title' => $swtsh_archive_title, 'archive_keywords' => $swtsh_archive_keywords, 'archive_description' => $swtsh_archive_description, 'facebook' => $swtsh_facebook_url, 'twitter' => $swtsh_twitter_url, 'google_plus' => $swtsh_google_profile), array( 'type' => $seo ));
			}
	
		}else{ echo "<br><h2>This nonce is not valid, You can't acceess directly try agian!</h2><br>";}
		
	}


	$swtsh_fetch_data = $wpdb->get_row("select * from $swsht_table_name where type='seo' limit 1");
?>
<link rel="stylesheet" href="<?php echo plugin_dir_url($file);?>/swt-seo-helper/css/style.css" type="text/css" media="all" />
<div class="main_div">
	<div class="main-grid">
			<div class="agile-grids">	
				<!-- validation -->
				<div class="grids">
					<div class="progressbar-heading grids-heading">
						<div style="float:left; width:14%;">
							<h1><a href="#"><img src="<?php echo plugin_dir_url($file); ?>/swt-seo-helper/images/logo.png" /></a></h1>
						</div>
						
						<h2>Update Your Keywords, Description, Social meadia Links</h2>
					</div>
					
					<div class="forms-grids">
						<div class="forms3">
						<div class="w3agile-validation w3ls-validation">
							<div class="panel panel-widget agile-validation register-form">
								<div class="validation-grids widget-shadow" data-example-id="basic-forms"> 
									<div class="input-info">
										<h3>Home Page Setting:</h3>
									</div>
									<div class="form-body form-body-info">
										<form method="post" name="swtsh_swtsh_add_keywords" enctype="multipart/form-data">
										
											<div class="form-group">
												<div class="form_text">Home page title</div>
												<input type="text" class="form-control" name="swtsh_home_title" placeholder="Enetr your home page title" maxlength="66" value="<?php echo esc_html($swtsh_fetch_data->home_title); ?>">
											</div>
											
											<div class="form-group">
												<div class="form_text">Home page keywords</div>
												<textarea class="form-control form-control-textarea" placeholder="Set home page keywords" name="swtsh_home_keywords"><?php echo esc_html($swtsh_fetch_data->home_keywords); ?></textarea>
											</div>
											
											<div class="form-group">
												<div class="form_text">Home page description</div>
												<textarea class="form-control form-control-textarea" placeholder="Set home page description" name="swtsh_home_description"><?php echo esc_html($swtsh_fetch_data->home_description); ?></textarea>
											</div>
											
											<div class="form-group">
												<div class="form_text">Home Page OG: Image (Facebook, twitter, google+)</div>
												<input type="text" class="form-control" name="swtsh_home_og_image" placeholder="Enter Image URL" value="<?php echo esc_html($swtsh_fetch_data->home_og_image); ?>" />
											</div>
											
											
											<br />
											<div class="input-info">
												<h3>Archive Page Setting</h3>
											</div>											
											<div class="form-group">
												<div class="form_text">Archive page title</div>
												<input type="text" class="form-control" name="swtsh_archive_title" placeholder="Enetr your archive page title" maxlength="66" value="<?php echo esc_html($swtsh_fetch_data->archive_title); ?>">
											</div>
											
											<div class="form-group">
												<div class="form_text">Archive page keywords</div>
												<textarea class="form-control form-control-textarea" placeholder="Set archive page keywords" name="swtsh_archive_keywords"><?php echo esc_html($swtsh_fetch_data->archive_keywords); ?></textarea>
											</div>
											
											<div class="form-group">
												<div class="form_text">Archive page description</div>
												<textarea class="form-control form-control-textarea" placeholder="Set archive page description" name="swtsh_archive_description"><?php echo esc_html($swtsh_fetch_data->archive_description); ?></textarea>
											</div>
											
											
											
											<br />
											<div class="input-info">
												<h3>Comman keyword for all pages or posts</h3>
											</div>											
											
											<div class="form-group">
												<div class="form_text">Home page comman keywords</div>
												<textarea class="form-control form-control-textarea" placeholder="Comman keyword for all pages or posts" name="swtsh_comman_keywords"><?php echo esc_html($swtsh_fetch_data->comman_keywords); ?></textarea>
											</div>
											
											
											<br />
											<div class="input-info">
												<h3>Update social meadia links</h3>
											</div>										
											<div class="form-group">
												<div class="form_text">Facebook page url</div>
												<input type="text" class="form-control" name="swtsh_facebook_url" placeholder="https://www.facebook.com/mypage" maxlength="66" value="<?php echo esc_html($swtsh_fetch_data->facebook); ?>" />
											</div>
											<div class="form-group">
												<div class="form_text">Twitter page url</div>
												<input type="text" class="form-control" name="swtsh_twitter_url" placeholder="https://www.twitter.com/mypage" maxlength="66" value="<?php echo esc_html($swtsh_fetch_data->twitter); ?>" />
											</div>
											<div class="form-group">
												<div class="form_text">Google plus profile</div>
												<input type="text" class="form-control" name="swtsh_google_profile" placeholder="https://plus.google.com/mypage" maxlength="66" value="<?php echo esc_html($swtsh_fetch_data->google_plus); ?>">
											</div>
											
																					
											<div class="form-group">
												<input type="hidden" name="swtsh_seo" value="seo" />
												<input type="hidden" name="swtsh_nonce" value="<?php echo $nonce = wp_create_nonce( 'swtsh-nonce' ); ?>" />
												<input type="submit" name="swtsh_add_keywords" value="Save Data" class="btn-primary mysubmit" />
											</div>
											
											
										</form>
									</div>
								</div>
							</div>
							
							
						</div>
						<div class="clear"> </div>
						</div>
					</div>
				</div>
				<!-- //validation -->
			</div>
		</div>
<?php

}
swtsh_show_html_form();
?>