## Slack Email Service
This repository is based on Symfony website skeleton 5.4 and adds a service EmailService that will be responsible for sending emails to Slack. 
The service uses Symfony's Mailer component, which is a tool that allows us to send emails with very little boilerplate code.

### Installation
```bash
git pull
cd symfony-slack-email
composer install
touch .env.local
echo "MAILER_DSN=smtp://localhost:1025" >> .env.local
```

### Run the application
```bash
docker compose up -d
symfony server:start
php bin/phpunit
```
* Use the mailcatcher container

### EmailService
MailerInterface Dependency: The EmailService service depends on the MailerInterface, which is autowired by Symfony's DI container. This makes it easier to substitute the actual mailer with a mock in unit tests.

The Mailer class expects an instance of a class that implements the TransportInterface. In our test, we're creating a mock of TransportInterface and passing it to the Mailer. 
This lets us control the behavior of the transport in our test, so we can verify that the send method is called with the correct parameters.

### Slack email provider
Sending an email to a Slack channel is a bit more involved than sending a regular email. 
Slack does not natively support receiving emails in channels, so we need to use a third-party service that provides an email to Slack functionality.

We will need to set up and configure MailClark or a similar service in our Slack account to get the unique email address associated with our Slack channel.

As for special requirements, there may be some depending on the third-party service we choose. For example, MailClark has a specific format for the subject line if we want to include mentions or reactions in our messages. We should check the documentation of the service we choose to ensure we are formatting our emails correctly.

Unit Testing: A basic unit test ensures the sendEmail method of the EmailService service sends an email. This is done using PHPUnit's mock object functionality to create a mock mailer and assert that the send method is called with a RawMessage instance.

### SlackEmailService
The SlackEmailService service requires an instance of EmailService and the email address associated with our Slack channel, which will be configured as an environment variable.

### SlackEmailServiceTest
In this test, we're creating a mock transport, a real Mailer with the mock transport, a real EmailService with the real Mailer, and finally, a real SlackEmailService with the real EmailService and a fake Slack email address.

Then we call the sendEmailToSlack method of the SlackEmailService and assert that this results in a call to the send method of the mock transport with a RawMessage instance.

This test verifies that when you send an email to Slack using the SlackEmailService, it uses the EmailService to send an actual email.