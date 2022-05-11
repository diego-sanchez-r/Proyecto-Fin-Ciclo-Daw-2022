<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220409160930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comentario ADD incidencia_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE comentario ADD CONSTRAINT FK_4B91E702E1605BE2 FOREIGN KEY (incidencia_id) REFERENCES incidencia (id)');
        $this->addSql('CREATE INDEX IDX_4B91E702E1605BE2 ON comentario (incidencia_id)');
        $this->addSql('ALTER TABLE incidencia ADD usuario_id INT NOT NULL, ADD averia_id INT NOT NULL');
        $this->addSql('ALTER TABLE incidencia ADD CONSTRAINT FK_C7C6728CDB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE incidencia ADD CONSTRAINT FK_C7C6728CD6F24FAE FOREIGN KEY (averia_id) REFERENCES tipo_averia (id)');
        $this->addSql('CREATE INDEX IDX_C7C6728CDB38439E ON incidencia (usuario_id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C7C6728CD6F24FAE ON incidencia (averia_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE comentario DROP FOREIGN KEY FK_4B91E702E1605BE2');
        $this->addSql('DROP INDEX IDX_4B91E702E1605BE2 ON comentario');
        $this->addSql('ALTER TABLE comentario DROP incidencia_id');
        $this->addSql('ALTER TABLE incidencia DROP FOREIGN KEY FK_C7C6728CDB38439E');
        $this->addSql('ALTER TABLE incidencia DROP FOREIGN KEY FK_C7C6728CD6F24FAE');
        $this->addSql('DROP INDEX IDX_C7C6728CDB38439E ON incidencia');
        $this->addSql('DROP INDEX UNIQ_C7C6728CD6F24FAE ON incidencia');
        $this->addSql('ALTER TABLE incidencia DROP usuario_id, DROP averia_id');
    }
}
