<?php

namespace App\Controller;

use App\Entity\Contact;
use App\Form\ContactFormType;
use App\Repository\ContactRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class ContactController
 * @Route("/contact")
 */
class ContactController extends AbstractController
{
    /**
     * @return Response HTTP response
     * @Route(
     *     "/",
     *     methods={"GET"},
     *     name="contact_index",
     * )
     */
    public function index(Request $request, ContactRepository $contactRepository, PaginatorInterface $paginator): Response
    {
        $pagination = $paginator->paginate(
            $contactRepository->queryAll(),
            $request->query->getInt('page', 1),
            ContactRepository::PAGINATOR_ITEMS_PER_PAGE
        );

        return $this->render(
            'contact/index.html.twig',
            ['pagination' => $pagination]
        );
    }

    /**
     * Create action.
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Repository\CategoryRepository        $contactRepository Contact repository
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/create",
     *     methods={"GET", "POST"},
     *     name="contact_create",
     * )
     */
    public function create(Request $request, ContactRepository $contactRepository): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactFormType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->save($contact);

            return $this->redirectToRoute('contact_index');
        }

        return $this->render(
            'contact/create.html.twig',
            ['form' => $form->createView()]
        );
    }

    /**
     * Edit action.
     *
     * @param \Symfony\Component\HttpFoundation\Request $request            HTTP request
     * @param \App\Entity\Category                      $contact           Contact entity
     * @param \App\Repository\CategoryRepository        $contactRepository Contact repository
     * @return \Symfony\Component\HttpFoundation\Response HTTP response
     * @throws \Doctrine\ORM\ORMException
     * @throws \Doctrine\ORM\OptimisticLockException
     *
     * @Route(
     *     "/{id}/edit",
     *     methods={"GET", "PUT"},
     *     requirements={"id": "[1-9]\d*"},
     *     name="contact_edit",
     * )
     */
    public function edit(Request $request, Contact $contact, ContactRepository $contactRepository): Response
    {
        $form = $this->createForm(ContactFormType::class, $contact, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $contactRepository->save($contact);

            $this->addFlash('success', 'message_updated_successfully');

            return $this->redirectToRoute('contact_index');
        }

        return $this->render(
            'contact/edit.html.twig',
            [
                'form' => $form->createView(),
                'contact' => $contact,
            ]
        );
    }
}
