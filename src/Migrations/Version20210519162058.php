<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210519162058 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE `order` (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, show_id INT NOT NULL, amount DOUBLE PRECISION DEFAULT \'0\' NOT NULL, payment_date DATETIME NOT NULL, payment_status VARCHAR(20) NOT NULL, confirmation_code VARCHAR(50) NOT NULL, payment_response LONGTEXT NOT NULL, INDEX IDX_F5299398A76ED395 (user_id), INDEX IDX_F5299398D0C1FC64 (show_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE `order` ADD CONSTRAINT FK_F5299398D0C1FC64 FOREIGN KEY (show_id) REFERENCES `show` (id)');
        $this->addSql('ALTER TABLE `show` ADD user_id INT NOT NULL, ADD amount DOUBLE PRECISION DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE `show` ADD CONSTRAINT FK_320ED901A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_320ED901A76ED395 ON `show` (user_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE `order`');
        $this->addSql('ALTER TABLE `show` DROP FOREIGN KEY FK_320ED901A76ED395');
        $this->addSql('DROP INDEX IDX_320ED901A76ED395 ON `show`');
        $this->addSql('ALTER TABLE `show` DROP user_id, DROP amount');
    }
}
