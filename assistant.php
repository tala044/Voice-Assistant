<?php
// ============================================================
// assistant.php
// يستقبل النص من app.js ويرسله إلى Gemini API
// ============================================================

header('Content-Type: application/json; charset=utf-8');

// ------------------------------------------------------------
// 1) تحميل config.php
// ------------------------------------------------------------

$configPath = __DIR__ . '/../config.php';

if (!file_exists($configPath)) {
    http_response_code(500);

    echo json_encode([
        'error' => 'ملف config.php غير موجود',
        'path' => $configPath
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

require $configPath;


// ------------------------------------------------------------
// 2) السماح بطلبات POST فقط
// ------------------------------------------------------------

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {

    http_response_code(405);

    echo json_encode([
        'error' => 'يجب إرسال الطلب باستخدام POST'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


// ------------------------------------------------------------
// 3) قراءة البيانات القادمة من app.js
// ------------------------------------------------------------

$rawInput = file_get_contents('php://input');

$input = json_decode($rawInput, true);

if (!is_array($input)) {

    http_response_code(400);

    echo json_encode([
        'error' => 'بيانات JSON غير صالحة',
        'raw_input' => $rawInput
    ], JSON_UNESCAPED_UNICODE);

    exit;
}

$prompt = isset($input['prompt'])
    ? trim($input['prompt'])
    : '';


// ------------------------------------------------------------
// 4) التأكد من وجود النص
// ------------------------------------------------------------

if ($prompt === '') {

    http_response_code(400);

    echo json_encode([
        'error' => 'لم يتم إرسال النص في الحقل prompt'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


// ------------------------------------------------------------
// 5) التأكد من وجود مفتاح Gemini
// ------------------------------------------------------------

if (
    !defined('GEMINI_API_KEY') ||
    trim(GEMINI_API_KEY) === '' ||
    trim(GEMINI_API_KEY) === 'ضع_مفتاحك_هنا'
) {

    http_response_code(500);

    echo json_encode([
        'error' => 'مفتاح Gemini API غير مضبوط في config.php'
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


// ------------------------------------------------------------
// 6) إعداد Gemini API
// ------------------------------------------------------------

$model = 'gemini-3.6-flash';

$url = "https://generativelanguage.googleapis.com/v1beta/models/{$model}:generateContent";


// ------------------------------------------------------------
// 7) تجهيز البيانات المرسلة إلى Gemini
// ------------------------------------------------------------

$body = json_encode([
    'contents' => [
        [
            'parts' => [
                [
                    'text' => $prompt
                ]
            ]
        ]
    ]
], JSON_UNESCAPED_UNICODE);


// ------------------------------------------------------------
// 8) إرسال الطلب باستخدام cURL
// ------------------------------------------------------------

$ch = curl_init($url);

curl_setopt_array($ch, [

    CURLOPT_RETURNTRANSFER => true,

    CURLOPT_POST => true,

    CURLOPT_HTTPHEADER => [
        'Content-Type: application/json',
        'x-goog-api-key: ' . trim(GEMINI_API_KEY)
    ],

    CURLOPT_POSTFIELDS => $body,

    CURLOPT_TIMEOUT => 30,

    CURLOPT_CONNECTTIMEOUT => 15,

    CURLOPT_SSL_VERIFYPEER => true,

    CURLOPT_SSL_VERIFYHOST => 2

]);


// ------------------------------------------------------------
// 9) تنفيذ الطلب
// ------------------------------------------------------------

$response = curl_exec($ch);

$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$curlError = curl_error($ch);

curl_close($ch);


// ------------------------------------------------------------
// 10) فشل الاتصال بالسيرفر
// ------------------------------------------------------------

if ($response === false) {

    http_response_code(502);

    echo json_encode([
        'error' => 'فشل الاتصال بـ Gemini API',
        'curl_error' => $curlError
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


// ------------------------------------------------------------
// 11) تحويل رد Gemini إلى JSON
// ------------------------------------------------------------

$data = json_decode($response, true);


// ------------------------------------------------------------
// 12) إذا Gemini رجع خطأ
// ------------------------------------------------------------

if ($httpCode >= 400) {

    http_response_code($httpCode);

    echo json_encode([
        'error' => 'Gemini API Error',
        'http_code' => $httpCode,
        'details' => $data,
        'raw_response' => $response
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


// ------------------------------------------------------------
// 13) استخراج رد Gemini
// ------------------------------------------------------------

$reply =
    $data['candidates'][0]['content']['parts'][0]['text']
    ?? null;


// ------------------------------------------------------------
// 14) التأكد من وجود الرد
// ------------------------------------------------------------

if ($reply === null) {

    http_response_code(502);

    echo json_encode([
        'error' => 'وصل رد من Gemini ولكن لم يتم العثور على النص',
        'response' => $data
    ], JSON_UNESCAPED_UNICODE);

    exit;
}


// ------------------------------------------------------------
// 15) إرسال الرد إلى app.js
// ------------------------------------------------------------

echo json_encode([
    'reply' => $reply
], JSON_UNESCAPED_UNICODE);

?>