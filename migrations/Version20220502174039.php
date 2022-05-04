<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220502174039 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comentario ADD usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E702DB38439E FOREIGN KEY (usuario_id) REFERENCES incidencia (id)');
        $this->addSql('CREATE INDEX IDX_4B91E702DB38439E ON comentario (usuario_id)');
        $this->addSql('ALTER TABLE incidencia DROP INDEX averia_id, ADD UNIQUE INDEX UNIQ_C7C6728CD6F24FAE (averia_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comentario DROP FOREIGN KEY FK_4B91E702DB38439E');
        $this->addSql('DROP INDEX IDX_4B91E702DB38439E ON comentario');
        $this->addSql('ALTER TABLE comentario DROP usuario_id');
        $this->addSql('ALTER TABLE incidencia DROP INDEX UNIQ_C7C6728CD6F24FAE, ADD INDEX averia_id (averia_id)');
    }
}
