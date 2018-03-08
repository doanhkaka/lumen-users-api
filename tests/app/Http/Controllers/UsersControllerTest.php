<?php

namespace Tests\App\Http\Controllers;

use App\User;
use TestCase;
use Laravel\Lumen\Testing\DatabaseMigrations;

class UsersControllerTest extends TestCase
{
    use DatabaseMigrations;

    public function testIndexStatusCodeShouldBe200()
    {
        $this->get('/api/users')->seeStatusCode(200);
    }

    public function testIndexShouldReturnACollectionOfRecords()
    {
        $users = factory(User::class, 2)->create();

        $this->get('/api/users');

        $content = json_decode($this->response->getContent(), true);
        $this->assertArrayHasKey('data', $content);

        foreach ($users as $user) {
            $this->seeJson([
                'id'        => $user->id,
                'email'     => $user->email,
                'name'      => $user->name,
                'address'   => $user->address,
                'tel'       => $user->tel,
                'created'   => $user->created_at->toIso8601String(),
                'updated'   => $user->updated_at->toIso8601String(),
            ]);
        }
    }

    public function testShowShouldReturnAValidUser()
    {
        $user = factory(User::class)->create();

        $this->get("/api/users/{$user->id}")
            ->seeStatusCode(200);

        $content = json_decode($this->response->getContent(), true);
        $this->assertArrayHasKey('data', $content);

        $data = $content['data'];
        $this->assertEquals($user->id, $data['id']);
        $this->assertEquals($user->email, $data['email']);
        $this->assertEquals($user->name, $data['name']);
        $this->assertEquals($user->address, $data['address']);
        $this->assertEquals($user->tel, $data['tel']);
        $this->assertEquals($user->created_at->toIso8601String(), $data['created']);
        $this->assertEquals($user->updated_at->toIso8601String(), $data['updated']);
    }

    public function testShowShouldFailWhenUserIdDoesNotExist()
    {
        $this->get('/api/users/99999999', ['Accept' => 'application/json'])
            ->seeStatusCode(404)
            ->seeJson([
                'message' => 'Not Found',
            ]);
    }

    public function testShowRouteShouldNotMatchAnInvalidRoute()
    {
        $this->get('/api/users/invalid-user-id');

        $this->assertNotRegExp(
            '/Not Found/',
            $this->response->getContent(),
            'UsersController@show route matching when it should not.'
        );
    }

    public function testUpdateShouldOnlyChangeFillableFields()
    {
        $user = factory(User::class)->create([
            'email' => 'test@example.com',
            'name' => 'Test Name',
            'address' => 'Test Address',
            'tel' => 'Test Phone Number',
            'api_token' => str_random(60),
        ]);

        $this->put("/api/users", [
            'email' => 'another@example.com',
            'name' => 'Another Name',
            'address' => 'Another Address',
            'tel' => 'Another Phone Number',
        ], [
            'Accept' => 'application/json',
            'x-api-key' => $user->api_token
        ]);

        $this->seeStatusCode(200)
            ->seeJson([
                'email' => 'test@example.com',
                'name' => 'Another Name',
                'address' => 'Another Address',
                'tel' => 'Another Phone Number',
            ])->seeInDatabase('users', [
                'name' => 'Another Name',
                'address' => 'Another Address',
                'tel' => 'Another Phone Number',
            ]);

        // Verify the data key in the resource
        $body = json_decode($this->response->getContent(), true);
        $this->assertArrayHasKey('data', $body);
    }

    public function testUpdateShouldFailWithAnEmptyToken()
    {
        $this->put("/api/users")
            ->seeStatusCode(401)
            ->seeJson([
                'error' => 'Unauthorized'
            ]);
    }

    public function testUpdateShouldFailWithAnInvalidToken()
    {
        $this->put("/api/users", [], [
            'Accept' => 'application/json',
            'x-api-key' => 'not-exist-api-token'
        ])
            ->seeStatusCode(401)
            ->seeJson([
                'error' => 'Unauthorized'
            ]);
    }
}
