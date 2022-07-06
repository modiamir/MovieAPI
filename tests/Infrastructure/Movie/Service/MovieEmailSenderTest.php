<?php

namespace App\Tests\Infrastructure\Movie\Service;

use App\Infrastructure\Movie\Service\MovieEmailSender;
use App\Tests\IntegrationTestCase;
use Symfony\Component\Messenger\Transport\InMemoryTransport;
use Symfony\Bundle\FrameworkBundle\Test\MailerAssertionsTrait;

class MovieEmailSenderTest extends IntegrationTestCase
{
    use MailerAssertionsTrait;

    function test_publishing_movie_created()
    {
        // Arrange
        /** @var MovieEmailSender $service */
        $service = self::getContainer()->get(MovieEmailSender::class);

        /** @var InMemoryTransport $transport */
        $transport = $this->getContainer()->get('messenger.transport.async');

        // Act
        $service->sendEmail("Sample subject", 'sample@email.com', 'Sample body');

        // Assert
        $email = $this->getMailerMessage();
        $this->assertNotNull($email);
        $this->assertEmailTextBodyContains($email, 'Sample body');
    }
}
