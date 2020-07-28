<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends RController
{
    /**
     * @var string the default layout for the controller view. Defaults to '//layouts/column1',
     * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
     */
    public $layout='//layouts/main';

    /**
     * @var array context menu items. This property will be assigned to {@link CMenu::items}.
     */
    public $menu=array();

    /**
     * @var array the breadcrumbs of the current page. The value of this property will
     * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
     * for more details on how to specify this property.
     */
    public $breadcrumbs=array();



    public function filters()
    {
        return array(
            'rights', // perform access control for CRUD operations
        );
    }

    /*public function init()
    {
        parent::init();

        // authorize user login
        if (!$this->isAuthorized()) {
            $this->redirect(array('/login'));
            Yii::app()->end();
        }

    }*/

    /**
     * @return bool
     */
    /*public function isAuthorized()
    {
        if ($this->id != 'login' && $this->id != 'logout' && $this->id != 'redirect' && $this->id != 'error') {
            $user = MyHelper::getUser();
            if ($user != null && $user->status != User::STATUS_LOCKED && $user->status != User::STATUS_BANNED) {

                return true;
            }
        }
        else {
            return true;
        }


        // destroy session
        Yii::app()->user->logout();
        return false;
    }

    protected function beforeAction($action)
    {
        Yii::beginProfile('Action: '. $action->id);
        return parent::beforeAction($action);
    }

    protected function afterAction($action)
    {
        Yii::endProfile('Action: '. $action->id);
        parent::afterAction($action);
    }

    protected function beforeRender($view)
    {
        Yii::beginProfile('Render: '. $view);
        return parent::beforeRender($view);
    }

    protected function afterRender($view, &$output)
    {
        Yii::endProfile('Render: '. $view);
        parent::afterRender($view, $output);
    }*/

    public function format_money($val = 0.0, $currency = '')
    {
        return is_numeric($val) ? $currency.number_format($val, 0, ',', '.') : $val;
    }
}