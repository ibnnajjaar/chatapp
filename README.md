## Where is Code?
Classes required to encrypt, decrypt data, to generate keys and share keys are located in the `app/Actions` directory.
List of other places where some other project related logic can be found:
1. `app/Http/Controllers/KeyExchangeController.php`
1. `app/Http/Controllers/MessageController.php`
1. `app/Models/Message.php`
1. `app/Models/User.php`

### Requirements
1. You need to have a php server running in your local network.
2. Composer is required to install the dependencies.
3. NPM is required to install the dependencies.
4. Set up a database for the application

### Installation
2. Clone the repository into your www directory.
3. Run the following command:

```bash
copy .env.example .env
```
Update the .env file with your database credentials.

```bash
composer install
php artisan migrate --seed
php artisan key:generate
npm install
npm run dev
```

### Login credentials

```bash
email: alice@example.com
password: alice12345

email: bob@example.com
password: bob12345

email: eve@example.com
password: eve12345
```

### Credits
- [Hussain Afeef (@ibnnajjaar)](https://github.com/ibnnajjaar)
- [Shaffan (@shaffan_09)](https://github.com/shaffan09)
