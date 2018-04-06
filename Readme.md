Web Server + generator Rainbow Table 
=====================================
Сервис генерирует пару (строка, хеш(md5)) и кладет в Redis.
Web-server по указанному хеш ищет и возвращает строку из
Redis.  

Starting the environment
---
 
~~~
docker-compose up -d
~~~

Connect to nginx
---
~~~
telnet localhost 8080
~~~

Request
---
~~~
POST / HTTP/1.1
Host: anyName
Content-Type: application/x-www-form-urlencoded
Content-Length: 37
~~~
~~~
hash=202cb962ac59075b964b07152d234b70
~~~