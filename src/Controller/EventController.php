<?php

namespace App\Controller;

use App\Entity\Event;
use App\Form\EventFormType;
use App\Repository\EventRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
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
    public function index(Request $request, EventRepository $eventRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $eventRepository->queryAll(),
            $request->query->getInt('page', 1),
            EventRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'event/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * @return Response HTTP response
     * @Route(
     *     "/",
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
     * @param \App\Repository\CategoryRepository        $eventRepository Contact repository
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
     * @param \App\Entity\Category                      $event           Contact entity
     * @param \App\Repository\CategoryRepository        $eventRepository Contact repository
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
}
