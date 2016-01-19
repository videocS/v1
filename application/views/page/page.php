<h1><?= $page->title; ?></h1>
<p><?= parse_bbcode(nl2br(htmlspecialchars($page->content))); ?></p>