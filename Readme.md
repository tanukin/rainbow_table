Web Server + generator Rainbow Table 
=====================================
Web server to search for a value using a hash that uses rainbow tables

#####Nginx + php-fpm + Redis

Settings
---
Check the file: src/Config/configFile.yaml
~~~
redis:
  scheme: tcp
  host: redis
  port: 6379

generator:
  numeric: true
  capitalLetters: true
  smallLetters: true

passwordLength: 3
~~~

Starting the environment
---
~~~
docker-compose up -d
~~~
Run the rainbow table generator
---
~~~
docker exec -d rainbowGenerator /var/www/app/bin/generator.php
~~~

Connect to nginx
---
~~~
telnet localhost 8080
~~~

Request
---
####GET
~~~
GET /?hash=d926d7bb9ccf46fc04a61bd65d87b9b3 HTTP/1.1
Host: anyName
~~~
####POST
~~~
POST / HTTP/1.1
Host: anyName
Content-Type: application/x-www-form-urlencoded
Content-Length: 37
~~~
~~~
hash=d926d7bb9ccf46fc04a61bd65d87b9b3
~~~


