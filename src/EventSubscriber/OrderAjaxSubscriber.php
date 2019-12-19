<?php

namespace App\EventSubscriber;

use phpDocumentor\Reflection\DocBlock\Description;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\FinishRequestEvent;

class OrderAjaxSubscriber implements EventSubscriberInterface
{
    public function onKernelFinishRequest(FinishRequestEvent $event)
    {
//       if ($event->getRequest()->isMethod()) {
//           dump($event->getRequest()->isXmlHttpRequest());
//       }
    }

    public static function getSubscribedEvents()
    {
        return [
            'kernel.finish_request' => 'onKernelFinishRequest',
        ];
    }
}
