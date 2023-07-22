<?php

class Completion extends CComponent {

    public static function employee($term) {
        $items = Employee::model()->findAll(array(
            'condition' => 'name LIKE :name', 
            'params' => array(':name' => '%' . $term . '%'), 
            'limit' => 30
        ));

        $rows = array();
        foreach ($items as $item) {
            $rows[] = array(
                'label' => $item->code . ' - ' . $item->name, // label for dropdown list
                'value' => $item->id, // value for input field
                'id' => $item->name, // return value from autocomplete
            );
        }

        return $rows;
    }
}