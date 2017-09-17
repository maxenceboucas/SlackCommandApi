<?php
/**
 * Created by PhpStorm.
 * User: Florian
 * Date: 06/09/2017
 * Time: 11:04
 */

namespace News\Model;

class News
{
    public $id;
    public $techno;
    public $date_publication;
    public $secteur;
    public $link;

    public function exchangeArray(array $data)
    {
        $this->id     = !empty($data['id']) ? $data['id'] : null;
        $this->techno = !empty($data['techno']) ? $data['techno'] : null;
        $this->date_publication = !empty($data['date_publication']) ? $data['date_publication'] : null;
        $this->secteur = !empty($data['secteur']) ? $data['secteur'] : null;
        $this->link = !empty($data['link']) ? $data['link'] : null;

    }

    public function getArrayCopy()
    {
        return get_object_vars($this);
    }

    public function toArray()
    {
        return (array) $this;
    }

    public function setId($id)
    {
        $this->id = $id;
    }
}