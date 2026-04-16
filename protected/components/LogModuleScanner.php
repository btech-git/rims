<?php

class LogModuleScanner extends CComponent {

    public static function getTransactionList() {
        $basePath = Yii::app()->getBasePath();
        $modules = array('accounting', 'frontDesk', 'transaction');
        
        $transactionList = array();
        $transactionList['Accounting'] = array();
        $transactionList['FrontDesk'] = array();
        $transactionList['Transaction'] = array();
        foreach ($modules as $module) {
            $filenames = array_diff(scandir("{$basePath}/modules/{$module}/controllers"), array('..', '.', 'DefaultController.php'));
            $controllerIds = array_map(function ($filename) { return str_replace('Controller.php', '', lcfirst($filename)); }, $filenames);
            $controllerIdValues = array_map(function ($controllerId) use ($module) { return $module . '/' . $controllerId; }, $controllerIds);
            $controllerIdLabels = array_map(function ($controllerId) { return ucfirst($controllerId); }, $controllerIds);
            $transactionList[ucfirst($module)] = array_combine($controllerIdValues, $controllerIdLabels);
        }
        
        return $transactionList;
    }

    public static function getMasterList() {
        $basePath = Yii::app()->getBasePath();
        $modules = array('master');
        
        $transactionList = array();
        $transactionList['Master'] = array();
        foreach ($modules as $module) {
            $masterFilenames = array_diff(scandir("{$basePath}/modules/{$module}/controllers"), array('..', '.', 'DefaultController.php'));
            $filenames = array_merge($masterFilenames, array('CoaController.php'));
            sort($filenames);
            $controllerIds = array_map(function ($filename) { return str_replace('Controller.php', '', lcfirst($filename)); }, $filenames);
            $controllerIdValues = array_map(function ($controllerId) use ($module) { return $module . '/' . $controllerId; }, $controllerIds);
            $controllerIdLabels = array_map(function ($controllerId) { return ucfirst($controllerId); }, $controllerIds);
            $transactionList[ucfirst($module)] = array_combine($controllerIdValues, $controllerIdLabels);
        }
        
        return $transactionList;
    }
}
