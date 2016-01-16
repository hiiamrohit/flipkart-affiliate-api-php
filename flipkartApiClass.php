<?php
/*
* Author: Rohit Kumar
* Website: iamrohit.in
* Version: 0.0.1
* Date: 16-01-2016
* App Name: FlipKart Affiliate Api
* Description: Simple flipkart api in php to create your online deals or e-commerce affiliate market place 
*/
 class flipkartApi {
   
    private static $affiliateID;

    private static $token;

    private static $timeout = 45;

    //Set filpkart affilate id and token at the time of class init.

     public function __construct($affiliateID, $token) {
       self::$affiliateID = $affiliateID;
       self::$token = $token;
      }


     public static function getData($url, $dataType) {

         try {

         	if(!isset($url) && !empty($url)) {
         		throw new exception("URL is not available.");
         	}

         	if(!isset($dataType) && !empty($dataType)) {
         		throw new exception("Please set datatype json or xml");
         	}

         	if (!function_exists('curl_init')){
                throw new exception("Curl is not available.");
         	}
         	 // Set header to make authentication
	        $headers = array(
	            'Cache-Control: no-cache',
	            'Fk-Affiliate-Id: '.self::$affiliateID,
	            'Fk-Affiliate-Token: '.self::$token
	            );

	        $cObj = curl_init();
	        curl_setopt($cObj, CURLOPT_URL, $url);
	        curl_setopt($cObj, CURLOPT_HTTPHEADER, $headers);
	        curl_setopt($cObj, CURLOPT_TIMEOUT, self::$timeout);
	        curl_setopt($cObj, CURLOPT_RETURNTRANSFER, TRUE);
	        $result = curl_exec($cObj);
	        curl_close($cObj);
             // render result as per format.
             if($dataType == 'json') {
               return $result ? json_decode($result, true) : false;
             } else if($dataType == 'xml') {
                return $result ? new SimpleXMLElement($result) : false;
             } else {
             	return false;
             }

         }  catch (Exception $e) {
            return $e->getMessage();
         }
      }


 }






?>