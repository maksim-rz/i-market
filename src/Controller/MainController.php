<?php

namespace App\Controller;

use App\Entity\Category;
use App\Entity\Product;
use App\Form\CategoryType;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{

    /**
     * @Route("/", name="addProduct")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function addProduct(EntityManagerInterface $entityManager, Request $request): Response
    {
 //       $entityManager = $this->getDoctrine()->getManager();
        $product = new Product();

        $category1 = new Category();
        $category1->setName('category1');
        $product->getCategories()->add($category1);
        $category2 = new Category();
        $category2->setName('category2');
        $product->getCategories()->add($category2);
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
 //           $data = $form->getData();
            $entityManager->persist($product);
            $entityManager->flush();

            $this->addFlash('success', 'Done!');
            return $this->redirect("/");

        } 

        $productRepository = $entityManager->getRepository(Product::class);
        $products = $productRepository->findAll();

        

        return $this->render('lucky/product.html.twig', [
            'productForm' => $form->createView(),
            'products' => $products

        ]);
    }



    /**
     * @Route("/product-remove/{product}", name="remove_product")
     * @param Product $product
     * @param EntityManagerInterface $entityManager
     * @return Response
     */

    public function removeProduct(Product $product, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('addProduct');


    }




}
