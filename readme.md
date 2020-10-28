# DOT'S AP

#### Configure Apache2
- mkdir /home/archemi/logs
- sudo a2enmod rewrite
- cd /etc/apache2/sites-available
- copy 001-dotsap.conf (folder conf)
- apache2ctl configtest
- sudo nano /etc/hosts
- add 127.0.0.1 dotsap.local
- sudo a2ensite 001-dotsap.conf
- sudo a2enmod rewrite
- sudo service apache2 restart
- sudo apt install php-sqlite3
- sudo service apache2 restart

#### Memo
- git config credential.helper 'store'
- Per gestire il db -> sqlitebrowser
- Sistemare diritti di scrittura
- admin / admin

### Add .htaccess
RewriteEngine On  
RewriteBase /dotsap/  
RewriteRule ^(app|dict|ns|tmp)\/|\.ini$ - [R=404]  
  
RewriteCond %{REQUEST_FILENAME} !-l  
RewriteCond %{REQUEST_FILENAME} !-f  
RewriteCond %{REQUEST_FILENAME} !-d  
RewriteRule .* /dotsap/index.php [L,QSA]  
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization},L]  
  
#### Nella sottocartella DB .htaccess
  
Require local  
