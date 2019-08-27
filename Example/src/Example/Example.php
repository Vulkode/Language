<?php

namespace Example;

use pocketmine\Server;
use pocketmine\Player;
use pocketmine\utils\Config;
use pocketmine\plugin\Plugin;
use pocketmine\plugin\PluginBase;
use pocketmine\utils\TextFormat as TF;
use pocketmine\command\Command;
use pocketmine\command\CommandSender;

class Example extends PluginBase {

	public function onEnable() {
		$this->saveResource('languages/spa.yml');
		$this->saveResource('languages/eng.yml');
		$this->saveResource('languages/jpn.yml');
		$this->getLogger()->info(TF::DARK_PURPLE.'Loaded successfully!'.base64_decode("DQogIF9fICAgICAgICAgICAgICAgICAgICAgICBfICAgICAgICAgICAgICAgICAgXyAgIF9fICAgIF9fICANCiAoICAvIF8gXyAgICAgL19fLyAgX18vLyAgLyApICAgICAgXyAnXyAvXy8gICBfKSAvICApLS8oX18pIA0KX18pLykoLy8gLykoLy8gICkoLy8gLy8pIChfXygpLykoLy8gLygvLykvICAgL19fKF9fLyAvIF9fLyAgDQogICAgICAgIC8gIC8gICAgICAgICAgICAgICAgIC8gIC8gICBfLyAgICAgICAgICAgICAgICAgICAgICA="));
	}

	/**
	* @param Player $sender
	* @param string $message
	*
	* @return string
	*/
	public function getMessage(Player $player, string $message) : string{
		$plugin = $this->getServer()->getPluginManager()->getPlugin('Language');
		if ($plugin === null) {
			return $message;
		}
		return $plugin->getTranslate($this, $player, $message);
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
			$sender->sendMessage($this->getMessage($sender, 'example.message'));
		}
		return true;
	}
}
