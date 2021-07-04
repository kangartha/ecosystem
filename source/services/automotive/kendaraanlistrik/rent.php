<?php
/**
 * USAGE
 *   curl "http://localhost/services/ecosystem/automotive/kendaraanlistrik/merk/"
 *   curl "{ecosystem_baseurl}/services/automotive/kendaraanlistrik/merk/"
 * 
 * @date       28-04-2021 23:46
 * @category   Automotive
 * @package    Kendaraan Listrik Library
 * @subpackage
 * @copyright  Copyright (c) 2013-endless AksiIDE
 * @license
 * @version
 * @link       http://www.aksiide.com
 * @since
 */
ini_set('display_errors', 0);
ini_set('display_startup_errors', 0);
//error_reporting(E_NONE);
include_once "../../config.php";
require_once "../../lib/lib.php";
date_default_timezone_set('Asia/Jakarta');

const KENDARAANLISTRIK_PRODUCT_URL = "http://kendaraanlistrik.net/contents/products.json";

$context = stream_context_create(
  array(
      'http' => array(
          'follow_location' => false
      ),
      'ssl' => array(
          "verify_peer"=>false,
          "verify_peer_name"=>false,
      ),
  )
);
$content = file_get_contents(KENDARAANLISTRIK_PRODUCT_URL, false, $context);
if (empty($content)){
  Output(0, 'Maaf, informasi Penyewaan Kendaraan Listrik belum ditemukan.');
}
$contentAsArray = json_decode($content, true);

$Text = "*Sewa Kendaraan Listrik*:";
foreach ($contentAsArray as $merk) {
  $rent = @$merk['rent'];
  if (empty($rent)) continue;
  $url = "http://kendaraanlistrik.net/product/rent/?q=".($merk['merk']);
  $Text .= "\n- [$merk[merk]]($url)";
}

//die($Text);
Output(0, $Text);
