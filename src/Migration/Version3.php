<?php

namespace Snowdog\DevTest\Migration;

use Snowdog\DevTest\Core\Database;

class Version3
{
    /**
     * @var Database|\PDO
     */
    private $database;

    public function __construct(
        Database $database
    ) {
        $this->database = $database;
    }

    public function __invoke()
    {
        $this->createVarnishTable();
        $this->createVarnishWebsiteLinkTable();
    }

    private function createVarnishTable()
    {
        $createQuery = <<<SQL
CREATE TABLE `varnish` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `ip` varchar(255) NOT NULL,
  `user_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `varnish_user_fk` (`user_id`),
  CONSTRAINT `varnish_user_fk` FOREIGN KEY (`user_id`) REFERENCES `users` (`user_id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
        $this->database->exec($createQuery);
    }

    private function createVarnishWebsiteLinkTable()
    {
        $createQuery = <<<SQL
CREATE TABLE `relation_varnish_website` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT,
  `varnish_id` int(11) unsigned NOT NULL,
  `website_id` int(11) unsigned NOT NULL,
  PRIMARY KEY (`id`),
  KEY `varnish_id` (`varnish_id`),
  KEY `website_id` (`website_id`),
  CONSTRAINT `varnish_id_fk` FOREIGN KEY (`varnish_id`) REFERENCES `varnish` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  CONSTRAINT `website_id_fk` FOREIGN KEY (`website_id`) REFERENCES `websites` (`website_id`) ON DELETE CASCADE ON UPDATE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8;
SQL;
        $this->database->exec($createQuery);
    }
}