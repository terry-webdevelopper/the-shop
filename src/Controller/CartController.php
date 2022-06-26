<?php
     
     namespace App\Controller;
      
     use App\Classe\Cart;
     use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
     use Symfony\Component\HttpFoundation\RequestStack;
     use Symfony\Component\HttpFoundation\Response;
     use Symfony\Component\Routing\Annotation\Route;
      
     class CartController extends AbstractController
     {
         /**
          * @Route("/mon-panier", name="cart")
          */
         public function index(RequestStack $stack): Response
         {
           $cart=$stack->getSession()->get('cart');          
           return $this->render('cart/index.html.twig',['cart' => $cart]);
         }
      
         /**
          * @Route("/cart/add/{id}", name="add_to_cart")
          */
         public function add(Cart $cart, $id): Response
         {
            $cart->add($id);
            return $this->redirectToRoute('cart');
         }
      
         /**
          * @Route("/cart/remove", name="remove_to_cart")
          */
         public function remove(Cart $cart): Response
         {
            $cart->remove();
            return $this->redirectToRoute('products');
         }
      
     }