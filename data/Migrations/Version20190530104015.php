<?php declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190530104015 extends AbstractMigration
{
    public function getDescription()
    {
        $description = 'This migration adds field `email` to table `user`' ;
        return $description;
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->getTable('user');
        $table->addColumn('email', 'string', ['notnull' => true, 'length' => 100]);
    }

    public function down(Schema $schema) : void
    {
        $table = $schema->getTable('user');
        $table->dropColumn('email');
    }
}
