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

        

        return $this->render('main/index.html.twig', [
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

    /**
     * @Route("/add-category", name="addCategory")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */

    public function addCategory(EntityManagerInterface $entityManager,Request $request): Response
    {
        //       $entityManager = $this->getDoctrine()->getManager();
        $category = new Category();
        $form = $this->createForm(CategoryType::class,$category,['method' => $request->getMethod()]);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            //           $data = $form->getData();
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success','Done!');
            return $this->redirect("/add-category");

        }

        $categoryRepository = $entityManager->getRepository(Category::class);
        $categories = $categoryRepository->findAll();

        return $this->render('main/category.html.twig',[
            'categoryForm' => $form->createView(),
            'categories' => $categories

        ]);
    }

    /**
     * @Route("/category-remove/{category}", name="remove_category")
     * @param Category $category
     * @param EntityManagerInterface $entityManager
     * @return Response
     */

    public function remove_category(Category $category,EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('addCategory');


    }
}
