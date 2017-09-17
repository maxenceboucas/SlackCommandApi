<?php
/**
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2016 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace News\Controller;

use RestApi\Controller\ApiController;
use News\Model\News;
use News\Model\NewsTable;
use Zend\Db\Sql\Ddl\Column\Time;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;

class NewsController extends ApiController
{
    private $newsTable;

    public function __construct(NewsTable $newsTable)
    {
        $this->newsTable = $newsTable;
    }


    public function getAllAction()
    {
        try{
            $news = $this->newsTable->fetchAll();

            $this->httpStatusCode = 200;
            $this->apiResponse['success'] = true;
            $this->apiResponse['news'] = $news;
        }
        catch(\Exception $e){
            // Set the response
            $this->httpStatusCode = 200;
            $this->apiResponse['success'] = false;
            $this->apiResponse['message'] = $e->getMessage();
        }

        return $this->createResponse();
    }

    public function getByTechnoAction()
    {

        $params = (array) json_decode($this->getRequest()->getContent());

        try{
            $news = $this->newsTable->getNewsByTechno($params['techno']);

            $this->httpStatusCode = 200;
            $this->apiResponse['success'] = true;
            $this->apiResponse['news'] = $news;
        }
        catch(\Exception $e)
        {
            $this->httpStatusCode = 200;
            $this->apiResponse['success'] = false;
            $this->apiResponse['message'] = $e->getMessage();
        }


        return $this->createResponse();
    }

    public function getBySecteurAction()
    {

        $params = (array) json_decode($this->getRequest()->getContent());

        try{
            $news = $this->newsTable->getNewsBySecteur($params['secteur']);

            $this->httpStatusCode = 200;
            $this->apiResponse['success'] = true;
            $this->apiResponse['news'] = $news;
        }
        catch(\Exception $e)
        {
            $this->httpStatusCode = 200;
            $this->apiResponse['success'] = false;
            $this->apiResponse['message'] = $e->getMessage();
        }


        return $this->createResponse();
    }

    public function createAction()
    {
        $params = (array) json_decode($this->getRequest()->getContent());
        $params['id'] = 0;
        $news = new News();

        $time = new Time()/1000;
        $params['time'] = $time;

        try{
            $news->exchangeArray($params);
            $id_news = $this->newsTable->saveNews($news);

            $this->httpStatusCode = 200;
            $this->apiResponse['success'] = true;
            $this->apiResponse['message'] = "News created";
            $this->apiResponse['news'] = array("id" => $id_news);

        }
        catch(\Exception $e){
            $this->httpStatusCode = 200;
            $this->apiResponse['success'] = false;
            $this->apiResponse['message'] = $e->getMessage();
        }


        return $this->createResponse();
    }
}
