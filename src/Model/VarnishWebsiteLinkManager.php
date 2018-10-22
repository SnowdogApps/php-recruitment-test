<?php

namespace Snowdog\DevTest\Model;

use Snowdog\DevTest\Core\Database;

class VarnishWebsiteLinkManager
{
    /**
     * @var Database|\PDO
     */
    private $database;
    public function __construct(Database $database)
    {
        $this->database = $database;
    }
    public function create($varnish_id, $website_id)
    {
        /** @var \PDOStatement $statement */
        $statement = $this->database->prepare('INSERT INTO relation_varnish_website (varnish_id, website_id) VALUES (:varnish_id, :website_id)');
        $statement->bindParam(':varnish_id', intval($varnish_id), \PDO::PARAM_INT);
        $statement->bindParam(':website_id', intval($website_id), \PDO::PARAM_INT);
        return $statement->execute();
    }

    public function delete($varnish_id, $website_id)
    {
        $query = $this->database->prepare('DELETE FROM relation_varnish_website WHERE (varnish_id = :varnish_id and website_id = :website_id)');
        $query->bindParam(":varnish_id", intval($varnish_id), \PDO::PARAM_INT);
        $query->bindParam(":website_id", intval($website_id), \PDO::PARAM_INT);
        return $query->execute();
    }
}