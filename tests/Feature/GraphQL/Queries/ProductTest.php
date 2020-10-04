<?php

namespace Tests\Feature\GraphQL\Queries;

use Tests\TestCase;

class ProductTest extends TestCase
{
    public function test_single_product_query()
    {
        $response = $this->graphQL('
        query {
          product(id: 1) {
            id
            slug
            name
            avatar
            description
            website
            twitter
            repo
            producthunt
            launched
          }
        }
        ')
        ->assertJson([
            'data' => [
                'product' => [
                    'id' => '1',
                    'slug' => 'taskord',
                    'name' => 'Taskord',
                    'avatar' => 'https://i.imgur.com/QpfHEy6.png',
                    'description' => 'Get things done socially with Taskord',
                    'user_id' => 1,
                    'website' => 'https://taskord.com',
                    'twitter' => 'taskord',
                    'repo' => 'https://gitlab.com/taskord/taskord',
                    'producthunt' => 'taskord',
                    'launched' => true,
                ],
            ],
        ]);
    }

    public function test_all_users_query()
    {
        $response = $this->graphQL('
        query {
          users(first: 1) {
            edges {
              node {
                id
                username
                firstname
                lastname
                avatar
                bio
                location
                company
                website
                twitter
                twitch
                telegram
                github
                youtube
                isStaff
                isVerified
                isDeveloper
                isBeta
                isPatron
                isPrivate
                isSuspended
              }
            }
          }
        }
        ')
        ->assertJson([
            'data' => [
                'users' => [
                    'edges' => [
                        [
                            'node' => [
                                'id' => '1',
                                'username' => 'test',
                                'firstname' => 'Firstname',
                                'lastname' => 'Lastname',
                                'avatar' => 'https://contractize.com/wp-content/uploads/2017/02/Robot.jpg',
                                'bio' => 'Test the taskord',
                                'location' => 'Internet',
                                'company' => 'Taskord',
                                'website' => 'https://taskord.test',
                                'twitter' => 'test',
                                'twitch' => 'test',
                                'telegram' => 'test',
                                'github' => 'test',
                                'youtube' => 'test',
                                'isStaff' => true,
                                'isVerified' => false,
                                'isDeveloper' => true,
                                'isBeta' => true,
                                'isPatron' => true,
                                'isPrivate' => false,
                                'isSuspended' => false,
                            ],
                        ],
                    ],
                ],
            ],
        ]);
    }
}
