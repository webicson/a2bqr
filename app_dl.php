<?php  
include ("lib/customer.defines.php");
include ("lib/customer.module.access.php");
include ("lib/customer.smarty.php");
include ("lib/epayment/includes/configure.php");
include ("lib/epayment/includes/html_output.php");
include ("./lib/epayment/includes/general.php");
include "phpqrcode/qrlib.php";  

if (!has_rights(ACX_ACCESS)) {
        Header("HTTP/1.0 401 Unauthorized");
        Header("Location: PP_error.php?c=accessdenied");
        die();
}

//print_r($_SESSION);


//set it to writable location, a place for temp generated PNG files
$PNG_TEMP_DIR = dirname(__FILE__).DIRECTORY_SEPARATOR.'phpqrcode/temp'.DIRECTORY_SEPARATOR;


// html PNG location prefix
$PNG_WEB_DIR = 'phpqrcode/temp/';


  

//ofcourse we need rights to create temp dir
if (!file_exists($PNG_TEMP_DIR))
    mkdir($PNG_TEMP_DIR);
   


$errorCorrectionLevel = 'L';

$matrixPointSize = 8;

$u = $_SESSION['qr_login'];
$p = $_SESSION['pr_password'];

$qr_nm = $u.'.'.time().'.png';
$filename = $PNG_TEMP_DIR.$qr_nm;
#$info = "csc:$u:$p@ISRAELNUMBER";
#$info = "csc:$u:$p@ENCRYPT-PHONE";
$info = "csc:$u:$p@zone2";
//var_dump($info);

QRcode::png($info, $filename, $errorCorrectionLevel, $matrixPointSize, 2);
  

$src = $PNG_WEB_DIR.basename($filename);
#var_dump($src);

$smarty->display('main.tpl');

?>

<style>
  .soft-phone-dl td { text-align: center; }
  .soft-phone-dl a { display: block; }
  .soft-phone-dl img { width: 200px; }
</style>

<table  class="tablebackgroundblue soft-phone-dl" align="center">
    <tr>
        <td>
          <a href="https://play.google.com/store/apps/details?id=cz.acrobits.softphone.cloudphone" target="_blank">
            <img src="./templates/default/images/appstores/googlestore.jpg" alt="">
          </a>
          <br>
          <a href="https://play.google.com/store/apps/details?id=cz.acrobits.softphone.cloudphone" target="_blank">Get from PlayStore</a>
        </td>
        <td>
          <a href="https://itunes.apple.com/us/app/cloud-softphone/id567475545?mt=8" target="_blank">
            <img src="./templates/default/images/appstores/applestore.jpg" alt="">
          </a>
          <br>
          <a href="https://itunes.apple.com/us/app/cloud-softphone/id567475545?mt=8" target="_blank">Get from AppStore</a>
        </td>

    </tr>
    <tr>
      <td colspan="2">
        <img src="<?php echo $src; ?>" alt="">
      </td>
    </tr>
</table>
<div>
  <div style="display:table; margin:  auto; width: 70%; font-size: 16px;">
    <div>
      <span style="font-weight: bold;">Softphone installation process:</span>
      <ol>
        <li>Select Android OS (Google Play) or iPhone (App store), depending on your phone type.</li>
        <li>Download and install the application on your mobile device.</li>
      </ol>
    </div>
    <div style="margin-top: 40px;">
      <span style="font-weight: bold;">After installation is completed:</span>
      <ol>
        <li>Open the app.</li>
        <li>Choose scan QR Code and scan the QR from your portal.</li>
        <li>Accept the TOS and verify that the application is registered well. The icon on the upper left corner should appear in green.</li>
      </ol>
    </div>
  </div>
</div>


