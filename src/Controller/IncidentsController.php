<?php

namespace App\Controller;

use App\Entity\Incidents;
use App\Form\IncidentsType;
use App\Repository\IncidentsRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IncidentsController extends AbstractController
{
    #[Route('/incidents', name: 'app_dashboard_incidents')]
    public function index(IncidentsRepository $incidentsRepository): Response
    {
        $incidents = $incidentsRepository->findBy([
            'user' => $this->getUser()
        ]);

        return $this->render('dashboard/incidents.html.twig', [
            'incidents' => $incidents
        ]);
    }

    #[Route('/incident/nouveau', 'app_dashboard_create_incident')]
    public function create(Request $request, EntityManagerInterface $entityManager): Response
    {
        $incident = new Incidents();

        $incidentForm = $this->createForm(IncidentsType::class, $incident);
        $incidentForm->handleRequest($request);

        if($incidentForm->isSubmitted() && $incidentForm->isValid())
        {
            $incident->setUser($this->getUser());
            $incident->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($incident);
            $entityManager->flush();
        }

        return $this->render('dashboard/create_incident.html.twig', [
            'incidentForm' => $incidentForm
        ]);
    }


    #[Route('/incident/modifier/{id}', 'app_dashboard_edit_incident')]
    public function edit(EntityManagerInterface $entityManager, Request $request, Incidents $incidents): Response
    {

        $incidentForm = $this->createForm(IncidentsType::class, $incidents);
        $incidentForm->handleRequest($request);

        if($incidentForm->isSubmitted() && $incidentForm->isValid())
        {
            $incidents->setUser($incidents->getUser());
            $incidents->setCreatedAt($incidents->getCreatedAt());

            $entityManager->persist($incidents);
            $entityManager->flush();

            return $this->redirectToRoute('app_dashboard_incidents');
        }

        return $this->render('dashboard/edit_incident.html.twig', [
            'incidentForm' => $incidentForm,
            'incident' => $incidents
        ]);
    }

    #[Route('/incident/supprimer/{id}', 'app_dashboard_delete_incident')]
    public function delete(Incidents $incidents, EntityManagerInterface $entityManager): Response
    {
        $entityManager->remove($incidents);
        $entityManager->flush();

        return $this->redirectToRoute('app_dashboard_incidents');
    }
}
