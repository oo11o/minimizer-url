<?php

namespace App\Controller;

use App\Entity\Link;
use App\Form\GenerateType;
use App\Service\ShortUrl;
use App\Service\Minimizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;


class IndexController extends AbstractController
{
    private $minimizer;

    public function __construct(Minimizer $minimizer)
    {
        $this->minimizer = $minimizer;
    }

    public function index(Request $request)
    {
        $link = new Link();
        $form = $this->createForm(GenerateType::class, $link);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            [$url, $timer] = [$form['url']->getData(), $form['timer']->getData()];
            $view['result'] = [
                'url' => $url,
                'minimize' => $this->minimizer->create($url, $timer)
            ];
        }

        $view['form'] = $form->createView();
        return $this->render('generate.html.twig', $view);
    }


    public function transfer(Request $request)
    {
        $link = $this->minimizer->findNoExpire($request->getRequestUri());

        if (!$link) {
            throw $this->createNotFoundException('Relative link not found. Probably expired time');
        }

        $this->minimizer->increaseRedirect($link->getId());

        return $this->redirect($link->getUrl(), 302);
    }

}
