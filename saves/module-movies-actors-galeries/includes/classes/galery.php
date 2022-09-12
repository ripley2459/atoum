<?php

	class galery implements iDB {
		///////////////////////////////////////////////////////////////////////////////////////////////
		// Fields

		private $id;
		private $name;
		private $registration_date;

		///////////////////////////////////////////////////////////////////////////////////////////////
		// Properties

		/**
		 * Propriété de id.
		 */
		public function getId() {
			return $this->id;
		}

		/**
		 * Propriété de name.
		 */
		public function setName( string $name ) {
			$this->name = $name;
		}

		public function getName() {
			return $this->name;
		}

		/**
		 * Propriété de la date d'inscription.
		 */
		public function getRegistrationDate() {
			return $this->registration_date;
		}

		///////////////////////////////////////////////////////////////////////////////////////////////
		// Methods

		/**
		 * Constructeur.
		 */
		public function __construct( int $id ) {
			// -1 = temporaire
			if( $id != -1 ) {
				global $DDB;

				$sql0 = 'SELECT * FROM rp_galeries WHERE galery_id = :galery_id';

				$rqst_retrieve = $DDB->prepare( $sql0 );
				$rqst_retrieve->execute( [ ':galery_id'=>$id ] );

				if( $rqst_retrieve ) {
					$actor = $rqst_retrieve->fetch();
					$this->id = $actor[ 'galery_id' ];
					$this->name = $actor[ 'galery_name' ];
					$this->registration_date = $actor[ 'galery_registration_date' ];
				}

				$rqst_retrieve->closeCursor();
			};
		}

		/**
		 * Crée un dossier avec le nom normalisé de la galerie, déposer les fichiers par défaut et enregistrer cette galerie dans la base de données.
		 */
		public function register() {
			global $DDB;

			// Ajout dans la base de données.
			$sql0 = 'INSERT INTO rp_galeries SET galery_name = :galery_name';
			$rqst_register = $DDB->prepare( $sql0 );
			$rqst_register->execute( [
				':galery_name'=>$this->name,
			] );
			$rqst_register->closeCursor();

			$this->__construct( $DDB->lastInsertId() );

			mkdir( UPLOADS . 'galeries/' . $this->getNormalizedFileName() );

			// Dépose des fichiers par défaut.
			copy( INCLUDES . 'placeholders/' . 'profile.png', UPLOADS . 'galeries/' . $this->getNormalizedFileName() . '/preview.png' );
		}

		/**
		 * Ajoute "removed_" devant le nom dans le dossier de la galerie.
		 * Si l'opération réussie, alors on supprime de la base de données cette galerie.
		 */
		public function unregister() {
			global $DDB;

			if( rename( UPLOADS . 'galeries/' . $this->getNormalizedFileName(), UPLOADS . 'galeries/removed_' . $this->getNormalizedFileName() ) ) {
				$sql0 = 'DELETE FROM rp_galeries WHERE galery_id = :galery_id';
				$rqst_unregister = $DDB->prepare( $sql0 );
				$rqst_unregister->execute( [ ':galery_id'=>$this->id ] );
				$rqst_unregister->closeCursor();
			}
		}

		/**
		 * Sauvegarde les changement appliqués sur cette instance dans la base de données.
		 * Renome également le dossier.
		 */
		public function save() {
			global $DDB;

			$sql0 = 'UPDATE rp_galeries SET galery_name = :galery_name WHERE galery_id = :galery_id';
			$rqst_save = $DDB->prepare( $sql0 );
			$rqst_save->execute( [
				':galery_name'=>$this->name,
				':galery_id'=>$this->id,
			] );
			$rqst_save->closeCursor();
		}

		/**
		 * Donne toutes les galeries enrgistrées dans la base de données.
		 * @return galery array.
		 */
		static function getAll() {
			global $DDB;

			$galeries = [];
			$sql0 = 'SELECT galery_id FROM rp_galeries ORDER BY galery_name';
			$rqst_get_galeries = $DDB->prepare( $sql0 );
			$rqst_get_galeries->execute();
			while( $galery = $rqst_get_galeries->fetch() ) {
				$galery = new galery( $galery[ 'galery_id' ] );
				array_push( $galeries, $galery );
			}
			$rqst_get_galeries->closeCursor();
			return $galeries;
		}

		/**
		 * Affiche toutes les galeries.
		 * Exploitable en HTML.
		 */
		static function showAll( $shuffle = false ) {
			global $DDB;
			$r = '<div id="galeries" style="column-count: 4;">';

			$galeries = galery::getAll();
			if( $shuffle ) shuffle( $galeries );

			foreach ( $galeries as $galerie )
			{
				$r .= '<div id="' . $galerie->getId() . '" class="galery"><a href="galery.php?galery=' . $galerie->getId() . '">' . $galerie->getPreview() . '<h3>' . $galerie->getName() . '</h3></a></div>';
			}
			return $r . '</div>';
		}

		/**
		 * Affiche cette galerie.
		 * Exploitable en HTML.
		 */
		public function display( $shuffle = false ) {
			$images = $this->getImages();
			return galery::displayAsGalery( $this, $images, $shuffle );
		}

		/**
		 * Affiche une galerie et ses images sous forme de galerie.
		 * Exploitable en HTML.
		 */
		static function displayAsGalery( $galery, $images = null, $shuffle = false ) {
			if( $images == null ) $images = $galery->getImages();
			if( $shuffle ) shuffle( $images );

			$imgS = '';
			$modal = '<div id="galery_slideshow_' . $galery->getNormalizedFileName() . '" class="modal galery_slideshow">';
			$thumbnails = '<div class="thumbnails">';

			$i = 0;
			foreach ( $images as $image )
			{
				if( $image == 'preview.png' ) continue;
				//if( $image == 'profile.png' ) continue;
				$i++;

				$name = $galery->getNormalizedFileName() . '/' . $image;

				if( galery::isFavorite( str_replace( "/", "_", $name ) ) ) $f = '<button class="fav" onclick="removeFavorite(\'' . $name . '\',this)"><i class="fa fa-star"></i></button>';
				else $f = '<button class="fav" onclick="setFavorite(\'' . $name . '\',this)"><i class="fa fa-star-o"></i></button>';

				$imgS .= '<img src="' . $galery->getUrl() . $image . '" onclick="openModal(\'galery_slideshow_' . $galery->getNormalizedFileName() . '\');currentSlide(' . $i . ')">';
				$modal .= '<div class="slide"><img src="' . $galery->getUrl() . $image . '">' . $f . '</div>';
				$thumbnails .= '<img src="' . $galery->getUrl() . $image . '" class="thumbnail" onclick="openModal(\'galery_slideshow_' . $galery->getNormalizedFileName() . '\');currentSlide(' . $i . ')">';
			}

			return '<div id="galery_container_' . $galery->getNormalizedFileName() . '" class="galery_container">
			<div id="galery_images_wrapper_' . $galery->getNormalizedFileName() . '" class="galery_images_wrapper" style="column-count: 4;">' . $imgS . '</div>' . $modal . '
			<div id="slideshow-progress">x/y</div>
			<button class="close" onclick="closeModal(\'galery_slideshow_' . $galery->getNormalizedFileName() . '\')"><i class="fa fa-close"></i></button>
			<button class="prev" onclick="plusSlides(-1)"><i class="fa fa-arrow-left"></i></button>
			<button class="next" onclick="plusSlides(1)"><i class="fa fa-arrow-right"></i></button>' . $thumbnails . '</div></div></div>';
		}

		/**
		 * Change le nom du fichier et dans la base de données de la galerie.
		 */
		public function changeName( string $newName ) {
			rename( UPLOADS . 'galeries/' . $this->getNormalizedFileName(),  UPLOADS . 'galeries/' . normalize( $newName . '_' . $this->registration_date ) );
			$this->setName( $newName );
			$this->save();
		}

		/**
		 * Affiche toutes les galeries sous forme d'une checkbox.
		 */
		static function displayAllAsCheckBox( int $contentId, int $relationType ) {
			$r ='';
			$relation = new relation( -1 );
			$relation->setA( $contentId );
			$relation->setType( $relationType );
			foreach ( galery::getAll() as $galery ) {
				$relation->setB( $galery->getid() );
				$r .= $galery->displayAsCheckbox( $relation->areLinked() );
			}
			return $r;
		}

		/**
		 * Affiche cette galerie sous forme d'une checkbox.
		 * Exploitable en HTML.
		 */
		public function displayAsCheckbox( bool $checked = false ) {
			$r = '<label for="galeries[]"><input type="checkbox" value="' . $this->id . '" name="galeries[]"';
			if( $checked ) $r .= ' checked';
			return $r .= '>' . $this->name . '</label>';
		}

		/**
		 * Donne vrai ou faux si une image est dans les favoris.
		 */
		static function isFavorite( $image ) {
			$images = galery::getFavorites();
			$flag = false;
			foreach ( $images as $img ) {
				if( $img == $image ) {
					$flag = true;
					break;
				}
			}
			return $flag;
		}

		/**
		 * Déplace une image dans les favoris.
		 */
		static function setFavorite( $image ) {
			copy( UPLOADS . 'galeries/' . $image, UPLOADS . 'galeries/favorites_1970-01-01_12_00_00/' . str_replace( "/", "_", $image ) );
		}

		/**
		 * Déplace une image dans les favoris.
		 */
		static function removeFavorite( $image ) {
			unlink( UPLOADS . 'galeries/favorites_1970-01-01_12_00_00/' . str_replace( "/", "_", $image ) );
		}

		/**
		 * Renvoie le tableau des images préférées.
		 */
		static function getFavorites() {
			return normalizedScan( UPLOADS . 'galeries/favorites_1970-01-01_12_00_00/' );
		}

		public function getNormalizedFileName() {
			return normalize( $this->getFileName() );
		}

		public function getFileName() {
			return $this->name . '_' . $this->registration_date;
		}

		/**
		 * Donne quelque chose exploitable par le serveur.
		 */
		public function getPath() {
			return UPLOADS . 'galeries/' . $this->getNormalizedFileName() . '/';
		}

		/**
		 * Donne quelque chose exploitable par le client.
		 */
		public function getUrl() {
			return UPLOADSDFROMURL . 'galeries/' . $this->getNormalizedFileName() . '/';
		}

		/**
		 * Donne l'image de preview de la galerie.
		 * Exploitable en HTML.
		 */
		public function getPreview() {
			return '<img src="' . $this->getUrl() . 'preview.png">';
		}

		/**
		 * Donne un tableau avec les images de la galerie.
		 */
		public function getImages() {
			return normalizedScan( UPLOADS . 'galeries/' . $this->getNormalizedFileName() . '/' );
		}

		/**
		 * Donne le nome d'une image en fonction de son chemin d'accès.
		 */
		static function getImageName( $image ) {
			return basename( $image ).PHP_EOL;
		}
	}