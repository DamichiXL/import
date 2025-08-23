# Import package

## Publishing file groups

### Publish all files (config, migrations, translations)
```shell
php artisan vendor:publish --tag=import
```

### Publish configurations only
```shell
php artisan vendor:publish --tag=import-config
```

### Publish migrations only
```shell
php artisan vendor:publish --tag=import-migrations
```

### Publish translations only
```shell
php artisan vendor:publish --tag=import-translations
```
