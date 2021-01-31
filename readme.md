# DOT'S AP

![alt text](https://github.com/archistico/dotsap/blob/master/img/homepage.jpg?raw=true)
![alt text](https://github.com/archistico/dotsap/blob/master/img/appuntamenti.jpg?raw=true)
![alt text](https://github.com/archistico/dotsap/blob/master/img/privacy.jpg?raw=true)
![alt text](https://github.com/archistico/dotsap/blob/master/img/nao-tao.jpg?raw=true)
![alt text](https://github.com/archistico/dotsap/blob/master/img/scheda.jpg?raw=true)
![alt text](https://github.com/archistico/dotsap/blob/master/img/amministrazione.jpg?raw=true)

## Memo  
- configurare il file .env
- admin / admin

## Aggiungi .htaccess se lo installi in una sottocartella  
RewriteEngine On  
RewriteBase /dotsap/  
RewriteRule ^(app|dict|ns|tmp)\/|\.ini$ - [R=404]  
  
RewriteCond %{REQUEST_FILENAME} !-l  
RewriteCond %{REQUEST_FILENAME} !-f  
RewriteCond %{REQUEST_FILENAME} !-d  
RewriteRule .* /dotsap/index.php [L,QSA]  
RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization},L]  
  
## Nella sottocartella DB .htaccess  
Require local  
