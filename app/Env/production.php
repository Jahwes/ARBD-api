<?php

putenv("APPLICATION_ENV=production");

putenv("CINEMAHD_ELASTICSEARCH_HOST=http://127.0.0.1:9200/cinemahd.test");
putenv("CINEMAHD_ELASTICSEARCH_TYPES=movie,order,people,price,room,spectator,user,ticket");

putenv("CINEMAHD_DATABASE_HOST=");
putenv("CINEMAHD_DATABASE_NAME=cinemahd");
putenv("CINEMAHD_DATABASE_USER=root");
putenv("CINEMAHD_DATABASE_PWD=");
