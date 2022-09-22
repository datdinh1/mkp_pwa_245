
### Require version:

```
php 7.4
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

cd database
sudo mysql -u root -p db-name < init_db.sql


### 4. Run Magento 2 deploy command:
push file .env

```bash
php bin/magento module:enable --all
php bin/magento se:up
php bin/magento se:di:co
php bin/magento setup:static-content:deploy -f
php bin/magento in:rei
php bin/magento c:f
