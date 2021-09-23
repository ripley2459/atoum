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
    }