# backend

## Project setup
```
composer update
```

### Create .env file and generate app key
```
php artisan key:generate
```

### Run migration command and insert demo data
```
php artisan migrate --seed
```

### Generate storage Link
```
php artisan storage:link
```

### Generate secret key
```
php artisan jwt:secret
```

### Go to dashboard using these credentials
[Login](http://localhost:8080/login) Email: shahadat015@gmail.com Password: password
