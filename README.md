<p align="center">
 <img width="400" src="images/logo.png?token=AGGN6WZMSPUPDIMJ3OVVJADBDWSNQ">
 <br><br>
 Welcome to the unofficial OSTicket API!<br>
 The purpose of this API is to help the community and leverage the use of OSTicket.
</p>

## How to Use
To use OSTicket Unofficial API you have to place the `ost_wbs` directory in the root of OSTicket server.<br>
Then, go to `ost_wbs > config.php` and change the DB credentials.

Use the following URL: `{YOUR-DOMAIN}/ost_wbs/?`

<b>NOTE</b>: If you dont know the credentials, go to `/include/ost-config.php`. That is the main config file for OSTicket system.

## Authentication
In all requests, the API key that was created in the OSTicket system must be sent to authenticate the user.<br>
Using the following format:

`{YOUR-DOMAIN}/ost_wbs/?apikey=XXXXXX...`

## TICKETS

You can fetch tickets from the database using the following URL:

```javascript
{YOUR DOMAIN}/ost_wbs/?apikey={APIKEY}&query=ticket&condition=all&parameters=6
```

| Event | Mandatory | Info
| --- | --- |  --- |
| `apikey`| ✅ | API KEY GENERATED |
| `query`|  ✅ | `ticket` |
| `condition`|  ✅ | `all`, `specific` |
| `parameters`|  ✅ | `ticketID/Number` |
