<?php declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190405131313 extends AbstractMigration
{
    public function getDescription()
    {
        $description = 'This migration creates new tables post tags';
        return $description;
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('tag');
        $table->addColumn('tag_id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['notnull' => true, 'length' => 50]);
        $table->setPrimaryKey(['tag_id']);
        $table->addOption('engine' , 'InnoDB');

        $table = $schema->createTable('post_tag');
        $table->addColumn('id', 'integer', ['autoincrement'=>true]);
        $table->addColumn('post_id', 'integer', ['notnull'=>true]);
        $table->addColumn('tag_id', 'integer', ['notnull'=>true]);
        $table->setPrimaryKey(['id']);
        $table->addOption('engine' , 'InnoDB');
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('post_tag');
        $schema->dropTable('tag');
    }
}
