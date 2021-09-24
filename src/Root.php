<?php declare(strict_types = 1);

namespace Takoma\Template\Api;

use PDO;
use Takoma\Lizy\Conf;
use Takoma\Lizy\DB\MysqlCnx;
use Takoma\Lizy\Files\Temp;
use Takoma\Lizy\Lizy;
use Takoma\Lizy\Pattern\Singleton;
use Takoma\Lizy\SlimInterface\LizySlim;
use Takoma\Lizy\Version;
use Takoma\Lizy\Web\ScriptUrl;

class Root
{
    use Singleton;

    const NS = __NAMESPACE__;

    /** @var self */
    private static $_instance;
    /** @var array */
    protected $dbConf;
    /** @var PDO */
    protected $dbCnx;
    /** @var array */
    protected $nrtDbConf;
    /** @var PDO */
    protected $nrtCnx;
    /** @var string */
    public $version;

    /** retourne l'instance du singleton */
    public static function get() :self
    {
        return self::set();
    }

    /** retourne l'instance du singleton */
    public static function set() :self
    {
        if (!isset(self::$_instance)) {
            self::$_instance = new self;
        }
        return self::$_instance;
    }

    /**
     * private constructor (singleton)
     *
     * @access private
     */
    final private function __construct()
    {
        $rootPath = dirname(__DIR__) . DIRECTORY_SEPARATOR;
        // initialisation de l'instance de configuration
        /** @var Conf $config */
        $config = Conf::set($rootPath . 'config.ini');
        // initialisation de l'instance LizySlim
        LizySlim::set($config);
        // initialisation de l'instance Lang
        // Lang::set(__NAMESPACE__, $rootPath . 'lang' . DIRECTORY_SEPARATOR);
        // initialisation de l'instance du dossier Temp
        Temp::get($config->getOption('file', 'tempsubdir'));
        // initialisation de l'instance Template
        // Template::set(__NAMESPACE__, $rootPath . 'tpl' . DIRECTORY_SEPARATOR);
        // initialisation de l'instance ScriptUrl
        ScriptUrl::set($config->getOption('proxy', 'home_path'));
        // vérification du mode maintenance
        if ($config->getOption('lizy', 'underMaintenance')) {
            Lizy::get()->setMaintenance();
        }
        // initialisation de l'instance MailerInterface
        // MailerInterface::set($config);
        // initialisation des données de connexion DB
        $this->dbConf = $config->getSection('db');

        $this->version = Lizy::getVersionFromComposer($rootPath . "composer.json");
        // lecture des versions
        Version::set($this->version);
    }

    public function getDbCnx() :PDO
    {
        if (!isset($this->dbCnx)) {
            $this->dbCnx = MysqlCnx::set(
                $this->dbConf['dns'],
                $this->dbConf['login'],
                $this->dbConf['password'],
                [PDO::MYSQL_ATTR_LOCAL_INFILE => true]);
        }

        return $this->dbCnx;
    }
}
