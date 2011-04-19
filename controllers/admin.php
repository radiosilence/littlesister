<?php

namespace Controllers;

import('core.types');
import('core.controller');
import('core.template');
import('core.utils.mobile');
import('core.exceptions');
import('core.validation');
import('controllers.page');
import('plugins.articles.article');

class Admin extends \Controllers\Page {
    protected $_confirmed_request;
    public function __construct($args=False) {
        parent::__construct($args);
        $t = $this->_template;
        try {
            $t->user_data = $this->_auth->user_data();
            $tok = ($_POST['_tok'] ? $_POST['_tok'] : $_GET['_tok']);
            $this->_confirmed_request = ($this->_session->get_tok() == $tok);
        } catch(\Core\AuthNotLoggedInError $e) {
            if($args['__uri__'] != '/admin/login') {
                header('Location: /admin/login');
                exit();
            }
        }
    }
    public function index() {
        $t = $this->_template;
        $at = \Plugins\Articles\Plugin::get_template('admin/list.php');
        $at->admin_url = '/admin';
        $at->posts = \Plugins\Articles\Article::mapper()
            ->attach_storage(\Core\Storage::container()
                ->get_storage('Article')
            )
            ->get_latest_articles();
        $t->admin_content = $at->render();
        $t->content = $t->render('admin_home.php');
        echo $t->render('main.php');
    }
    public function edit_article() {
        $t = $this->_template;
        $t->admin_content = $this->_edit_article($this->_session->get_tok(), $this->_args['article_id']);
        $t->content = $t->render('admin_home.php');
        echo $t->render('main.php');
    }

    protected function _edit_article($tok, $id=False) {
        $t = \Plugins\Articles\Plugin::get_template('admin/edit.php');
        $t->admin_url = "/admin";
        $t->tok = $tok;
        try {
            if($id) {
                $t->title = "Edit Article";
                $article = \Plugins\Articles\Article::container()
                    ->get_by_id($id);
            } else {
                $t->title = "Create Article";
                $t->new = True;
                $article = \Plugins\Articles\Article::create($_POST, True);
            }

            if($_POST['_do'] == '1' && $this->_confirmed_request) {
                $article->overwrite($_POST);
                $article->form_values();
                $validator = \Core\Validator::validator('\Plugins\Articles\Article');
                $validator->validate($_POST, \Plugins\Articles\Article::validation());
                \Core\Storage::container()
                    ->get_storage('Article')
                    ->save($article);
            }

            $t->article = $article;
                
        } catch(\Core\ValidationError $e) {
            return $this->_return_message("Fail",
                "Validation error(s):",
                $e->get_errors(), $t);
        }

        return $t->render();
    }

    public function login() {
        $t = $this->_template;
        $t->user_field = "User";
        $t->login_action = '/admin/login';
        $t->set_file('login_page.php');
        if(isset($_POST['username'])) {
            try {
                $this->_auth->attempt($_POST['username'], $_POST['password']);        
                header('Location: /admin');
            } catch(\Core\AuthAttemptError $e) {
                $t->content = $this->_return_message("Fail",
                    "Invalid username or password.");
            }            
        } else {
            $t->content = $t->render();
        }
        echo $t->render('main.php');
    }

}