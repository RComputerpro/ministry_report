<?php

namespace App\Controller;

use App\Entity\Reports;
use App\Form\AddReportType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Twig\Environment;

class AddReportController extends AbstractController {

    /**
     * @var Environment
     */

    private $twig;
    private $reports;
    private $form;

    private $username;

    public function __construct(Environment $twig, TokenStorageInterface $tsi) 
    {
        $this->twig = $twig;
        $this->reports = new Reports();
        $this->username = $tsi->getToken()->getUser()->getUserIdentifier();
    }
    
    public function index(Request $request, EntityManagerInterface $em):Response
    {
        $this->form = $this->createForm(AddReportType::class, $this->reports);
        $this->form->handleRequest($request);

        if($this->form->isSubmitted() && $this->form->isValid()) {
            $this->reports->setUser($this->username);
            $em->persist($this->reports);
            $em->flush();
            return $this->redirectToRoute('report');
        }
        $formView = $this->form->createView();
        return new Response($this->twig->render('pages/add_report.html.twig', ['form' => $formView]));
    }
}