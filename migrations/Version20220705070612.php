<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220705070612 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "movie_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "movie_cast_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "movie_rating_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "movie" (id INT NOT NULL, name VARCHAR(255) NOT NULL, release_date DATE NOT' .
                        ' NULL, director VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "movie_cast" (id INT NOT NULL, movie_id INT DEFAULT NULL,' .
                        ' name VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_E1DE98FB8F93B6FC ON "movie_cast" (movie_id)');
        $this->addSql('CREATE TABLE "movie_rating" (id INT NOT NULL, movie_id INT DEFAULT NULL,' .
                        ' platform_name VARCHAR(255) NOT NULL, rate DOUBLE PRECISION NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_214EBB578F93B6FC ON "movie_rating" (movie_id)');
        $this->addSql('ALTER TABLE "movie_cast" ADD CONSTRAINT FK_E1DE98FB8F93B6FC FOREIGN KEY (movie_id)' .
                        ' REFERENCES "movie" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "movie_rating" ADD CONSTRAINT FK_214EBB578F93B6FC FOREIGN KEY (movie_id)' .
                        ' REFERENCES "movie" (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE "movie_cast" DROP CONSTRAINT FK_E1DE98FB8F93B6FC');
        $this->addSql('ALTER TABLE "movie_rating" DROP CONSTRAINT FK_214EBB578F93B6FC');
        $this->addSql('DROP SEQUENCE "movie_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "movie_cast_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "movie_rating_id_seq" CASCADE');
        $this->addSql('DROP TABLE "movie"');
        $this->addSql('DROP TABLE "movie_cast"');
        $this->addSql('DROP TABLE "movie_rating"');
    }
}
