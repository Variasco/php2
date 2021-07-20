<?php


namespace app\controllers;


use app\engine\App;
use app\exceptions\AuthException;

class AdminController extends MainController
{
    protected function actionIndex()
    {
        $userRepository = App::call()->userRepository;
        $isAdmin = $userRepository->isAdmin();
        $userName = $userRepository->getUser();
        if ($isAdmin) {
            $orders = App::call()->orderRepository->getAll();
            echo $this->render('admin', [
                'orders' => $orders,
            ]);
        } else {
            throw new AuthException("У пользователя {$userName} недостаточно прав для просмотра содержимого страницы");
        }
    }

    protected function actionOrderDetails()
    {
        $userRepository = App::call()->userRepository;
        $isAdmin = $userRepository->isAdmin();
        $userName = $userRepository->getUser();
        $params = [];
        if ($isAdmin) {
            $id = App::call()->request->getParams()['id'] ?? null;
            $order = App::call()->orderRepository->getOne($id);
            $userSessionId = $order['session_id'] ?? null;
            $params['cartGoods'] = App::call()->cartRepository->getCart($userSessionId);
            $params['total'] = App::call()->cartRepository->getTotalPrice($userSessionId);
            $params['order'] = $order;
            $params['statuses'] = App::call()->config['statuses'];
            echo $this->render('orderDetails', $params);
        } else {
            throw new AuthException("У пользователя {$userName} недостаточно прав для просмотра содержимого страницы");
        }
    }

    protected function actionChangeStatus()
    {
        $status = App::call()->request->getParams()['status'] ?? null;
        $id = App::call()->request->getParams()['id'] ?? null;
        $order = App::call()->orderRepository->getOneAsObject($id);
        if ($order) {
            $order->status = $status;
            App::call()->orderRepository->save($order);
            $response['status'] = 'ok';
        } else {
            $response['status'] = 'error';
        }
        echo json_encode($response);
    }
}
