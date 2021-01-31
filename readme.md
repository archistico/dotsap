# DOT'S AP

Gestionale di studio medico  

![homepage](https://github.com/archistico/dotsap/blob/master/img/homepage.png?raw=true)  
  
Zona appuntamenti  
![appuntamenti](https://github.com/archistico/dotsap/blob/master/img/appuntamenti.png?raw=true)  
  
Creazione pdf privacy
![privacy](https://github.com/archistico/dotsap/blob/master/img/privacy.png?raw=true)  
  
Gestione Nao/Tao  
![nao-tao](https://github.com/archistico/dotsap/blob/master/img/nao-tao.png?raw=true)  
  
Schede di monitoraggio  
![scheda](https://github.com/archistico/dotsap/blob/master/img/scheda.png?raw=true)  
  
Area amministrazione    
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
