<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220409162024 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comentario DROP id_incidencia');
        $this->addSql('ALTER TABLE incidencia DROP tipo_averia, DROP id_usuario');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comentario ADD id_incidencia INT NOT NULL');
        $this->addSql('ALTER TABLE incidencia ADD tipo_averia INT NOT NULL, ADD id_usuario INT NOT NULL');
    }
}
