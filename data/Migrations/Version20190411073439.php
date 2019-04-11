<?php declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190411073439 extends AbstractMigration
{
    public function getDescription()
    {
        $description = 'This migration creates table for user`s saved posts';
        return $description;
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('saved_post');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('post_id', 'integer', ['notnull' => true]);
        $table->addColumn('user_id', 'integer', ['notnull' => true]);
        $table->addColumn('date_saved', 'datetime', ['notnull' => true]);
        $table->setPrimaryKey(['id']);
        $table->addOption('engine', 'InnoDB');

    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('saved_post');
    }
}
