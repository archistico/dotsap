# DOT'S AP

![homepage](https://github.com/archistico/dotsap/blob/master/img/homepage.png?raw=true)
![appuntamenti](https://github.com/archistico/dotsap/blob/master/img/appuntamenti.png?raw=true)
![privacy](https://github.com/archistico/dotsap/blob/master/img/privacy.png?raw=true)
![nao-tao](https://github.com/archistico/dotsap/blob/master/img/nao-tao.png?raw=true)
![scheda](https://github.com/archistico/dotsap/blob/master/img/scheda.png?raw=true)
![amministrazione](https://github.com/archistico/dotsap/blob/master/img/amministrazione.png?raw=true)

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
