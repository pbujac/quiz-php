<?php

namespace AdminBundle\Controller;

use AdminBundle\Manager\PaginatorManager;
use AppBundle\Entity\Category;
use AdminBundle\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends Controller
{
    /**
     * @param int $page = 1
     *
     * @return RedirectResponse|Response
     *
     * @Route("/category/list/{page}", name="admin.category.list")
     */
    public function listAction(int $page = 1)
    {
        $categories = $this->getDoctrine()
            ->getRepository(Category::class)
            ->getCategoriesByPage($page);

        $maxPages = ceil($categories->count() / PaginatorManager::PAGE_LIMIT);

        return $this->render('admin/category/list.html.twig', [
            'categories' => $categories->getQuery()->getResult(),
            'maxPages' => $maxPages,
            'currentPage' => $page,
        ]);
    }

    /**
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/category/create", name="admin.category.create")
     */
    public function createAction(Request $request)
    {
        $category = new Category();
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash(
                'notice',
                $category->getTitle() . ' category has been successfully added!'
            );

            return $this->redirectToRoute('admin.category.list');
        }

        return $this->render('admin/category/create.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Category $category
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/category/edit/{category}", name="admin.category.edit")
     */
    public function editAction(Category $category, Request $request)
    {
        $form = $this->createForm(CategoryType::class, $category);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();
            $em->persist($category);
            $em->flush();

            $this->addFlash(
                'notice',
                'Category has been successfully modified!'
            );

            return $this->redirectToRoute('admin.category.list');
        }

        return $this->render('admin/category/edit.html.twig', [
            'form' => $form->createView()
        ]);
    }

    /**
     * @param Category $category
     *
     * @return RedirectResponse|Response
     *
     * @Route("/category/delete/{category}", name="admin.category.delete")
     */
    public function deleteAction(Category $category)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($category);
        $em->flush();

        $this->addFlash(
            'notice',
            'Category has been successfully removed!'
        );

        return $this->redirectToRoute('admin.category.list');

    }
}
