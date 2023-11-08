<?php

require_once __DIR__ . '/Database.php';

class Posts
{
    private int $id;
    private string $latvar;
    private string $lngvar;
    private string $title;
    private string $body;
    private string $updatedAt;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getlatvar(): string
    {
        return $this->latvar;
    }

    public function setlatvar(string $latvar)
    {
        $this->id = $latvar;
    }

    public function getlngvar(): string
    {
        return $this->latvar;
    }

    public function setlngvar(string $lngvar)
    {
        $this->id = $lngvar;
    }

    public function getTitle(): string
    {
        return $this->id;
    }

    public function setTitle(string $title)
    {
        $this->id = $title;
    }

    public function getBody(): string
    {
        return $this->body;
    }

    public function setBody(string $body)
    {
        $this->body = $body;
    }

    public function getUpdatedAt(): string
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(string $updatedAt)
    {
        $this->updatedAt = $updatedAt;
    }

    public static function createPost(string $body, string $title, string $latvar, string $lngvar, int $id)
    {
        $pdo = Database::getPDO();

        $sql = <<<SQL
            INSERT INTO posts (title, body, pos_lat,pos_lng, id)
            VALUES (:title, :body, :latvar, :lngvar, :id)
        SQL;

        $statement = $pdo->prepare($sql);
        $statement->execute([
            'title' => $title,
            'body' => $body,
            'latvar' => $latvar,
            'lngvar' => $lngvar,
            'id' => $id,
        ]);
        $pdo = Database::getPDO();


        $sqlPid = <<<SQL
            SELECT LAST_INSERT_ID() 
        SQL;
    }
}
