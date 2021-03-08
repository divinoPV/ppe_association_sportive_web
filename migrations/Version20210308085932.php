<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210308085932 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document (id INT AUTO_INCREMENT NOT NULL, document_categorie_id INT NOT NULL, nom VARCHAR(255) NOT NULL, lien VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, creer DATETIME NOT NULL, modifier DATETIME NOT NULL, INDEX IDX_D8698A761110C65C (document_categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE document_categorie (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE evenement (id INT AUTO_INCREMENT NOT NULL, sport_id INT NOT NULL, type_id INT NOT NULL, categorie_id INT NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, debut DATETIME NOT NULL, fin DATETIME NOT NULL, creer DATETIME NOT NULL, modifier DATETIME NOT NULL, nombre_places INT NOT NULL, image VARCHAR(255) NOT NULL, vignette VARCHAR(255) NOT NULL, INDEX IDX_B26681EAC78BCF8 (sport_id), INDEX IDX_B26681EC54C8C93 (type_id), INDEX IDX_B26681EBCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE inscription (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, evenement_id INT NOT NULL, creer DATETIME NOT NULL, INDEX IDX_5E90F6D6A76ED395 (user_id), INDEX IDX_5E90F6D6FD02F13 (evenement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE sport (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, categorie_id INT NOT NULL, email VARCHAR(255) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', password VARCHAR(255) NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, forgotten_password TINYINT(1) DEFAULT NULL, naissance DATETIME DEFAULT NULL, creer DATETIME DEFAULT NULL, modifier DATETIME DEFAULT NULL, INDEX IDX_8D93D649BCF5E72D (categorie_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE document ADD CONSTRAINT FK_D8698A761110C65C FOREIGN KEY (document_categorie_id) REFERENCES document_categorie (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EAC78BCF8 FOREIGN KEY (sport_id) REFERENCES sport (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE evenement ADD CONSTRAINT FK_B26681EBCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE inscription ADD CONSTRAINT FK_5E90F6D6FD02F13 FOREIGN KEY (evenement_id) REFERENCES evenement (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649BCF5E72D FOREIGN KEY (categorie_id) REFERENCES categorie (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EBCF5E72D');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649BCF5E72D');
        $this->addSql('ALTER TABLE document DROP FOREIGN KEY FK_D8698A761110C65C');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6FD02F13');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EAC78BCF8');
        $this->addSql('ALTER TABLE evenement DROP FOREIGN KEY FK_B26681EC54C8C93');
        $this->addSql('ALTER TABLE inscription DROP FOREIGN KEY FK_5E90F6D6A76ED395');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE document');
        $this->addSql('DROP TABLE document_categorie');
        $this->addSql('DROP TABLE evenement');
        $this->addSql('DROP TABLE inscription');
        $this->addSql('DROP TABLE sport');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE user');
    }
}
