# PHP Email Reader

This sample repo will show how to use Hosted Auth to log in a user and display his/hers latest 10 email messages.

This repo uses the [LeafPHP](https://leafphp.dev/) PHP Framework.

## Setup

### System dependencies
PHP version 8.3.4 or higher

### Gather environment variables

You'll need the following value on an .env file:

```text
API_KEY_V3=<YOU_API_KEY_V3>
```

The `.env` file is added to `.gitignore`. Ensure to store these values securely.

### Install dependencies

```bash
$ composer require leafs/leaf
$ composer require leafs/blade
$ composer require vlucas/phpdotenv
$ composer require leafs/session
```

## Hosted Authentication

You need to add the following to your Callback URIs tab on the Hosted Authentication section of your Nylas Dashboard

Details on how to do that can be found here [How to create a scheduler with Python and Taipy](https://www.nylas.com/blog/how-to-create-a-scheduler-with-python-and-taipy/)

```
http://localhost:8000
http://localhost:8000/oauth/exchange
```

## Usage

To run the project, clone it and the run

```
php -S localhost:8000
```

## Get support

If you found a bug or want to suggest a new [feature/use case/sample], please file an issue.

## Learn more

Visit our [Nylas documentation](https://developer.nylas.com/) to learn more.
