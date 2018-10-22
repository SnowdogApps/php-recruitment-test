<?php

namespace Snowdog\DevTest\Model;

use Snowdog\DevTest\Core\Database;

class VarnishManager
{

    /**
     * @var Database|\PDO
     */
    private $database;
    /**
     * @var VarnishWebsiteLinkManager
     */
    private $varnishWebsiteLinkManager;

    public function __construct(Database $database, VarnishWebsiteLinkManager $varnishWebsiteLinkManager)
    {
        $this->database = $database;
        $this->varnishWebsiteLinkManager = $varnishWebsiteLinkManager;
    }

    public function getAllByUser(User $user)
    {
        $userId = $user->getUserId();
        /** @var \PDOStatement $statement */
        $query = $this->database->prepare('SELECT * FROM varnish WHERE user_id = :user');
        $query->bindParam(':user', $userId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Varnish::class);
    }

    public function getWebsites(Varnish $varnish)
    {
        $varnishId = $varnish->getId();
        /** @var \PDOStatement $statement */
        $query = $this->database->prepare('
              SELECT *
              FROM websites
              INNER JOIN relation_varnish_website ON (websites.website_id = relation_varnish_website.website_id)
              WHERE relation_varnish_website.varnish_id = :varnish_id
        ');
        $query->bindParam(':varnish_id', $varnishId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_CLASS, Website::class);
    }

    public function getByWebsite(Website $website)
    {
        $websiteId = $website->getWebsiteId();
        /** @var \PDOStatement $statement */
        $query = $this->database->prepare('
            SELECT *
            FROM varnish
            INNER JOIN relation_varnish_website ON (varnish.id = relation_varnish_website.varnish_id)
            WHERE relation_varnish_website.website_id = :website_id
        ');
        $query->bindParam(':website_id', $websiteId, \PDO::PARAM_INT);
        $query->execute();
        return $query->fetch();
    }

    public function create(User $user, $ip)
    {
        $userId = $user->getUserId();
        /** @var \PDOStatement $statement */
        $statement = $this->database->prepare('INSERT INTO varnish (ip, user_id) VALUES (:ip, :user_id)');
        $statement->bindParam(':ip', $ip, \PDO::PARAM_STR);
        $statement->bindParam(':user_id', $userId, \PDO::PARAM_INT);
        $statement->execute();
        return $this->database->lastInsertId();
    }

    public function getVarnishById($id){
        $id = intval($id);
        /** @var \PDOStatement $statement */
        $query = $this->database->prepare("SELECT * FROM varnish WHERE id = :id");
        $query->setFetchMode(\PDO::FETCH_CLASS, Varnish::class);
        $query->bindParam(':id', $id, \PDO::PARAM_STR);
        $query->execute();
        $res = $query->fetch(\PDO::FETCH_CLASS);
        return $res;

    }

}