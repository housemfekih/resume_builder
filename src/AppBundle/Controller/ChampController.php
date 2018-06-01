<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Champ;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Champ controller.
 *
 * @Route("champ")
 */
class ChampController extends Controller
{
    /**
     * Lists all champ entities.
     *
     * @Route("/", name="champ_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $champs = $em->getRepository('AppBundle:Champ')->findAll();

        return $this->render('champ/index.html.twig', array(
            'champs' => $champs,
        ));
    }

    /**
     * Creates a new champ entity.
     *
     * @Route("/new", name="champ_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $champ = new Champ();
        $form = $this->createForm('AppBundle\Form\ChampType', $champ);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($champ);
            $em->flush();

            $manager = $this->get('mgilet.notification');
            //$notif = $manager->createNotification('Hello world !');
            // or the one-line method :
            $notif =$manager->createNotification('Notification subject','Some random text','http://google.fr');
    
            // you can add a notification to a list of entities
            // the third parameter ``$flush`` allows you to directly flush the entities
            $manager->addNotification(array($this->getUser()), $notif, true);
            dump($manager);
            return $this->redirectToRoute('champ_show', array('id' => $champ->getId()));
    
        }

        return $this->render('champ/new.html.twig', array(
            'champ' => $champ,
            'form' => $form->createView(),



            
        ));
    }

    /**
     * Finds and displays a champ entity.
     *
     * @Route("/{id}", name="champ_show")
     * @Method("GET")
     */
    public function showAction(Champ $champ)
    {
        $deleteForm = $this->createDeleteForm($champ);

        return $this->render('champ/show.html.twig', array(
            'champ' => $champ,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing champ entity.
     *
     * @Route("/{id}/edit", name="champ_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, Champ $champ)
    {
        $deleteForm = $this->createDeleteForm($champ);
        $editForm = $this->createForm('AppBundle\Form\ChampType', $champ);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('champ_edit', array('id' => $champ->getId()));
        }

        return $this->render('champ/edit.html.twig', array(
            'champ' => $champ,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a champ entity.
     *
     * @Route("/{id}", name="champ_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, Champ $champ)
    {
        $form = $this->createDeleteForm($champ);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($champ);
            $em->flush();
        }

        return $this->redirectToRoute('champ_index');
    }

    /**
     * Creates a form to delete a champ entity.
     *
     * @param Champ $champ The champ entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Champ $champ)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('champ_delete', array('id' => $champ->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
