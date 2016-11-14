<?php

putenv("APPLICATION_ENV=testing");

putenv("CINEMAHD_ELASTICSEARCH_HOST=http://127.0.0.1:9200/cinemahd.test");
putenv("CINEMAHD_ELASTICSEARCH_TYPES=movie,order,room,user,price,spectator,showing,ticket,type,people");

putenv("CINEMAHD_DATABASE_HOST=127.0.0.1");
putenv("CINEMAHD_DATABASE_NAME=test_cinemahd");
putenv("CINEMAHD_DATABASE_USER=root");
putenv("CINEMAHD_DATABASE_PWD=");
