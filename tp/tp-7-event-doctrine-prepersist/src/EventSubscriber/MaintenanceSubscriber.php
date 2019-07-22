<?php

namespace App\EventSubscriber;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\HttpKernel\Event\FilterResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpFoundation\Response;

use Symfony\Component\Dotenv\Dotenv;

class MaintenanceSubscriber implements EventSubscriberInterface
{
    private $twig;

    public function __construct(\Twig_Environment $twig) {
        $this->twig = $twig;
    }

    public function methodCalledOnKernelResponse(FilterResponseEvent $filterResponseEvent)
    {
        $dotenv = new Dotenv();
        $dotenv->load('../.env');

        $maintenance = $_ENV['MAINTENANCE'];
        if ($maintenance == 'true') {
            $content = $this->twig->render('maintenance.html.twig');

            $response = new Response($content);
            return $filterResponseEvent->setResponse($response);
        }
        return $filterResponseEvent->getResponse()->getContent();
 
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::RESPONSE => 'methodCalledOnKernelResponse'
        ];
    }
}