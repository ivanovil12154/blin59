<?php
/*
  if ($_SERVER['REQUEST_METHOD'] <> 'POST') {
    $rows = [["ERROR", "NotPost"]];
    echo json_encode($rows);
    exit;
  };
  echo "Begin";

  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['my_file'])) {
    // Получаем путь к временному файлу
    $tmpName = $_FILES['my_file']['tmp_name'];

    // Читаем и выводим содержимое
    if (file_exists($tmpName)) {
        echo "<pre>" . htmlspecialchars(file_get_contents($tmpName)) . "</pre>";
    } else {
        echo "Файл не загружен.";
    }
   };

*/
$host = 'localhost';
$db   = 'u198290_blin';
$user = 'u198290_user';
$pass = 'user@blin59';
$charset = 'utf8mb4';


$pdo = new PDO('mysql:host=localhost;dbname=u198290_blin', 'u198290_user', 'user@blin59');
//$pdo = ConnectPDO();
try {

if ($_FILES['my_file']['error'] === UPLOAD_ERR_OK) {
    // 1. Получаем бинарные данные файла
    $fileData = file_get_contents($_FILES['my_file']['tmp_name']);
    $fileName = $_FILES['my_file']['name'];
    $fileSize = $_FILES['my_file']['size'];    

    echo $fileData;
    echo $fileName;


    // 2. Подготавливаем запрос (используем PDO)
//    $stmt = $pdo->prepare("INSERT INTO files (filename, filedata) VALUES (?, ?)");

    $stmt = $pdo->prepare("INSERT INTO TFiles(FileName, FileAutorID, FileSize, FileData) VALUES (?,?,?,?)");

    // 3. Выполняем запрос
    $stmt->execute([$fileName, 4, $fileSize, $fileData]);
    echo "Файл успешно сохранен в базе данных.";
} else {
    echo "Ошибка";    
 
}


  } catch (Exception $e) {
    $rows = [["ERROR", "PHP", $e->getMessage()]];
    echo json_encode($rows);    
};

?>