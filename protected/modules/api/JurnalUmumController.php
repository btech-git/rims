<?php

class JurnalUmumController extends Controller {

    public function actionIndex() {
        echo CJSON::encode([1, 2, 3]);
    }
}
