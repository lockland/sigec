<?php

namespace Sigec\controller;

use Sigec\view\Product as View;
use Core\helpers\Redirector;
use Sigec\model\Product;

class ProductController extends ControllerBase
{
    private $view = null;
    private $model = null;

    public function __construct()
    {
        parent::__construct();
        $this->view = new View();
        $this->view->assign('action', '');
        $this->view->assign('controller', 'Product');
        $this->view->assign('username', $this->user->getName());
        $this->model = new Product(new \PDO(DB_DSN, DB_USER, DB_PASS));
    }

    public function listAll()
    {
        $this->view->assign('products', $this->model->fetchAll());
        $this->view->generateHTML();
    }

    public function add($errors = [], $product = null)
    {
        $this->view->assign('errors', $errors);
        $this->view->assign('product', $product);
        $this->view->assign('action', __FUNCTION__);
        $this->view->generateHTML();
    }

    public function update($errors = [], $product = null)
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        $product = $product ?: new \StdClass();

        try {
            $this->model->retrieve($id);
            $product->ID = $this->model->getId();
            $product->DESC_PROD = $this->model->getDescription();
            $product->ESTOQ_MIN = $this->model->getMinQuantity();
            $product->ESTOQ_MAX = $this->model->getMaxQuantity();
            $product->VALOR_CUSTO = $this->model->getValue();
            $product->VALOR_VENDA = $this->model->getSalesValue();
            $product->OBS = $this->model->getOBS();
            $product->QTDE = $this->model->getQuantity();
            $product->GRUPO_ID = $this->model->getGroup();
            $product->FAMILIA_ID = $this->model->getFamily();
            $product->LOCAL_ID = $this->model->getLocal();
            $product->FORNECEDOR_ID = $this->model->getSupply();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $errors[] = 'Could not retrieve product using id';
        }

        $this->view->assign('errors', $errors);
        $this->view->assign('product', $product);
        $this->view->assign('action', __FUNCTION__);
        $this->view->generateHTML();
    }

    public function save()
    {
        $errors = [];
        $post = (object) $_POST;
        try {
            $this->model
                ->setId((int) $post->id)
                ->setDescription($post->desc_prod)
                ->setMinQuantity($post->estoq_min)
                ->setMaxQuantity($post->estoq_max)
                ->setQuantity($post->qtde_prod)
                ->setValue($post->val_custo)
                ->setSalesValue($post->val_venda)
                ->setOBS($post->observ)
                ->save();
        } catch (\Exception $e) {
            error_log($e->getMessage());
            $errors[] = 'Could not store the product in database';
        }

        $action = $_GET['action'];
        
        if (count($errors) <= 0) {
            $redirector = new Redirector('Product', 'listAll');
            $redirector->redirect();
        }

        $this->$action($errors, $post);
    }

    public function filter()
    {
        $this->view->assign('products', $this->model->filter($_POST['field']));
        $this->view->generateHTML();
    }
}
