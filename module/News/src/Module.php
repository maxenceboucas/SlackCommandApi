<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace News;

use News\Model\News;
use News\Model\NewsTable;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\HydratingResultSet;

use Zend\ModuleManager\Feature\ConfigProviderInterface;

class Module implements ConfigProviderInterface
{
    const VERSION = '3.0.3-dev';

    public function getConfig()
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public function getServiceConfig()
    {
        return [
            'factories' => [
                Model\NewsTable::class => function($container) {
                    $tableGateway = $container->get(Model\NewsTableGateway::class);
                    return new Model\NewsTable($tableGateway);
                },
                Model\NewsTableGateway::class => function ($container) {
                    $dbAdapter = $container->get(AdapterInterface::class);
                    $resultSetPrototype = new HydratingResultSet();
                    $resultSetPrototype->setObjectPrototype(new News());
                    return new TableGateway('news', $dbAdapter, null, $resultSetPrototype);
                },
            ],
        ];
    }

    public function getControllerConfig()
    {
        return [
            'factories' => [
                Controller\NewsController::class => function($container) {
                    return new Controller\NewsController(
                        $container->get(Model\NewsTable::class)
                    );
                },
            ],
        ];
    }
}
