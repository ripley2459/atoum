<?php

	namespace Atoum;

	class at_class_upload extends at_class_content {

		/**
		 * Remove the upload file from the database and remove the saved file on the disk.
		 */
		public function remove() {
			global $DDB;

			$sql0 = 'SELECT content_path FROM ' . PREFIX . 'content WHERE content_id = :content_id';
			$sql1 = 'DELETE FROM ' . PREFIX . 'content WHERE content_id = :content_id';

			$rqst_content_select = $DDB->prepare( $sql0 );
			$rqst_content_remove = $DDB->prepare( $sql1 );

			$rqst_content_select->execute( [ ':content_id' => $this->id ] );
			$file = $rqst_content_select->fetch();
			if ( unlink( $file[ 'content_path' ] ) ) $rqst_content_remove->execute( [ ':content_id' => $this->id ] );

			$rqst_content_select->closeCursor();
			$rqst_content_remove->closeCursor();
		}
	}