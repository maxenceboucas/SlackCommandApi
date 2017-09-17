<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace News;

use Zend\Router\Http\Literal;
use Zend\Router\Http\Segment;

return [
    'router' => [
        'routes' => [
            'news' => [
                'type' => Literal::class,
                'options' => [
                    'route'    => '/news',
                    'defaults' => [
                        'controller' => Controller\NewsController::class,
                        'action' => 'getAll',
                        'isAuthorizationRequired' => false // set true if this api Required JWT Authorization.
                    ],
                ],
                'may_terminate' => true,
                'child_routes' => array(
                    'getByTechno' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/techno',
                            'defaults' => array(
                                'controller' => Controller\NewsController::class,
                                'action' => 'getByTechno',
                                'isAuthorizationRequired' => false
                            ),
                        ),
                    ),
                    'getBySecteur' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/secteur',
                            'defaults' => array(
                                'controller' => Controller\NewsController::class,
                                'action' => 'getBySecteur',
                                'isAuthorizationRequired' => false
                            ),
                        ),
                    ),
                    'create' => array(
                        'type' => 'Segment',
                        'options' => array(
                            'route' => '/create',
                            'defaults' => array(
                                'controller' => Controller\NewsController::class,
                                'action' => 'create',
                                'isAuthorizationRequired' => false
                            ),
                        ),
                    ),
                ),
            ],
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'strategies' => array(
            'ViewJsonStrategy',
        )
    ],
];
