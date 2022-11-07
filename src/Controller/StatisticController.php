<?php

namespace App\Controller;

use App\Entity\Link;
use App\Form\StatisticType;
use App\Service\Minimizer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StatisticController extends AbstractController
{
    private $minimizer;

    /**
     * @Route("/statistic", name="app_statistic")
     */

    public function index(Request $request, Minimizer $minimizer): Response
    {
        $link = new Link();
        $form = $this->createForm(StatisticType::class, $link);
        $form->handleRequest($request);

        $view = [
            'form' => $form->createView(),
            'popular' => $minimizer->findPopular(),
            'host' => $request->getSchemeAndHttpHost()
        ];

        if ($form->isSubmitted() && $form->isValid()) {
            $url = $form['url']->getData();
            $statistic = $minimizer->find(parse_url($url)['path']);

            if (!$statistic) {
                $view['error'] = 'The Link not valid';
                return $this->render('statistic.html.twig', $view);
            }

            $view['result'] = [
                'url' => $statistic->getUrl(),
                'expire' => $statistic->getExpire()->format('Y-m-d H:i:s'),
                'number_redirect' => $statistic->getNumberRedirect(),
                'short_url' => $url,
                'created' => $statistic->getCreatedDate()->format('Y-m-d H:i:s'),
            ];

        }
        return $this->render('statistic.html.twig', $view);
    }

    public function isValid()
    {

    }

}
