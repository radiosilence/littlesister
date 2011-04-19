<?php // Routeses

$routes = array(
    '^([0-9]+)(.*)$' => 'Page:method=display_article;article_id=$1',
    '^admin/login' => 'Admin:method=login',
    '^admin/edit-article/?(.*)$' => 'Admin:method=edit_article;article_id=$1',
    '^admin/delete-article/(.*)$' => 'Admin:method=delete_article;article_id=$1',
    '^admin/new-article$' => 'Admin:method=edit_article',
    '^admin' => 'Admin',
    '^(.*?)$' => 'Page:method=index'
);

