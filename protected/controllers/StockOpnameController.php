<?php

class StockOpnameController extends Controller {
    
    public function filters() {
        return array(
            'access',
        );
    }

    public function filterAccess($filterChain) {

        $filterChain->run();
    }

    public function actionRun($f) {
        $row = 1;
        if (($handle = fopen("/home/pmahendro/Documents/stock_opname/{$f}.csv", "r")) !== FALSE) {
            while (($data = fgetcsv($handle, 1000)) !== FALSE) {
//                if ($row > 1) {
                    echo var_dump($data) . '<br/>';
//                } else {
//                    
//                }
                $row++;
            }
            fclose($handle);
        }
    }

}