<?php

    namespace Atoum;

    class at_class_page extends at_abstract_content {
        /**
         * Return the iframe of that instance.
         * @return iframe of the that page.
         */
        public function get_iframe() {
            return '<iframe src=' . $this->path . '" title="' .  $this->title . '" class="large"></iframe>';
        }

        static function get_all() {
            global $DDB, $order_by, $order_direction;
            $pages = [];
            $sql0 = 'SELECT content_id FROM ' . PREFIX . 'content WHERE content_type = :content_type ORDER BY ' . $order_by . ' ' . $order_direction;
            $rqst0 = $DDB->prepare( $sql0 );
			$rqst0->execute( [ ':content_type'=>'page' ] );
            while( $page = $rqst0->fetch() ) {
                $page = new at_class_page( $page[ 'content_id' ] );
                array_push( $pages, $page );
            }
            return $pages;
        }

        static function show_all_as_table() {
            global $DDB, $order_by, $order_direction;
            $to_return = '<table id="pages_list">  
            <tr>
                <th><a href="admin.php?p=pages.php&ob=title&od=' . inverse_order_direction( $order_direction ) . '">Title<i class="' . $order_direction . '"></i></a></th>
                <th><a href="admin.php?p=pages.php&ob=slug&od=' . inverse_order_direction( $order_direction ) . '">Slug<i class="' . $order_direction . '"></i></a></th>
                <th><a href="admin.php?p=pages.php&ob=date_modified&od=' . inverse_order_direction( $order_direction ) . '">Date Modified<i class="' . $order_direction . '"></i></a></th>
            </tr>';
            foreach ( at_class_page::get_all() as $page ) {
                $to_return .= '<tr>
                    <td>' . $page->get_title() . '</td>
                    <td>' . $page->get_slug() . '</td>
                    <td>' . $page->get_date_modified() . '</td>
                </tr>';
            }
            return $to_return . '</table>';
        }
    }