<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Mission;
use App\Form\Admin\MissionFormType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;

/**
 * @Route("/admin")
 */
class MissionController extends AbstractController
{

    /**
     * @Route("/mission/list", name="admin_mission_list")
     */
    public function list(EntityManagerInterface $em)
    {
        $missions = $em->getRepository(Mission::class)->findAll();
        
        return $this->render('admin/mission/list.html.twig', [
            'missions' => $missions,
        ]);
    }

    /**
     * @Route("/mission/edit/{id}", name="admin_mission_edit")
     */
    public function edit(Mission $mission, Request $request, EntityManagerInterface $em)
    {
        $form = $this->createForm(MissionFormType::class,$mission);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $mission = $form->getData();

            $em->persist($mission);
            $em->flush();       

            $this->addFlash(
                'success',
                'Einsatz wurde gespeichert'
            );

            return $this->redirectToRoute('admin_mission_list');
        }

        return $this->render('admin/mission/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/mission/create", name="admin_mission_create")
     */
    public function create(EntityManagerInterface $em, Request $request)
    {
        $form = $this->createForm(MissionFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $mission = $form->getData();

            $em->persist($mission);
            $em->flush();       

            $this->addFlash(
                'success',
                'Einsatz wurde erstellt'
            );
        
            return $this->redirectToRoute('admin_mission_list');
        }
        return $this->render('admin/mission/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/mission/view", name="admin_mission_view")
     */
    public function view(EntityManagerInterface $em, Request $request)
    {

    }

    /**
     * @Route("/mission/delete", name="admin_mission_delete")
     */
    public function delete(EntityManagerInterface $em, Request $request)
    {
        
    }

}
