<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220905101242 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE refresh_tokens (id INT AUTO_INCREMENT NOT NULL, refresh_token VARCHAR(128) NOT NULL, username VARCHAR(255) NOT NULL, valid DATETIME NOT NULL, UNIQUE INDEX UNIQ_9BACE7E1C74F2195 (refresh_token), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE orders_addresses DROP FOREIGN KEY FK_1D0A344E8D9F6D38');
        $this->addSql('ALTER TABLE orders_addresses DROP FOREIGN KEY FK_1D0A344EF5B7AF75');
        $this->addSql('DROP TABLE orders_addresses');
        $this->addSql('ALTER TABLE `order` ADD shop_id INT NOT NULL, ADD address_id INT DEFAULT NULL, CHANGE status status SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F52993984D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('CREATE INDEX IDX_F52993984D16C4DD ON `order` (shop_id)');
        $this->addSql('CREATE INDEX IDX_F5299398F5B7AF75 ON `order` (address_id)');
        $this->addSql('ALTER TABLE order_transaction CHANGE shop_deposit_id shop_deposit_id INT DEFAULT NULL, CHANGE status status SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE photo ADD CONSTRAINT FK_14B784184584665A FOREIGN KEY (product_id) REFERENCES product (id)');
        $this->addSql('ALTER TABLE product CHANGE price price INT DEFAULT NULL');
        $this->addSql('ALTER TABLE product ADD CONSTRAINT FK_D34A04AD12469DE2 FOREIGN KEY (category_id) REFERENCES category (id)');
        $this->addSql('ALTER TABLE shop ADD CONSTRAINT FK_AC6A4CA2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE shops_addresses ADD CONSTRAINT FK_D4A3243D4D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE shops_addresses ADD CONSTRAINT FK_D4A3243DF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
        $this->addSql('ALTER TABLE shop_deposit ADD CONSTRAINT FK_96E8DD134D16C4DD FOREIGN KEY (shop_id) REFERENCES shop (id)');
        $this->addSql('ALTER TABLE token CHANGE type type SMALLINT NOT NULL');
        $this->addSql('ALTER TABLE token ADD CONSTRAINT FK_5F37A13BA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE users_addresses ADD CONSTRAINT FK_9B70FF7A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE users_addresses ADD CONSTRAINT FK_9B70FF7F5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE orders_addresses (order_id INT NOT NULL, address_id INT NOT NULL, UNIQUE INDEX UNIQ_1D0A344EF5B7AF75 (address_id), INDEX IDX_1D0A344E8D9F6D38 (order_id), PRIMARY KEY(order_id, address_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE orders_addresses ADD CONSTRAINT FK_1D0A344E8D9F6D38 FOREIGN KEY (order_id) REFERENCES `order` (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('ALTER TABLE orders_addresses ADD CONSTRAINT FK_1D0A344EF5B7AF75 FOREIGN KEY (address_id) REFERENCES address (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('DROP TABLE refresh_tokens');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F52993984D16C4DD');
        $this->addSql('ALTER TABLE `order` DROP FOREIGN KEY FK_F5299398F5B7AF75');
        $this->addSql('DROP INDEX IDX_F52993984D16C4DD ON `order`');
        $this->addSql('DROP INDEX IDX_F5299398F5B7AF75 ON `order`');
        $this->addSql('ALTER TABLE `order` DROP shop_id, DROP address_id, CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE order_transaction CHANGE shop_deposit_id shop_deposit_id INT NOT NULL, CHANGE status status VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE photo DROP FOREIGN KEY FK_14B784184584665A');
        $this->addSql('ALTER TABLE product DROP FOREIGN KEY FK_D34A04AD12469DE2');
        $this->addSql('ALTER TABLE product CHANGE price price NUMERIC(15, 0) NOT NULL');
        $this->addSql('ALTER TABLE shop DROP FOREIGN KEY FK_AC6A4CA2A76ED395');
        $this->addSql('ALTER TABLE shop_deposit DROP FOREIGN KEY FK_96E8DD134D16C4DD');
        $this->addSql('ALTER TABLE shops_addresses DROP FOREIGN KEY FK_D4A3243D4D16C4DD');
        $this->addSql('ALTER TABLE shops_addresses DROP FOREIGN KEY FK_D4A3243DF5B7AF75');
        $this->addSql('ALTER TABLE token DROP FOREIGN KEY FK_5F37A13BA76ED395');
        $this->addSql('ALTER TABLE token CHANGE type type VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE users_addresses DROP FOREIGN KEY FK_9B70FF7A76ED395');
        $this->addSql('ALTER TABLE users_addresses DROP FOREIGN KEY FK_9B70FF7F5B7AF75');
    }
}
