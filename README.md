## System description

The system allows to make **currency conversion requests**. For each request, the users specifies **the source currency,
the target currency and the amount they** want to convert.

The system must **validate data for invalid values**, such as
malformed currency code, negative amounts.

Whenever a request for a not existing currency is done, the system must
**return an error messsage** and **the administrator must be notified via email**.

**Any request done in the morning (A.M. hours) must be rejected**.


It should be possible to **use both database and api calls to http REST service** as conversion source. The
conversion source **could be optionally cached**.

When using a database, a **CSV file** containing data **could be imported** to feed the table. Such functionality
can be used from both an **http endpoint and a console command**

## Required tests

- (x) it can convert amounts between arbitrary currencies
- (x) it validates currency conversion requests data
- if a conversion for a not existing currency is requested, an error message with 404 status is returned
- if a conversion for a not existing currency is requested, an email is sent to the admin
- it blocks requests in A.M. hours
- (x) it can convert between two currencies using db
- it can convert between two currencies using api
- it can convert between two currencies using cache
- it can import CSV files into database
- It can import CSV conversions from file upload
- It can import CSV conversions from command line
