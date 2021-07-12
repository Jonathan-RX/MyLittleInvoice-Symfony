<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210712065551 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE customer (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) DEFAULT NULL, adress LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', email VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE invoice (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, adress LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', content LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', sold DOUBLE PRECISION DEFAULT NULL, printed TINYINT(1) DEFAULT NULL, send_by_mail TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_906517449395C3F3 (customer_id), INDEX IDX_90651744B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE payment (id INT AUTO_INCREMENT NOT NULL, invoice_id INT DEFAULT NULL, customer_id INT DEFAULT NULL, amount DOUBLE PRECISION DEFAULT NULL, date DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_6D28840D2989F1FD (invoice_id), INDEX IDX_6D28840D9395C3F3 (customer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quotation (id INT AUTO_INCREMENT NOT NULL, customer_id INT DEFAULT NULL, created_by_id INT DEFAULT NULL, adress LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', content LONGTEXT DEFAULT NULL COMMENT \'(DC2Type:array)\', printed TINYINT(1) DEFAULT NULL, send_by_mail TINYINT(1) DEFAULT NULL, created_at DATETIME DEFAULT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_474A8DB99395C3F3 (customer_id), INDEX IDX_474A8DB9B03A8386 (created_by_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, username VARCHAR(180) NOT NULL, roles JSON NOT NULL, password VARCHAR(255) NOT NULL, email VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649F85E0677 (username), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_906517449395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE invoice ADD CONSTRAINT FK_90651744B03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D2989F1FD FOREIGN KEY (invoice_id) REFERENCES invoice (id)');
        $this->addSql('ALTER TABLE payment ADD CONSTRAINT FK_6D28840D9395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE quotation ADD CONSTRAINT FK_474A8DB99395C3F3 FOREIGN KEY (customer_id) REFERENCES customer (id)');
        $this->addSql('ALTER TABLE quotation ADD CONSTRAINT FK_474A8DB9B03A8386 FOREIGN KEY (created_by_id) REFERENCES `user` (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_906517449395C3F3');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D9395C3F3');
        $this->addSql('ALTER TABLE quotation DROP FOREIGN KEY FK_474A8DB99395C3F3');
        $this->addSql('ALTER TABLE payment DROP FOREIGN KEY FK_6D28840D2989F1FD');
        $this->addSql('ALTER TABLE invoice DROP FOREIGN KEY FK_90651744B03A8386');
        $this->addSql('ALTER TABLE quotation DROP FOREIGN KEY FK_474A8DB9B03A8386');
        $this->addSql('DROP TABLE customer');
        $this->addSql('DROP TABLE invoice');
        $this->addSql('DROP TABLE payment');
        $this->addSql('DROP TABLE quotation');
        $this->addSql('DROP TABLE `user`');
    }
}
