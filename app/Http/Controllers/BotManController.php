<?php

namespace App\Http\Controllers;

use App\Conversations\StyleConversation;
use App\Repository\Contracts\ItemPropertyRepository;
use App\Repository\Contracts\ItemRepository;
use App\Repository\Contracts\UserRepository;
use BotMan\BotMan\BotMan;
use BotMan\Drivers\Facebook\Extensions\Element;
use BotMan\Drivers\Facebook\Extensions\ElementButton;
use BotMan\Drivers\Facebook\Extensions\GenericTemplate;
use Illuminate\Http\Request;

class BotManController extends Controller {

	private $userRepo;
	private $itemRepo;
	private $itemPropertyRepo;
	private $limit;
	private $defaultSort;
	private $defaultOrder;
	private $popularOrder;

	public function __construct(UserRepository $userRepo, ItemRepository $itemRepo, ItemPropertyRepository $itemPropertyRepo) {
		$this->userRepo = $userRepo;
		$this->itemRepo = $itemRepo;
		$this->itemPropertyRepo = $itemPropertyRepo;
		$this->limit = 10;
		$this->defaultSort = config('settings.defaultSort');
		$this->defaultOrder = config('settings.defaultOrder');
		$this->popularOrder = config('settings.popularOrder');
	}

	public function botTest(Request $request) {
		$items = $this->itemRepo->getItemsBot($request->input('q'), $this->limit, $request->input('page'));
		foreach ($items as $item) {
			echo $item->getName() . ', ';
		}
		if (!isset($items) || $items->count() == 0) {
			$s = 'bro';
			echo 'Sorry ' . $s . ', I couldn\'t find styles that match your request. Please try a new query';
		} else {
			if ($items->count() >= $this->limit) {
				//$bot->userStorage()->save(['page' => 1]);
				//$bot->userStorage()->save(['query' => $request->input('q')]);
			}
			$template = $this->createStyleTemplate($items, 1, $request->input('q'));
			dd($template);
		}
	}
	/**
	 * Place your BotMan logic here.
	 */
	public function handle() {
		$botman = app('botman');

		$botman->hears('Hello', function (BotMan $bot) {
			$bot->reply('Hi there :)');
		});

		$botman->hears('GET_STARTED', function (BotMan $bot) {
			$user = $bot->getUser();
			$bot->reply('Hi ' . $user->getFirstName() . '! I am Shakara. I can help you with your style selection! Ask me question like "Show ankara dresses for women"');
		});
		$botman->hears('Personalize', function (BotMan $bot) {
			$bot->reply(GenericTemplate::create()
					->addElements([
						Element::create('Account linking')
							->subtitle('All about BotMan')
							->addButton(
								ElementButton::create('Login')
									->url('https://www.shakara.com/login')
									->type('account_link')
							),
					])
			);
		});
		$botman->on('account_linking', function ($data, $bot) {
			// Handle account linking
		});

// 		$botman->hears('Help', function (BotMan $bot) {
		// 			$bot->reply('Some tips:
		// * Type \'Show me\' and keywords to find style: e.g. \'Show me ankara dresses for women\'
		// * Upload an image of a style you\'re seeking
		// * Type a specific search: e.g. \'red dress under $80\'
		// * Type \'back\' to see previous search results
		// * Type "new search" or click on restart to start a new search
		// * Save your favorite looks & items by clicking on the image, then the heart icon
		// * Retrieve your faves using the menu or typing \'faves\'');
		// 		});
		$botman->hears('Help', function (BotMan $bot) {
			$bot->reply('Some tips:
* Type \'Show me\' and keywords to find style: e.g. \'Show ankara dresses for women\'');
		});

		$botman->hears('Show {style}', function ($bot, $style) {
			$bot->types();
			$items = $this->itemRepo->getItemsBot($style, $this->limit, 1);
			if (!isset($items) || $items->count() == 0) {
				$user = $bot->getUser();
				if ($user->getGender()) {
					$s = $user->getGender() == 'male' ? 'bro' : 'sis';
				} else {
					$s = '';
				}
				$bot->reply('Sorry ' . $s . ', I couldn\'t find styles that match your request. Please try a new query');
			} else {
				$template = $this->createStyleTemplate($items);
				$bot->reply($template);
				if ($items->count() >= $this->limit) {
					$bot->startConversation(new StyleConversation($style, $this->limit));
				} else {
					$bot->reply('That\'s all the style we got for your query. You can try a new search using \'show me...\'');
				}
			}
		});

		$botman->hears('Thank you', function (BotMan $bot) {
			$bot->reply('Don\'t mention.');
			$bot->reply('On a second thought, please tell your friends');
		});

		$botman->hears('Thanks', function (BotMan $bot) {
			$bot->reply('Don\'t mention.');
			$bot->reply('On a second thought, please tell your friends');
		});

		$botman->fallback(function ($bot) {
			$bot->types();
			$bot->reply('Sorry, I did not understand these commands. Please retype again...');
		});

		$botman->listen();
	}

	public static function createStyleTemplate($items) {
		$template = GenericTemplate::create()->addImageAspectRatio(GenericTemplate::RATIO_SQUARE);
		foreach ($items as $item) {
			$template->addElement(Element::create($item->getName())
					->subtitle($item->getUserName())
					->image($item->getImage())
					->addButton(ElementButton::create('View Style')->url($item->getURL()))
					->addButton(ElementButton::create('Download Image')->url($item->getImage()))
					->addButton(ElementButton::create('Share')->type('element_share')));
		}
		return $template;
	}

	/**
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function tinker() {
		return view('tinker');
	}

	/**
	 * Loaded through routes/botman.php
	 * @param  BotMan $bot
	 */
	public function startConversation(BotMan $bot) {
		$bot->startConversation(new ExampleConversation());
	}
}
