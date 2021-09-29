<?php

    namespace Atoum;

    class at_class_post extends at_abstract_content {
        static function get_all() {
            global $DDB, $order_by, $order_direction;
            $posts = [];
            $sql0 = 'SELECT content_id FROM ' . PREFIX . 'content WHERE content_type = :content_type ORDER BY ' . $order_by . ' ' . $order_direction;
            $rqst0 = $DDB->prepare( $sql0 );
			$rqst0->execute( [ ':content_type'=>'post' ] );
            while( $post = $rqst0->fetch() ) {
                $post = new at_class_post( $post[ 'content_id' ] );
                array_push( $posts, $post );
            }
            return $posts;
        }

        static function show_all_as_table() {
            global $DDB, $order_by, $order_direction;
            $to_return = '<table id="posts_list">  
            <tr>
                <th><a href="admin.php?p=posts.php&ob=title&od=' . inverse_order_direction( $order_direction ) . '">Title<i class="' . $order_direction . '"></i></a></th>
                <th><a href="admin.php?p=posts.php&ob=slug&od=' . inverse_order_direction( $order_direction ) . '">Slug<i class="' . $order_direction . '"></i></a></th>
                <th><a href="admin.php?p=posts.php&ob=date_modified&od=' . inverse_order_direction( $order_direction ) . '">Date Modified<i class="' . $order_direction . '"></i></a></th>
            </tr>';
            foreach ( at_class_post::get_all() as $post ) {
                $to_return .= '<tr>
                    <td>' . $post->get_title() . '</td>
                    <td>' . $post->get_slug() . '</td>
                    <td>' . $post->get_date_modified() . '</td>
                </tr>';
            }
            return $to_return . '</table>';
        }
    }