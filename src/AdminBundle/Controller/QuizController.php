<?php

namespace AdminBundle\Controller;

use AdminBundle\Form\CreateQuizType;
use AdminBundle\Form\EditQuizType;
use AdminBundle\Manager\PaginatorManager;
use AppBundle\Entity\Quiz;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class QuizController extends Controller
{
    /**
     * @param int $page = 1
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/quiz/list/{page}",name="admin.quiz.list")
     */
    public function listAction(Request $request, int $page = 1)
    {
        $filter = $request->get('filter');

        $quizzes = $this->getDoctrine()
            ->getRepository(Quiz::class)
            ->getQuizByFilter($filter, $page);

        $maxPages = ceil($quizzes->count() / PaginatorManager::PAGE_LIMIT);

        return $this->render('admin/quiz/list.html.twig', [
            'quizzes' => $quizzes->getQuery()->getResult(),
            'maxPages' => $maxPages,
            'currentPage' => $page,
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse|Response
     *
     * @Route("/quiz/create", name="admin.quiz.create")
     */
    public function createAction(Request $request)
    {
        $form = $this->createForm(CreateQuizType::class, new Quiz());
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $quiz = $form->getData();
            $quiz->setAuthor($this->getUser());

            $em = $this->getDoctrine()->getManager();
            foreach ($quiz->getQuestions() as $question) {
                $question->setQuiz($quiz);
                $em->persist($question);

                foreach ($question->getAnswers() as $answer) {
                    $answer->setQuestion($question);
                    $em->persist($answer);
                }
            }
            $em->persist($quiz);
            $em->flush();

            return $this->redirectToRoute('admin.dashboard');
        }

        return $this->render(
            "admin/quiz/create.html.twig",
            ['form' => $form->createView()]
        );
    }

    /**
     * @param Quiz $quiz
     * @param Request $request
     *
     * @return RedirectResponse|Response
     *
     * @Route("/quiz/{quiz_id}/edit", name="admin.quiz.edit")
     *
     * @ParamConverter("quiz", options={"id" = "quiz_id"})
     */
    public function editAction(Quiz $quiz, Request $request)
    {
        $form = $this->createForm(EditQuizType::class, $quiz);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            $em->persist($quiz);
            $em->flush();

            $this->addFlash(
                'notice',
                'Quiz has been successfully modified!'
            );

            return $this->redirectToRoute('admin.quiz.edit', [
                'quiz_id' => $quiz->getId(),
            ]);
        }
        return $this->render('admin/quiz/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @param Quiz $quiz
     *
     * @return RedirectResponse|Response
     *
     * @Route("/quiz/{quiz_id}/delete", name="admin.quiz.delete")
     *
     * @ParamConverter("quiz", options={"id" = "quiz_id"})
     */
    public function deleteAction(Quiz $quiz)
    {
        $em = $this->getDoctrine()->getManager();

        $em->remove($quiz);
        $em->flush();

        $this->addFlash(
            'notice',
            'Quiz has been successfully removed!'
        );

        return $this->redirectToRoute('admin.quiz.list');
    }
}
