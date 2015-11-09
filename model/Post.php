<?php
class Post extends Model {

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

	public function postWithLinkExists($link) {
		$stmt = $this->db->prepare('SELECT * FROM post WHERE link=:link');
		$stmt->execute(array(':link' => $link));
		return $stmt->fetchColumn() > 0;
	}

	// add a post to the db
	public function addPost($post) {
		$sql = 'INSERT INTO post (feedsource_id, title, link, publishedAt, updated, image, ' .
			'totalViews, favorites, latitude, longitude, summary, body) VALUES ' .
			'(:feedsource_id, :title, :link, :publishedAt, :updated, :image, :totalViews, :favorites, ' .
			':latitude, :longitude, :summary, :body)';
		$stmt = $this->db->prepare($sql);
		$stmt->execute(array(':feedsource_id' => $post['feedsource_id'],
			':title' => $post['title'],
			':link' => $post['link'],
			':publishedAt' => $post['publishedAt'],
			':updated' => $post['updated'],
			':image' => $post['image'],
			':totalViews' => $post['totalViews'],
			':favorites' => $post['favorites'],
			':latitude' => $post['latitude'],
			':longitude' => $post['longitude'],
			':summary' => $post['summary'],
			':body' => $post['body']));
	}
}