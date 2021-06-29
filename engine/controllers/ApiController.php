<?php


namespace app\controllers;


use app\models\Product;

class ApiController extends MainController
{
    protected function actionIndex() {
        if (isset($_GET['page'])) {
            $page = (int)$_GET['page'];
            $catalog = (new Product())->getLimit($page);

            $response[] = $this->renderTemplate('catalogMore', [
                'catalog' => $catalog,
            ]);
            $response[] = $page + QUANTITY;
            echo json_encode($response);
        }
    }
}
