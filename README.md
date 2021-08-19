<p align="center">
 <img width="400" src="images/logo.png?token=AGGN6WZMSPUPDIMJ3OVVJADBDWSNQ">
 <br><br>
 Welcome to the unofficial OSTicket API!<br>
 The purpose of this API is to help the community and leverage the use of OSTicket.
</p>


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
