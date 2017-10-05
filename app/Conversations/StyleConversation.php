<?php

namespace App\Conversations;

use BotMan\BotMan\Messages\Conversations\Conversation;
use BotMan\BotMan\Messages\Incoming\Answer;
use BotMan\BotMan\Messages\Outgoing\Actions\Button;
use BotMan\BotMan\Messages\Outgoing\Question;
use Illuminate\Foundation\Inspiring;

class StyleConversation extends Conversation {
	/**
	 * First question
	 */
	protected $page;
	protected $style;
	private $itemRepo;
	private $limit;

	public function __construct($style, $itemRepo, $page, $limit) {
		$this->itemRepo = $itemRepo;
		$this->style = $style;
		$this->page = $page;
		$this->limit = $limit;
	}

	public function askMore() {
		$question = Question::create("Type 'more' for more styles or use the options below to refine search")
			->fallback('Unable to ask question')
			->callbackId('ask_reason')
			->addButtons([
				Button::create('Show more')->value('more'),
				Button::create('New search')->value('new'),
				Button::create('Stop')->value('stop'),
				Button::create('Thank you')->value('thank'),
			]);

		return $this->ask($question, function (Answer $answer) {
			if ($answer->isInteractiveMessageReply()) {
				if ($answer->getValue() === 'more') {
					$this->say('Okay...');
					$items = $this->itemRepo->getItemsBot($this->style, $this->limit, $this->page);
					if (!isset($items) || $items->count() == 0) {
						$this->say('Sorry, I couldn\'t get more styles for your request. I think that\'s all');
					} else {
						$template = BotmanController::createStyleTemplate($items);
						$this->say($template);
						if ($items->count() >= $this->limit) {
							$this->page++;
							$this->askMore();
						}
					}
				} elseif ($answer->getValue() === 'new') {
					$this->say('You know the drill, start a new search with \'show\'');
				} elseif ($answer->getValue() === 'stop') {
					$this->say('Okay, hope you got what you need.');
				} elseif ($answer->getValue() === 'thank') {
					$this->say('Don\'t mention.');
					$this->say('On a second thought, please tell your friends :)');
				} else {
					$this->say(Inspiring::quote());
				}
			}
		});
	}

	/**
	 * Start the conversation
	 */
	public function run() {
		$this->askMore();
	}
}
