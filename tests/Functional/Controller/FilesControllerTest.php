<?php

namespace App\Tests\Functional\Controller;

use App\Repository\HostedFileRepository;
use App\Repository\UserRepository;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class FilesControllerTest extends WebTestCase
{
    private KernelBrowser $client;

    protected function setUp(): void
    {
        $this->client = static::createClient();
    }

    /**
     * @throws \JsonException
     */
    public function testUploadFile(): void
    {
        $userRepository = static::getContainer()->get(UserRepository::class);

        $admin = $userRepository->findOneBy(['login' =>'admin']);

        $this->client->loginUser($admin);

        $fixturesPathFromRoot = '/src/DataFixtures/Files/df5g4h6df5g4h6f5g4h6fdgh6f5g1h6fg51h.mp4';

        $path = (DIRECTORY_SEPARATOR === '\\')
            ? str_replace('/', '\\', $fixturesPathFromRoot)
            : str_replace('\\', '/', $fixturesPathFromRoot);

        $fullFilePath = dirname(__DIR__, 3).$path;

        $uploadedFile = new UploadedFile(
            $fullFilePath,
            'test.jpg'
        );

        // Attention, the fixtures file is deleted, it must be secured before uploading
        copy($fullFilePath, $fullFilePath.'.tmp');

        $this->client->request('POST', '/api/files/upload', ['description' => 'My awesome image!'],
            [
                'file' => $uploadedFile
            ]
        );

        rename($fullFilePath.'.tmp', $fullFilePath);

        $responseData = json_decode(($this->client->getResponse())->getContent(), true, 512, JSON_THROW_ON_ERROR);

        self::assertResponseIsSuccessful();
        self::assertSame($responseData['description'], 'My awesome image!');
    }
}