<?php

namespace App\Test\Controller;

use App\Entity\SignIn;
use App\Repository\SignInRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class SignInControllerTest extends WebTestCase
{
    private KernelBrowser $client;
    private SignInRepository $repository;
    private string $path = '/sign/in/';

    protected function setUp(): void
    {
        $this->client = static::createClient();
        $this->repository = static::getContainer()->get('doctrine')->getRepository(SignIn::class);

        foreach ($this->repository->findAll() as $object) {
            $this->repository->remove($object, true);
        }
    }

    public function testIndex(): void
    {
        $crawler = $this->client->request('GET', $this->path);

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('SignIn index');

        // Use the $crawler to perform additional assertions e.g.
        // self::assertSame('Some text on the page', $crawler->filter('.p')->first());
    }

    public function testNew(): void
    {
        $originalNumObjectsInRepository = count($this->repository->findAll());

        $this->markTestIncomplete();
        $this->client->request('GET', sprintf('%snew', $this->path));

        self::assertResponseStatusCodeSame(200);

        $this->client->submitForm('Save', [
            'sign_in[holidays]' => 'Testing',
            'sign_in[workshops]' => 'Testing',
            'sign_in[user]' => 'Testing',
            'sign_in[timeStart]' => 'Testing',
            'sign_in[timeStop]' => 'Testing',
            'sign_in[timeFinish]' => 'Testing',
            'sign_in[hourCount]' => 'Testing',
        ]);

        self::assertResponseRedirects('/sign/in/');

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));
    }

    public function testShow(): void
    {
        $this->markTestIncomplete();
        $fixture = new SignIn();
        $fixture->setHolidays('My Title');
        $fixture->setWorkshops('My Title');
        $fixture->setUser('My Title');
        $fixture->setTimeStart('My Title');
        $fixture->setTimeStop('My Title');
        $fixture->setTimeFinish('My Title');
        $fixture->setHourCount('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));

        self::assertResponseStatusCodeSame(200);
        self::assertPageTitleContains('SignIn');

        // Use assertions to check that the properties are properly displayed.
    }

    public function testEdit(): void
    {
        $this->markTestIncomplete();
        $fixture = new SignIn();
        $fixture->setHolidays('My Title');
        $fixture->setWorkshops('My Title');
        $fixture->setUser('My Title');
        $fixture->setTimeStart('My Title');
        $fixture->setTimeStop('My Title');
        $fixture->setTimeFinish('My Title');
        $fixture->setHourCount('My Title');

        $this->repository->save($fixture, true);

        $this->client->request('GET', sprintf('%s%s/edit', $this->path, $fixture->getId()));

        $this->client->submitForm('Update', [
            'sign_in[holidays]' => 'Something New',
            'sign_in[workshops]' => 'Something New',
            'sign_in[user]' => 'Something New',
            'sign_in[timeStart]' => 'Something New',
            'sign_in[timeStop]' => 'Something New',
            'sign_in[timeFinish]' => 'Something New',
            'sign_in[hourCount]' => 'Something New',
        ]);

        self::assertResponseRedirects('/sign/in/');

        $fixture = $this->repository->findAll();

        self::assertSame('Something New', $fixture[0]->getHolidays());
        self::assertSame('Something New', $fixture[0]->getWorkshops());
        self::assertSame('Something New', $fixture[0]->getUser());
        self::assertSame('Something New', $fixture[0]->getTimeStart());
        self::assertSame('Something New', $fixture[0]->getTimeStop());
        self::assertSame('Something New', $fixture[0]->getTimeFinish());
        self::assertSame('Something New', $fixture[0]->getHourCount());
    }

    public function testRemove(): void
    {
        $this->markTestIncomplete();

        $originalNumObjectsInRepository = count($this->repository->findAll());

        $fixture = new SignIn();
        $fixture->setHolidays('My Title');
        $fixture->setWorkshops('My Title');
        $fixture->setUser('My Title');
        $fixture->setTimeStart('My Title');
        $fixture->setTimeStop('My Title');
        $fixture->setTimeFinish('My Title');
        $fixture->setHourCount('My Title');

        $this->repository->save($fixture, true);

        self::assertSame($originalNumObjectsInRepository + 1, count($this->repository->findAll()));

        $this->client->request('GET', sprintf('%s%s', $this->path, $fixture->getId()));
        $this->client->submitForm('Delete');

        self::assertSame($originalNumObjectsInRepository, count($this->repository->findAll()));
        self::assertResponseRedirects('/sign/in/');
    }
}
