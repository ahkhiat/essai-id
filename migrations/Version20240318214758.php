<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240318214758 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commandes ADD Id_Commande INT AUTO_INCREMENT NOT NULL, DROP id, ADD PRIMARY KEY (Id_Commande)');
        $this->addSql('ALTER TABLE livres MODIFY id INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON livres');
        $this->addSql('ALTER TABLE livres CHANGE id Id_Commande INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE livres ADD PRIMARY KEY (Id_Commande)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE commandes MODIFY Id_Commande INT NOT NULL');
        $this->addSql('DROP INDEX `primary` ON commandes');
        $this->addSql('ALTER TABLE commandes ADD id INT NOT NULL, DROP Id_Commande');
        $this->addSql('ALTER TABLE livres MODIFY Id_Commande INT NOT NULL');
        $this->addSql('DROP INDEX `PRIMARY` ON livres');
        $this->addSql('ALTER TABLE livres CHANGE Id_Commande id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE livres ADD PRIMARY KEY (id)');
    }
}
