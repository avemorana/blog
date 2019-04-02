<?php declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190402094446 extends AbstractMigration
{
    public function getDescription()
    {
        $description = 'This migration creates new table for post comments';
        return $description;
    }

    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('comment');
        $table->addColumn('comment_id', 'integer', ['autoincrement'=>true]);
        $table->addColumn('post_id', 'integer', ['notnull'=>true]);
        $table->addColumn('user_id', 'integer', ['notnull'=>true]);
        $table->addColumn('content', 'string', ['notnull'=>true, 'length' => 255]);
        $table->addColumn('date_created', 'datetime', ['notnull'=>true]);
        $table->setPrimaryKey(['comment_id']);
        $table->addOption('engine' , 'InnoDB');
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('comment');
    }
}
