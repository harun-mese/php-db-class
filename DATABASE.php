<?php

include 'config.php';

class Database {
    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;

    private $conn;
    private $error;
    private $stmt;

    public function __construct() {
        // PDO bağlantısını oluştur
        $conn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname;
        $options = array(
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        );

        try {
            $this->conn = new PDO($conn, $this->user, $this->pass, $options);
        } catch(PDOException $e) {
            $this->error = $e->getMessage();
        }
    }

    public function addPost($title, $content, $category) {
        $this->stmt = $this->conn->prepare('INSERT INTO posts (title, content, category) VALUES (:title, :content, :category)');
        $this->stmt->bindParam(':title', $title);
        $this->stmt->bindParam(':content', $content);
        $this->stmt->bindParam(':category', $category);
        return $this->stmt->execute();
    }

    public function deletePost($id) {
        $this->stmt = $this->conn->prepare('DELETE FROM posts WHERE id = :id');
        $this->stmt->bindParam(':id', $id);
        return $this->stmt->execute();
    }

    public function updatePost($id, $title, $content, $category) {
        $this->stmt = $this->conn->prepare('UPDATE posts SET title = :title, content = :content, category = :category WHERE id = :id');
        $this->stmt->bindParam(':id', $id);
        $this->stmt->bindParam(':title', $title);
        $this->stmt->bindParam(':content', $content);
        $this->stmt->bindParam(':category', $category);
        return $this->stmt->execute();
    }

    public function getPostById($id) {
        $this->stmt = $this->conn->prepare('SELECT * FROM posts WHERE id = :id');
        $this->stmt->bindParam(':id', $id);
        $this->stmt->execute();
        return $this->stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getPostsByCategory($category) {
        $this->stmt = $this->conn->prepare('SELECT * FROM posts WHERE category = :category');
        $this->stmt->bindParam(':category', $category);
        $this->stmt->execute();
        return $this->stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

//********************************************************************************************** */
// Database sınıfını include et
include 'Database.php';

// Database sınıfından bir örnek oluştur
$db = new Database();

// Post ekle
$db->addPost('Başlık', 'İçerik', 'Kategori');

// Post sil
$db->deletePost(1);

// Post güncelle
$db->updatePost(1, 'Yeni Başlık', 'Yeni İçerik', 'Yeni Kategori');

// ID ile post getir
$post = $db->getPostById(1);

// Blog kategorisindeki tüm içerikleri getir
$posts = $db->getPostsByCategory('Blog');

