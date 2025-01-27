<?php

class BlogDatabase
{
    private $pdo;

    public function __construct($dsn, $username, $password)
    {
        try {
            $this->pdo = new PDO($dsn, $username, $password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            die("Database connection failed: " . $e->getMessage());
        }
    }

    // Kullanıcı İşlemleri
    public function createUser($username, $password, $email)
    {
        $sql = "INSERT INTO users (username, password, email) VALUES (:username, :password, :email)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':username' => $username,
            ':password' => password_hash($password, PASSWORD_BCRYPT),
            ':email' => $email,
        ]);
        return $this->pdo->lastInsertId();
    }

    public function getUserById($id)
    {
        $sql = "SELECT * FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateUser($id, $userData)
    {
        $sql = "UPDATE users SET username = :username, email = :email WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':username' => $userData['username'],
            ':email' => $userData['email'],
            ':id' => $id,
        ]);
        return $stmt->rowCount();
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount();
    }

    // Blog Yazıları
    public function createPost($title, $content, $authorId)
    {
        $sql = "INSERT INTO posts (title, content, author_id) VALUES (:title, :content, :author_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':title' => $title,
            ':content' => $content,
            ':author_id' => $authorId,
        ]);
        return $this->pdo->lastInsertId();
    }

    public function getPostById($id)
    {
        $sql = "SELECT * FROM posts WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updatePost($id, $postData)
    {
        $sql = "UPDATE posts SET title = :title, content = :content WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':title' => $postData['title'],
            ':content' => $postData['content'],
            ':id' => $id,
        ]);
        return $stmt->rowCount();
    }

    public function deletePost($id)
    {
        $sql = "DELETE FROM posts WHERE id = :id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':id' => $id]);
        return $stmt->rowCount();
    }

    // Kategori İşlemleri
    public function createCategory($name)
    {
        $sql = "INSERT INTO categories (name) VALUES (:name)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':name' => $name]);
        return $this->pdo->lastInsertId();
    }

    public function getAllCategories()
    {
        $sql = "SELECT * FROM categories";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Yorum İşlemleri
    public function addComment($postId, $content, $authorId)
    {
        $sql = "INSERT INTO comments (post_id, content, author_id) VALUES (:post_id, :content, :author_id)";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            ':post_id' => $postId,
            ':content' => $content,
            ':author_id' => $authorId,
        ]);
        return $this->pdo->lastInsertId();
    }

    public function getCommentsByPost($postId)
    {
        $sql = "SELECT * FROM comments WHERE post_id = :post_id";
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([':post_id' => $postId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}

