<?php
/**
 * Hacksaw plugin for Craft CMS
 *
 * Hacksaw Twig Extension
 *
 * @author    Ryan Shrum
 * @copyright Copyright (c) 2016 Ryan Shrum
 * @link      ryanshrum.com
 * @package   Hacksaw
 * @since     2.0.1
 */

namespace App\Twig;

use Symfony\Component\HttpFoundation\Request;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;
use App\Repository\ServiceRepository;

class CalculateOrderDetailsTwigExtension extends AbstractExtension
{
    /**
     * @var ServiceRepository
     */
    private $serviceRepository;

    public function __construct(ServiceRepository $serviceRepository)
    {
        $this->serviceRepository = $serviceRepository;


    }

    public function getFunctions()
    {
        return [
            new TwigFunction('getServices', [$this, 'getServices']),
            new TwigFunction('getServicesSum', [$this, 'getServicesSum']),
        ];
    }

    public function getServices(array $services)
    {

       $result = array();

        foreach ($services as $service) {

            $result[] = $this->serviceRepository->findService($service);
        }
        return $result;
    }

    public function getServicesSum(array $services)
    {
        $result = array();
       $this->getServices($services);

       foreach ($this->getServices($services) as $item) {
           $result[] = $item->getPrice();
       }
        return array_sum($result);
    }
}
