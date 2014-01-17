<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<title>Blog</title>
<link rel="stylesheet" type="text/css" href="/trip/assets/css/fonts.css">
<link rel="stylesheet" type="text/css" href="/trip/assets/css/map.css">
</head>
<body>
	<div id="blog_wrapper">
		<div id="inner_blog">
		<h1>Create a New Post</h1>
		<form id="blog_form" method="post" action='blog_handler'>
			<input type="hidden" id="bloggername" name="name" value="<?php echo $_SESSION['username']; ?>">
			<textarea id="blog_text" name="blog_text" required="required" placeholder="Type <br> for line break."></textarea><br>
			<input type="submit" value="Submit Post">
		</form>
		<a class="backlink" href="/<?php echo $page->site_url; ?>/admin/">Back</a>
		</div>
	</div>
</body>
</html>
