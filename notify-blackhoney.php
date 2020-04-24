<?php
// กรณีต้องการตรวจสอบการแจ้ง error ให้เปิด 3 บรรทัดล่างนี้ให้ทำงาน กรณีไม่ ให้ comment ปิดไป
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
 
// กรณีมีการเชื่อมต่อกับฐานข้อมูล
//require_once("dbconnect.php");
 
$accToken = "8hl5zzFoaFLWrfOs5gZL4xs0t5PEJaaljd2TDZ267cO";
$notifyURL = "https://notify-api.line.me/api/notify";
 
$headers = array(
    'Content-Type: application/x-www-form-urlencoded',
    'Authorization: Bearer '.$accToken
);
$data = array(
    'message' => 'มีลูกค้าสั่ง ของ กรุณา ดูใน line ด้วยครับ'
);
 
// ส่วนของการส่งการแจ้งเตือนผ่านฟังก์ชั่น cURL
$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, $notifyURL);
curl_setopt( $ch, CURLOPT_POST, 1);
curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query($data));
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, 0); // ถ้าเว็บเรามี ssl สามารถเปลี่ยนเป้น 2
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, 0); // ถ้าเว็บเรามี ssl สามารถเปลี่ยนเป้น 1
curl_setopt( $ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1);
$result = curl_exec( $ch );
curl_close( $ch );
 
// ตรวจสอบค่าข้อมูล ว่าเป็นตัวแปร ปรเภทไหน ข้อมูลอะไร
var_dump($result);
 
// การเช็คสถานะการทำงาน 
$result = json_decode($result,TRUE);
// ดูโครงสร้าง กรณีแปลงเป็น array แล้ว
//echo "<pre>";
//print_r($result);
 
// ตรวจสอบข้อมูล ใช้เป็นเงื่อนไขในการทำงาน
if(!is_null($result) && array_key_exists('status',$result)){
    if($result['status']==200){
        echo "Pass";
    }
}
?>
