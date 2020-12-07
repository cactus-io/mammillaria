# Mammillaria

Mammillaria is light, fast, and stateless file download micro-service that servered contents to
be download by 3th partis.

Mammillaria uses JWT to protect contents from anonymous access while providing a direct link to
contents.

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
	cd ..

First of all generate a token by executing the following command:

	docker run -it \
		cactusio/mammillaria:latest \
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
		-v ./mammillaria:/mnt/storage \
		cactusio/mammillaria:latest

Open a browser to download the file

	
	http://localhost:80/api/v2/{token}/content

example:

	http://localhost:80/api/v2/cactus/eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJwYXRoIjoiXC9SRUFETUUubWQiLCJhY2Nlc3MiOiJyIiwiZXhwaXJ5IjoiMjAyMS0wMS0wMSAwMDowMDowMCIsImhvc3QiOm51bGwsImFjY291bnQiOm51bGx9.7ayp1qlry4F_3yTJ1RkG9lYGgBowHVhXZoXYINjuyj8/content

	
	
## Contributing

If you would like to contribute to the project, please read our
[contributor documentation](http://cactus-io.viraweb123.ir/wb/blog/content-contributor)
and the [`CONTRIBUTING.md`](CONTRIBUTING.md). The `CONTRIBUTING.md` file
explains how to set up a development installation, how to run the test suite,
and how to contribute to documentation.

For a high-level view of the vision and next directions of the project, see the
[Cactus community roadmap](docs/roadmap.md).

