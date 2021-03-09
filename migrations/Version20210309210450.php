<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210309210450 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6B26681E');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6B26681E FOREIGN KEY (evenement) REFERENCES evenement (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6B26681E');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6B26681E FOREIGN KEY (evenement) REFERENCES evenement (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
    }
}
