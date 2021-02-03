<?php

/**
 * Заказать или приобрести готовые модельки можно
 * в VK @bedrock_models
 */

namespace Convert;

  use Convert\Utils\ModelConvert;

  use pocketmine\plugin\PluginBase;
  use pocketmine\Server;

    class Main extends PluginBase 
    {
        private static $instance;

        public function onLoad(): void 
        {
            self::setInstance($this);
        }

        public function onEnable(): void
        {
            self::defaultMessage();
        }

        public static function defaultMessage(): void
        {
            Server::getInstance()->getLogger()->info('Plugin Started Working');
        }

        private static function setInstance(Main $instance): void 
        {
            self::$instance = $instance;
        }

        public static function getInstance(): Main 
        {
            return self::$instance;
        }
    }

?>
