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

class CategoryController extends AbstractController
{
    /**
     * @Route("/add-category", name="addCategory")
     * @param EntityManagerInterface $entityManager
     * @param Request $request
     * @return Response
     */
    public function addCategory(EntityManagerInterface $entityManager, Request $request): Response
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'Done!');
            return $this->redirect("/add-category");

        }

        $categoryRepository = $entityManager->getRepository(Category::class);
        $categories = $categoryRepository->findAll();



        return $this->render('lucky/category.html.twig', [
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

    public function removeProduct(Category $category, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($category);
        $entityManager->flush();

        return $this->redirectToRoute('addCategory');


    }
}
