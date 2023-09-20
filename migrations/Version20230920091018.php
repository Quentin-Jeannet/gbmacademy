<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230920091018 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant ADD titre VARCHAR(255) DEFAULT NULL, ADD date_naissance DATE DEFAULT NULL, ADD telephone VARCHAR(255) DEFAULT NULL, ADD ville VARCHAR(255) DEFAULT NULL, ADD hopital VARCHAR(255) DEFAULT NULL, ADD specialite VARCHAR(255) DEFAULT NULL, ADD service VARCHAR(255) DEFAULT NULL, ADD num_rpps VARCHAR(255) DEFAULT NULL, ADD certificat TINYINT(1) DEFAULT NULL, ADD hebergement TINYINT(1) DEFAULT NULL, ADD transport TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant DROP titre, DROP date_naissance, DROP telephone, DROP ville, DROP hopital, DROP specialite, DROP service, DROP num_rpps, DROP certificat, DROP hebergement, DROP transport');
    }
}
