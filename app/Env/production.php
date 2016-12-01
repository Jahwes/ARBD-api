<?php

putenv("APPLICATION_ENV=production");

putenv("CINEMAHD_ELASTICSEARCH_HOST=http://elasticsearch.cinemahd.ovh:9200/cinemahd.prod");
putenv("CINEMAHD_ELASTICSEARCH_TYPES=movie,order,room,user,price,spectator,showing,ticket,type,people");

putenv("CINEMAHD_DATABASE_HOST=192.168.5.11");
putenv("CINEMAHD_DATABASE_NAME=cinemahd");
putenv("CINEMAHD_DATABASE_USER=root");
putenv("CINEMAHD_DATABASE_PWD=");
