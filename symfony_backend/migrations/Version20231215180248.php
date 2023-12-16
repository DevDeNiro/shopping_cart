<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231215180248 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE cart (id UUID NOT NULL, session_id VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN cart.id IS \'(DC2Type:cart_id)\'');
        $this->addSql('CREATE TABLE cart_items (id UUID NOT NULL, cart_id UUID NOT NULL, product_id UUID NOT NULL, quantity INT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN cart_items.id IS \'(DC2Type:cart_items_id)\'');
        $this->addSql('COMMENT ON COLUMN cart_items.cart_id IS \'(DC2Type:cart_id)\'');
        $this->addSql('COMMENT ON COLUMN cart_items.product_id IS \'(DC2Type:product_id)\'');
        $this->addSql('CREATE TABLE products (id UUID NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN products.id IS \'(DC2Type:product_id)\'');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP TABLE cart');
        $this->addSql('DROP TABLE cart_items');
        $this->addSql('DROP TABLE products');
    }
}
