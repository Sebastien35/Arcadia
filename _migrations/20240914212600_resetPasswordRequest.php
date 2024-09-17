<?php

use Phpmig\Migration\Migration;

class Init extends Migration
{
    /**
     * Do the migration
     */
    public function up()
    {
        $sql = "
        -- Définir le mode SQL pour désactiver l'auto-incrément sur zéro
        SET SQL_MODE = 'NO_AUTO_VALUE_ON_ZERO';

        -- Commencer la transaction
        START TRANSACTION;

        -- Création de la table reset_password_request
        CREATE TABLE `reset_password_request` (
            `id` int(11) NOT NULL AUTO_INCREMENT,
            `user_id` int(11) NOT NULL,
            `selector` varchar(20) NOT NULL,
            `hashed_token` varchar(100) NOT NULL,
            `requested_at` datetime NOT NULL,
            `expires_at` datetime NOT NULL,
            PRIMARY KEY (`id`),
            KEY `FK_user_for_password_reset` (`user_id`)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_general_ci;

        -- Ajouter la contrainte de clé étrangère
        ALTER TABLE `reset_password_request`
        ADD CONSTRAINT `FK_user_for_password_reset`
        FOREIGN KEY (`user_id`) REFERENCES `users` (`id`);

        -- Valider la transaction
        COMMIT;
        ";

        $container = $this->getContainer();
        $container['db']->exec($sql);
    }
}