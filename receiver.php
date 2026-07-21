<?php
// إعدادات الأمان
$SECRET_KEY = "autovem_secret_2026"; // كلمة مرور لحماية الاستقبال

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['key']) || $_POST['key'] !== $SECRET_KEY) {
        http_response_code(403);
        die("Unauthorized: مفتاح الأمان غير صحيح.");
    }

    $fileName = $_POST['file_name'] ?? '';
    $content = $_POST['content'] ?? '';

    // قائمة الملفات المسموحة فقط لحماية السيرفر من الحقن
    $allowed_files = ['task.md', 'walkthrough.md', 'implementation_plan.md'];
    
    if (!in_array($fileName, $allowed_files)) {
        http_response_code(400);
        die("Invalid file name: اسم الملف غير مسموح.");
    }

    // إنشاء مجلد المستندات إذا لم يكن موجوداً
    if (!is_dir('artifacts')) {
        mkdir('artifacts', 0755, true);
    }

    $filePath = 'artifacts/' . $fileName;
    file_put_contents($filePath, $content);
    
    echo "Success: $fileName updated successfully.";
} else {
    echo "Autovem Receiver API is online. (Use POST method to sync).";
}
?>
