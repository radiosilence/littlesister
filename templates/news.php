<?php foreach($articles as $article): ?>
<article>
<h1><?=$article->title?></h1>
<p><em><?=$article->posted_on->format("l j<\s\u\p>S</\s\u\p> F 'y")?></em> by <strong><?=$article->author_username?></strong></p>
<p><?=$article->preview?>...</p>
<p><a href="/<?=$article->id?>/<?=$article->seo_title?>.html">Read More...</a></p>
</article>
<?php endforeach; ?>
