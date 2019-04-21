<?php

namespace OrderBundle\Controller;

use MyFramework\Controller\Controller;
use MyFramework\Controller\Request;
use MyFramework\Controller\Response;

use OrderBundle\Entity\CreditCard;

use OrderBundle\Repository\CustomerRepository;
use OrderBundle\Repository\ItemRepository;

use OrderBundle\Validators\CreditCardExpirationValidator;
use OrderBundle\Validators\CreditCardNumberValidator;
use OrderBundle\Validators\NotEmptyValidator;
use OrderBundle\Validators\NumericValidator;
use OrderBundle\Service\OrderService;

use OrderBundle\Exception\BadWordsFoundException;
use OrderBundle\Exception\CustomerNotAllowedException;
use OrderBundle\Exception\ItemNotAvailableException;
use PaymentBundle\Exception\PaymentErrorException;

class OrderController extends Controller
{
    private $customerRepository;
    private $itemRepository;
    private $orderService;

    public function __construct(
        CustomerRepository $customerRepository,
        ItemRepository $itemRepository,
        OrderService $orderService
    )
    {
        $this->customerRepository = $customerRepository;
        $this->itemRepository = $itemRepository;
        $this->orderService = $orderService;
    }

    /**
     * POST /order
     *
     * int customer_id
     * int item_id
     * string description
     * int credit_card_number
     * \DateTime credit_card_expiration
     *
     * 200 - {"id":"aab5d5fd-70c1-11e5-a4fb-b026b977eb28"}
     * 404
     * 400
     * 412
     */
    public function sendOrderAction(Request $request)
    {
        if (!$this->isValid($request)) {
            return new Response(Response::BAD_REQUEST, 'Invalid parameters');
        }

        $customerID = $request->get('customer_id');
        $customer = $this->customerRepository->findByID($customerID);

        if (!$customer) {
            return new Response(Response::NOT_FOUND, 'Customer not found');
        }

        $itemID = $request->get('item_id');
        $item = $this->itemRepository->findByID($itemID);

        if (!$item) {
            return new Response(Response::NOT_FOUND, 'Item not found');
        }

        $description = $request->get('description');

        $creditCard = new CreditCard(
            $request->get('credit_card_number'),
            $request->getDate('credit_card_expiration')
        );

        try {
            $order = $this->orderService->process(
                $customer,
                $item,
                $description,
                $creditCard
            );

        } catch (CustomerNotAllowedException $e) {
            return new Response(Response::PRECONDITIONS_FAIL, '1 - Customer not allowed');
        } catch (ItemNotAvailableException $e) {
            return new Response(Response::PRECONDITIONS_FAIL, '2 - Item not available');
        } catch (BadWordsFoundException $e) {
            return new Response(Response::PRECONDITIONS_FAIL, "3 - Could not process this order");
        } catch (PaymentErrorException $e) {
            return new Response(Response::PRECONDITIONS_FAIL, "4 - Payment failed");
        }

        if ($order) {
            return new Response(Response::OK, $order->getOrderGUID());
        }

        return new Response(Response::BAD_REQUEST);
    }

    private function isValid(Request $request)
    {
        $validators = [
            new NotEmptyValidator($request->get('description')),
            new NumericValidator($request->get('item_id')),
            new NumericValidator($request->get('customer_id')),
            new CreditCardNumberValidator($request->get('credit_card_number')),
            new CreditCardExpirationValidator($request->getDate('credit_card_expiration')),
        ];

        foreach ($validators as $validator) {
            if (!$validator->isValid()) {
                return false;
            }
        }

        return true;
    }
}