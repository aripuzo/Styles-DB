<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery as m;

class ItemControllerTest extends TestCase{

	private $itemRepository;
	private $userRepository;
    private $itemPropertyRepository;
    private $statRepository;

  	private $itemController;
  	private $user;

  	public function setUp(){
    	parent::setup();
    	$this->userRepository = m::mock('App\Repository\Contracts\UserRepository');
    	$this->app->instance('App\Repository\UserRepository', $this->userRepository);
    	$this->itemRepository = m::mock('App\Repository\Contracts\ItemRepository');
    	$this->app->instance('App\Repository\ItemRepository', $this->itemRepository);
    	$this->statRepository = m::mock('App\Repository\Contracts\StatRepository');
    	$this->app->instance('App\Repository\StatRepository', $this->statRepository);
    	$this->itemPropertyRepository = m::mock('App\Repository\Contracts\ItemPropertyRepository');
    	$this->app->instance('App\Repository\ItemPropertyRepository', $this->itemPropertyRepository);
		
    	// inject the mocked version of the repository
    	$this->itemController = new \App\Http\Controllers\ItemController($this->userRepository, $this->itemRepository, $this->itemPropertyRepository, $this->statRepository);
    	$this->user = User::find(22);//factory(User::class)->create();
  	}

  	public function tearDown(){
    	m::close();
    	parent::tearDown();
  	}

  	public function testIndex(){
    	$response = $this->call('GET', '/');
    	$response->assertViewHas('items');
    	$response->assertStatus(200);
  	}

  	public function testFavItem(){
  		$response = $this->actingAs($this->user)->withSession(['foo' => 'bar'])->json('GET', '/item/like', ['id' => '50']);
        $response->assertStatus(200)
            ->assertJson([
                'response' => true,
            ]);
    }

    public function testBookmarkItem(){
  		$response = $this->actingAs($this->user)->withSession(['foo' => 'bar'])->json('GET', '/item/bookmark', ['id' => '50']);
        $response->assertStatus(200)
	            ->assertJson([
	                'response' => true,
	            ]);
    }

    public function testDownloadItem(){
        $response = $this->actingAs($this->user)->withSession(['foo' => 'bar'])->json('GET', '/item/download', ['id' => '50']);
        $response->assertStatus(200)
	            ->assertJson([
	                'response' => true,
	            ]);
    }

    public function testMakeCommentItem(){
  		$data = [
	        'id' => '50',
	        'text' => 'Test comment'
	    ];
        $response = $this->actingAs($this->user)->withSession(['foo' => 'bar'])->call('POST', '/item/comment', $data);
        $response->assertStatus(302);
        $this->assertDatabaseHas('comments', [
	        'text' => 'Test comment'
	    ]);
    }
}
