<?php

class SqlViewGenerator extends CComponent {

    public static function count($view) {
        $sql = "SELECT COUNT(*) FROM ({$view}) v";

        return $sql;
    }

}
