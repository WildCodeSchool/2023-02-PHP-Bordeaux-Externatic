<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230704093017 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE joboffer_user (joboffer_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_F947B652BD612208 (joboffer_id), INDEX IDX_F947B652A76ED395 (user_id), PRIMARY KEY(joboffer_id, user_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE joboffer_user ADD CONSTRAINT FK_F947B652BD612208 FOREIGN KEY (joboffer_id) REFERENCES joboffer (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE joboffer_user ADD CONSTRAINT FK_F947B652A76ED395 FOREIGN KEY (user_id) REFERENCES `user` (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE joboffer_user DROP FOREIGN KEY FK_F947B652BD612208');
        $this->addSql('ALTER TABLE joboffer_user DROP FOREIGN KEY FK_F947B652A76ED395');
        $this->addSql('DROP TABLE joboffer_user');
    }
}
