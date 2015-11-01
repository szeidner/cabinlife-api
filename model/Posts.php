<?php
class Posts extends Model {

	public function __construct() {
		parent::__construct("Posts");
	}

	public function getAllPosts() {
		return $this->db->query('SELECT * FROM post');
	}
}