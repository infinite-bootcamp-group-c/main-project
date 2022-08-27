<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220824171129 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` CHANGE status status SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE order_transaction CHANGE status status SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE token CHANGE type type SMALLINT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE order_transaction CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE token CHANGE type type VARCHAR(255) DEFAULT NULL');
    }
}
