<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240613090034 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Add the 'promotionStatus' column as ENUM with default value 'None'
        $this->addSql("ALTER TABLE book ADD promotion_status ENUM('None', 'Basic', 'Pro') NOT NULL DEFAULT 'None'");


        // Convert existing 'isPromoted' values to 'promotionStatus'g
        $this->addSql("UPDATE book SET promotion_status = 'Basic' WHERE is_promoted = true");
        $this->addSql("UPDATE book SET promotion_status = 'None' WHERE is_promoted = false");

        // Drop the 'isPromoted' column
        $this->addSql('ALTER TABLE book DROP is_promoted');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        // Re-add the 'isPromoted' column
        $this->addSql('ALTER TABLE book ADD is_promoted BOOLEAN NOT NULL DEFAULT false');

        // Convert existing 'promotionStatus' values back to 'isPromoted'
        $this->addSql("UPDATE book SET is_promoted = true WHERE promotion_status = 'Basic'");
        $this->addSql("UPDATE book SET is_promoted = false WHERE promotion_status = 'None'");

        // Drop the 'promotionStatus' column
        $this->addSql('ALTER TABLE book DROP promotion_status');
    }
}
