
## File path

Some of fields are used to address a file on the download server.

The field 'path' is used to define full path of the file. This is an abslout file
path from server storage.

As an example:

	{
		'path': '/a/b.txt'
		...
	}

Refers to the file 'b.txt' in the folder 'a'. If the storage path is '/path/to/storage'
then the full path will be:

	/path/to/storage/a/b.txt

## Access controll

Token is used ot control the access to a file. Here is options to control the
download:

- access: the access of the user to the file
- expire: valid duration to access to the file.

To control access to a file, add the following attribute:

	{
		'access': 'r'
		...
	}
	
Which means the file can be read. Here is possible option:

- r: read
- w: write
- rw: read and write

To limit the duration of access, add the following option:


	{
		'expiry': {date-time}
		...
	}
	
For example:


	{
		'access': 'r',
		'expiry': '2019-01-01 00:00:00'
		...
	}
	

## Trust host

The server may be used in the conjuction of servral other micro-services. By adding some
valueable information about them, the log information is more readable.

	{
		'host': {...}
	}

For example:

	{
		'host': {
			'domain': 'www.cactus-ico.com'
		}
	}

## Account information

Account information are used in logs.


	{
		'account': {...}
	}
