<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventFormFilterType;
use App\Form\EventFormType;
use App\Repository\CategoryRepository;
use App\Repository\EventRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class EventController
 * @Route("/event")
 */
class EventController extends AbstractController
{
    /**
     * @return Response HTTP response
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="event_index",
     * )
     */
    public function index(Request $request, EventRepository $eventRepository, PaginatorInterface $paginator, CategoryRepository $categoryRepository): Response
    {
        $pagination = $paginator->paginate(
            $eventRepository->queryAll(),
            $request->query->getInt('page', 1),
            EventRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        $categoryChoices = $categoryRepository->getNamesForFormFilter();
        $formFilter = $this->createForm(EventFormFilterType::class, null, [
            'method' => 'GET',
            'category_choices' => $categoryChoices
        ]);
        $formFilter->handleRequest($request);

        return $this->render(
            'event/index.html.twig',
            [
                'pagination' => $pagination,
                'formFilter' => $formFilter->createView(),
            ]
        );
    }

    /**
     * @return Response HTTP response
     * @Route(
     *     "/search",
     *     methods={"GET"},
     *     name="event_search",
     * )
     */
    public function search(Request $request): Response
    {
        return $this->render(
            'event/search.html.twig',
            []
        );
    }


    /**
     * Create action.
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Repository\CategoryRepository        $eventRepository Event repository
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="event_create",
     * )
     */
    public function create(Request $request, EventRepository $eventRepository): Response
    {
        $event = new Event();
        $form = $this->createForm(EventFormType::class, $event);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event->setUser($this->getUser());
            $eventRepository->save($event);

            return $this->redirectToRoute('event_index');
        }

        return $this->render(
            'event/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Category                      $event           Event entity
     * @param \App\Repository\CategoryRepository        $eventRepository Event repository
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="event_edit",
     * )
     */
    public function edit(Request $request, Event $event, EventRepository $eventRepository): Response
    {
        $form = $this->createForm(EventFormType::class, $event, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $event->setUser($this->getUser());
            $eventRepository->save($event);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('event_index');
        }

        return $this->render(
            'event/edit.html.twig',
            [
                'form' => $form->createView(),
                'event' => $event,
            ]
        );
    }

    /**
     * Delete action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Category                      $event           Event entity
     * @param \App\Repository\CategoryRepository        $eventRepository Event repository
     *
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     *
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/delete",
     *     methods={"GET", "DELETE"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="event_delete",
     * )
     */
    public function delete(Request $request, Event $event, EventRepository $eventRepository): Response
    {
        $form = $this->createForm(FormType::class, $event, ['method' => 'DELETE']);
        $form->handleRequest($request);

        if ($request->isMethod('DELETE') && !$form->isSubmitted()) {
            $form->submit($request->request->get($form->getName()));
        }

        if ($form->isSubmitted() && $form->isValid()) {
            $eventRepository->delete($event);
            $this->addFlash('success', 'message.deleted_successfully');

            return $this->redirectToRoute('event_index');
        }

        return $this->render(
            'event/delete.html.twig',
            [
                'form' => $form->createView(),
                'event' => $event,
            ]
        );
    }
}
