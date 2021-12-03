<?php

namespace App\Controller;

use App\Entity\Dos;
use App\Form\DosType;
use App\Repository\DosRepository;
use Doctrine\ORM\EntityManagerInterface;
use Dompdf\Dompdf;
use Dompdf\Options;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/dos")
 */
class DosController extends AbstractController
{
    /**
     * @Route("/", name="dos_index", methods={"GET"})
     */
    public function index(DosRepository $dosRepository): Response
    {
        return $this->render('dos/index.html.twig', [
            'dos' => $dosRepository->findAll(),
        ]);
    }

    /**
     * @Route("/data", name="dos_data", methods={"GET"})
     */
    public function dosdata(DosRepository $dosRepository): Response
    {
        // Configure Dompdf according to your needs
        $pdfOptions = new Options();
        $pdfOptions->set('defaultFont', 'Arial');

        // Instantiate Dompdf with our options
        $dompdf = new Dompdf($pdfOptions);


        // Retrieve the HTML generated in our twig file
        $html = $this->renderView('dos/data.html.twig', [
            'folders' => $dosRepository->findAll(),
        ]);

        // Load HTML to Dompdf
        $dompdf->loadHtml($html);

        // (Optional) Setup the paper size and orientation 'portrait' or 'portrait'
        $dompdf->setPaper('A4', 'portrait');

        // Render the HTML as PDF
        $dompdf->render();

        // Output the generated PDF to Browser (force download)
        $dompdf->stream("mypdf.pdf", [
            "Attachment" => true
        ]);
    }


    /**
     * @Route("/new", name="dos_new", methods={"GET", "POST"})
     */
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $do = new Dos();
        $form = $this->createForm(DosType::class, $do);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($do);
            $entityManager->flush();

            return $this->redirectToRoute('dos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dos/new.html.twig', [
            'do' => $do,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dos_show", methods={"GET"})
     */
    public function show(Dos $do): Response
    {
        return $this->render('dos/show.html.twig', [
            'do' => $do,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="dos_edit", methods={"GET", "POST"})
     */
    public function edit(Request $request, Dos $do, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(DosType::class, $do);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('dos_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('dos/edit.html.twig', [
            'do' => $do,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="dos_delete", methods={"POST"})
     */
    public function delete(Request $request, Dos $do, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$do->getId(), $request->request->get('_token'))) {
            $entityManager->remove($do);
            $entityManager->flush();
        }

        return $this->redirectToRoute('dos_index', [], Response::HTTP_SEE_OTHER);
    }
}
