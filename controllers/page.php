<?php

/**
 * Simple pagescontroller
 */

namespace Controllers;
import('core.types');
import('core.controller');
import('core.template');
import('core.utils.mobile');
import('core.exceptions');
import('plugins.articles.article');

class Page extends \Core\Controller {
    public function index() {
        $this->_init();
        $t = $this->_template;
        $t->articles = \Plugins\Articles\Article::mapper()
            ->attach_storage(\Core\Storage::container()
                ->get_storage('Article')
            )
            ->get_latest_articles();

        $t->content = $t->render('news.php');
        $t->title = 'News';
        echo $t->render('main.php');
    }
    protected function _init() {
        $t = new \Core\Template();
        $t->date = new \DateTime();
        $t->title = $this->_pages[$this->_args['page']];
        $t->page = $this->_args['page'];
        $t->menu_items = $this->_pages;
        $t->is_mobile = \Core\Utils\Mobile::detect();
        $this->_template = $t;
    }
    public function display_article() {
        $this->_init();
        $t = $this->_template;
        try {
            $t->article = \Plugins\Articles\Article::mapper()
                ->get_article($this->_args['article_id']);
            $t->article_id = $this->_args['article_id'];
            $t->content = $t->render('news_article.php');
            $t->title = $article->title;
            echo $t->render('main.php');            
        } catch (\Plugins\Articles\ArticleNotFoundError $e) {
            throw new \Core\HTTPError(404, "Article #{$this->_args[article_id]}");
        }
    }
}