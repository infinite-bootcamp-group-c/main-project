<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220905065005 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` ADD shop_id INT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('CREATE INDEX IDX_F52993984D16C4DD ON `order` (shop_id)');
        $this->addSql('ALTER TABLE product CHANGE price price INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984D16C4DD');
        $this->addSql('DROP INDEX IDX_F52993984D16C4DD ON `order`');
        $this->addSql('ALTER TABLE `order` DROP shop_id');
        $this->addSql('ALTER TABLE product CHANGE price price NUMERIC(15, 0) NOT NULL');
    }
}
