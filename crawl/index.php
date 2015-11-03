<?php

// remove all the limits
set_time_limit(0);
ini_set('memory_limit', '-1');
ini_set('display_errors', true);
date_default_timezone_set('America/New_York');

require_once __DIR__ . '/dom.php'; # for PHP 5.3+
require_once __DIR__ . '/../includes/config.php';
require_once __DIR__ . '/../core/Model.php';
require_once __DIR__ . '/../model/FeedSource.php';
require_once __DIR__ . '/../model/Post.php';
$postModel = new Post();

// get feed list from database
$feedSourceModel = new FeedSource();
$feedSources = $feedSourceModel->getAllFeedSources();

// create a new dom doc
$doc = new DOMDocument();

foreach ($feedSources as $feedSource) {
	$e = $feedSource['url'];

	echo "doing $e...<br>";

	$doc->load($e);

	// check resource[i] root node is 'entry'
	$entrys = $doc->getElementsByTagName("entry");
	$has = false;
	foreach ($entrys as $entry) {
		$has = true;
	}

	// check resource[i] root node is 'item'
	if (!$has) {
		$entrys = $doc->getElementsByTagName("item");
	}

	foreach ($entrys as $entry) {
		//url of the article in feed,
		//headline of the article,
		//summary text of article,
		//time article was posted,
		//time added to DB,
		//image associated with article,
		//source of the article

		//get rss title
		$titles = $entry->getElementsByTagName("title");
		$title = $titles->item(0)->nodeValue;

		//get rss link
		$links = $entry->getElementsByTagName("link");
		$link = $links->item(0)->nodeValue;
		//if link Value is NULL, then get href
		if ($link == "") {
			$links = $entry->getElementsByTagName("link");
			$link = $links->item(0)->getattribute("href");
		}
		//get rss description
		$descriptions = $entry->getElementsByTagName("description");
		$description = $descriptions->item(0)->nodeValue;
		//if description Value is NULL, then Tag name "content"
		if ($description == "") {
			$descriptions = $entry->getElementsByTagName("content");
			$description = $descriptions->item(0)->nodeValue;
		}
		// if description Value is still NULL, then Tag name "encoded" (Wired Feeds)
		if ($description == "") {
			$descriptions = $entry->getElementsByTagName("encoded");
			$description = $descriptions->item(0)->nodeValue;
		}

		//format description
		$html = str_get_html($description);
		//remove images
		foreach ($html->find("img") as $d) {
			$d->outertext = "";
		}

		//get 50 words and remove specific char
		$description = trim($html->plaintext);
		// $arr = explode(' ', str_replace('* ', "", $description));
		// $i = 0;
		// $description = "";
		// foreach ($arr as $c) {
		// 	$i++;
		// 	if ($i <= 50) {
		// 		$description .= $c . " ";
		// 	}
		// }
		$description = trim(str_replace('</img>', '', $description));
		$description = trim(str_replace('[HTML1]', '', $description));

		//get rss pubDate
		$pubDates = $entry->getElementsByTagName("pubDate");
		$pubDate = $pubDates->item(0)->nodeValue;
		//if pubDate Value is NULL, then Tag name "published"
		if ($pubDate == "") {
			$pubDates = $entry->getElementsByTagName("published");
			$pubDate = $pubDates->item(0)->nodeValue;
		}

		//get image
		$images = $entry->getElementsByTagName("thumbnail");
		$image = "";
		if (!is_null($images->item(0))) {
			$image = $images->item(0)->nodeValue;
			$arr = explode('src="', $image);
			if (count($arr) > 1) {
				$image = $arr[1];
				$arr1 = explode('"', $image);
				$image = $arr1[0];
			}
		}

		//convert datetime to normal datetime
		$time = strtotime($pubDate);
		$end_date = date('Y-m-d : h:i:s', $time);

		if (!$postModel->postWithLinkExists($link)) {
			//Insert data to DB
			$post['feedsource_id'] = intval($feedSource['id']);
			$post['title'] = $title;
			$post['link'] = $link;
			$post['publishedAt'] = $end_date;
			$post['image'] = $image;
			$post['totalViews'] = 0;
			$post['favorites'] = 0;
			$post['latitude'] = 0;
			$post['longitude'] = 0;
			$post['summary'] = $description;
			$post['body'] = $description;

			$postModel->addPost($post);
		}
	}
	echo "$e is done.<br>";
}