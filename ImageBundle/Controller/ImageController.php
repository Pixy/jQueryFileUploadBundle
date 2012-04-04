<?php

namespace Bold\ImageBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;


use Bold\ImageBundle\Classes\UploadHandler;


class ImageController extends Controller
{

    public function indexAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        if(!$projet = $em->getRepository('BoldPrezBundle:Projet')->find($id)) {
            throw $this->createNotFoundException('Le projet[id='.$id.'] n\'existe pas.');
        }
        $client = $projet->getClient();
        $projets = $client->getProjets();

        return $this->render('BoldImageBundle::index.html.twig', array(
            'client' => $client,
            'projet' => $projet,
            'projets' => $projets,
        ));
    }


    /**
     *  Ajouter une image
     * @param integer $id
     */
    public function ajouterAction($id) {
        $em = $this->getDoctrine()->getEntityManager();

        if(!$projet = $em->getRepository('BoldPrezBundle:Projet')->find($id)) {
            throw $this->createNotFoundException('Le projet[id='.$id.'] n\'existe pas.');
        }
        $client = $projet->getClient();
        $upload_handler = new UploadHandler();
        $request = $this->get('request');

        $rep = json_encode('');

        switch ($request->getMethod()) {
            case 'OPTIONS':
                break;
            case 'HEAD':
            case 'GET':
                $upload_handler->get();
                break;
            case 'POST':
                if ($request->getMethod() === 'DELETE') {
                    $upload_handler->delete();
                } else {
                    $rep = $upload_handler->post();
                }
                break;
            case 'DELETE':
                $upload_handler->delete();
                break;
            default:
                header('HTTP/1.1 405 Method Not Allowed');
        }

        $json = $rep;

        $response = new Response();
        $response->headers->set('Content-Type', 'application/json');
        $response->setContent($json);
        return $response;
    }
}