<?php

namespace vthang87\customfield;

use Yii;
use yii\helpers\Inflector;

/**
 * This is just an example.
 */
class CustomFieldModule extends \yii\base\Module
{
    /**
     * @inheritdoc
     */
    public $defaultRoute = 'custom-field-group';
    
    /**
     * @var string Default url for breadcrumb
     */
    public $defaultUrl;
    
    /**
     * @var string Default url label for breadcrumb
     */
    public $defaultUrlLabel;
    
    /**
     * @var string Main layout using for module. Default to layout of parent module.
     */
    public $mainLayout = '@vthang87/customfield/views/layouts/main.php';
    
    /**
     * @var array
     * @see [[menus]]
     */
    private $_coreItems = [
        'custom-field-group' => 'Custom Field Groups',
    ];
    
    /**
     * @var array
     * @see [[menus]]
     */
    private $_menus = [];
    
    /**
     * @var array
     * @see [[items]]
     */
    private $_normalizeMenus;
    
    
    public $formFieldName       = 'customFields';
    public $formSearchFieldName = 'customFieldsSearch';
    
    /**
     * @var array
     * @see [[items]]
     */
    public $models = [];
    
    public function init()
    {
        parent::init();
        if (!isset(Yii::$app->i18n->translations['customfield'])) {
            Yii::$app->i18n->translations['customfield'] = [
                'class'          => 'yii\i18n\PhpMessageSource',
                'sourceLanguage' => 'en',
                'basePath'       => '@vthang87/customfield/messages',
            ];
        }
    }
    
    /**
     * @inheritdoc
     */
    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {
            /* @var $action \yii\base\Action */
            $view = $action->controller->getView();
            
            $view->params['breadcrumbs'][] = [
                'label' => ($this->defaultUrlLabel ?: Yii::t('customfield','Custom Field')),
                'url'   => ['/' . ($this->defaultUrl ?: $this->uniqueId)],
            ];
            
            return true;
        }
        
        return false;
    }
    
    /**
     * Get available menu.
     * @return array
     */
    public function getMenus()
    {
        if ($this->_normalizeMenus === null) {
            $mid = '/' . $this->getUniqueId() . '/';
            // resolve core menus
            $this->_normalizeMenus = [];
            
            //$config     = components\Configs::instance();
            //$conditions = [
            //	'user'       => $config->db && $config->db->schema->getTableSchema($config->userTable),
            //	'assignment' => ($userClass = Yii::$app->getUser()->identityClass) && is_subclass_of($userClass,'yii\db\BaseActiveRecord'),
            //	'menu'       => $config->db && $config->db->schema->getTableSchema($config->menuTable),
            //];
            foreach ($this->_coreItems as $id => $lable) {
                //if(!isset($conditions[$id]) || $conditions[$id]){
                $this->_normalizeMenus[$id] = ['label' => Yii::t('customfield',$lable),'url' => [$mid . $id]];
                //}
            }
            foreach (array_keys($this->controllerMap) as $id) {
                $this->_normalizeMenus[$id] = ['label' => Yii::t('customfield',Inflector::humanize($id)),'url' => [$mid . $id]];
            }
            
            // user configure menus
            foreach ($this->_menus as $id => $value) {
                if (empty($value)) {
                    unset($this->_normalizeMenus[$id]);
                    continue;
                }
                if (is_string($value)) {
                    $value = ['label' => $value];
                }
                $this->_normalizeMenus[$id] = isset($this->_normalizeMenus[$id]) ? array_merge($this->_normalizeMenus[$id],$value)
                    : $value;
                if (!isset($this->_normalizeMenus[$id]['url'])) {
                    $this->_normalizeMenus[$id]['url'] = [$mid . $id];
                }
            }
        }
        
        return $this->_normalizeMenus;
    }
    
    /**
     * Set or add available menu.
     *
     * @param array $menus
     */
    public function setMenus($menus)
    {
        $this->_menus          = array_merge($this->_menus,$menus);
        $this->_normalizeMenus = null;
    }
}
