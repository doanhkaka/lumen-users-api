<?php

namespace Tests\App\Transformer;

use TestCase;
use App\User;
use App\Transformer\UserTransformer;
use League\Fractal\TransformerAbstract;
use Laravel\Lumen\Testing\DatabaseMigrations;

class UserTransformerTest extends TestCase
{
    use DatabaseMigrations;

    public function testItCanBeInitialized()
    {
        $subject = new UserTransformer();
        $this->assertInstanceOf(TransformerAbstract::class, $subject);
    }

    public function testItTransformsAUserModel()
    {
        $user = factory(User::class)->create();
        $subject = new UserTransformer();

        $transform = $subject->transform($user);

        $this->assertArrayHasKey('email', $transform);
        $this->assertArrayHasKey('name', $transform);
        $this->assertArrayHasKey('address', $transform);
        $this->assertArrayHasKey('tel', $transform);
        $this->assertArrayHasKey('created', $transform);
        $this->assertArrayHasKey('updated', $transform);
    }
}