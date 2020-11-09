<?php
declare(strict_types = 1);

namespace App;

use App\Entity\Client;
use App\Entity\Order;
use App\Entity\OrderType;
use App\Entity\OrderStage;
use App\Repository\ClientRepository;
use App\Repository\OrderStageRepository;
use App\Repository\OrderTypeRepository;
use App\Exception\BadOrderRequestException;
use App\Repository\AllowedStagesPerOrderTypeRepository;
use App\Repository\OrderRepository;
use Symfony\Component\EventDispatcher\GenericEvent ;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class OrderService
{
    /**
     * @var ClientRepository
     */
    private $clientRepository;

    /**
     * @var OrderStageRepository
     */
    private $orderStageRepository;

    /**
     * @var OrderTypeRepository
     */
    private $orderTypeRepository;

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * @var AllowedStagesPerOrderTypeRepository
     */
    private $allowedStagesPerOrderTypeRepository;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    /**
     * @var string
     */
    const ORDER_CREATED_STATE = 'created';

    public function __construct(
        ClientRepository $clientRepository, 
        OrderStageRepository $orderStageRepository,
        OrderTypeRepository $orderTypeRepository, 
        OrderRepository $orderRepository,
        AllowedStagesPerOrderTypeRepository $allowedStagesPerOrderTypeRepository,
        EventDispatcherInterface $eventDispatcher
    ){
        $this->clientRepository = $clientRepository;
        $this->orderStageRepository = $orderStageRepository;
        $this->orderTypeRepository = $orderTypeRepository;
        $this->orderRepository = $orderRepository;
        $this->allowedStagesPerOrderTypeRepository = $allowedStagesPerOrderTypeRepository;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * returns an order Entity created with values gathered from a Request body
     * this methoded is intended to be used with the data from POST issued to create a new order
     * 
     * @param array $requestData
     * 
     * @return Order
     */
    public function createNewOrderFromArray(array $requestData): Order
    {
        if (
            !array_key_exists('client_id', $requestData) ||
            !array_key_exists('type', $requestData) ||
            array_key_exists('stage', $requestData)  // new orders cannot include stage
        ){
            throw new BadOrderRequestException('invalid request');
        }

        $requestData['stage'] = self::ORDER_CREATED_STATE;

        return $this->populateOrder(new Order, $requestData);
    }

    /**
     * updates an order entity with data provided in an array
     * this methoded is intended to be used with the data from PATCH request issued to update an order
     * 
     * @param int $orderId
     * @param array $requestData
     * 
     * @return Order
     * 
     * @throws BadOrderRequestException
     */
    public function updateOrderFromArray(int $orderId, array $requestData): Order
    {
        $order = $this->orderRepository->findOneBy(['id' => $orderId]);
        
        if (!$order) {
            throw new BadOrderRequestException('invalid order id');
        }

        return $this->populateOrder($order, $requestData);
    }

    /**
     * populates an order with data from an array
     * 
     * @param Order $order
     * @param array $data
     * 
     * @return Order
     */
    private function populateOrder(Order $order, array $data): Order
    {
        if (array_key_exists('client_id', $data)) {
            $order->setClient($this->getClient($data['client_id']));
        }

        if (array_key_exists('type', $data)) {
            $order->setType($this->getType($data['type']));
        }

        if (array_key_exists('stage', $data)) {
            $stage = $this->getStage($data['stage']);
            $allowedStage = $this->allowedStagesPerOrderTypeRepository->findOneBy([
                'type' => $order->getType(),
                'stage' => $stage
            ]);

            if (!$allowedStage) {
                throw new BadOrderRequestException('Stage not allowed for order');
            }

            $order->setStage($stage);

            $event = new GenericEvent($order, ['type' => 'order.state.change']);
            $this->eventDispatcher->dispatch($event, 'order.state.change');
        }

        return $order;
    }
    
    /**
     * returns a Client Entity from the given $id
     * 
     * @param int $id
     * 
     * @return Client
     * 
     *  @throws BadOrderRequestException
     */
    private function getClient(int $id): Client
    {
        $client = $this->clientRepository->findOneBy(['id' => $id]);
        if (!$client) {
            throw new BadOrderRequestException('invalid client id');
        }

        return $client;
    }
    
    /**
     * returns a OrderType Entity from the given $name
     * 
     * @param string $name
     * 
     * @return OrderType
     * 
     *  @throws BadOrderRequestException
     */
    private function getType(string $name): OrderType
    {
        $type = $this->orderTypeRepository->findOneBy(['name' => \strtolower($name)]);
        if (!$type) {
            throw new BadOrderRequestException('invalid order type');
        }

        return $type;
    }

    /**
     * returns a OrderStage Entity from the given $id
     * 
     * @param string $name
     * 
     * @return OrderStage
     * 
     *  @throws BadOrderRequestException
     */
    private function getStage(string $name): OrderStage
    {
        $stage = $this->orderStageRepository->findOneBy(['name' => \strtolower($name)]);
        if (!$stage) {
            throw new BadOrderRequestException('Invalid order Stage');
        }

        return $stage;
    }
}