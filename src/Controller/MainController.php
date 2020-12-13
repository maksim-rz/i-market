<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="index")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function index(EntityManagerInterface $entityManager, Request $request): Response
    {
 //       $entityManager = $this->getDoctrine()->getManager();
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product, ['method' => $request->getMethod()]);
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

        return $this->render('main/index.html.twig', [
            'form' => $form->createView(),
            'products' => $products

        ]);
    }

    /**
     * @Route("/remove/{product}", name="remove_product")
     * @param Product $product
     * @param EntityManagerInterface $entityManager
     * @return Response
     */

    public function removeProduct(Product $product, EntityManagerInterface $entityManager)
    {
        $entityManager->remove($product);
        $entityManager->flush();

        return $this->redirectToRoute('index');


    }
}
