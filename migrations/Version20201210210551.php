<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201210210551 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product ADD description LONGTEXT DEFAULT NULL');
        $this->addSql('ALTER TABLE product_category MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC7356DE18E50B');
        $this->addSql('DROP INDEX IDX_CDFC7356DE18E50B ON product_category');
        $this->addSql('ALTER TABLE product_category DROP PRIMARY KEY');
        $this->addSql('ALTER TABLE product_category ADD category_id INT NOT NULL, DROP id, CHANGE product_id_id product_id INT NOT NULL');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC73564584665A FOREIGN KEY (product_id) REFERENCES product (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC735612469DE2 FOREIGN KEY (category_id) REFERENCES category (id) ON DELETE CASCADE');
        $this->addSql('CREATE INDEX IDX_CDFC73564584665A ON product_category (product_id)');
        $this->addSql('CREATE INDEX IDX_CDFC735612469DE2 ON product_category (category_id)');
        $this->addSql('ALTER TABLE product_category ADD PRIMARY KEY (product_id, category_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE product DROP description');
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC73564584665A');
        $this->addSql('ALTER TABLE product_category DROP FOREIGN KEY FK_CDFC735612469DE2');
        $this->addSql('DROP INDEX IDX_CDFC73564584665A ON product_category');
        $this->addSql('DROP INDEX IDX_CDFC735612469DE2 ON product_category');
        $this->addSql('ALTER TABLE product_category ADD id INT AUTO_INCREMENT NOT NULL, ADD product_id_id INT NOT NULL, DROP product_id, DROP category_id, DROP PRIMARY KEY, ADD PRIMARY KEY (id)');
        $this->addSql('ALTER TABLE product_category ADD CONSTRAINT FK_CDFC7356DE18E50B FOREIGN KEY (product_id_id) REFERENCES product (id)');
        $this->addSql('CREATE INDEX IDX_CDFC7356DE18E50B ON product_category (product_id_id)');
    }
}
