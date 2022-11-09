
### Require version:

```
php 8.1
composer 2
elasticsearch 7
```

### 1. Pull new code:
```bash
git fetch --all
git pull
```

### 2. Under root of project folder, install upward module:
```bash
composer install
```
### 3. Import DB:

~root magento(mkp_pwa_245):
```bash
cd database
sudo mysql -u root -p db-name < empty.sql
```

### 4. Run Magento 2 deploy command:
push file .env

```bash
php bin/magento module:enable --all
php bin/magento se:up
php bin/magento se:di:co
php bin/magento setup:static-content:deploy -f
php bin/magento in:rei
php bin/magento c:f
```
### 5. Set Permission folder:

```bash
sudo find var generated vendor pub/static pub/media app/etc -type f -exec chmod g+w {} +
sudo find var generated vendor pub/static pub/media app/etc -type d -exec chmod g+ws {} +
sudo chown -R :www-data .
sudo chmod u+x bin/magento
```


### 6. Import Sample data
```bash

php bin/magento sampledata:deploy

```

```
### 7. Config PWA Magento:
## 7.1 Copy file .env.example and rename to .env then change some config bellow:
```bash
# example https://master-7rqtwti-mfwmkrjfqvbjk.us-4.magentosite.cloud/
MAGENTO_BACKEND_URL

# example en
STOREFRONT_LANGUAGE_CODE

FACEBOOK_API_KEY

GOOGLE_API_KEY
```

## 7.2. Deploy code PWA and build the project into optimized assets at the root of the project:
```bash
cd ./pwa
yarn install --ignore-engines
yarn build
```
## 7.3. Add config to file env.php (root magento): etc/env.php
```bash

'pwa_path' => [
        'default' => [
            'default' => '/var/www/mkp_pwa_245/pwa/dist/upward.yml'
        ]
    ]

```