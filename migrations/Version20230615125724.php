<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230615125724 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE joboffer (id INT AUTO_INCREMENT NOT NULL, company_id INT DEFAULT NULL, job_id INT DEFAULT NULL, contract_id INT DEFAULT NULL, salary_id INT DEFAULT NULL, title VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, city VARCHAR(50) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX IDX_F33F8164979B1AD6 (company_id), INDEX IDX_F33F8164BE04EA9 (job_id), INDEX IDX_F33F81642576E0FD (contract_id), INDEX IDX_F33F8164B0FDF16E (salary_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE joboffer ADD CONSTRAINT FK_F33F8164979B1AD6 FOREIGN KEY (company_id) REFERENCES company (id)');
        $this->addSql('ALTER TABLE joboffer ADD CONSTRAINT FK_F33F8164BE04EA9 FOREIGN KEY (job_id) REFERENCES job (id)');
        $this->addSql('ALTER TABLE joboffer ADD CONSTRAINT FK_F33F81642576E0FD FOREIGN KEY (contract_id) REFERENCES contract (id)');
        $this->addSql('ALTER TABLE joboffer ADD CONSTRAINT FK_F33F8164B0FDF16E FOREIGN KEY (salary_id) REFERENCES salary (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE joboffer DROP FOREIGN KEY FK_F33F8164979B1AD6');
        $this->addSql('ALTER TABLE joboffer DROP FOREIGN KEY FK_F33F8164BE04EA9');
        $this->addSql('ALTER TABLE joboffer DROP FOREIGN KEY FK_F33F81642576E0FD');
        $this->addSql('ALTER TABLE joboffer DROP FOREIGN KEY FK_F33F8164B0FDF16E');
        $this->addSql('DROP TABLE joboffer');
    }
}
