<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220514141954 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE incidencia DROP INDEX averia_id, ADD UNIQUE INDEX UNIQ_C7C6728CD6F24FAE (averia_id)');
        $this->addSql('ALTER TABLE noticias ADD usuario_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE noticias ADD CONSTRAINT FK_253D925DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('CREATE INDEX IDX_253D925DB38439E ON noticias (usuario_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE incidencia DROP INDEX UNIQ_C7C6728CD6F24FAE, ADD INDEX averia_id (averia_id)');
        $this->addSql('ALTER TABLE noticias DROP FOREIGN KEY FK_253D925DB38439E');
        $this->addSql('DROP INDEX IDX_253D925DB38439E ON noticias');
        $this->addSql('ALTER TABLE noticias DROP usuario_id');
    }
}
