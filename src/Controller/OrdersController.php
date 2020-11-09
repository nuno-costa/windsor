<?php
declare(strict_types = 1);

namespace App\Controller;

use App\Entity\SerializableEntity;
use App\OrderService;
use App\Exception\UserReturnableException;
use App\Repository\OrderRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\ORM\EntityManagerInterface;

class OrdersController extends AbstractController
{
    /**
     * list all orders in the system
     * 
     * @Route("/orders", name="orders_list", methods={"GET","HEAD"})
     */
    public function index(OrderRepository $orderRepository): Response
    {
        $result = [];
        $data = $orderRepository->findAll();
        array_walk($data, function(SerializableEntity $record) use (&$result){
            $result[] = $record->toArray();
        });

        return $this->json($result);
    }

     /**
     * creates a new order in the system
     * 
     * @Route("/orders", name="orders_create", methods={"POST"})
     */
    public function create(Request $request, OrderService $OrderService, EntityManagerInterface $em)
    {
        try {
            $em->persist(
                $OrderService->createNewOrderFromArray($this->getBodyData($request))
            );
            $em->flush();

            return new Response('', 201);
        } catch(UserReturnableException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }

     /**
     * update an order in the system
     * 
     * @Route("/order/{id}", name="orders_update", methods={"PATCH"})
     */
    public function update(Request $request, int $id, OrderService $OrderService, EntityManagerInterface $em)
    {
        try {
            $em->persist(
                $OrderService->updateOrderFromArray($id, $this->getBodyData($request))
            );
            $em->flush();

            return new Response('', 200);
        } catch(UserReturnableException $e) {
            return $this->json(['error' => $e->getMessage()], 400);
        }
    }

    /**
     * Returns the request body data as na array
     * 
     * @param Request $request
     * 
     * @return mixed[]
     * 
     * @throws UserReturnableException
     */
    private function getBodyData(Request $request): array
    {
        $body = json_decode($request->getContent(), true);
        if (!$body) {
            throw new UserReturnableException('invalid json');
        }

        return $body;
    }
}
