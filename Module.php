<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonModule for the canonical source repository
 * @copyright Copyright (c) 2005-2012 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace G403TempRoleProvider;

use Zend\ModuleManager\Feature\AutoloaderProviderInterface;
use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

class Module implements AutoloaderProviderInterface
{
    public function getServiceConfig()
    {
        return [
            'factories' => [
                'G403TempIdentityProvider' => function ($sm) {
                    $tip                   = new Provider\Identity\Temp;
                    $config                = $sm->get('Config');
                    $mainIdentityProviderC = $config['G403TempRoleProvider']['MainIdentityProvider'];
                    $mainIdentityProvider  = $sm->get($mainIdentityProviderC);
                    $tip->setMainProvider($mainIdentityProvider);
                    return $tip;
                },
                'G403TempIdentityService' => function ($sm) {
                    $tempIdService = new Service\Temp;
                    $tempIdService->setTempRoleProvider($sm->get('G403TempIdentityProvider'));
                    return $tempIdService;
                }
            ]
        ];
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
            // if we're in a namespace deeper than one level we need to fix the \ in the path
                    __NAMESPACE__ => __DIR__ . '/src/' . str_replace('\\', '/' , __NAMESPACE__),
                ),
            ),
        );
    }
}
