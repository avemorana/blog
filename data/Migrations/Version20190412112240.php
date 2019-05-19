<?php declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190412112240 extends AbstractMigration
{
    public function getDescription()
    {
        $description = 'This migration creates table for user`s blocked users';
        return $description;
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('blocked_user');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('user_id', 'integer', ['notnull' => true]);
        $table->addColumn('blocked_id', 'integer', ['notnull' => true]);
        $table->setPrimaryKey(['id']);
        $table->addOption('engine', 'InnoDB');
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('blocked_user');
    }
}
