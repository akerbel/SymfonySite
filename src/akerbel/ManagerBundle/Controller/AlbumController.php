<?php

namespace akerbel\ManagerBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use akerbel\ManagerBundle\Entity\Album;
use akerbel\ManagerBundle\Form\AlbumType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class AlbumController extends Controller
{
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();
        
        $albums = $em->getRepository('akerbelManagerBundle:Album')->findAll();
        
        return $this->render('akerbelManagerBundle:Album:index.html.twig', array(
            'albums' => $albums,
        ));
    }
    
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $album = $em->getRepository('akerbelManagerBundle:Album')->find($id);
        
        $delete_form = $this->createFormBuilder()
            ->setAction($this->generateUrl('album_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('Delete', SubmitType::class, array('label' => 'Delete Album'))
            ->getForm();
        
        return $this->render('akerbelManagerBundle:Album:show.html.twig', array(
            'album' => $album,
            'delete_form' => $delete_form->createView(),
        ));
    }
    
    public function newAction()
    {
        $Album = new Album();
        
        $Form = $this->createForm('akerbel\ManagerBundle\Form\AlbumType', $Album, array(
            'action' => $this->generateUrl('album_create'),
            'method' => 'POST',
        ));
        
        $Form->add('create', SubmitType::class, array('label' => 'Create Album'));
        
        return $this->render('akerbelManagerBundle:Album:new.html.twig', array(
            'form' => $Form->createView(),
        ));
    }
    
    public function createAction(Request $request)
    {
        $Album = new Album();
        
        $Form = $this->createForm('akerbel\ManagerBundle\Form\AlbumType', $Album, array(
            'action' => $this->generateUrl('album_create'),
            'method' => 'POST',
        ));
        
        $Form->add('create', SubmitType::class, array('label' => 'Create Album'));
        
        $Form->handleRequest($request);
        
        if ($Form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($Album);
            $em->flush();
            
            $this->get('session')->getFlashBag()->add('msg', 'New Album has been created!');
            
            return $this->redirect($this->generateUrl('album_show', array('id' => $Album->getId())));
        }
        
        $this->get('session')->getFlashBag()->add('msg', 'Something went wrong!');
        
        return $this->render('akerbelManagerBundle:Album:new.html.twig', array(
            'form' => $Form->createView(),
        ));
    }
    
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $album = $em->getRepository('akerbelManagerBundle:Album')->find($id);
        
        $form = $this->createForm('akerbel\ManagerBundle\Form\AlbumType', $album, array(
            'action' => $this->generateUrl('album_update', array('id' => $album->getid())),
            'method' => 'PUT',
        ));
        
        $form->add('Update', SubmitType::class, array('label' => 'Update Album'));
        
        return $this->render('akerbelManagerBundle:Album:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        
        $album = $em->getRepository('akerbelManagerBundle:Album')->find($id);
        
        $form = $this->createForm('akerbel\ManagerBundle\Form\AlbumType', $album, array(
            'action' => $this->generateUrl('album_update', array('id' => $album->getid())),
            'method' => 'PUT',
        ));
        
        $form->add('Update', SubmitType::class, array('label' => 'Update Album'));
        
        $form->handleRequest($request);
        
        if ($form->isValid()) {
            $em->flush();
            $this->get('session')->getFlashBag()->add('msg', 'Album updated!');
            
            return $this->redirect($this->generateUrl('album_show', array('id' => $id)));
        }
        
        return $this->render('akerbelManagerBundle:Album:edit.html.twig', array(
            'form' => $form->createView(),
        ));
    }
    
    public function deleteAction(Request $request, $id)
    {
        $delete_form = $this->createFormBuilder()
            ->setAction($this->generateUrl('album_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('Delete', SubmitType::class, array('label' => 'Delete Album'))
            ->getForm();
            
        $delete_form->handleRequest($request);
        
        if ($delete_form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $album = $em->getRepository('akerbelManagerBundle:Album')->find($id);
            $em->remove($album);
            $em->flush();
        }
        
        $this->get('session')->getFlashBag()->add('msg', 'Your album has been deleted!');
        
        return $this->redirect($this->generateUrl('album'));
    }
}
