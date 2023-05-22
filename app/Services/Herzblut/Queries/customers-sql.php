SELECT FIRST %d DB_ACCOUNTCODE,
DB_CONTACT AS CONTACTNAME,
DB_NAME AS SURNAME,
DB_EMAILADDRESS,
DB_MOBILE,
DB_LASTMODIFIEDDATE,
DB_USERFIELD1,
DB_CUSTOMERTYPE_ID
FROM CUSTOMERS
WHERE %s
ORDER BY DB_LASTMODIFIEDDATE DESC
