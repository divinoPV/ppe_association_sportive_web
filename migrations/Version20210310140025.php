<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210310140025 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(256) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, categorie INT NOT NULL, nom VARCHAR(256) NOT NULL, lien VARCHAR(256) NOT NULL, description VARCHAR(256) NOT NULL, creer DATETIME NOT NULL, modifier DATETIME NOT NULL, INDEX IDX_D8698A76497DD634 (categorie), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(256) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, sport INT NOT NULL, type INT NOT NULL, nom VARCHAR(256) NOT NULL, description VARCHAR(612) NOT NULL, debut DATETIME NOT NULL, fin DATETIME NOT NULL, creer DATETIME NOT NULL, modifier DATETIME NOT NULL, nombre_places INT NOT NULL, image VARCHAR(256) NOT NULL, vignette VARCHAR(256) NOT NULL, evenementCategorie INT NOT NULL, INDEX IDX_B26681E1A85EFD2 (sport), INDEX IDX_B26681E8CDE5729 (type), INDEX IDX_B26681E6A2A8A1F (evenementCategorie), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement_categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (user INT NOT NULL, evenement INT NOT NULL, creer DATETIME NOT NULL, INDEX IDX_5E90F6D68D93D649 (user), INDEX IDX_5E90F6D6B26681E (evenement), PRIMARY KEY(user, evenement)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(256) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(256) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, categorie_id INT DEFAULT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL, mdp VARCHAR(255) NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, forgotten_password TINYINT(1) DEFAULT NULL, naissance DATETIME DEFAULT NULL, creer DATETIME DEFAULT NULL, modifier DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), INDEX IDX_8D93D649BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A76497DD634 FOREIGN KEY (categorie) REFERENCES document_categorie (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E1A85EFD2 FOREIGN KEY (sport) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E8CDE5729 FOREIGN KEY (type) REFERENCES type (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681E6A2A8A1F FOREIGN KEY (evenementCategorie) REFERENCES evenement_categorie (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D68D93D649 FOREIGN KEY (user) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6B26681E FOREIGN KEY (evenement) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BCF5E72D');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A76497DD634');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6B26681E');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E6A2A8A1F');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E1A85EFD2');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681E8CDE5729');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D68D93D649');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE document_categorie');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE evenement_categorie');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
    }
}
