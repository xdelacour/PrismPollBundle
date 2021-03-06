<?php

namespace Prism\PollBundle\Controller\Backend;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\RedirectResponse;

class PollController extends Controller
{
    /**
     * Init
     */
    public function init()
    {
        $this->pollEntity = $this->container->getParameter('prism_poll.poll_entity');
        $this->pollEntityRepository = $this->getDoctrine()->getEntityManager()->getRepository($this->pollEntity);
        $this->pollForm = $this->container->getParameter('prism_poll.poll_form');
        $this->opinionForm = $this->container->getParameter('prism_poll.opinion_form');
    }

    /**
     * List all polls
     *
     * @return Response
     */
    public function listAction()
    {
        $this->init(); // TODO: create a controller listener to call it automatically

        $polls = $this->pollEntityRepository->findBy(
            array(),
            array('createdAt' => 'DESC')
        );

        return $this->render('PrismPollBundle:Backend\Poll:list.html.twig', array(
            'polls' => $polls
        ));
    }

    /**
     * Edit or add a new poll
     *
     * @param Poll $pollId
     *
     * @return Response|RedirectReponse
     */
    public function editAction($pollId)
    {
        $this->init();

        $poll = $this->pollEntityRepository->find($pollId);

        if (!$poll) {
            $poll = new $this->pollEntity;
        }

        $form = $this->createForm(new $this->pollForm, $poll, array('opinion_form' => $this->opinionForm));

        if ('POST' == $this->getRequest()->getMethod()) {

            $form->bindRequest($this->getRequest());

            if ($form->isValid()) {

                $em = $this->getDoctrine()->getEntityManager();
                $em->persist($poll);
                $em->flush();

                $this->get('session')->setFlash('success', "The poll has been successfully saved!");

                return $this->redirect($this->generateUrl('PrismPollBundle_backend_poll_edit', array('pollId' => $poll->getId())));
            }
        }

        return $this->render('PrismPollBundle:Backend\Poll:edit.html.twig', array(
            'poll' => $poll,
            'form' => $form->createView()
        ));
    }

    /**
     * Delete a poll
     *
     * @param Poll $pollId
     *
     * @return RedirectReponse
     */
    public function deleteAction($pollId)
    {
        $this->init();

        $poll = $this->pollEntityRepository->find($pollId);

        if (!$poll) {
            throw $this->createNotFoundException("This poll doesn't exist.");
        }

        $em = $this->getDoctrine()->getEntityManager();
        $em->remove($poll);
        $em->flush();

        $this->get('session')->setFlash('success', "The poll has been successfully deleted!");

        return $this->redirect($this->generateUrl('PrismPollBundle_backend_poll_list'));
    }
}
