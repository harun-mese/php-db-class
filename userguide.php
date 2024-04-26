<?php

// config.php dosyasını include et
include 'config.php';

// Database sınıfını include et
include 'DB.php';

// Database sınıfından bir örnek oluştur
$database = new DB();

// Örnek üzerinden bir sorgu yap
$database->query('SELECT * FROM users WHERE id = :id AND age > :age');

// Parametreleri bağla
$database->bind(':id', 1);
$database->bind(':age', 18);

// Sorguyu çalıştır ve sonucu al
$result = $database->single();

// Sonucu ekrana yazdır
print_r($result);


//  *******************************************************************************************

// Database sınıfından bir örnek oluştur
$database = new Database();

// Örnek üzerinden bir sorgu yap
$database->prepareQuery('SELECT * FROM users');

// Sorguyu çalıştır ve sonuç kümesini al
$results = $database->getResultSet();

// Sonuç kümesini ekrana yazdır
foreach ($results as $row) {
    echo "Kullanıcı ID: " . $row['id'] . ", Kullanıcı Adı: " . $row['username'] . ", Email: " . $row['email'] . "<br>";
}


