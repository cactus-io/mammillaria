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



