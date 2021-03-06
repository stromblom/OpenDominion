<?php

namespace OpenDominion\Tests\Http;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use OpenDominion\Tests\AbstractTestCase;

class HomeTest extends AbstractTestCase
{
    use DatabaseMigrations;

    public function testHomePage()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function testRedirectLoggedInUserWithoutSelectedDominionToDashboard()
    {
        $this->createAndImpersonateUser();

        $response = $this->get('/');

        $response->assertRedirect('/dashboard');
    }

    public function testRedirectLoggedInUserWithSelectedDominionToStatus()
    {
        $this->seedDatabase();
        $user = $this->createAndImpersonateUser();
        $round = $this->createRound();
        $this->createAndSelectDominion($user, $round);

        $response = $this->get('/');

        $response->assertRedirect('/dominion/status');
    }

    public function testUserShouldNotGetRedirectedOnReferredRequests()
    {
        $this->seedDatabase();
        $user = $this->createAndImpersonateUser();
        $round = $this->createRound();
        $dominion = $this->createDominion($user, $round);

        $response = $this->get('/', [
            'HTTP_REFERER' => 'foo',
        ]);

        $response
            ->assertStatus(200)
            ->assertSee('Dashboard');

        $this->selectDominion($dominion);

        $response = $this->get('/', [
            'HTTP_REFERER' => 'foo',
        ]);

        $response
            ->assertStatus(200)
            ->assertSee('Play');
    }
}
