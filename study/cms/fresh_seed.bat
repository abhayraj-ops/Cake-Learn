@echo off
cd /d %~dp0

echo === Starting Fresh Seed Process ===

echo [1/3] Rolling back all migrations...
php bin/cake.php migrations rollback
php bin/cake.php migrations rollback
php bin/cake.php migrations rollback
php bin/cake.php migrations rollback

echo [2/3] Running migrations...
php bin/cake.php migrations migrate

echo [3/3] Running seeds in order...
php bin/cake.php migrations seed --seed UsersSeed
php bin/cake.php migrations seed --seed ArticlesSeed
php bin/cake.php migrations seed --seed TagsSeed
php bin/cake.php migrations seed --seed ArticlesTagsSeed

echo === Done! ===
pause