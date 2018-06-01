<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Cv;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Cv controller.
 *
 * @Route("cv")
 */
class CvController extends Controller
{
    /**
     * Lists all cv entities.
     *
     * @Route("/", name="cv_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $cvs = $em->getRepository('AppBundle:Cv')->findAll();

        return $this->render('cv/index.html.twig', array(
            'cvs' => $cvs,
        ));
    }
	/**
     * Creates a new cv entity.
     *
     * @Route("/beforeNew", name="cv_before_new")
     */
    public function beforeNewAction()
    {
 
		$em = $this->getDoctrine()->getManager();

        $templates = $em->getRepository('AppBundle:Template')->findAll();


        return $this->render('cv/beforeNew.html.twig', array(
     
			'templates' => $templates,
			'url' => $this->getParameter('template_directory')."/"
        ));
    }
    /**
     * Creates a new cv entity.
     *
     * @Route("/new/{id}", name="cv_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request,$id)
    {
		$em = $this->getDoctrine()->getManager();
		
		$template = $em->getRepository('AppBundle:Template')->find($id);
		
		
		$group = $template->getGroupeId();
		$sectionTab = [];
		$sections = $template->getGroupeId()->getSectionsGroupeRel();
		
		
		foreach ($sections as $section) {
			$champ_tab = [];
			$champs = $section->getSectionChampsRel();
			foreach ($champs as $champ) {
				$champ_tab[$champ->getId()] = [$champ->getNomChamp(),$champ->getTypeChamp(),$champ->getLongeurChamp(),$champ->getId()];
			}
			 $sectionTab[$section->getId()] = ["name" => $section->getNomSection(),"champs" => $champ_tab,'id' => $section->getId()];
			
        }

		
		$res = ['name'=>$template->getGroupeId()->getNomGroupe(),
		'sections' => $sectionTab];
		
		
        $cv = new Cv();
        $form = $this->createForm('AppBundle\Form\CvType', $cv);
		

        $templates = $em->getRepository('AppBundle:Template')->findAll();
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($cv);
            $em->flush();

            return $this->redirectToRoute('cv_show', array('id' => $cv->getId()));
        }

        return $this->render('cv/new.html.twig', array(
            'cv' => $cv,
            'form' => $form->createView(),
			'templates' => $res,
			'id' => $id
        ));
    }

    /**
     * Finds and displays a cv entity.
     *
     * @Route("/{id}", name="cv_show")
     * @Method("GET")
     */
    public function showAction(Cv $cv)
    {
        $deleteForm = $this->createDeleteForm($cv);

        return $this->render('cv/show.html.twig', array(
            'cv' => $cv,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing cv entity.
     *
     * @Route("/{id}/edit", name="cv_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Cv $cv)
    {
        $deleteForm = $this->createDeleteForm($cv);
        $editForm = $this->createForm('AppBundle\Form\CvType', $cv);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('cv_edit', array('id' => $cv->getId()));
        }

        return $this->render('cv/edit.html.twig', array(
            'cv' => $cv,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),







        ));
    }

    /**
     * Deletes a cv entity.
     *
     * @Route("/{id}", name="cv_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Cv $cv)
    {
        $form = $this->createDeleteForm($cv);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($cv);
            $em->flush();
        }

        return $this->redirectToRoute('cv_index');
    }

    /**
     * Creates a form to delete a cv entity.
     *
     * @param Cv $cv The cv entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Cv $cv)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('cv_delete', array('id' => $cv->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
