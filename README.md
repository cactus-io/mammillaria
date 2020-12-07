# Mammillaria

Mammillaria is light, fast, and stateless micro-service to manage contents to
be download by 3th partis.

Mammillaria uses JWT to protect contents from anonymous access.

It can be used with any other micro-services as download center.

## Download API

The REST API to download a file is: 

    GET: {host}/api/v2/cactus/files/{token}/content

Where {host} is the full path of the server and {token} is a JWT token.

## Token

Information of the file, access control, and other metadata are placed in
the JWT token. There are several fields in the token to control Mammillaria.
For more information about field in the token see document/token.md

## Quick Start

Create a directory 

	mkdir mammillaria
	cd mammillaria

Create a test file:

	touch README.md
	echo "#Hello world">>README.md

First of all generate a token by executing the following command:

	docker run -it \
		5a73c08cdc5c \
		../bin/generate-token

Fill all required attribute to generate a new token:

	Mammillaria
	File Path:/README.md
	Access (r, rw, w):r
	Expire at (ex. 2021-01-01 00:00:00):2021-01-01 00:00:00
	Key:321
	
	-------------------------------------------
	Token:
	-------------------------------------------
	 File     |/README.md
	 Access   |r
	 Expiry   |2021-01-01 00:00:00
	-------------------------------------------
	eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJwYXRoIjoiXC9SRUFETUUubWQiLCJhY2Nlc3MiOiJyIiwiZXhwaXJ5IjoiMjAyMS0wMS0wMSAwMDowMDowMCIsImhvc3QiOm51bGwsImFjY291bnQiOm51bGx9.7ayp1qlry4F_3yTJ1RkG9lYGgBowHVhXZoXYINjuyj8
		
To run a new instance of the server:

	docker run \
		-p "80:80" \
		-e "MAMMILLARIA_JWT_KEY=321" \
		-v .:/mnt/storage \
		5a73c08cdc5c
		
		cactos-iso/mammillaria:latest

Open a browser to download the file

	
	http://localhost:80/api/v2/{token}/content

example:

	http://localhost:80/api/v2/cactus/eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJwYXRoIjoiXC9SRUFETUUubWQiLCJhY2Nlc3MiOiJyIiwiZXhwaXJ5IjoiMjAyMS0wMS0wMSAwMDowMDowMCIsImhvc3QiOm51bGwsImFjY291bnQiOm51bGx9.7ayp1qlry4F_3yTJ1RkG9lYGgBowHVhXZoXYINjuyj8/content
