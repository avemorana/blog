<?php declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190319152917 extends AbstractMigration
{
    public function getDescription()
    {
        $description = 'This is initial migration which creates blog tables';
        return $description;
    }

    /**
     * @param Schema $schema
     */
    public function up(Schema $schema) : void
    {
        $table = $schema->createTable('user');
        $table->addColumn('user_id', 'integer', ['autoincrement'=>true]);
        $table->addColumn('login', 'string', ['notnull'=>true]);
        $table->addColumn('password', 'string', ['notnull'=>true]);
        $table->setPrimaryKey(['user_id']);
        $table->addOption('engine' , 'InnoDB');

        $table = $schema->createTable('post');
        $table->addColumn('post_id', 'integer', ['autoincrement'=>true]);
        $table->addColumn('title', 'string', ['notnull'=>true]);
        $table->addColumn('content', 'text', ['notnull'=>true]);
        $table->addColumn('date_created', 'datetime', ['notnull'=>true]);
        $table->addColumn('user_id', 'integer', ['notnull'=>true]);
        $table->setPrimaryKey(['post_id']);
        $table->addOption('engine' , 'InnoDB');
    }

    public function down(Schema $schema) : void
    {
        $schema->dropTable('user');
        $schema->dropTable('post');
    }
}
