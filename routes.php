<?php // Routeses

$routes = array(
    '^([0-9]+)(.*)$' => 'Page:method=display_article;article_id=$1',
    '^(.*?)$' => 'Page:method=index'
);

