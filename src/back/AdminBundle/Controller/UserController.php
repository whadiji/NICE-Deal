<?php

namespace back\AdminBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Controller for User.
 * 
 * @package backAdminBundle
 * 
 * @author Amal Hsouna
 */
class UserController extends Controller
{
    public function indexAction()
    {
        $n = 0;
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUsers();
        
        foreach ($user AS $users ) {
                $n = $n+1;
        }
        return $this->render('backAdminBundle:Default:index.html.twig', array('user' => $n));
    }
    
    /**
     * Return a list of users.
     * 
     * @return Response
     */
     public function getListUsersAction()
    { 
        $userManager = $this->get('fos_user.user_manager');
        $user = $userManager->findUsers();
        $users1 = array();
        $n = 0;
        foreach ($user AS $user1 ) {

                $users1[$n]=$user1 ;
                $n = $n+1;

        }
        
        $paginator = $this->get('knp_paginator');
        $users = $paginator->paginate($user,
         $this->get('request')->query->get('page', 1), 3);

        return $this->render('backAdminBundle:Liste:liste-admin.html.twig',array('users' =>$users,"nbreutil"=>$n));
    }
    
    /**
     * Return a list of users.
     * 
     * @return Response
     */
     public function getNbrUsersConnectAction()
    { 
        $userManager = $this->get('back_utilisateur.manager.client');
        $user = $userManager->getNbrUserConnect();var_dump($user);exit;
        $users1 = array();
        $n = 0;
        foreach ($user AS $user1 ) {

                $users1[$n]=$user1 ;
                $n = $n+1;

        }
        
        $paginator = $this->get('knp_paginator');
        $users = $paginator->paginate($user,
         $this->get('request')->query->get('page', 1), 3);

        return $this->render('backAdminBundle:Liste:liste-admin.html.twig',array('users' =>$users,"nbreutil"=>$n));
    }
    
}
