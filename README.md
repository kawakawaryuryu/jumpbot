# jumpbot
twitter bot to tweet jump buyer

# Preparation
## configure parameters (CONSUMER_KEY, CONSUMER_SECRET etc)
```
# copy config_template.php
$ cd config
$ cp config_template.php config.php

# set parameters
$ vim config.php
```

## create buyers.json and buyer.json
- must create **buyers.json** to save all buyers and **buyer.json** to save last and next buyer
```
# fix each buyer name
$ vim make_json.php
$ php make_json.php
```

# Docker
## docker build
```
$ docker build -t jumpbot .
```

## docker run
```
docker run -d --name jump jumpbot
```

## docker exec interactively by bash
```
$ docker exec -it jump bash
```

# Docker Compose
## docker-compose up
```
$ docker-compose up -d

# need to rebuild
$ docker-compose up -d --build
```
