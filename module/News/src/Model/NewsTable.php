<?php
/**
 * Created by PhpStorm.
 * User: Florian
 * Date: 06/09/2017
 * Time: 11:04
 */

namespace News\Model;

use RuntimeException;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\TableGateway\TableGatewayInterface;

class NewsTable
{
    private $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function fetchAll()
    {

        $resultSet = $this->tableGateway->select()->toArray();
        return $resultSet;

    }

    public function getNewsByTechno($techno)
    {

        $resultSet = $this->tableGateway->select(array("techno" => $techno))->toArray();
        return $resultSet;

    }

    public function getNewsBySecteur($secteur)
    {

        $resultSet = $this->tableGateway->select(array("secteur" => $secteur))->toArray();
        return $resultSet;

    }

    public function saveNews(News $team)
    {
        $data = $team->toArray();

        // Creation de l'utilisateur
        if (is_null($data['id']) || $data['id'] === 0) {
            unset($data['id']);
            $this->tableGateway->insert($data);
            $id = $this->tableGateway->lastInsertValue;

            return $id;
        }

        // Mise à jour de l'utilisateur
        if (! $this->getNews($data['id'])) {
            throw new RuntimeException(sprintf(
                'Cannot update news with identifier %d; does not exist',
                $data['id']
            ));
        }

        $this->tableGateway->update($data, ['id' => $data['id']]);
        return $data['id'];
    }

    public function deleteNews($id)
    {
        if (! $this->getNews($id)) {
            throw new RuntimeException(sprintf(
                'Cannot delete news with identifier %d; does not exist',
                $id
            ));
        }

        $this->tableGateway->delete(['id' => (int) $id]);
        return $id;
    }
}