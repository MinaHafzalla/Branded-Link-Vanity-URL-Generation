<?php
/*
 * Smarty plugin
 * ----------------------------------
 * File:     function.affyourls.php
 * Type:     function
 * Name:     affyourls
 * ----------------------------------
 */
function smarty_function_affyourls($params, &$smarty)
{
// Your API Credentials go here
$username = 'yourapiusername';
$password = 'yourapipassword';

// Affiliate ID
$affiliateid = $params['affiliateid']; 

// Replace this with your domain name
$url = 'https://example.com/whmcs/aff.php?aff=' . $affiliateid .'';

// (Optional) - Change User Agent String
$agent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1)';

// DO NOT EDIT
$format = 'json';

// Replace this link with your YOURLS API file path
$api_url = 'http://yourownshortdomain.com/yourls-api.php';

// DO NOT EDIT
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $api_url);
curl_setopt($ch, CURLOPT_HEADER, 0);            // No header in the result
curl_setopt($ch, CURLOPT_USERAGENT, $agent);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true); // Return, do not echo result
curl_setopt($ch, CURLOPT_POST, 1);              // This is a POST request
curl_setopt($ch, CURLOPT_POSTFIELDS, array(     // Data to POST
		'url'      => $url,
		'keyword'  => $keyword,
		'format'   => $format,
		'action'   => 'shorturl',
		'username' => $username,
		'password' => $password
	));
$data = curl_exec($ch);
curl_close($ch);
$json = json_decode($data, true);
echo $json["shorturl"];
}
?>