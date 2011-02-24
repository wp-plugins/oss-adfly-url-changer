<?php
/*
Plugin Name: OSS Adf.ly URL Changer
Plugin URI: http://wordpress.org/extend/plugins/oss-adfly-url-changer/
Description: This control allows your to change all the URL in the Post to Adf.ly URL Ads
Version: The Plugin's Version Number, e.g.: 1.0.1
Author: Kamran Shahid Butt
Author URI: http://www.onestepsolutions.biz
License: A "oss-Adf.ly" license name e.g. GPL2
*/
?>
<?php
/*  Copyright YEAR  PLUGIN_AUTHOR_NAME  (email : PLUGIN AUTHOR EMAIL)

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License, version 2, as 
    published by the Free Software Foundation.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 51 Franklin St, Fifth Floor, Boston, MA  02110-1301  USA
*/
?>
<?php

add_filter('the_content','oss_adfly_url',99);
add_action('admin_menu', 'oss_adf_ly');

if(isset($_POST['submit']) and isset($_POST['oss_adf_ly_id']))
{
	$option_name = 'oss_adf_ly_id' ; 
	$newvalue = $_POST['oss_adf_ly_id'];
	
	if ( get_option($option_name)  != $newvalue) {
		update_option($option_name, $newvalue);
	} 
	else {
		$deprecated=' ';
		$autoload='no';
		add_option($option_name, $newvalue, $deprecated, $autoload);
	}
}

function oss_adf_ly()
{
	add_submenu_page( "options-general.php", 'OSS Adf.ly', "OSS Adf.ly", "manage_options", 'OSS-Adf-ly', 'oss_adf_ly_html');
}

function oss_adf_ly_html()
{
	if (!current_user_can('manage_options'))
		wp_die( __('You do not have sufficient permissions to access this page.') );
	if(!(isset($_POST['submit'])))
	{
		echo '
			<div class="wrap">
					<h2>Adf.ly Account Information</h2>
					In order to function, you need a <a href="http://adf.ly/?id=196604">Adf.ly account</a> and a User Id.
					<form method="post" id="frm" name="frm">
					<div>
						<p>
							<label for="wpingfm-pingfmkey">Adf.ly User Id:</label>
						  <input type="text" value="'.get_option("oss_adf_ly_id").'" id="oss_adf_ly_id" name="oss_adf_ly_id" />
						</p>
						<input type="hidden" value="oss_adf_ly_id_submit" name="submit-type">
						<p><input type="submit" value="save key" name="submit">
					</p></div>
					</form>
			<script type="text/javascript"><!--
			google_ad_client = "pub-5286077459468711";
			/* 336x280, created 2/19/11 */
			google_ad_slot = "0197607484";
			google_ad_width = 336;
			google_ad_height = 280;
			//-->
			</script>
			<script type="text/javascript"
			src="http://pagead2.googlesyndication.com/pagead/show_ads.js">
			</script>
				</div>';

	}
}


function oss_adfly_url($content) {
	$userid = get_option("oss_adf_ly_id");
	if(strlen($userid)){
		$content = str_replace("href='http://", "href='http://adf.ly/".$userid."/", $content);
		$content = str_replace('href="http://', 'href="http://adf.ly/'.$userid.'/', $content);
	}
	
	return $content;
}
?>