<?php

namespace App\Controller\Admin;

use App\Entity\Quotation;
use App\Form\QuotationType;
use App\Repository\QuotationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/quotation")
 */
class QuotationController extends AbstractController
{
    /**
     * @Route("/", name="admin_quotation_index", methods={"GET"})
     */
    public function index(QuotationRepository $quotationRepository): Response
    {
        return $this->render('admin/quotation/index.html.twig', [
            'quotations' => $quotationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="admin_quotation_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $quotation = new Quotation();
        $form = $this->createForm(QuotationType::class, $quotation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($quotation);
            $entityManager->flush();

            return $this->redirectToRoute('admin_quotation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/quotation/new.html.twig', [
            'quotation' => $quotation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_quotation_show", methods={"GET"})
     */
    public function show(Quotation $quotation): Response
    {
        return $this->render('admin/quotation/show.html.twig', [
            'quotation' => $quotation,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="admin_quotation_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Quotation $quotation): Response
    {
        $form = $this->createForm(QuotationType::class, $quotation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_quotation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('admin/quotation/edit.html.twig', [
            'quotation' => $quotation,
            'form' => $form,
        ]);
    }

    /**
     * @Route("/{id}", name="admin_quotation_delete", methods={"POST"})
     */
    public function delete(Request $request, Quotation $quotation): Response
    {
        if ($this->isCsrfTokenValid('delete'.$quotation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($quotation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_quotation_index', [], Response::HTTP_SEE_OTHER);
    }

    /**
     * @Route("/archive/{id}", name="admin_quotation_archive", methods={"POST"})
     */
    public function archive(Request $request, Quotation $quotation): Response
    {
        if ($this->isCsrfTokenValid('archive'.$quotation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $quotation->setArchived(true);
            $entityManager->persist($quotation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_quotation_index', [], Response::HTTP_SEE_OTHER);
    }
    /**
     * @Route("/unarchive/{id}", name="admin_quotation_unarchive", methods={"POST"})
     */
    public function unarchive(Request $request, Quotation $quotation): Response
    {
        if ($this->isCsrfTokenValid('unarchive'.$quotation->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $quotation->setArchived(false);
            $entityManager->persist($quotation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_quotation_index', [], Response::HTTP_SEE_OTHER);
    }
}
