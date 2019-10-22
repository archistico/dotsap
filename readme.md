# DOT'S AP

#### Install
- extract database.zip -> .database.sqlite
  
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
  
### SQL
CREATE TABLE "appuntamenti" ( `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, `data` INTEGER NOT NULL, `ora` INTEGER NOT NULL, `persona` TEXT NOT NULL, `note` TEXT, `annullato` INTEGER NOT NULL, `assente` INTEGER NOT NULL, `fatto` INTEGER NOT NULL, `inizio` TEXT, `fine` TEXT );  
CREATE TABLE categoria1( id INTEGER PRIMARY KEY, descrizione TEXT NOT NULL );  
CREATE TABLE categoria2( id INTEGER PRIMARY KEY, descrizione TEXT NOT NULL, madre INTEGER REFERENCES categoria1(id) ON UPDATE CASCADE );  
CREATE TABLE categoria3( id INTEGER PRIMARY KEY, descrizione TEXT NOT NULL, madre INTEGER REFERENCES categoria2(id) ON UPDATE CASCADE );  
CREATE TABLE categoria4( id INTEGER PRIMARY KEY, descrizione TEXT NOT NULL, madre INTEGER REFERENCES categoria3(id) ON UPDATE CASCADE );  
CREATE TABLE `movimenti` ( `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT, `giorno` INTEGER NOT NULL, `importo` NUMERIC NOT NULL, `note` TEXT, `cat1` INTEGER NOT NULL, `cat2` INTEGER NOT NULL, `cat3` INTEGER NOT NULL, `cat4` INTEGER NOT NULL );  
CREATE TABLE `orario` ( `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, `giorno` TEXT NOT NULL, `ora` TEXT NOT NULL, `ambulatorio` TEXT, `attivo` INTEGER NOT NULL );  
CREATE TABLE `pazienti` ( `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, `cognome` TEXT NOT NULL, `nome` TEXT NOT NULL, `datanascita` TEXT NOT NULL, `sesso` TEXT, `codicefiscale` TEXT, `indirizzo` TEXT, `citta` TEXT, `telefono` TEXT, `data` TEXT, `segreteria` INTEGER NOT NULL DEFAULT 0, `associazione` INTEGER NOT NULL DEFAULT 0, `sostituti` INTEGER NOT NULL DEFAULT 0, `consulenti` INTEGER NOT NULL DEFAULT 0, `softwarehouse` INTEGER NOT NULL DEFAULT 0 );  
CREATE TABLE `todo` ( `id` INTEGER NOT NULL PRIMARY KEY AUTOINCREMENT UNIQUE, `todo` TEXT NOT NULL, `chi` TEXT NOT NULL );  
CREATE TABLE `users` ( `user_id` TEXT NOT NULL UNIQUE, `password` TEXT NOT NULL, PRIMARY KEY(`user_id`) );  