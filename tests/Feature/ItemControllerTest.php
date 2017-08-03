<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Mockery as m;

class ItemControllerTest extends TestCase{

	private $itemRepository;
	private $userRepository;
    private $itemPropertyRepository;
    private $statRepository;

  	private $itemController;

  	public function setUp(){
    	parent::setup();
    	$this->userRepository = m::mock('App\Repository\Contracts\UserRepository');
    	$this->app->instance('App\Repository\Contracts\UserRepository', $this->userRepository);
    	$this->itemRepository = m::mock('App\Repository\Contracts\ItemRepository');
    	$this->app->instance('App\Repository\Contracts\ItemRepository', $this->itemRepository);
    	$this->statRepository = m::mock('App\Repository\Contracts\StatRepository');
    	$this->app->instance('App\Repository\Contracts\StatRepository', $this->statRepository);
    	$this->itemPropertyRepository = m::mock('App\Repository\Contracts\ItemPropertyRepository');
    	$this->app->instance('App\Repository\Contracts\ItemPropertyRepository', $this->itemPropertyRepository);
		
    	// inject the mocked version of the repository
    	$this->itemController = new App\Http\Controllers\PostController($this->userRepository, $this->itemRepository, $this->itemPropertyRepository, $this->statRepository);
  	}

  	public function tearDown(){
    	m::close();
    	parent::tearDown();
  	}

  	public function testIndex(){
    	$this->itemRepository->shoudlReceive('paginate')->once()->andReturn(array());
    	$response = $this->call('GET', '/');
    	$this->assertResponseOk($response);
    	$this->assertViewHas('posts');
  	}
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }
}
