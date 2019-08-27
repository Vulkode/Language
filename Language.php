<?php

namespace Language;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TF;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Language extends PluginBase {

	/** @var Language */
	protected static $plugin;

	public function onEnable() {
		static::$plugin = $this;
		$this->saveDefaultConfig();
		$this->getLogger()->info(TF::DARK_PURPLE.'Loaded successfully!'.base64_decode("DQogIF9fICAgICAgICAgICAgICAgICAgICAgICBfICAgICAgICAgICAgICAgICAgXyAgIF9fICAgIF9fICANCiAoICAvIF8gXyAgICAgL19fLyAgX18vLyAgLyApICAgICAgXyAnXyAvXy8gICBfKSAvICApLS8oX18pIA0KX18pLykoLy8gLykoLy8gICkoLy8gLy8pIChfXygpLykoLy8gLygvLykvICAgL19fKF9fLyAvIF9fLyAgDQogICAgICAgIC8gIC8gICAgICAgICAgICAgICAgIC8gIC8gICBfLyAgICAgICAgICAgICAgICAgICAgICA="));
	}

	/**
	* @return Language|null
	*/
	public static function getInstance() : Language{
		return static::$plugin;
	}

	/**
	* @param Plugin $plugin
	* @param Player $player
	* @param string $params
	*
	* @return string
	*/
	public function getTranslate(Plugin $plugin, Player $player, string $params) : string{
		$dir = $plugin->getDataFolder() . '/languages/';
		if (!is_dir($dir)) {
			mkdir($dir, 0477);
		}

		$language = $this->getLanguage($player);
		$lang = new Config($dir . $language . '.yml');

		if ($lang->exists($params)) {
			return TF::colorize($lang->get($params));
		}

		foreach (array_diff(scandir($dir), [".", ".."]) as $filelang) {
			$config = new Config($dir . $filelang, Config::YAML);
			if ($config->exists($params)) {
				return TF::colorize($config->get($params));
			}
		}
		
		return TF::colorize($params);
	}

	/**
	* @param Player $player
	* @return string
	*/
	public function getLanguage(Player $player) : string{
		return (new Config($this->getDataFolder() . 'languages.yml', Config::YAML))->get($player->getName(), 'eng');
	}

	/**
	* @return array
	*/
	public function getLanguages() : array{
		return (new Config($this->getDataFolder() . 'config.yml', Config::YAML))->getAll();
	}

	/**
	 * @param CommandSender $sender
	 * @param Command       $command
	 * @param string        $label
	 * @param string[]      $args
	 *
	 * @return bool
	 */
	public function onCommand(CommandSender $sender, Command $command, string $label, array $args) : bool{
		if ($sender instanceof Player) {
			$config = new Config($this->getDataFolder() . 'languages.yml', Config::YAML);
			
			if (count($args) < 1) {
				$sender->sendMessage(TF::RED . 'Usage: /lang list');
				return true;
			}

			$default = $args[0];

			if ($default == 'list') {
				$sender->sendMessage(TF::GREEN . 'Language list: ');
				foreach ($this->getLanguages() as $key => $value) {
					$sender->sendMessage(TF::GREEN . $key . ' - ' . $value);
				}
			}elseif (array_key_exists($default, $this->getLanguages())) {
				$config->set($sender->getName(), $default);
				$config->save();
				$sender->sendMessage(TF::GREEN . 'Your language change to ' . $default . '.');
			}else{
				$sender->sendMessage(TF::RED . 'The language ' . $default . ' not exists.');
			}
			return true;
		}
		return true;
	}
}