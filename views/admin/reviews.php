<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<title>Reviews</title>
<link rel="stylesheet" type="text/css" href="/trip/assets/css/fonts.css">
<link rel="stylesheet" type="text/css" href="/trip/assets/css/destination.css">
</head>
<body>
<div id="review_wrapper">
	<div id="inner_review">
		<h1>Write a Review</h1>
		<form id="review_form" method="post" action='review_handler'>
			<input type="hidden" id="reviewer" name="reviewer" value="<?php echo $_SESSION['username']; ?>">
		<div id="form_wrapper">
			<div id="locale"><label>Venue</label><?php echo $selectstring; ?></div>
		<div id="rating">
			<label>Rating</label>
			<div id="scores">
			<input type="radio" name="score" value="1">1
			<input type="radio" name="score" value="2">2
			<input type="radio" name="score" value="3">3
			<input type="radio" name="score" value="4">4
			<input type="radio" name="score" value="5">5
			</div>
		</div>
		<div id="signature"><label>Signature</label><span><?php echo ucwords($_SESSION['username']); ?></span></div>
		</div>
			<div id="text_wrapper">
				<textarea id="review_text" name="review_text" required="required" placeholder="Type <br> for line break."></textarea>
			</div>
			<input type="submit" id="review_btn" value="Submit Review">
		</form>
		<a id="backlink" href="/<?php echo $page->site_url; ?>/admin/">Back</a>
	</div>
</div>
</body>
</html>
