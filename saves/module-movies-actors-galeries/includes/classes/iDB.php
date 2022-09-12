<?php

	interface iDb {
		/**
		 * Ajoute à la base de données.
		 */
		public function register ();

		/**
		 * Supprime de la base de données.
		 */
		public function unregister ();

		/**
		 * Sauvegarde les changement effectués sur l'instance dans la base de données.
		 */
		public function save ();
	}