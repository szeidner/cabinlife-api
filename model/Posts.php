<?php
class Posts
{
    protected $db;

    public function __construct(PDO $db)
    {
        $this->db = $db;
    }

    public function getAllPosts() {
        return $this->db->query('SELECT * FROM post');
    }
}