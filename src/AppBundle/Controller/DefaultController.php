<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use AppBundle\Entity\User;

class DefaultController extends Controller
{
   
       /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dachAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('dashboard.html.twig');
    }


      /**
     * @Route("/", name="acceuilPage")
     */
    public function acceuilAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('acceuil.html.twig');
    }
    

          /**
     * @Route("/contact", name="contactPage")
     */
    public function contactAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('contact.html.twig');
    }

    
          /**
     * @Route("/themes", name="themePage")
     */
    public function themeAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('themes.html.twig');
    }

              /**
     * @Route("/about", name="aboutPage")
     */
    public function aboutAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('about.html.twig');
    }





/**
     * @Route("/send-notification", name="send_notification")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse
     */
    public function sendNotification(Request $request)
    {
        $manager = $this->get('mgilet.notification');
        $notif = $manager->createNotification('Hello world !');
        $notif->setMessage('This a notification.');
        $notif->setLink('http://symfony.com/');
        // or the one-line method :
        // $manager->createNotification('Notification subject','Some random text','http://google.fr');

        // you can add a notification to a list of entities
        // the third parameter ``$flush`` allows you to directly flush the entities
        $manager->addNotification(array($this->getUser()), $notif, true);

        return $this->render('test.html.twig');
//        return $this->redirectToRoute('homepage
    }







        /**
     * @Route("/test", name="test")
     */
    public function testAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('test.html.twig');
    }

           /**
     * @Route("/log_out", name="logout_page")
     */
    public function logoutAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('logout.html.twig');
    }

         /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/admin", name="admin_page")
     *
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function adminAction(Request $request)
    {
        // replace this example code with whatever you need
        return $this->render('admin.html.twig');
    }


      /**
     * @Route("/calendrier", name="calend_page")
     */
    public function calendAction(Request $request)

   {
       return $this->render('calendrier.html.twig');
}


   
    /**
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @Route("/user", name="user_page")
     *
     * @Security("has_role('ROLE_USER')")
     */
    public function userAction(){
      
        return $this->render('user.html.twig');
}

}
