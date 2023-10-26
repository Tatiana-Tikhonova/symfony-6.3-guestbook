<?php

namespace App\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ConferenceControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Give your feedback');
    }



    public function testCommentSubmission()
    {
        $client = static::createClient();
        $client->request('GET', '/conference/moskva-2021');
        $client->submitForm('Submit', [
                       'comment[author]' => 'Fabien',
                       'comment[text]' => 'Some feedback from an automated functional test',
                      'comment[email]' => 'me@automat.ed',
                      'comment[photo]' => dirname(__DIR__, 2).'/public/images/under-construction.gif',
                ]);
        $this->assertResponseRedirects();
        $client->followRedirect();
        $this->assertSelectorExists('div:contains("There are 2 comments")');

    }

    public function testConferencePage()
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/');

        $this->assertCount(2, $crawler->filter('h4'));

        $client->clickLink('View');

        $this->assertPageTitleContains('Москва');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h2', 'Москва 2021');
        $this->assertSelectorExists('div:contains("There are 1 comments")');

    }

}
