<?php

namespace App\Http\Controllers\Api;

use Exception;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use InvalidArgumentException;
use Order\Application\Order\CreateOrderSvc;
use Order\Application\Order\DataContract\Message\CancelOrderMsg;
use Order\Application\Order\DataContract\Message\ChangeItemMsg;
use Order\Application\Order\DataContract\Message\CloseOrderMsg;
use Order\Application\Order\DataContract\Message\CreateOrderMsg;
use Order\Application\Order\DataContract\Message\DeliverOrderMsg;
use Order\Application\Order\DataContract\Message\GetOrderMsg;
use Order\Application\Order\DataContract\Message\ProcessOrderMsg;
use Order\Application\Order\DataContract\Result\OrderItemRst;
use Order\Application\Order\DomainService\OrderIdTranslator;
use Order\Application\Order\DomainService\OrderItemsTranslator;
use Order\Application\Order\Service\CancelOrderSvc;
use Order\Application\Order\Service\ChangeItemSvc;
use Order\Application\Order\Service\CloseOrderSvc;
use Order\Application\Order\Service\DeliverOrderSvc;
use Order\Application\Order\Service\GetOrderSvc;
use Order\Application\Order\Service\ProcessOrderSvc;
use Order\Domain\Order\Exception\OrderIdIsNullException;
use Order\Domain\Order\Exception\OrderItemEmptyException;
use Order\Domain\Order\Exception\TableNoEmptyException;
use Order\Domain\Order\Model\OrderStatus;
use Order\Infra\Repository\Mongo\OrderRepository;

class OrderController extends Controller
{
    /**
     * @param Request $request
     * @return false|string
     * @throws OrderIdIsNullException
     * @throws OrderItemEmptyException
     * @throws TableNoEmptyException
     */
    public function createOrder(Request $request)
    {
        $orderRepository = new OrderRepository();
        $orderItemsTranslator = new OrderItemsTranslator();
        $createOrderSvc = new CreateOrderSvc($orderRepository, $orderItemsTranslator);

        $inputs = $request->all();
        $items = [];
        foreach ($inputs['items'] as $item) {
            $items[] = new OrderItemRst($item['productId'], $item['qty'], $item['price']);
        }

        $createOrderMsg = new CreateOrderMsg(
            $inputs['tableNo'],
            $items
        );

        $result = $createOrderSvc->handle($createOrderMsg);

        return json_encode($result);
    }

    /**
     * @param string $id
     * @return false|string
     * @throws Exception
     */
    public function getOrder(string $id)
    {
        $orderRepository = new OrderRepository();
        $orderIdTranslator = new OrderIdTranslator();
        $getOrderSvc = new GetOrderSvc($orderRepository, $orderIdTranslator);

        $getOrderMsg = new GetOrderMsg($id);

        $orderRst = $getOrderSvc->handle($getOrderMsg);

        return json_encode($orderRst);
    }

    public function changeOrderItems(Request $request, string $id)
    {
        $items = $request->all();
        $msg = new ChangeItemMsg($id, $items);

        $orderRepository = new OrderRepository();
        $idTranslator = new OrderIdTranslator();
        $itemTranslator = new OrderItemsTranslator();
        $changeItemSvc = new ChangeItemSvc($orderRepository, $idTranslator, $itemTranslator);

        $changeItemSvc->handle($msg);

        return response('', 204);
    }

    /**
     * @param Request $request
     * @param string $id
     * @return ResponseFactory|Response
     * @throws Exception
     */
    public function changeOrderStatus(Request $request, string $id)
    {
        $repository = new OrderRepository();
        $idTranslator = new OrderIdTranslator();
        $inputs = $request->all();
        switch ($inputs['orderStatus']) {
            case OrderStatus::Processing()->getValue():
                $msg = new ProcessOrderMsg($id);
                $serv = new ProcessOrderSvc($repository, $idTranslator);
                break;
            case OrderStatus::Deliver()->getValue():
                $msg = new DeliverOrderMsg($id);
                $serv = new DeliverOrderSvc($repository, $idTranslator);
                break;
            case OrderStatus::Closed()->getValue():
                $msg = new CloseOrderMsg($id);
                $serv = new CloseOrderSvc($repository, $idTranslator);
                break;
            default:
                throw new InvalidArgumentException('order status invalid');
        }

        $serv->handle($msg);

        return response('', 204);
    }

    /**
     * @param string $id
     * @return ResponseFactory|Response
     * @throws Exception
     */
    public function cancelOrder(string $id)
    {
        $msg = new CancelOrderMsg($id);
        $serv = new CancelOrderSvc(new OrderRepository(), new OrderIdTranslator());

        $serv->handle($msg);

        return response('', 204);
    }
}
