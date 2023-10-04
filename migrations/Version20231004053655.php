<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231004053655 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE alerte (id INT AUTO_INCREMENT NOT NULL, applicant_id INT NOT NULL, employer_id INT NOT NULL, message VARCHAR(255) NOT NULL, state TINYINT(1) NOT NULL, INDEX IDX_3AE753A97139001 (applicant_id), INDEX IDX_3AE753A41CD9E7A (employer_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE alerte ADD CONSTRAINT FK_3AE753A97139001 FOREIGN KEY (applicant_id) REFERENCES `user` (id)');
        $this->addSql('ALTER TABLE alerte ADD CONSTRAINT FK_3AE753A41CD9E7A FOREIGN KEY (employer_id) REFERENCES company (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE alerte DROP FOREIGN KEY FK_3AE753A97139001');
        $this->addSql('ALTER TABLE alerte DROP FOREIGN KEY FK_3AE753A41CD9E7A');
        $this->addSql('DROP TABLE alerte');
    }
}
