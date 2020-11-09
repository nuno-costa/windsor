<?php
declare(strict_types = 1);

namespace App\Tests;

use App\Entity\Client;
use App\Entity\OrderStage;
use App\Entity\OrderType;
use App\OrderService;
use PHPUnit\Framework\TestCase;
use App\Exception\BadOrderRequestException;
use App\Repository\ClientRepository;
use App\Repository\OrderStageRepository;
use App\Repository\OrderTypeRepository;
use App\Repository\OrderRepository;
use App\Repository\AllowedStagesPerOrderTypeRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Prophecy\Argument;

class OrderServiceTest extends TestCase
{
    public function setUp()
    {
        $this->prophet = new \Prophecy\Prophet();


        $client =  $this->prophet->prophesize(Client::class);
        $client->getId()->willReturn(1);

        $this->clientRepository = $this->prophet->prophesize(ClientRepository::class); 
        $this->clientRepository->findOneBy(['id' => 1])->willReturn($client);

        $this->orderStageRepository = $this->prophet->prophesize(OrderStageRepository::class);
        $this->orderStageRepository->findOneBy(['name' => 'created'])->willReturn(new OrderStage);
        
        $this->orderTypeRepository = $this->prophet->prophesize(OrderTypeRepository::class); 
        $this->orderTypeRepository->findOneBy(['name' => 'trial'])->willReturn(new OrderType);

        $this->orderRepository = $this->prophet->prophesize(OrderRepository::class);

        $this->allowedStagesPerOrderTypeRepository = $this->prophet->prophesize(AllowedStagesPerOrderTypeRepository::class);   
        $this->allowedStagesPerOrderTypeRepository->findOneBy(Argument::any())->willReturn(true); 
        
        $this->eventDispatcher = $this->prophet->prophesize(EventDispatcherInterface::class);
        $this->eventDispatcher->dispatch(Argument::any(), Argument::any())->willReturn(new \StdClass);

        $this->orderService = new OrderService(
            $this->clientRepository->reveal(), 
            $this->orderStageRepository->reveal(), 
            $this->orderTypeRepository->reveal(), 
            $this->orderRepository->reveal(), 
            $this->allowedStagesPerOrderTypeRepository->reveal(),
            $this->eventDispatcher->reveal()
        );
    }
    
    public function tearDown()
    {
        $this->prophet->checkPredictions();
    }

    public function test_it_validates_data_when_creating_new_order()
    {
        $this->expectException(BadOrderRequestException::class);
        $this->orderService->createNewOrderFromArray([]);
    }

    public function test_it_allows_valid_keys_when_creating_new_order()
    {
        $order = $this->orderService->createNewOrderFromArray(['client_id' => 1, 'type' => 'trial']);
        $this->assertSame($order->getClient()->getId(), 1);
    }

    public function test_it_fails_if_stage_is_not_allowed()
    {
        $this->expectException(BadOrderRequestException::class);
        $this->allowedStagesPerOrderTypeRepository->findOneBy(Argument::any())->willReturn(null); 
        $this->orderService = new OrderService(
            $this->clientRepository->reveal(), 
            $this->orderStageRepository->reveal(), 
            $this->orderTypeRepository->reveal(), 
            $this->orderRepository->reveal(), 
            $this->allowedStagesPerOrderTypeRepository->reveal(),
            $this->eventDispatcher->reveal()
        );

         $this->orderService->createNewOrderFromArray(['client_id' => 1, 'type' => 'trial']);
    }
}