<?php
class Posts extends Model {

	public function __construct() {
		parent::__construct("Post");
	}

	// get all posts from the database
	public function getAllPosts() {
		$stmt = $this->db->prepare('SELECT * FROM post');
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	// get a single post
	public function getPost($id) {
		$stmt = $this->db->prepare('SELECT * FROM post WHERE id=:id');
		$stmt->execute(array(':id' => $id));
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
}