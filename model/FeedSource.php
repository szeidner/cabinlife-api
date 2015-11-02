<?php
class FeedSource extends Model {

	public function __construct() {
		parent::__construct("FeedSource");
	}

	// get all posts from the database
	public function getAllFeedSources() {
		$stmt = $this->db->prepare('SELECT * FROM feedsource');
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_ASSOC);
	}

	// get a single post
	public function getFeedSource($id) {
		$stmt = $this->db->prepare('SELECT * FROM feedsource WHERE id=:id');
		$stmt->execute(array(':id' => $id));
		return $stmt->fetch(PDO::FETCH_ASSOC);
	}
}